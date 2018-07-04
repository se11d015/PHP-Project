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
		if (isset($_POST["insertfamilybttn"]) && (int) $_POST["insertfamilybttn"]==1)
		{
			if (isset($_POST["order_code"]) && isset($_POST["family_code"]) && isset($_POST["family_name"]))
			{				
				$fields = array("order_code", "family_code", "family_name", "citation_author", "citation_year", "family_name_mn", "family_name_en", "family_name_ru", "alternative_name", "user_id");

				$checkvalues = array((int)$_POST["order_code"], (int)$_POST["family_code"], $_POST["family_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["family_name_mn"], $_POST["family_name_en"], $_POST["family_name_ru"], $_POST["alternative_name"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".tafamilyname", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		

			}
		}
		
		if (isset($_POST["updatefamilybttn"]) && (int) $_POST["updatefamilybttn"]==1)
		{
			if (isset($_POST["order_code"]) && isset($_POST["family_code"]) && isset($_POST["family_name"]) && isset($_POST["family_id"]))
			{	
				$wherevalues = "family_id=".(int) $_POST["family_id"];
				
				$fields = array("order_code", "family_code", "family_name", "citation_author", "citation_year", "family_name_mn", "family_name_en", "family_name_ru", "alternative_name", "user_id");

				$checkvalues = array((int)$_POST["order_code"], (int)$_POST["family_code"], $_POST["family_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["family_name_mn"], $_POST["family_name_en"], $_POST["family_name_ru"], $_POST["alternative_name"], (int) $_POST["user_id"]);	

	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".tafamilyname", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}
						
		if (($action=="delete") && isset($_GET["family_id"]))
		{
			$family_id = (int) $_GET["family_id"];
			
			if($sess_profile==1)
				$wherevalues = "family_id = ".$family_id;
			else
				$wherevalues = "family_id = ".$family_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".tafamilyname",$wherevalues);
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
	
	$family_name = (isset($_GET["family_name"])) ?  $_GET["family_name"] : "";
	$family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
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
	
	if(empty($order_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taon.order_name_mn) LIKE lower('%".$order_name_mn."%') OR lower(taon.alternative_name) LIKE lower('%".$order_name_mn."%'))";
		$search_url .= "&order_name_mn=".$order_name_mn;
	}
		
	if(empty($family_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{	
		$searchQuery .= " AND (lower(tafn.family_name) LIKE lower('%".$family_name."%') OR lower(tafn.alternative_name) LIKE lower('%".$family_name."%'))";
		$search_url .= "&family_name=".$family_name;
	}
	
	if(empty($family_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tafn.family_name_mn) LIKE lower('%".$family_name_mn."%') OR lower(tafn.alternative_name) LIKE lower('%".$family_name_mn."%'))";
		$search_url .= "&family_name_mn=".$family_name_mn;
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
		require("tafamilyname/inc.edit_familynameform.php");
	}elseif ($action=="add")
	{
		require("tafamilyname/inc.add_familynameform.php");
	}elseif ($action=="more")
	{
		require("tafamilyname/inc.more_familynameform.php");
	}else
	{
		require("tafamilyname/inc.list_familynameform.php");
	}
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}	
?>
