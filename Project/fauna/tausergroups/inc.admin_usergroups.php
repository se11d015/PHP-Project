<?php
if ($sess_profile==1)
{
	$my_url .= "?menuitem=".$menuitem;
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}else
	{
		$action = "";
	}

	if (isset($_POST["insertuserbttn"]))
	{
		if (isset($_POST["group_id"]) && isset($_POST["user_id"]))
		{
			$fields = array("group_id", "user_id");
			$checkvalues = array($_POST["group_id"], $_POST["user_id"]);
			
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}
			
			$result = $db->insert("".$schemas.".tausergroups", $fields, $values);
	
			if(! $result)
				show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
		}
	}
			
	if (($action=="delete") && isset($_GET["group_id"]) && isset($_GET["user_id"]))
	{
		$group_id = (int) $_GET["group_id"];
		$user_id = (int) $_GET["user_id"];
		$wherevalues = "group_id = ".$group_id." AND user_id=".$user_id;
		
		$result = $db->delete("".$schemas.".tausergroups", $wherevalues);
		if(! $result)
			show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
		else
			show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
	}
	
	$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"]: 1;
	$my_page = "&page=".$page;
	
	$searchQuery = "";
	$search_url = "";
	
	$groupid = (isset($_GET["groupid"])) ? (int) $_GET["groupid"]: 0;	
	$userid = (isset($_GET["userid"])) ? (int) $_GET["userid"]: 0;	
					
	if($groupid==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND taug.group_id = ".$groupid;
		$search_url .= "&groupid=".$groupid;
	}
	
	if($userid==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND taug.user_id = ".$userid;
		$search_url .= "&userid=".$userid;
	}
	
	if ($action=="add")
	{
		require("tausergroups/inc.add_usergroups.php");
	}else
	{
		require("tausergroups/inc.list_usergroups.php");
	}
} else {
		$notify ="Таны хандалт буруу байна.";
		show_notification("error", "", $notify);
}
?>
