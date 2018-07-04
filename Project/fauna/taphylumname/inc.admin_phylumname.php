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
		if (isset($_POST["insertphylumbttn"]) && (int) $_POST["insertphylumbttn"]==1)
		{
			if (isset($_POST["kingdom_code"]) && isset($_POST["phylum_code"]) && isset($_POST["phylum_name"]))
			{				
				$fields = array("kingdom_code", "phylum_code", "phylum_name", "citation_author", "citation_year", "phylum_name_mn", "phylum_name_en", "phylum_name_ru", "alternative_name", "user_id");

				$checkvalues = array((int)$_POST["kingdom_code"], (int)$_POST["phylum_code"], $_POST["phylum_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["phylum_name_mn"], $_POST["phylum_name_en"], $_POST["phylum_name_ru"], $_POST["alternative_name"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taphylumname", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		

			}
		}
		
		if (isset($_POST["updatephylumbttn"]) && (int) $_POST["updatephylumbttn"]==1)
		{
			if (isset($_POST["kingdom_code"]) && isset($_POST["phylum_code"]) && isset($_POST["phylum_name"]) && isset($_POST["phylum_id"]))
			{	
				$wherevalues = "phylum_id=".(int) $_POST["phylum_id"];
				
				$fields = array("kingdom_code", "phylum_code", "phylum_name", "citation_author", "citation_year", "phylum_name_mn", "phylum_name_en", "phylum_name_ru", "alternative_name", "user_id");
				
				$checkvalues = array((int)$_POST["kingdom_code"], (int)$_POST["phylum_code"], $_POST["phylum_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["phylum_name_mn"], $_POST["phylum_name_en"], $_POST["phylum_name_ru"], $_POST["alternative_name"], (int) $_POST["user_id"]);	
	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taphylumname", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}
						
		if (($action=="delete") && isset($_GET["phylum_id"]))
		{
			$phylum_id = (int) $_GET["phylum_id"];
			
			if($sess_profile==1)
				$wherevalues = "phylum_id = ".$phylum_id;
			else
				$wherevalues = "phylum_id = ".$phylum_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".taphylumname",$wherevalues);
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

	$kingdom_name_mn = (isset($_GET["kingdom_name_mn"])) ? $_GET["kingdom_name_mn"] : "";
	$phylum_name = (isset($_GET["phylum_name"])) ?  $_GET["phylum_name"] : "";
	$phylum_name_mn = (isset($_GET["phylum_name_mn"])) ? $_GET["phylum_name_mn"] : "";
	
	if(empty($kingdom_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(takn.kingdom_name_mn) LIKE lower('%".$kingdom_name_mn."%')";
		$search_url .= "&kingdom_name_mn=".$kingdom_name_mn;
	}
		
	if(empty($phylum_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapn.phylum_name) LIKE lower('%".$phylum_name."%')";
		$search_url .= "&phylum_name=".$phylum_name;
	}
	
	if(empty($phylum_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapn.phylum_name_mn) LIKE lower('%".$phylum_name_mn."%')";
		$search_url .= "&phylum_name_mn=".$phylum_name_mn;
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
		require("taphylumname/inc.edit_phylumnameform.php");
	}elseif ($action=="add")
	{
		require("taphylumname/inc.add_phylumnameform.php");
	}elseif ($action=="more")
	{
		require("taphylumname/inc.more_phylumnameform.php");		
	}else
	{
		require("taphylumname/inc.list_phylumnameform.php");
	}
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}	
?>
