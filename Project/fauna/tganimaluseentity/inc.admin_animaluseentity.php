<?php

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 1)) 
{
    $my_url .= "?menuitem=" . $menuitem;
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "";
    }
	
	require("modules/generategeom.class.php");  
   	
	if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 2)) 
	{
		if (isset($_POST["insertanimaluseentitybttn"]) && (int) $_POST["insertanimaluseentitybttn"] == 1) 
		{
			if (isset($_POST["aimag_name"]) && isset($_POST["soum_name"]) && isset($_POST["entity_type"]) && isset($_POST["entity_name"])) 
			 {      
				$geom = new generategeom();
				$geomvalues = "";
	
				$geomsrid = (int) $_POST["geom_srid"];
				$geomtype = (int) $_POST["geom_type"];
	
				// point
				if ($geomtype == 2) {
					$points = array();
	
					$points[0] = $_POST["x_coord"];
					$points[1] = $_POST["y_coord"];
				
					if($geomsrid ==4326)
						$geomvalues = $geom->generatePointGeom($points, 4326);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POINT");
				}
	
				// point
				if ($geomtype == 3) {
					$points = array();
	
					$points[0] = ($_POST["x_coordinate_sec"]/60 + $_POST["x_coordinate_min"])/60 + $_POST["x_coordinate_deg"];
					$points[1] = ($_POST["y_coordinate_sec"]/60 + $_POST["y_coordinate_min"])/60 + $_POST["y_coordinate_deg"];
						  
					$geomvalues = $geom->generatePointGeom($points, 4326);
	
				}
	
				if (empty($geomvalues))
					$geomvalues = "NULL";			
					
				
				$fields = array("aimag_name", "soum_name", "entity_type", "entity_name", "register_number", "location_address", "tel_number", "fax_number", "email_address", "web_address", "postal_address", "geom", "user_id");
				$checkvalues = array((int) $_POST["aimag_name"],(int) $_POST["soum_name"], (int) $_POST["entity_type"], $_POST["entity_name"], $_POST["register_number"], $_POST["location_address"],  $_POST["tel_number"],   $_POST["fax_number"], $_POST["email_address"], $_POST["web_address"], $_POST["postal_address"]);
				
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}
				array_push($values, $geomvalues, $sess_user_id);
	
				$result = $db->insert("" . $schemas . ".tganimaluseentity", $fields, $values);
				if (!$result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");	
			}
		}
    
        if (isset($_POST["updateanimaluseentitybttn"]) && (int) $_POST["updateanimaluseentitybttn"] == 1) 
		{
			if (isset($_POST["aimag_name"]) && isset($_POST["soum_name"]) && isset($_POST["entity_type"]) && isset($_POST["entity_name"]) && isset($_POST["entity_id"]))  
			{
                $wherevalues = "entity_id=" . (int) $_POST["entity_id"];

				$geom = new generategeom();
				$geomvalues = "";
	
				$geomsrid = (int) $_POST["geom_srid"];
				$geomtype = (int) $_POST["geom_type"];
	
				// point
				if ($geomtype == 2) {
					$points = array();
	
					$points[0] = $_POST["x_coord"];
					$points[1] = $_POST["y_coord"];
				
					if($geomsrid ==4326)
						$geomvalues = $geom->generatePointGeom($points, 4326);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POINT");
				}
	
				// point
				if ($geomtype == 3) {
					$points = array();
	
					$points[0] = ($_POST["x_coordinate_sec"]/60 + $_POST["x_coordinate_min"])/60 + $_POST["x_coordinate_deg"];
					$points[1] = ($_POST["y_coordinate_sec"]/60 + $_POST["y_coordinate_min"])/60 + $_POST["y_coordinate_deg"];
						  
					$geomvalues = $geom->generatePointGeom($points, 4326);
	
				}
	
				if (empty($geomvalues))
					$geomvalues = "NULL";
	
				$fields = array("aimag_name", "soum_name", "entity_type", "entity_name", "register_number", "location_address", "tel_number", "fax_number", "email_address", "web_address", "postal_address", "geom", "user_id");
				$checkvalues = array( $_POST["aimag_name"],  $_POST["soum_name"], (int) $_POST["entity_type"], $_POST["entity_name"], $_POST["register_number"], $_POST["location_address"],  $_POST["tel_number"],   $_POST["fax_number"], $_POST["email_address"], $_POST["web_address"], $_POST["postal_address"]);
				$values = array();
				
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
				}
				array_push($values, $geomvalues, (int) $_POST["user_id"]);
				
				$result = $db->update("".$schemas.".tganimaluseentity", $fields, $values, $wherevalues);
				if(! $result)
					  show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}

        if (($action == "delete") && isset($_GET["entity_id"])) 
		{

            $entity_id = (int) $_GET["entity_id"];

            if ($sess_profile == 1)
                $wherevalues = "entity_id = " . $entity_id;
            else
                $wherevalues = "entity_id = " . $entity_id . " AND user_id = " . $sess_user_id;

			$result = $db->delete("" . $schemas . ".tganimaluseentity", $wherevalues);
			if (!$result) 
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
        }
		
		if (isset($_POST["insertanimalusepermissionbttn"]) && (int) $_POST["insertanimalusepermissionbttn"] == 1) 
		{
			 if (isset($_POST["permission_type"]) && isset($_POST["entity_name"]) && isset($_POST["permission_number"]) && isset($_POST["approved_date"]) && isset($_POST["use_purpose"]) && isset($_POST["aimag_name"]) && isset($_POST["soum_name"]) && isset($_POST["place_name"])) 
			 {
				if ($_POST["approved_date"] != '0000-00-00')
					$approved_date = $_POST["approved_date"];
				else
					$approved_date = date('Y-m-d');
				
				if ($_POST["end_date"] != '0000-00-00')
					$end_date = $_POST["end_date"];
				else
					$end_date = NULL;            					
									
				$fields = array("permission_type", "entity_name", "approved_org", "approved_statement", "permission_number", "approved_date", "end_date", "use_purpose", "aimag_name", "soum_name", "place_name", "use_duration", "additional_info", "user_id");
				$checkvalues = array(  (int) $_POST["permission_type"], (int) $_POST["entity_name"], $_POST["approved_org"], $_POST["approved_statement"], $_POST["permission_number"], $approved_date, $end_date, (int) $_POST["use_purpose"], (int) $_POST["aimag_name"], (int) $_POST["soum_name"], $_POST["place_name"], $_POST["use_duration"], $_POST["additional_info"], $sess_user_id);
				
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}         
	
				$result = $db->insert("" . $schemas . ".taanimalusepermission", $fields, $values);
				if (!$result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");	
			}
		}
    
        if (isset($_POST["updateanimalusepermissionbttn"]) && (int) $_POST["updateanimalusepermissionbttn"] == 1) 
		{

            if (isset($_POST["permission_type"]) && isset($_POST["entity_name"]) && isset($_POST["permission_number"]) && isset($_POST["approved_date"]) && isset($_POST["use_purpose"]) && isset($_POST["aimag_name"]) && isset($_POST["soum_name"]) && isset($_POST["place_name"]) && isset($_POST["permission_id"]))
			{
                $wherevalues = "permission_id=" . (int) $_POST["permission_id"];

				if ($_POST["approved_date"] != '0000-00-00')
					$approved_date = $_POST["approved_date"];
				else
					$approved_date = date('Y-m-d');
					
				if ($_POST["end_date"] != '0000-00-00')
					$end_date = $_POST["end_date"];
				else
					$end_date = NULL;            					
									
				$fields = array("permission_type", "entity_name", "approved_org", "approved_statement", "permission_number", "approved_date", "end_date", "use_purpose", "aimag_name", "soum_name", "place_name", "use_duration", "additional_info", "user_id");
				$checkvalues = array(  (int) $_POST["permission_type"], (int) $_POST["entity_name"], $_POST["approved_org"], $_POST["approved_statement"], $_POST["permission_number"], $approved_date, $end_date, (int) $_POST["use_purpose"], (int) $_POST["aimag_name"], (int) $_POST["soum_name"], $_POST["place_name"], $_POST["use_duration"], $_POST["additional_info"], $sess_user_id);
				
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}					
				
				$result = $db->update("".$schemas.".taanimalusepermission", $fields, $values, $wherevalues);
				if(! $result)
					  show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
            }
        }

        if (($action == "delete") && isset($_GET["permission_id"])) 
		{
            $permission_id = (int) $_GET["permission_id"];

            if ($sess_profile == 1)
                $wherevalues = "permission_id = " . $permission_id;
            else
                $wherevalues = "permission_id = " . $permission_id . " AND user_id = " . $sess_user_id;

			$result = $db->delete("" . $schemas . ".taanimalusepermission", $wherevalues);
			if (!$result)
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
        }
		
	 	if (isset($_POST["insertanimalusenamebttn"]) && (int) $_POST["insertanimalusenamebttn"]==1)
		{
			if (isset($_POST["permission_id"]) && isset($_POST["species_code"]) && isset($_POST["use_amount"]))
			{	
				$fields = array("permission_id", "species_name", "use_amount", "amount_unit", "additional_info", "user_id");
				
				$checkvalues = array((int) $_POST["permission_id"],(int) $_POST["species_code"], $_POST["use_amount"], $_POST["amount_unit"], $_POST["additional_info"],  $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taanimalusename", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");	
			}
		}
		
		if (isset($_POST["updateanimalusenamebttn"]) && (int) $_POST["updateanimalusenamebttn"]==1)
		{
			if (isset($_POST["permission_id"]) && isset($_POST["species_code"]) && isset($_POST["use_amount"]) && isset($_POST["species_id"]))
			{	
				$wherevalues = "species_id=".(int) $_POST["species_id"];
				
				$fields = array("permission_id", "species_name", "use_amount", "amount_unit", "additional_info", "user_id");
				
				$checkvalues = array((int) $_POST["permission_id"],(int) $_POST["species_code"], $_POST["use_amount"], $_POST["amount_unit"], $_POST["additional_info"], (int) $_POST["user_id"]);	

	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taanimalusename", $fields, $values, $wherevalues);
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
			 
			$result = $db->delete("".$schemas.".taanimalusename",$wherevalues);
			if(! $result)
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
		}
		
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
    $aimag_name_mn = (isset($_GET["aimag_name_mn"])) ? $_GET["aimag_name_mn"] : "";
    $soum_name_mn = (isset($_GET["soum_name_mn"])) ? $_GET["soum_name_mn"] : "";
    $entity_type = (isset($_GET["entity_type"])) ? (int) $_GET["entity_type"] : 0;

    if (empty($aimag_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(taaim.aimag_name_mn) LIKE lower('%" . $aimag_name_mn . "%')";
        $search_url .= "&aimag_name_mn=" . $aimag_name_mn;
    }

    if (empty($soum_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {

        $searchQuery .= " AND lower(tasou.soum_name_mn) LIKE lower('%" . $soum_name_mn . "%')";
        $search_url .= "&soum_name_mn=" . $soum_name_mn;
    }

    if (empty($entity_name)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tgcen.entity_name) LIKE lower('%" . $entity_name . "%')";
        $search_url .= "&entity_name=" . $entity_name;
    }

	if($entity_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND tgcen.entity_type = ".$entity_type;
	    $search_url .= "&entity_type=".$entity_type;
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
        require("tganimaluseentity/inc.edit_animaluseentityform.php");
    }elseif ($action=="permissionedit"){
		require("tganimaluseentity/inc.edit_animalusepermissionform.php");
    }elseif ($action=="paymentedit"){
		require("tganimaluseentity/inc.edit_animalusepaymentform.php");
	}elseif ($action=="useedit"){
		require("tganimaluseentity/inc.edit_animalusenameform.php");
	}elseif ($action == "output") {
	    require("tganimaluseentity/inc.output_animaluseentityform.php");
    } elseif ($action == "add") {
        require("tganimaluseentity/inc.add_animaluseentityform.php");
    }elseif ($action=="permissionadd"){  
	    require("tganimaluseentity/inc.add_animalusepermissionform.php");
    }elseif ($action=="paymentadd"){
		require("tganimaluseentity/inc.add_animalusepaymentform.php");
	}elseif ($action=="useadd"){  
	    require("tganimaluseentity/inc.add_animalusenameform.php");
	} elseif ($action == "more") {
        require("tganimaluseentity/inc.more_animaluseentityform.php");
    } elseif ($action == "permissionmore") {
        require("tganimaluseentity/inc.more_animalusepermissionform.php");
    } elseif ($action == "paymentmore") {
        require("tganimaluseentity/inc.more_animalusepaymentform.php");
    } else {
        require("tganimaluseentity/inc.list_animaluseentityform.php");
    }
} else {
    $notify = "Таны хандалт буруу байна.";
    show_notification("error", "", $notify);
}
?>
