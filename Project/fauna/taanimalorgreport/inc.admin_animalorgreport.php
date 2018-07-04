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
					$path = $path . "/" . $report_type. "/";;
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
							unlink($_POST["report_path"] . "/" . $_POST["report_file"]);
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
						unlink($rowfile[0]["report_path"] . "/" . $rowfile[0]["report_file"]);
				}
			}
		}
	}
	
	$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"]: 1;
	$my_page = "&page=".$page;
	
	$searchQuery = "";
	$search_url = "";
		
	$report_name = (isset($_GET["report_name"])) ? $_GET["report_name"] : "";	
	$type_name = (isset($_GET["type_name"])) ? (int) $_GET["type_name"]: 0;	

	
	if(empty($report_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapr.report_name) LIKE lower('%".$report_name."%')";
		$search_url .= "&report_name=".$report_name;
	}
	
	if($type_name==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tapr.report_type = ".$type_name;
		$search_url .= "&type_name=".$type_name;
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
		require("taanimalorgreport/inc.edit_animalorgreportform.php");
	}elseif ($action=="add")
	{
		require("taanimalorgreport/inc.add_animalorgreportform.php");
	}elseif ($action == "activityadd") 
	{
        require("taanimalorgreport/inc.add_animalorgactivityform.php");
    }elseif ($action=="select")
	{
		require("taanimalorgreport/inc.select_animalorg.php");
	}elseif ($action == "more") 
	{
        require("taanimalorgreport/inc.more_animalorgreportform.php");
    }else
	{
		require("taanimalorgreport/inc.list_animalorgreportform.php");
	}
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}
?>
