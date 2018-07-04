<?php
$my_url .= "?menuitem=".$menuitem;
if (isset($_GET["action"]))
{
	$action = $_GET["action"];
}else
{
	$action = "";
}

if($sess_profile==1) 
{
	if (isset($_POST["insertuserbttn"]) && (int) $_POST["insertuserbttn"]==1)
	{
		if (isset($_POST["login_name"]) && isset($_POST["login_password"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["organization"]))
		{				
			$login_date = date("Y-m-d H:i:s");
			$login_session = generateSessionString(16);
			
			$fields = array("login_name", "login_passwd", "firstname", "lastname", "organization", "phone", "email", "profile", "login_status", "login_date", "login_session");
			$checkvalues = array($_POST["login_name"], md5($_POST["login_password"]), $_POST["firstname"], $_POST["lastname"],$_POST["organization"], $_POST["phone"], 
			$_POST["email"], $_POST["profile"], $_POST["login_status"], $login_date, $login_session);
	
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}
			
			$result = $db->insert("".$schemas.".tausers", $fields, $values);
			if(! $result)
				show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
		}
	}
	
	if (($action=="delete") && isset($_GET["user_id"]))
	{
		$wherevalues = "user_id=".(int) $_GET["user_id"];
		
		$result = $db->delete("".$schemas.".tausergroups", $wherevalues);

		$result = $db->delete("".$schemas.".tausers", $wherevalues);
		if(! $result)
			show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
		else
			show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
	}
}	
		
if (isset($_POST["updateuserbttn"]) && (int) $_POST["updateuserbttn"]==1)
{
	if (isset($_POST["login_name"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["user_id"]) && isset($_POST["organization"]))
	{	
		$wherevalues = "user_id=".(int) $_POST["user_id"];
		$fields = array("login_name", "firstname", "lastname", "organization", "phone", "email", "profile", "login_status");
		$checkvalues = array($_POST["login_name"], $_POST["firstname"], $_POST["lastname"],$_POST["organization"], $_POST["phone"], 
		$_POST["email"], $_POST["profile"], $_POST["login_status"]);

		$values = array();
		for ($i=0; $i<sizeof($checkvalues); $i++)
		{
			$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
		}
		
		$result = $db->update("".$schemas.".tausers", $fields, $values, $wherevalues);
		if(! $result)
			show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
		else
			show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
	}
}
				
if (isset($_POST["updatepassbttn"]) && (int) $_POST["updatepassbttn"]==1)
{
	if (isset($_POST["login_password"]) && isset($_POST["user_id"]))
	{	
		$wherevalues = "user_id=".(int) $_POST["user_id"];
		
		$fields = array("login_passwd");
		$values = array("'".md5($_POST["login_password"])."'");
		
		$result = $db->update("".$schemas.".tausers", $fields, $values, $wherevalues);
		if(! $result)
			show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
		else
			show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
	}
}	

$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"]: 1;
$my_page = "&page=".$page;

$searchQuery = "";
$search_url = "";
	
$valueQuery1 = "";
$whereQuery1 = "";

$lastname = (isset($_GET["lastname"])) ? $_GET["lastname"]: "";	
$group_id = (isset($_GET["group_id"])) ? (int) $_GET["group_id"]: 0;	
$login_name = (isset($_GET["login_name"])) ? $_GET["login_name"]: "";	
$profile = (isset($_GET["profile"])) ? (int) $_GET["profile"]: 0;	
					
if(empty($lastname))
{
	$searchQuery .= "";
	$search_url .= "";
}else
{
	$searchQuery .= " AND lower(tu.lastname) LIKE lower('%".$lastname."%')";
	$search_url .= "&lastname=".$lastname;
}

if($group_id==0)
{
	$searchQuery .= "";
	$search_url .= "";
} else
{
	$searchQuery .= " AND tug.group_id = ".$group_id;
	$search_url .= "&group_id=".$group_id;
	
	$valueQuery1 = ", ".$schemas.".tausergroups tug";
	$whereQuery1 = " AND tu.user_id = tug.user_id";
}

if(empty($login_name))
{
	$searchQuery .= "";
	$search_url .= "";
}else
{
	$searchQuery .= " AND lower(tu.login_name) LIKE lower('%".$login_name."%')";
	$search_url .= "&login_name=".$login_name;
}

if($profile==0)
{
	$searchQuery .= "";
	$search_url .= "";
} else
{
	$searchQuery .= " AND tu.profile = ".$profile;
	$search_url .= "&profile=".$profile;
}	

$sort_url = "";
$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"]: 0;
$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"]: 0;

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
	require("tausers/inc.edit_userform.php");
}elseif ($action=="add")
{
	require("tausers/inc.add_userform.php");
}elseif ($action=="usergroups")
{
	require("tausers/inc.admin_usergroups.php");
}elseif ($action=="password")
{
	require("tausers/inc.edit_password.php");
}else
{
	require("tausers/inc.list_userform.php");
}
?>
