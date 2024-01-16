<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Users extends API_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model( 'Model_users' );
	}

	public function patchUserName_patch( $userNo, $userName )
	{
		$this->data_validation->clear();

		$req_param = [
			'userNo'   => $userNo,
			'userName' => $userName,
		];

		// 필수 항목
		$this->data_validation->set_rules( 'userNo', '', 'trim|xss_clean|numeric|required' );
		$this->data_validation->set_rules( 'userName', '', 'trim|xss_clean|required' );

		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// 초기값 세팅
			$data = NULL;

			if($this->Model_users->select_user([$userNo]))
			{
				$this->Model_users->update_user( $req_param['userNo'], $req_param['userName'] );
				// 응답 코드 작성
				$response = [
					'code'     => SUCCESS,
					'message'  => 'SUCCESS',
					'request'  => $req_param,
				];
			}
			else
			{
				$this->Model_users->insert_user( $req_param );

				// 응답 코드 작성
				$response = [
					'code'     => 204,
					'message'  => 'NO_CONTENT',
					'request'  => $req_param,
				];
			}


			// 응답 코드 작성
			$response = [
				'code'     => SUCCESS,
				'message'  => 'SUCCESS',
				'request'  => $req_param,
			];
		}
		catch( Validation_Exception $e )
		{
			// 요청 파라미터 에러
			$response['code']    = BAD_REQUEST;
			$response['message'] =  'BAD_REQUEST' ;
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Validation_Exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Db_exception $e )
		{
			// DB 오류
			$response['code']    = INTERNAL_SERVER_ERROR;
			$response['message'] =  'INTERNAL_SERVER_ERROR' ;
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Db_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Application_exception $e )
		{
			$response['code']    = $e->getCode();
			$response['message'] = $e->getMessage();
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Application_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}

		$this->dataResponse( $response );
	}

	public function findUserNo_get( $userNo )
	{
		$this->data_validation->clear();

		$req_param = [
			'userNo' => $userNo,
		];

		// 필수 항목
		$this->data_validation->set_rules( 'userNo', '', 'trim|xss_clean|numeric|required' );

		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// 초기값 세팅
			$data = NULL;

			$select_user = $this->Model_users->select_user( $req_param );

			if( $select_user )
			{
				$data = $select_user;
			}

			// 응답 코드 작성
			$response = [
				'code'     => SUCCESS,
				'message'  => 'SUCCESS',
				'response' => $data,
				'request'  => $req_param,
			];
		}
		catch( Validation_Exception $e )
		{
			// 요청 파라미터 에러
			$response['code']    = BAD_REQUEST;
			$response['message'] =  'BAD_REQUEST' ;
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Validation_Exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Db_exception $e )
		{
			// DB 오류
			$response['code']    = INTERNAL_SERVER_ERROR;
			$response['message'] =  'INTERNAL_SERVER_ERROR' ;
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Db_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Application_exception $e )
		{
			$response['code']    = $e->getCode();
			$response['message'] = $e->getMessage();
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Application_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}

		$this->dataResponse( $response );
	}
}