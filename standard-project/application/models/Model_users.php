<?php

class Model_users extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function select_user( array $search ): array
	{
		$this->sdb->select( '
            no AS userNo,
			name AS userName,
			email AS userEmail,
			birth AS userBirth
        ' );

		if( !empty( $search['userNo'] ) )
		{
			$this->sdb->where( 'no', $search['userNo'] );
		}


		$query = $this->sdb->get( USER_INFO );

		if( $query )
		{
			if( $query->num_rows() > 0 )
			{
				$order_info = NULL;

				foreach( $query->result() as $row )
				{
					$order_info = [
						'userNo'      => $row->userNo,
						'userName'    => $row->userName,
						'userEmail'   => $row->userEmail,
						'userBirth'   => $row->userBirth,
					];
				}

				return $order_info;
			}
			else
			{
				return [];
			}
		}
		else
		{
			throw new Db_exception( ['message' => $this->sdb->_error_message(), 'code' => $this->sdb->_error_number()] );
		}
	}

	public function insert_user( $data )
	{
		$insert_data = [
			'email' => $data['email'],
			'pw' => password_hash($data['pw'], PASSWORD_DEFAULT),
			'name' => $data['name'],
			'birth' => $data['birth'],
			'createAt' => date("Y-m-d H:i:s")
		];

		if( !$this->mdb->insert( USER_INFO, $insert_data ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return $this->mdb->insert_id();
	}

	public function update_user( int $userNo, string $name, string $email, string $pw, string $birth ): bool
	{
		$update_data = [
			'email' => $email,
			'pw' => password_hash($pw, PASSWORD_DEFAULT),
			'name' => $name,
			'birth' => $birth,
		];

		$this->mdb->where( 'no', $userNo );

		if( !$this->mdb->update( USER_INFO, $update_data ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return TRUE;
	}

	public function delete_user( int $userNo ): bool
	{

		$this->mdb->where( 'no', $userNo );

		if( !$this->mdb->delete( USER_INFO ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return TRUE;
	}


	public function select_char( array $search ): array
	{
		$this->sdb->select( '
            no AS userNo,
			name AS userName,
			level AS userLevel,
        ' );

		if( !empty( $search['userNo'] ) )
		{
			$this->sdb->where( 'no', $search['userNo'] );
			$this->sdb->where( 'ch_no', $search['chNo'] );
		}
		


		$query = $this->sdb->get( CHAR_INFO );

		if( $query )
		{
			if( $query->num_rows() > 0 )
			{
				$order_info = [];

				foreach( $query->result() as $row )
				{
					$order_info[] = [
						'userNo'      => $row->userNo,
						'userName'    => $row->userName,
						'userLevel'   => $row->userLevel,
					];
				}

				return $order_info;
			}
			else
			{
				return [];
			}
		}
		else
		{
			throw new Db_exception( ['message' => $this->sdb->_error_message(), 'code' => $this->sdb->_error_number()] );
		}
	}

	public function insert_char( $data )
	{
		$insert_data = [
			'no' => $data['no'],
			'name' => $data['name'],
			'level' => $data['level'],
		];

		if( !$this->mdb->insert( CHAR_INFO, $insert_data ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return $this->mdb->insert_id();
	}

	public function update_char( int $userNo, int $chNo , string $name, string $level ): bool
	{
		$update_data = [
			'no' => $userNo,
			'name' => $name,
			'level' => $level,
		];

		$this->mdb->where( 'ch_no', $chNo );
		echo "<pre>";
		print_r($update_data);
		var_dump($update_data);
		echo "</pre>";

		if( !$this->mdb->update( CHAR_INFO, $update_data ) )
		{

			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return TRUE;
	}

	public function delete_char( int $userNo, int $chNo ): bool
	{

		$this->mdb->where( 'no', $userNo );
		$this->mdb->where( 'ch_no', $chNo );

		if( !$this->mdb->delete( CHAR_INFO ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return TRUE;
	}


	


}
