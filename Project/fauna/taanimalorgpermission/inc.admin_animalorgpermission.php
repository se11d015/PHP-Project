<?php
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 1))
{
	require("modules/upload_document.class.php");
	
	$my_url .= "?menuitem=".$menuitem;
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}else
	{
		$action = "";
	}

	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2))
	{
    	if (isset($_POST["insertanimalorgpermissionbttn"]) && (int) $_POST["insertanimalorgpermissionbttn"] == 1) 
		{
        	 if (isset($_POST["org_name"]) && isset($_POST["permission_number"])&& isset($_POST["activity_name"])&& isset($_POST["approved_date"])){
			 
				$activity_name = "";
				$fldCode = $_POST["activity_name"];

				if(is_array($fldCode)){
					for($j=0; $j<count($fldCode); $j++){
						$activity_name .= (empty($fldCode[$j]) ? "": $fldCode[$j].", ");		
					}
				}	
				
				if ($_POST["approved_date"] != '0000-00-00')
					$approved_date = $_POST["approved_date"];
				else
					$approved_date = date('Y-m-d');
	
				if ($_POST["canceled_date"] != '0000-00-00')
					$canceled_date = $_POST["canceled_date"];
				else
					$canceled_date = NULL;
	
				if ($_POST["extended_date"] != '0000-00-00')
					$extended_date = $_POST["extended_date"];
				else
					$extended_date = NULL;
	
				if ($_POST["end_date"] != '0000-00-00')
					$end_date = $_POST["end_date"];
				else
					$end_date = NULL;
	
				$fields = array("org_name", "activity_name", "permission_number", "approved_org", "approved_date", "approved_statement", "canceled_org", "canceled_date", "canceled_statement", "extended_org", "extended_date", "extended_statement", "end_date", "additional_info", "user_id");
	
				$checkvalues = array((int) $_POST["org_name"], $activity_name, $_POST["permission_number"], $_POST["approved_org"], $approved_date, $_POST["approved_statement"], $_POST["canceled_org"], $canceled_date, $_POST["canceled_statement"], $_POST["extended_org"], $extended_date, $_POST["extended_statement"], $end_date, $_POST["additional_info"], $sess_user_id);
	
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}
	
				$result = $db->insert("" . $schemas . ".taanimalorgpermission", $fields, $values);
				if (!$result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
			}
		}

    	if (isset($_POST["updateanimalorgpermissionbttn"]) && (int) $_POST["updateanimalorgpermissionbttn"] == 1) 
		{
        	if (isset($_POST["permission_number"]) && isset($_POST["org_name"]) && isset($_POST["approved_date"]) && isset($_POST["permission_id"])) 
			{
				$wherevalues = "permission_id=" . (int) $_POST["permission_id"];
				
				$activity_name = "";
				$fldCode = $_POST["activity_name"];

				if(is_array($fldCode)){
					for($j=0; $j<count($fldCode); $j++){
						$activity_name .= (empty($fldCode[$j]) ? "": $fldCode[$j].", ");		
					}
				}	
	
				if ($_POST["approved_date"] != '0000-00-00')
					$approved_date = $_POST["approved_date"];
				else
					$approved_date = date('Y-m-d');
	
				if ($_POST["canceled_date"] != '0000-00-00')
					$canceled_date = $_POST["canceled_date"];
				else
					$canceled_date = NULL;
	
				if ($_POST["extended_date"] != '0000-00-00')
					$extended_date = $_POST["extended_date"];
				else
					$extended_date = NULL;
	
				 if ($_POST["end_date"] != '0000-00-00')
					$end_date = $_POST["end_date"];
				else
					$end_date = NULL;
	
				$fields = array("org_name", "activity_name", "permission_number", "approved_org", "approved_date", "approved_statement", "canceled_org", "canceled_date", "canceled_statement", "extended_org", "extended_date", "extended_statement", "end_date", "additional_info", "user_id");
	
				$checkvalues = array((int) $_POST["org_name"], $activity_name, $_POST["permission_number"], $_POST["approved_org"], $approved_date, $_POST["approved_statement"], $_POST["canceled_org"], $canceled_date, $_POST["canceled_statement"], $_POST["extended_org"], $extended_date, $_POST["extended_statement"], $end_date, $_POST["additional_info"], (int) $_POST["user_id"]);
	
	
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}
	
				$result = $db->update("" . $schemas . ".taanimalorgpermission", $fields, $values, $wherevalues);
				if (!$result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}

    	if (($action == "permissiondelete") && isset($_GET["permission_id"])) 
		{
			$permission_id = (int) $_GET["permission_id"];
	
			if ($sess_profile == 1)
				$wherevalues = "permission_id = " . $permission_id;
			else
				$wherevalues = "permission_id = " . $permission_id . " AND user_id = " . $sess_user_id;
	
			$result = $db->delete("" . $schemas . ".taanimalorgpermission", $wherevalues);
			if (!$result)
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
    	}
	}
	
	$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"]: 1;
	$my_page = "&page=".$page;
	
	$searchQuery = "";
	$search_url = "";
	
	$org_name = (isset($_GET["org_name"])) ? $_GET["org_name"] : "";	
	$aimag_code = (isset($_GET["aimag_code"])) ? (int) $_GET["aimag_code"]: 0;
	$permission_number = (isset($_GET["permission_number"])) ? $_GET["permission_number"] : "";
	$approved_date = (isset($_GET["approved_date"])) ? (int) $_GET["approved_date"]: 0;
	$end_date = (isset($_GET["end_date"])) ? (int) $_GET["end_date"]: 0;
	$type_name = (isset($_GET["type_name"])) ? $_GET["type_name"]: "";	
	
	if(empty($type_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapp.activity_name) LIKE lower('%".$type_name."%')";
		$search_url .= "&type_name=".$type_name;
	}
	
	if(empty($org_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgpo.org_name) LIKE lower('%".$org_name."%')";
		$search_url .= "&org_name=".$org_name;
	}
	
	if($aimag_code==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tgpo.aimag_name = ".$aimag_code;
		$search_url .= "&aimag_code=".$aimag_code;
	}
	
	if(empty($permission_number))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapp.permission_number) LIKE lower('%".$permission_number."%')";
		$search_url .= "&permission_number=".$permission_number;
	}
	
	if($approved_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND date_part('year',tapp.approved_date) = ".$approved_date;
		$search_url .= "&approved_date=".$approved_date;
	}
	
	if($end_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND date_part('year',tapp.end_date) = ".$end_date;
		$search_url .= "&end_date=".$end_date;
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
		require("taanimalorgpermission/inc.edit_animalorgpermissionform.php");
	}elseif ($action=="add")
	{
		require("taanimalorgpermission/inc.add_animalorgpermissionform.php");
	}elseif ($action == "activityadd") {
        require("taanimalorgpermission/inc.add_animalorgactivityform.php");
    }elseif ($action=="select")
	{
		require("taanimalorgpermission/inc.select_animalorg.php");
	}elseif ($action == "more") {
        require("taanimalorgpermission/inc.more_animalorgpermissionform.php");
    }else
	{
		require("taanimalorgpermission/inc.list_animalorgpermissionform.php");
	}
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}
?>
