<?php

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 1)) 
{
    $my_url .= "?menuitem=" . $menuitem;
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "";
    }

    if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2)) 
	{
        require("modules/generategeom.class.php");
		require("modules/upload_document.class.php");

        if (isset($_POST["insertanimalorgbttn"]) && (int) $_POST["insertanimalorgbttn"] == 1) 
		{
            if (isset($_POST["org_name"])) 
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

                $fields = array("aimag_name", "soum_name", "org_name", "register_number", "location_address", "tel_number", "fax_number", "email_address", "web_address", "postal_address", "geom", "user_id");

                $checkvalues = array($_POST["aimag_name"], $_POST["soum_name"], $_POST["org_name"], $_POST["register_number"], $_POST["location_address"], $_POST["tel_number"], $_POST["fax_number"], $_POST["email_address"], $_POST["web_address"], $_POST["postal_address"]);

                $values = array();
                for ($i = 0; $i < sizeof($checkvalues); $i++) {
                    $values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
                }
                array_push($values, $geomvalues, $sess_user_id);

                $result = $db->insert("" . $schemas . ".tganimalorg", $fields, $values);
                if (!$result)
                    show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
                else
                    show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
            }
        }
   
    	if (isset($_POST["updateanimalorgbttn"]) && (int) $_POST["updateanimalorgbttn"] == 1) 
		{

        	if (isset($_POST["org_name"]) && isset($_POST["org_id"]))
		 	{
            	$wherevalues = "org_id=" . (int) $_POST["org_id"];

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
           
                $fields = array("aimag_name", "soum_name", "org_name", "register_number", "location_address", "tel_number", "fax_number", "email_address", "web_address", "postal_address", "geom", "user_id");
                $checkvalues = array($_POST["aimag_name"], $_POST["soum_name"], $_POST["org_name"], $_POST["register_number"], $_POST["location_address"], $_POST["tel_number"], $_POST["fax_number"], $_POST["email_address"], $_POST["web_address"], $_POST["postal_address"]);

                $values = array();
                for ($i = 0; $i < sizeof($checkvalues); $i++) {
                    $values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
                }
                array_push($values, $geomvalues, (int) $_POST["user_id"]);
  

				$result = $db->update("" . $schemas . ".tganimalorg", $fields, $values, $wherevalues);
				if (!$result) {
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				} else {
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
				}
			}
        }

		if (($action == "delete") && isset($_GET["org_id"])) {
			$org_id = (int) $_GET["org_id"];
	
			if ($sess_profile == 1)
				$wherevalues = "org_id = " . $org_id;
			else
				$wherevalues = "org_id = " . $org_id . " AND user_id = " . $sess_user_id;
	
			$result = $db->delete("" . $schemas . ".tganimalorg", $wherevalues);
			if (!$result)
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
		}


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

    	if (isset($_POST["insertanimalorgreportbttn"]) && (int) $_POST["insertanimalorgreportbttn"] == 1) 
		{
        	if (isset($_POST["org_name"]) && isset($_POST["report_type"]) && isset($_POST["report_name"])) 
			{

				$report_type = $_POST["report_type"];
				$report_file = "";
				$report_path = "";
	
				if (is_uploaded_file($_FILES['report_file']['tmp_name'])) {
					$today = date('Y-m-d');
	
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/" . $year;
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $_MY_CONF["ANIMALORGREPORT_PATH"];
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $report_type . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
	
					$uploader = new file_upload();
					$uploader->first_values('', '_' . $report_type, 'MB', '20');
					$uploader->uploader_set($_FILES['report_file'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $DOCUMENT_TYPES);
	
					if ($uploader->uploaded) {
						$report_file = $uploader->uploaded_files[0];
						$report_path = $path;
					} else {
						show_notification("error", "", $uploader->error);
					}
				}
	
				$fields = array("org_name", "report_type", "report_name", "report_duration", "report_summary", "report_file", "report_path", "user_id");
	
				$checkvalues = array((int) $_POST["org_name"], $_POST["report_type"], $_POST["report_name"], $_POST["report_duration"], $_POST["report_summary"], $report_file, $report_path, $sess_user_id);
	
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}
	
				$result = $db->insert("" . $schemas . ".taanimalorgreport", $fields, $values);
				if (!$result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
			}
		}

    	if (isset($_POST["updateanimalreportbttn"]) && (int) $_POST["updateanimalreportbttn"] == 1) 
		{
			if (isset($_POST["org_name"]) && isset($_POST["report_type"]) && isset($_POST["report_name"]) && isset($_POST["report_id"])) 
			{
				$wherevalues = "report_id=" . (int) $_POST["report_id"];
				
				$report_type = (int) $_POST["report_type"];
				$report_file = "";
				$report_path = "";
	
				if (is_uploaded_file($_FILES['report_file']['tmp_name'])) {
					$today = date('Y-m-d');
	
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/" . $year;
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $_MY_CONF["ANIMALORGREPORT_PATH"];
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $report_type. "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
	
					$uploader = new file_upload();
					$uploader->first_values('', '_' . $report_type, 'MB', '20');
					$uploader->uploader_set($_FILES['report_file'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $DOCUMENT_TYPES);
	
					if ($uploader->uploaded) {
						$report_file = $uploader->uploaded_files[0];
						$report_path = $path;
						if (!empty($_POST["report_path"]) && !empty($_POST["report_file"]))
							unlink($_POST["report_path"] . $_POST["report_file"]);
					} else {
						show_notification("error", "", $uploader->error);
					}
				} else {
					if (isset($_POST["report_file"]) && strlen($_POST["report_file"]) > 0) {
						$report_file = $_POST["report_file"];
					}
				}
	
				$fields = array("org_name", "report_type", "report_name", "report_duration", "report_summary", "report_file", "report_path", "user_id");
	
				$checkvalues = array((int) $_POST["org_name"], $_POST["report_type"], $_POST["report_name"], $_POST["report_duration"], $_POST["report_summary"], $report_file, $report_path, (int) $_POST["user_id"]);
	
	
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}
	
				$result = $db->update("" . $schemas . ".taanimalorgreport", $fields, $values, $wherevalues);
				if (!$result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}


	    if (($action == "reportdelete") && isset($_GET["report_id"])) 
		{
			$report_id = (int) $_GET["report_id"];
	
			if ($sess_profile == 1)
				$wherevalues = "report_id = " . $report_id;
			else
				$wherevalues = "report_id = " . $report_id . " AND user_id = " . $sess_user_id;
	
			$selQuery = "SELECT report_file, report_path FROM " . $schemas . ".taanimalorgreport WHERE " . $wherevalues;
			$rowfile = $db->query($selQuery);
	
			$result = $db->delete("" . $schemas . ".taanimalorgreport", $wherevalues);
			if (!$result) {
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			} else {
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
	
				if (!empty($rowfile)) {
					if (!empty($rowfile[0]["report_path"]) && !empty($rowfile[0]["report_file"]))
						unlink($rowfile[0]["report_path"] . $rowfile[0]["report_file"]);
				}
			}
		}
	}

    $page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
    $my_page = "&page=" . $page;

    $searchQuery = "";
    $search_url = "";

    $org_name = (isset($_GET["org_name"])) ? $_GET["org_name"] : "";
    $aimag_code = (isset($_GET["aimag_code"])) ? (int) $_GET["aimag_code"] : 0;

    if (empty($org_name)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tapr.org_name) LIKE lower('%" . $org_name . "%')";
        $search_url .= "&org_name=" . $org_name;
    }
	
    if ($aimag_code == 0) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND tapr.aimag_name = " . $aimag_code;
        $search_url .= "&aimag_name=" . $aimag_code;
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
        require("tganimalorg/inc.edit_animalorgform.php");
    } elseif ($action == "add") {
        require("tganimalorg/inc.add_animalorgform.php");
    } elseif ($action == "permissionadd") {
        require("tganimalorg/inc.add_animalorgpermissionform.php");
    } elseif ($action == "permissionedit") {
        require("tganimalorg/inc.edit_animalorgpermissionform.php");
    } elseif ($action == "reportadd") {
        require("tganimalorg/inc.add_animalorgreportform.php");
    } elseif ($action == "reportedit") {
        require("tganimalorg/inc.edit_animalorgreportform.php");
    } elseif ($action == "output") {
		require("tganimalorg/inc.output_animalorgform.php");
	} elseif ($action == "more") {
        require("tganimalorg/inc.more_animalorgform.php");
	} elseif ($action == "permissionmore") {
        require("tganimalorg/inc.more_animalorgpermissionform.php");
    } else {
        require("tganimalorg/inc.list_animalorgform.php");
    }
} else {
    $notify = "Таны хандалт буруу байна.";
    show_notification("error", "", $notify);
}
?>
