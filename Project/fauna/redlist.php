<?php
$_MY_CONF["DATABASE_USER"]   	=   "fauna_user";
$_MY_CONF["DATABASE_NAME"]   	=   "faunadb";
$_MY_CONF["DATABASE_SERVER"]   	=   "www.eic.mn";
$_MY_CONF["DATABASE_PASS"]   	=   "729_fauna_user;";
$_MY_CONF["DATABASE_PORT"]   	=   "5432";

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
}
$db = new pgsql($_MY_CONF["DATABASE_NAME"], $_MY_CONF["DATABASE_SERVER"], $_MY_CONF["DATABASE_USER"], $_MY_CONF["DATABASE_PASS"], $_MY_CONF["DATABASE_PORT"]);

$schemas = "scfauna";
$startQuery = "SELECT";
$valueQuery = "tarl.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru, tcrs.name_mn global_name_mn, tcrs.name_en global_name_en, tcrs1.name_mn regional_name_mn, tcrs1.name_en regional_name_en FROM  ".$schemas.".taredlist tarl,".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn, ".$schemas.".tcredliststatus tcrs , ".$schemas.".tcredliststatus tcrs1";

$whereQuery = "WHERE tarl.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code AND tarl.global_code = tcrs.status_code AND tarl.regional_code = tcrs1.status_code ORDER BY species_name_mn";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$rows = $db->query($selQuery);
echo json_encode(array("result"=>$rows), JSON_UNESCAPED_UNICODE);
		
?>