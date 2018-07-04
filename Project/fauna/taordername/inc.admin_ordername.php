<?php
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 1))
{				
	$my_url .= "?menuitem=".$menuitem;
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}else
	{
		$action = "";
	}
	

	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2))
	{	
		if (isset($_POST["insertorderbttn"]) && (int) $_POST["insertorderbttn"]==1)
		{
			if (isset($_POST["class_code"]) && isset($_POST["order_code"]) && isset($_POST["order_name"]))
			{				
				$fields = array("class_code", "order_code", "order_name", "citation_author", "citation_year", "order_name_mn", "order_name_en", "order_name_ru", "alternative_name", "user_id");

				$checkvalues = array((int)$_POST["class_code"], (int)$_POST["order_code"], $_POST["order_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["order_name_mn"], $_POST["order_name_en"], $_POST["order_name_ru"], $_POST["alternative_name"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taordername", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		

			}
		}
		
		if (isset($_POST["updateorderbttn"]) && (int) $_POST["updateorderbttn"]==1)
		{
			if (isset($_POST["class_code"]) && isset($_POST["order_code"]) && isset($_POST["order_name"]) && isset($_POST["order_id"]))
			{	
				$wherevalues = "order_id=".(int) $_POST["order_id"];
				
				$fields = array("class_code", "order_code", "order_name", "citation_author", "citation_year", "order_name_mn", "order_name_en", "order_name_ru", "alternative_name", "user_id");

				$checkvalues = array((int)$_POST["class_code"], (int)$_POST["order_code"], $_POST["order_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["order_name_mn"], $_POST["order_name_en"], $_POST["order_name_ru"], $_POST["alternative_name"], (int) $_POST["user_id"]);	

	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taordername", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}
						
		if (($action=="delete") && isset($_GET["order_id"]))
		{
			$order_id = (int) $_GET["order_id"];
			
			if($sess_profile==1)
				$wherevalues = "order_id = ".$order_id;
			else
				$wherevalues = "order_id = ".$order_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".taordername",$wherevalues);
			if(! $result)
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
		
		}
	}
	
	$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
	$my_page = "&page=".$page;
	
	$searchQuery = "";
	$search_url = "";
	
	$order_name = (isset($_GET["order_name"])) ?  $_GET["order_name"] : "";
	$order_name_mn = (isset($_GET["order_name_mn"])) ? $_GET["order_name_mn"] : "";
	$phylum_name_mn = (isset($_GET["phylum_name_mn"])) ? $_GET["phylum_name_mn"] : "";
	
	if(empty($phylum_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapn.phylum_name_mn) LIKE lower('%".$phylum_name_mn."%')";
		$search_url .= "&phylum_name_mn=".$phylum_name_mn;
	}
	
	if(empty($order_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taon.order_name) LIKE lower('%".$order_name."%') OR lower(taon.alternative_name) LIKE lower('%".$order_name."%'))";
		$search_url .= "&order_name=".$order_name;
	}
	
	if(empty($order_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taon.order_name_mn) LIKE lower('%".$order_name_mn."%') OR lower(taon.alternative_name) LIKE lower('%".$order_name_mn."%'))";
		$search_url .= "&order_name_mn=".$order_name_mn;
	}
	
	$sort_url = "";
	$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
	$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;
	
	if($sort==0)
		$sort_url .= "";
	else
		$sort_url .= "&sort=".$sort;
	
	if($sort_type==0)
		$sort_url .= "";
	else
		$sort_url .= "&sorttype=".$sort_type; 
	
	if ($action=="edit")
	{
		require("taordername/inc.edit_ordernameform.php");
	}elseif ($action=="add")
	{
		require("taordername/inc.add_ordernameform.php");
	}elseif ($action=="more")
	{
		require("taordername/inc.more_ordernameform.php");
	}else
	{
		require("taordername/inc.list_ordernameform.php");
	}
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}	
?>
