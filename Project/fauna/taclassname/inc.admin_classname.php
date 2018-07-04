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
		if (isset($_POST["insertclassbttn"]) && (int) $_POST["insertclassbttn"]==1)
		{
			if (isset($_POST["phylum_code"]) && isset($_POST["class_code"]) && isset($_POST["class_name"]))
			{				
				$fields = array("phylum_code", "class_code", "class_name", "citation_author", "citation_year", "class_name_mn", "class_name_en", "class_name_ru", "alternative_name", "user_id");

				$checkvalues = array((int)$_POST["phylum_code"], (int)$_POST["class_code"], $_POST["class_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["class_name_mn"], $_POST["class_name_en"], $_POST["class_name_ru"],  $_POST["alternative_name"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taclassname", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		

			}
		}
		
		if (isset($_POST["updateclassbttn"]) && (int) $_POST["updateclassbttn"]==1)
		{
			if (isset($_POST["phylum_code"]) && isset($_POST["class_code"]) && isset($_POST["class_name"]) && isset($_POST["class_id"]))
			{	
				$wherevalues = "class_id=".(int) $_POST["class_id"];
				
				$fields = array("phylum_code", "class_code", "class_name", "citation_author", "citation_year", "class_name_mn", "class_name_en", "class_name_ru", "alternative_name", "user_id");

				$checkvalues = array((int)$_POST["phylum_code"], (int)$_POST["class_code"], $_POST["class_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["class_name_mn"], $_POST["class_name_en"], $_POST["class_name_ru"],  $_POST["alternative_name"], (int) $_POST["user_id"]);	

	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taclassname", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}
						
		if (($action=="delete") && isset($_GET["class_id"]))
		{
			$class_id = (int) $_GET["class_id"];
			
			if($sess_profile==1)
				$wherevalues = "class_id = ".$class_id;
			else
				$wherevalues = "class_id = ".$class_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".taclassname",$wherevalues);
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
	
	$class_name = (isset($_GET["class_name"])) ?  $_GET["class_name"] : "";
	$class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
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
        
    if(empty($class_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tacn.class_name) LIKE lower('%".$class_name."%')";
		$search_url .= "&class_name=".$class_name;
	}
	
	if(empty($class_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%".$class_name_mn."%')";
		$search_url .= "&class_name_mn=".$class_name_mn;
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
		require("taclassname/inc.edit_classnameform.php");
	}elseif ($action=="add")
	{
		require("taclassname/inc.add_classnameform.php");
	}elseif ($action=="more")
	{
		require("taclassname/inc.more_classnameform.php");
	}else
	{
		require("taclassname/inc.list_classnameform.php");
	}
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}	
?>
