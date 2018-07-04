<?php
class pgsql 
{    
	var $db;
	var $db_host;
	var $db_user;
	var $db_password;
	var $db_port;
	var $db_conn;
 
	function pgsql($a_db, $a_db_host, $a_db_user, $a_db_password, $a_db_port) 
	{
		$this->db = $a_db;
		$this->db_host = $a_db_host;
		$this->db_user = $a_db_user;
		$this->db_password = $a_db_password;
		$this->db_port = $a_db_port;

		try
		{
			$this->db_conn = pg_connect("host=$this->db_host port=$this->db_port dbname=$this->db user=$this->db_user password=$this->db_password");
			if (! $this->db_conn)
				throw new Exception("$this->db: Connection database error!");
		}
		catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	
	function query($sql) 
	{
 		try
		{
 			$temp = pg_query($this->db_conn, $sql);
 		}
 		catch (Exception $e)
		{
			echo $e->getMessage();
 		}
		if (strtoupper(substr($sql,0,6))=="SELECT") 
		{ 
			if (!$temp)
			{
				return array(); //Empty array
			} else
			{
				$res = pg_fetch_all($temp); //Fetches all rows
				if ($res==false)
				{
					return array(); //Empty array
				}else
				{
					if (is_array($res))
						return $res;
					else
						return array(); //Empty array
				}
			}
		} else
		{
			return $temp;
		}
	}
	
	function insert($table, $fields, $values) 
	{
		$sql = "INSERT INTO $table ";
		$temp1 = implode(",",$fields); //Join array elements with a staring
		$temp2 = implode(",",$values); //Join array elements with a staring
		$sql .= "($temp1) VALUES ($temp2)";
		//echo $sql;
		return $this->query($sql); 
	}
	
	function update($table, $fields, $values, $where) 
	{
		if ($where!="") 
		{
			$sql = "UPDATE $table SET ";
			for ($i=0;$i<count($fields);$i++)
			{
				$sql .= $fields[$i]." = ".$values[$i].(($i==count($fields)-1)?"":" , ");
			}
			$sql .= " WHERE $where";
			//echo $sql;
			return $this->query($sql);
		}
	}
 
 	function validate($table, $fields, $values, $from, $where) 
	{
		if ($where!="") 
		{
			$sql = "UPDATE $table SET ";
			for ($i=0;$i<count($fields);$i++)
			{
				$sql .= $fields[$i]." = ".$values[$i].(($i==count($fields)-1)?"":" , ");
			}
			$sql .= " FROM $from";
			$sql .= " WHERE $where";
			//echo $sql;
			return $this->query($sql);
		}
	}
	   
	function delete($table, $where) 
	{
		if ($where!="") 
		{
			$sql = "DELETE FROM $table WHERE $where";
			//echo $sql;
			return $this->query($sql);
		}
	}
		
	function isGroupRole($schemas, $sess_profile, $sess_user_id, $item_id, $role_id)
	{
		$temp = 0;
		
		if($sess_profile==1) {
			if($role_id==1 || $role_id==2)
			{
				$temp = 1;	
			}
		}
		if($sess_profile==2)
		{
			$checkQuery = "SELECT tgr.*	FROM ".$schemas.".tagrouproles AS tgr WHERE tgr.item_id = ".$item_id." AND tgr.role_id = ".$role_id." AND tgr.group_id IN (SELECT group_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id.")";
			$checkrows = $this->query($checkQuery);
			if (!empty($checkrows)) 
				$temp = 1;			
		}
		if($sess_profile==3)
		{
			if($role_id==1)
			{
				$checkQuery = "SELECT tgr.*	FROM ".$schemas.".tagrouproles AS tgr WHERE tgr.item_id = ".$item_id." AND tgr.role_id = ".$role_id." AND tgr.group_id IN (SELECT group_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id.")";
				$checkrows = $this->query($checkQuery);
				if (!empty($checkrows)) 
					$temp = 1;
			}
		}

		return $temp;
	}
}
?>
