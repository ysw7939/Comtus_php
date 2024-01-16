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
            id AS userNo,
			name AS userName
        ' );

		if( !empty( $search['userNo'] ) )
		{
			$this->sdb->where( 'id', $search['userNo'] );
		}

		if( !empty( $search['userName'] ) )
		{
			$this->sdb->where( 'name', $search['userName'] );
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
						'userNo'       => $row->userNo,
						'userName'     => $row->userName,
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
			'name' => $data['userName'],
		];

		if( !$this->mdb->insert( USER_INFO, $insert_data ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return $this->mdb->insert_id();
	}

	public function update_user( int $userNo, string $userName ): bool
	{
		$update_data = [
			'name' => $userName
		];

		$this->mdb->where( 'id', $userNo );

		if( !$this->mdb->update( USER_INFO, $update_data ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return TRUE;
	}
}
