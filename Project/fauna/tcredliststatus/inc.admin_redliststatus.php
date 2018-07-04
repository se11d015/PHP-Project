<?php
$my_url .= "?menuitem=".$menuitem;
$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"]: 1;
$my_page = "&page=".$page;
if(isset($_GET["action"]))
{
	$action = $_GET["action"];
}else
{
	$action = "";
}


	if(isset($_POST["insertredliststatusbttn"]))
	{
		if(isset($_POST["status_code"]) && isset($_POST["name_mn"]))
		{
			$fields = array("status_code", "name_mn", "name_en", "desc_mn", "desc_en");
			$checkvalues = array($_POST["status_code"], $_POST["name_mn"], $_POST["name_en"], $_POST["desc_mn"], $_POST["desc_en"]);
	
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}			
							
			$result = $db->insert("".$schemas.".tcredliststatus", $fields, $values);
	
			if(! $result)
				show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
		}
	}
				
	if(isset($_POST["updateredliststatusbttn"]))
	{
		if(isset($_POST["status_id"]) && isset($_POST["status_code"]) && isset($_POST["name_mn"]))
		{	
			$wherevalues = "status_id=".(int) $_POST["status_id"];
			$fields = array("status_code", "name_mn", "name_en", "desc_mn", "desc_en");
			$checkvalues = array($_POST["status_code"], $_POST["name_mn"], $_POST["name_en"], $_POST["desc_mn"], $_POST["desc_en"]);
			
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}			
			
			$result = $db->update("".$schemas.".tcredliststatus", $fields, $values, $wherevalues);
			if(! $result)
				show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
		}
	}
				
	if(($action=="delete") && isset($_GET["status_id"]))
	{
		$wherevalues = "status_id=".(int) $_GET["status_id"];
	
		$result = $db->delete("".$schemas.".tcredliststatus", $wherevalues);
		if(! $result)
			show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
		else
			show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
	}

	
	
	if ($action=="edit")
	{
		require("tcredliststatus/inc.edit_redliststatusform.php");
	}
	elseif ($action=="add")
	{
		require("tcredliststatus/inc.add_redliststatusform.php");
	}elseif ($action=="more")
	{
		require("tcredliststatus/inc.more_redliststatusform.php");
	}else
	{
		require("tcredliststatus/inc.list_redliststatusform.php");
	}
	
?>
