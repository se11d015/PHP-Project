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
		if (isset($_POST["insertkingdombttn"]) && (int) $_POST["insertkingdombttn"]==1)
		{
			if (isset($_POST["kingdom_code"]) && isset($_POST["kingdom_name"]))
			{				
				$fields = array("kingdom_code", "kingdom_name", "citation_author", "citation_year", "kingdom_name_mn", "kingdom_name_en", "kingdom_name_ru", "alternative_name", "user_id");

				$checkvalues = array((int)$_POST["kingdom_code"], $_POST["kingdom_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["kingdom_name_mn"], $_POST["kingdom_name_en"], $_POST["kingdom_name_ru"], $_POST["alternative_name"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".takingdomname", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		

			}
		}
		
		if (isset($_POST["updatekingdombttn"]) && (int) $_POST["updatekingdombttn"]==1)
		{
			if (isset($_POST["kingdom_code"]) && isset($_POST["kingdom_name"]) && isset($_POST["kingdom_id"]))
			{	
				$wherevalues = "kingdom_id=".(int) $_POST["kingdom_id"];
				
				$fields = array("kingdom_code", "kingdom_name", "citation_author", "citation_year", "kingdom_name_mn", "kingdom_name_en", "kingdom_name_ru", "alternative_name", "user_id");;
				
				$checkvalues = array((int)$_POST["kingdom_code"], $_POST["kingdom_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["kingdom_name_mn"], $_POST["kingdom_name_en"], $_POST["kingdom_name_ru"], $_POST["alternative_name"], (int) $_POST["user_id"]);	
	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".takingdomname", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}
						
		if (($action=="delete") && isset($_GET["kingdom_id"]))
		{
			$kingdom_id = (int) $_GET["kingdom_id"];
			
			if($sess_profile==1)
				$wherevalues = "kingdom_id = ".$kingdom_id;
			else
				$wherevalues = "kingdom_id = ".$kingdom_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".takingdomname",$wherevalues);
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
	
	$kingdom_name = (isset($_GET["kingdom_name"])) ?  $_GET["kingdom_name"] : "";
	$kingdom_name_mn = (isset($_GET["kingdom_name_mn"])) ? $_GET["kingdom_name_mn"] : "";

	if(empty($kingdom_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(takn.kingdom_name) LIKE lower('%".$kingdom_name."%')";
		$search_url .= "&kingdom_name=".$kingdom_name;
	}
	
	if(empty($kingdom_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(takn.kingdom_name_mn) LIKE lower('%".$kingdom_name_mn."%')";
		$search_url .= "&kingdom_name_mn=".$kingdom_name_mn;
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
		require("takingdomname/inc.edit_kingdomnameform.php");
	}elseif ($action=="more")
	{
		require("takingdomname/inc.more_kingdomnameform.php");
	}elseif ($action=="add")
	{
		require("takingdomname/inc.add_kingdomnameform.php");
	}else
	{
		require("takingdomname/inc.list_kingdomnameform.php");
	}	
} else {
		$notify ="Таны хандалт буруу байна.";
		show_notification("error", "", $notify);
}	
?>
