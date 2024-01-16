<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Users extends API_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model( 'Model_users' );
	}


	public function deleteUser_delete($userNo) 
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

			// Model을 이용해서 유저정보 삭제
			$userNo = $this->Model_users->delete_user($req_param['userNo']);
	
			// 응답 코드 작성
			$response = [
				'code'     => SUCCESS,
				'message'  => 'SUCCESS',
				'response' => ['userNo' => $userNo],
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

	public function createUser_post() 
	{
		$this->data_validation->clear();

		$req_param = [
			'email' => $this->post('email'),
			'pw' => $this->post('pw'),
			'name' => $this->post('name'),
			'birth' => $this->post('birth')	
		];

		// 필수 항목
		$this->data_validation->set_rules( 'name', '', 'trim|xss_clean|required' );

		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// 초기값 세팅
			$data = NULL;

			$userNo = $this->Model_users->insert_user($req_param);

			// 응답 코드 작성
			$response = [
				'code'     => SUCCESS,
				'message'  => 'SUCCESS',
				'response' => ['userNo' => $userNo],
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

	public function patchUserName_patch( $userNo )
	{
		$this->data_validation->clear();

		$req_param = [
			'no'   => $userNo,
			'email' => $this->patch('email'),
			'pw' => $this->patch('pw'),
			'name' => $this->patch('name'),
			'birth' => $this->patch('birth')
		];

		// 필수 항목
		$this->data_validation->set_rules( 'no', '', 'trim|xss_clean|numeric|required' );
		$this->data_validation->set_rules( 'name', '', 'trim|xss_clean|required' );

		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// 초기값 세팅
			$data = NULL;

			if($this->Model_users->select_user([$userNo]))
			{
				$this->Model_users->update_user( $req_param['no'], $req_param['name'], $req_param['email'],$req_param['pw'],$req_param['birth'] );
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

	public function findChar_get( $userNo, $chNo)
	{
		$this->data_validation->clear();

		$req_param = [
			'userNo' => $userNo,
			'chNo' => $chNo,
		];

		// 필수 항목
		$this->data_validation->set_rules( 'userNo', '', 'trim|xss_clean|numeric|required' );

		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// 초기값 세팅
			$data = NULL;

			$select_char = $this->Model_users->select_char( $req_param , $chNo);

			if( $select_char )
			{
				$data = $select_char;
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

	public function createChar_post() 
	{
		$this->data_validation->clear();

		$req_param = [
			'no' => $this->post('no'),
			'name' => $this->post('name'),
			'level' => $this->post('level')	
		];

		// 필수 항목
		$this->data_validation->set_rules( 'name', '', 'trim|xss_clean|required' );

		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// 초기값 세팅
			$data = NULL;

			$userNo = $this->Model_users->insert_char($req_param);

			// 응답 코드 작성
			$response = [
				'code'     => SUCCESS,
				'message'  => 'SUCCESS',
				'response' => ['userNo' => $userNo],
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

	public function patchChar_patch( $userNo, $chNo )
	{
		$this->data_validation->clear();

		$req_param = [
			'no'   => $userNo,
			'chNo' => $chNo,
			'name' => $this->patch('name'),
			'level' => $this->patch('level')
		];

		// 필수 항목
		$this->data_validation->set_rules( 'no', '', 'trim|xss_clean|numeric|required' );
		$this->data_validation->set_rules( 'name', '', 'trim|xss_clean|required' );

		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// 초기값 세팅
			$data = NULL;

			if($this->Model_users->select_char([$chNo]))
			{
				$this->Model_users->update_char( $req_param['no'],$req_param['chNo'], $req_param['name'], $req_param['level'] );
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

	public function deleteChar_delete($no, $chNo) 
	{
		$this->data_validation->clear();

		$req_param = [
			'no' => $no,
			'chNo' => $chNo,
		];

		// 필수 항목
		$this->data_validation->set_rules( 'no', '', 'trim|xss_clean|required' );

		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// Model을 이용해서 유저정보 삭제
			$userNo = $this->Model_users->delete_char($req_param['no'], $req_param['chNo']);
	
			// 응답 코드 작성
			$response = [
				'code'     => SUCCESS,
				'message'  => 'SUCCESS',
				'response' => ['userNo' => $userNo],
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
