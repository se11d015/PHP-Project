<?php

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 1)) 
{
    $my_url .= "?menuitem=" . $menuitem;
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "";
    }
    
	if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 2)) 
	{
	 	if (isset($_POST["insertanimalusepaymentbttn"]) && (int) $_POST["insertanimalusepaymentbttn"]==1)
		{
			if (isset($_POST["permission_id"]) && isset($_POST["species_code"]) && isset($_POST["used_amount"]) && isset($_POST["report_date"]))
			{	
				if ($_POST["report_date"] != '0000-00-00')
					$report_date = $_POST["report_date"];
				else
					$report_date = date('Y-m-d');
				
				$fields = array("report_date", "permission_id", "species_name", "used_amount", "amount_unit", "ecology_rate", "payment_value", "discount_value", "total_payment", "additional_info", "user_id");
				
				$checkvalues = array($report_date, (int) $_POST["permission_id"], (int) $_POST["species_code"], $_POST["used_amount"], $_POST["amount_unit"], $_POST["ecology_rate"], $_POST["payment_value"], $_POST["discount_value"], $_POST["total_payment"], $_POST["additional_info"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taanimalusepayment", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны үндсэн мэдээлэл амжилттай нэмэгдлээ.");	
			}
		}
		
		if (isset($_POST["updateanimalusepaymentbttn"]) && (int) $_POST["updateanimalusepaymentbttn"]==1)
		{
			if (isset($_POST["permission_id"]) && isset($_POST["species_code"]) && isset($_POST["used_amount"]) && isset($_POST["report_date"]) && isset($_POST["payment_id"]))
			{	
				$wherevalues = "payment_id=".(int) $_POST["payment_id"];
				
				if ($_POST["report_date"] != '0000-00-00')
					$report_date = $_POST["report_date"];
				else
					$report_date = date('Y-m-d');
				
				$fields = array("report_date", "permission_id", "species_name", "used_amount", "amount_unit", "ecology_rate", "payment_value", "discount_value", "total_payment", "additional_info", "user_id");
				
				$checkvalues = array($report_date, (int) $_POST["permission_id"], (int) $_POST["species_code"], $_POST["used_amount"], $_POST["amount_unit"], $_POST["ecology_rate"], $_POST["payment_value"], $_POST["discount_value"], $_POST["total_payment"], $_POST["additional_info"],  (int) $_POST["user_id"]);	

	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taanimalusepayment", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}
						
		if (($action=="delete") && isset($_GET["payment_id"]))
		{
			$payment_id = (int) $_GET["payment_id"];
			
			if($sess_profile==1)
				$wherevalues = "payment_id = ".$payment_id;
			else
				$wherevalues = "payment_id = ".$payment_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".taanimalusepayment",$wherevalues);
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

    $entity_name = (isset($_GET["entity_name"])) ? $_GET["entity_name"] : "";
	$permission_number = (isset($_GET["permission_number"])) ? $_GET["permission_number"] : "";
	$species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
    $species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";
	

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
	
	if(empty($species_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taan.species_name_mn) LIKE lower('%".$species_name_mn."%') OR lower(tagn.genus_name_mn) LIKE lower('%".$species_name_mn."%') )";
		$search_url .= "&species_name_mn=".$species_name_mn;
	}
	
	if(empty($species_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taan.species_name) LIKE lower('%".$species_name."%') OR lower(tagn.genus_name) LIKE lower('%".$species_name."%') )";
		$search_url .= "&species_name=".$species_name;
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
        require("taanimalusepayment/inc.edit_animalusepaymentform.php");
    }elseif ($action == "add") {
        require("taanimalusepayment/inc.add_animalusepaymentform.php");
    }elseif ($action == "more") {
        require("taanimalusepayment/inc.more_animalusepaymentform.php");
    } else {
        require("taanimalusepayment/inc.list_animalusepaymentform.php");
    }
} else {
    $notify = "Таны хандалт буруу байна.";
    show_notification("error", "", $notify);
}
?>
