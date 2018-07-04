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

	if (isset($_POST["insertgrouprolebttn"]))
	{
		if (isset($_POST["group_id"]) && isset($_POST["item_id"]) && isset($_POST["role_id"]))
		{
			$itemid = (int) $_POST["item_id"];
			
			if($itemid==0){
				
				$fields = array("group_id", "item_id", "role_id");
				$group_id = (int) $_POST["group_id"];
				$role_id = (int) $_POST["role_id"];
	
				$count = 0;
				for($j = 1; $j < sizeof(GROUP_ITEM_TYPE); $j++)
				{				
					$checkvalues = array($group_id, $j, $role_id);
					$values = array();
					for ($i=0; $i<sizeof($checkvalues); $i++)
					{
						$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
					}
					
					$result = $db->insert("".$schemas.".tagrouproles", $fields, $values);
					if(! $result)
						show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
					else
						$count++;					
				}
				
				if($count>0)
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");					
			
			} else {
				$fields = array("group_id", "item_id", "role_id");
				$checkvalues = array($_POST["group_id"], $_POST["item_id"], $_POST["role_id"]);
				
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".tagrouproles", $fields, $values);
		
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
			}
		}
	}
			
	if (($action=="delete") && isset($_GET["group_id"]) && isset($_GET["item_id"]) && isset($_GET["role_id"]))
	{
		$group_id = (int) $_GET["group_id"];
		$item_id = (int) $_GET["item_id"];
		$role_id = (int) $_GET["role_id"];		
		$wherevalues = "group_id = ".$group_id." AND item_id=".$item_id." AND role_id=".$role_id;
		
		$result = $db->delete("".$schemas.".tagrouproles", $wherevalues );
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
	$itemid = (isset($_GET["itemid"])) ? (int) $_GET["itemid"]: 0;	
	$roleid = (isset($_GET["roleid"])) ? (int) $_GET["roleid"]: 0;			
					
	if($groupid==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tagr.group_id = ".$groupid;
		$search_url .= "&groupid=".$groupid;
	}
	
	if($itemid==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tagr.item_id = ".$itemid;
		$search_url .= "&itemid=".$itemid;
	}	

	if($roleid==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tagr.role_id = ".$roleid;
		$search_url .= "&roleid=".$roleid;
	}
			
	if ($action=="add")
	{
		require("tagrouproles/inc.add_grouproles.php");
	}else
	{
		require("tagrouproles/inc.list_grouproles.php");
	}
} else {
		$notify ="Таны хандалт буруу байна.";
		show_notification("error", "", $notify);
}
?>
