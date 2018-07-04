<?php

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 1)) {
require("modules/generategeom.class.php");
require("modules/upload_document.class.php");

$my_url .= "?menuitem=" . $menuitem;
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 2)) {

    if (isset($_POST["insertmngbttn"]) && (int) $_POST["insertmngbttn"] == 1) {
        if (isset($_POST["zone_name"])) {
		   		
            if ($_POST["doc_date"] != '0000-00-00')
                $doc_date = $_POST["doc_date"];
            else
                $doc_date = date('Y-m-d');
				
                $doc_filename = "";
				$doc_pathname = "";		
				if (is_uploaded_file($_FILES['doc_filename']['tmp_name']))
				{
					$today = date('Y-m-d');
					
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/".$year;
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path."/".$_MY_CONF["taanimalmng_PATH"];
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path;
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
						
					$uploader = new file_upload();
					$uploader->first_values('','','MB','20') ;
					$uploader->uploader_set($_FILES['doc_filename'], date("Y", strtotime($today)).date("m", strtotime($today)).date("d", strtotime ($today)), $path, $DOCUMENT_TYPES);
					
					if ($uploader->uploaded) {
                        if (!empty($_POST["doc_pathname"]) > 0 && !empty($_POST["doc_filename"]))
                            unlink($_POST["doc_pathname"] . $_POST["doc_filename"]);
                        $doc_filename = $uploader->uploaded_files[0];
                        $doc_pathname = $path;
                    } else {
                        show_notification("error", "", $uploader->error);
                    }
                } else {
                    if (isset($_POST["doc_pathname"]) && !empty($_POST["doc_pathname"]) && isset($_POST["doc_filename"]) && !empty($_POST["doc_filename"])) {
                        $doc_filename = $_POST["doc_filename"];
                        $doc_pathname = $_POST["doc_pathname"];
                    }
                }

            $fields = array("zone_name", "doc_type", "doc_date", 
			"doc_filename", "doc_pathname", "user_id");
            $values = array("'".$_POST["zone_name"]."'",  (int) $_POST["type_id"],  "'".$doc_date."'", 
			"'".$doc_filename."'", "'".$doc_pathname."'", $sess_user_id);

            $result = $db->insert("" . $schemas . ".taanimalmng", $fields, $values);
            if (!$result)
                show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
            else
                show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
				
			
        }
    }

    if (isset($_POST["updatemngbttn"]) && (int) $_POST["updatemngbttn"] == 1) {
        
        if (isset($_POST["zone_name"])) {
            $wherevalues = "doc_id=" . (int) $_POST["doc_id"];
                $doc_id=$_POST["doc_id"];
				if ($_POST["doc_date"] != '0000-00-00')
							$doc_date = $_POST["doc_date"];
						else
							$doc_date = date('Y-m-d');
                $doc_filename = "";
				$doc_pathname = "";	
								
				if (is_uploaded_file($_FILES['doc_filename']['tmp_name']))
				{
					$today = date('Y-m-d');
					
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/".$year;
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path."/".$_MY_CONF["taanimalmng_PATH"];
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path;
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
						
					$uploader = new file_upload();
					$uploader->first_values('','_'.$doc_id,'MB','20') ;
					$uploader->uploader_set($_FILES['doc_filename'], date("Y", strtotime($today)).date("m", strtotime($today)).date("d", strtotime ($today)), $path, $DOCUMENT_TYPES);
					
					if ($uploader->uploaded)
					{
						$doc_filename = $uploader->uploaded_files[0];
						$doc_pathname = $path;
						if(strlen($_POST["doc_filename"])>0 && strlen($_POST["doc_pathname"])>0)
							unlink($_POST["doc_pathname"]."/".$_POST["doc_filename"]);							
					} else 
					{
						show_notification("error", "", $uploader->error);
					}	
				}else
					{
						if(isset($_POST["doc_filename"]) && strlen($_POST["doc_filename"])>0)
						{
							$doc_filename = $_POST["doc_filename"];				
						}					
					}

			$fields = array("zone_name", "doc_type", "doc_date",  
			"doc_filename", "doc_pathname", "user_id");
            $values = array( "'".$_POST["zone_name"]."'", (int) $_POST["type_id"],  "'".$doc_date."'",  
			"'".$doc_filename."'" ,"'".$_POST["doc_pathname"]."'", (int) $_POST["user_id"]);
				
					
				
				$result = $db->update("".$schemas.".taanimalmng", $fields, $values, $wherevalues);
				if(! $result) {
					show_notification("error", "", "Эвдрэлд орсон талбайн мэдээлэл өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				} else {
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
				}
        }
    }

	if (($action == "delete") && isset($_GET["doc_id"])) 
		{
            $doc_id = (int) $_GET["doc_id"];

            if ($sess_profile == 1)
                $wherevalues = "doc_id = " . $doc_id;
            else
                $wherevalues = "doc_id = " . $doc_id . " AND user_id = " . $sess_user_id;
			
            $selQuery = "SELECT doc_filename, doc_pathname FROM " . $schemas . ".taanimalmng WHERE " . $wherevalues;
            $rowfile = $db->query($selQuery);

            $result = $db->delete("" . $schemas . ".taanimalmng", $wherevalues);
            if (!$result) {
                show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
            } else {
                show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
                if (!empty($rowfile)) {

                    if (!empty($rowfile[0]["doc_pathname"]) && !empty($rowfile[0]["doc_filename"]))
                    	unlink($rowfile[0]["doc_pathname"] . $rowfile[0]["doc_filename"]);
                }
            }
        }
}

$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
$my_page = "&page=" . $page;
$searchQuery = "";
$search_url = "";

$doc_date = (isset($_GET["doc_date"])) ? (int) $_GET["doc_date"] : 0;
$aimag_name_mn = (isset($_GET["aimag_name_mn"])) ? $_GET["aimag_name_mn"] : "";
$zone_name = (isset($_GET["zone_name"])) ? $_GET["zone_name"] : "";
$type_id = (isset($_GET["type_id"])) ? $_GET["type_id"] : 0;

if(empty($type_id))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND taamn.doc_type=".$type_id;
		$search_url .= "&doc_type=".$type_id;
	}

	if($doc_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',taamn.doc_date) = ".$doc_date;
		$search_url .= "&doc_date=".$doc_date;
	}
	if(empty($aimag_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tganz.aimag_name_mn) LIKE lower('%".$aimag_name_mn."%')";
		$search_url .= "&aimag_name_mn=".$aimag_name_mn;
	}
	
	if(empty($zone_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
	
		$searchQuery .= " AND lower(taamn.zone_name) LIKE lower('%".$zone_name."%')";
		$search_url .= "&zone_name=".$zone_name;
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

if ($action == "add") {
    require("taanimalmng/inc.add_animalmngform.php");
}  elseif ($action == "more") {
    require("taanimalmng/inc.more_animalmngform.php");
} elseif ($action == "edit") {
    require("taanimalmng/inc.edit_animalmngform.php");
} else {
    require("taanimalmng/inc.list_animalmngform.php");
}
} else {
$notify = "Таны хандалт буруу байна.";
show_notification("error", "", $notify);
}
?>
