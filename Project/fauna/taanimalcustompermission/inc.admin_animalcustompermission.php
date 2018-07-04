<?php

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 1)) 
{
    $my_url .= "?menuitem=" . $menuitem;
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "";
    }

	if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 2)) 
	{     
		if (isset($_POST["insertanimalcustompermissionbttn"]) && (int) $_POST["insertanimalcustompermissionbttn"] == 1) 
		{
			 if (isset($_POST["permission_type"]) && isset($_POST["entity_id"]) && isset($_POST["permission_type"]) && isset($_POST["approved_date"]) && isset($_POST["end_date"])) 
			 {
				if ($_POST["approved_date"] != '0000-00-00')
					$approved_date = $_POST["approved_date"];
				else
					$approved_date = date('Y-m-d');
				
				if ($_POST["end_date"] != '0000-00-00')
					$end_date = $_POST["end_date"];
				else
					$end_date = date('Y-m-d');            					
				
				$fields = array("permission_type", "entity_name", "approved_org", "approved_statement", "permission_number", "approved_date", "end_date", "port_name", "importer_country", "importer_name", "origin_name", "additional_info",  "user_id");
				$checkvalues = array(  (int) $_POST["permission_type"], (int) $_POST["entity_id"], $_POST["approved_org"],  
				$_POST["approved_statement"], $_POST["permission_number"], $approved_date, $end_date, $_POST["port_name"], $_POST["importer_country"], $_POST["importer_name"], $_POST["origin_name"], $_POST["additional_info"], $sess_user_id);
				
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}         
	
				$result = $db->insert("" . $schemas . ".taanimalcustompermission", $fields, $values);
				if (!$result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");	
			}
		}
    
        if (isset($_POST["updateanimalcustompermissionbttn"]) && (int) $_POST["updateanimalcustompermissionbttn"] == 1) 
		{

            if (isset($_POST["permission_type"]) && isset($_POST["entity_name"]) && isset($_POST["permission_type"]) && isset($_POST["approved_date"]) && isset($_POST["end_date"]) && isset($_POST["permission_id"]))
			{
                $wherevalues = "permission_id=" . (int) $_POST["permission_id"];

				if ($_POST["approved_date"] != '0000-00-00')
					$approved_date = $_POST["approved_date"];
				else
					$approved_date = date('Y-m-d');
				if ($_POST["end_date"] != '0000-00-00')
					$end_date = $_POST["end_date"];
				else
					$end_date = date('Y-m-d');

				$fields = array("permission_type", "entity_name", "approved_org", "approved_statement", "permission_number", "approved_date", "end_date", "port_name", "importer_country", "importer_name", "origin_name", "additional_info",  "user_id");
				$checkvalues = array(  (int) $_POST["permission_type"], (int) $_POST["entity_name"], $_POST["approved_org"], $_POST["approved_statement"], $_POST["permission_number"], $approved_date, $end_date, $_POST["port_name"], $_POST["importer_country"], $_POST["importer_name"], $_POST["origin_name"], $_POST["additional_info"],(int) $_POST["user_id"]);
				
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}					
				
				$result = $db->update("".$schemas.".taanimalcustompermission", $fields, $values, $wherevalues);
				if(! $result) {
					  show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				} else {
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
                }
            }
        }

        if (($action == "delete") && isset($_GET["permission_id"])) 
		{
            $permission_id = (int) $_GET["permission_id"];

            if ($sess_profile == 1)
                $wherevalues = "permission_id = " . $permission_id;
            else
                $wherevalues = "permission_id = " . $permission_id . " AND user_id = " . $sess_user_id;

			$result = $db->delete("" . $schemas . ".taanimalcustompermission", $wherevalues);
			if (!$result) {
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			} else {
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
				
			}

        } 
	 	if (isset($_POST["insertanimalcustomnamebttn"]) && (int) $_POST["insertanimalcustomnamebttn"]==1)
		{
			if (isset($_POST["permission_id"]) && isset($_POST["species_code"]) && isset($_POST["species_amount"]))
			{	
				$fields = array("permission_id", "species_name", "species_amount", "amount_unit", "species_info", "user_id");
				
				$checkvalues = array((int) $_POST["permission_id"],(int) $_POST["species_code"], $_POST["species_amount"], $_POST["amount_unit"], $_POST["species_info"],  $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taanimalcustomname", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");	
			}
		}
		
		if (isset($_POST["updateanimalcustomnamebttn"]) && (int) $_POST["updateanimalcustomnamebttn"]==1)
		{
			if (isset($_POST["permission_id"]) && isset($_POST["species_code"]) && isset($_POST["species_amount"]) && isset($_POST["species_id"]))
			{	
				$wherevalues = "species_id=".(int) $_POST["species_id"];
				
				$fields = array("permission_id", "species_name", "species_amount", "amount_unit", "species_info", "user_id");
				
				$checkvalues = array((int) $_POST["permission_id"],(int) $_POST["species_code"], $_POST["species_amount"], $_POST["amount_unit"], $_POST["species_info"],  (int) $_POST["user_id"]);	

	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taanimalcustomname", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}
						
		if (($action=="delete") && isset($_GET["species_id"]))
		{
			$species_id = (int) $_GET["species_id"];
			
			if($sess_profile==1)
				$wherevalues = "species_id = ".$species_id;
			else
				$wherevalues = "species_id = ".$species_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".taanimalcustomname",$wherevalues);
			if(! $result)
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
		
		}
		
    }
	
    $page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
    $my_page = "&page=" . $page;

    $searchQuery = "";
    $search_url = "";

    $permission_number = (isset($_GET["permission_number"])) ? $_GET["permission_number"] : "";
	$approved_date = (isset($_GET["approved_date"])) ? (int) $_GET["approved_date"] : 0;
	$end_date = (isset($_GET["end_date"])) ? (int) $_GET["end_date"] : 0;
	$permission_type = (isset($_GET["permission_type"])) ? (int) $_GET["permission_type"] : 0;
    $entity_name = (isset($_GET["entity_name"])) ? $_GET["entity_name"] : "";

	if($permission_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND tgcpe.permission_type = ".$permission_type;
	    $search_url .= "&permission_type=".$permission_type;
	}
	
	if($end_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgcpe.end_date) = ".$end_date;
		$search_url .= "&end_date=".$end_date;
	}
	
    if($approved_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgcpe.approved_date) = ".$approved_date;
		$search_url .= "&approved_date=".$approved_date;
	}	

	if(empty($entity_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgcen.entity_name) LIKE lower('%".$entity_name."%')";
		$search_url .= "&entity_name=".$entity_name;
	}

	if(empty($permission_number))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgcpe.permission_number) LIKE lower('%".$permission_number."%')";
		$search_url .= "&permission_number=".$permission_number;
	}
	
    $sort_url = "";
    $sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
    $sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;

    if ($sort == 0)
        $sort_url .= "";
    else
        $sort_url .= "&sort=" . $sort;

    if ($sort_type == 0)
        $sort_url .= "";
    else
        $sort_url .= "&sorttype=" . $sort_type;
	
    if ($action == "edit") {
        require("taanimalcustompermission/inc.edit_animalcustompermissionform.php");
	}elseif ($action == "add") {
        require("taanimalcustompermission/inc.add_animalcustompermissionform.php");
	}elseif ($action=="customedit") {
		require("taanimalcustompermission/inc.edit_animalcustomnameform.php");
	}elseif ($action == "customadd") {
        require("taanimalcustompermission/inc.add_animalcustomnameform.php");
	}elseif ($action == "output") {
        require("tganimalcustomentity/inc.output_animalcustomentityform.php");
    }elseif ($action == "more"){
        require("taanimalcustompermission/inc.more_animalcustompermissionform.php");
    } else {
        require("taanimalcustompermission/inc.list_animalcustompermissionform.php");
    }
} else {
    $notify = "Таны хандалт буруу байна.";
    show_notification("error", "", $notify);
}
?>
