<?php

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 4, 1)) 
{
    $my_url .= "?menuitem=" . $menuitem;
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "";
    }
	
    if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 4, 2)) 
	{
		require("modules/upload_document.class.php");
	
		if (isset($_POST["insertredbookbttn"]) && (int) $_POST["insertredbookbttn"] == 1) 
		{
			if (isset($_POST["species_code"]) && isset($_POST["approved_year"])) 
			{
				$species_code = (int) $_POST["species_code"];
	
				$fauna_filename = "";
				$picture_pathname = "";
	
				if (is_uploaded_file($_FILES['fauna_filename']['tmp_name'])) 
				{
					$today = date('Y-m-d');
	
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/" . $year;
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $_MY_CONF["REDBOOK_PATH"];
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $species_code . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
	
					$uploader = new file_upload();
					$uploader->first_values('', '_' . $species_code, 'MB', '31');
					$uploader->uploader_set($_FILES['fauna_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);
	
					if ($uploader->uploaded) {
						$fauna_filename = $uploader->uploaded_files[0];
						$picture_pathname = $path;
						$fauna_filename = $fauna_filename;
					} else {
						show_notification("error", "", $uploader->error);
					}
				}
	
				$dist_filename = "";
				$picture_pathname = "";
	
				if (is_uploaded_file($_FILES['dist_filename']['tmp_name'])) 
				{
					$today = date('Y-m-d');
	
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/" . $year;
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $_MY_CONF["REDBOOK_PATH"];
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $species_code . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
	
					$uploader = new file_upload();
					$uploader->first_values('', '_' . $species_code, 'MB', '31');
					$uploader->uploader_set($_FILES['dist_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);
	
					if ($uploader->uploaded) {
						$dist_filename = $uploader->uploaded_files[0];
						$picture_pathname = $path;
						$dist_filename = $dist_filename;
					} else {
						show_notification("error", "", $uploader->error);
					}
				}
	
				$fields = array("species_code", "approved_year", "species_status", "status_endemic", "status_relict", "status_mn", "status_en", "description_mn", "description_en", "habitat_mn", "habitat_en", "growth_mn", "growth_en", "population_threats_mn", "population_threats_en", "convervation_measures_mn", "convervation_measures_en", "further_action_mn", "further_action_en", "source_mn", "source_en", "fauna_filename", "dist_filename", "picture_pathname",  "user_id");

				$checkvalues = array((int) $_POST["species_code"],(int) $_POST["approved_year"],(int) $_POST["species_status"], $_POST["status_endemic"], $_POST["status_relict"], $_POST["status_mn"], $_POST["status_en"], $_POST["description_mn"], $_POST["description_en"], $_POST["habitat_mn"], $_POST["habitat_en"], $_POST["growth_mn"], $_POST["growth_en"], $_POST["population_threats_mn"], $_POST["population_threats_en"], $_POST["convervation_measures_mn"], $_POST["convervation_measures_en"], $_POST["further_action_mn"], $_POST["further_action_en"], $_POST["source_mn"], $_POST["source_en"], $fauna_filename,  $dist_filename, $picture_pathname,  $sess_user_id);
				
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}
	
				$result = $db->insert("" . $schemas . ".taredbook", $fields, $values);
				if (!$result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
			}
		}

        if (isset($_POST["updateredbookbttn"]) && (int) $_POST["updateredbookbttn"] == 1) 
		{

            if (isset($_POST["species_code"]) && isset($_POST["approved_year"]) && isset($_POST["redbook_id"])) 
			{
                $wherevalues = "redbook_id=" . (int) $_POST["redbook_id"];
                $species_code = (int) $_POST["species_code"];

                $fauna_filename = "";
                $picture_pathname = "";

                if (is_uploaded_file($_FILES['fauna_filename']['tmp_name'])) 
				{
                    $today = date('Y-m-d');

                    $file = "files/index.php";
                    $year = date("Y", strtotime($today));
                    $path = "upload/" . $year;
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $_MY_CONF["REDBOOK_PATH"];
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $species_code . "/";
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }

                    $uploader = new file_upload();
                    $uploader->first_values('', '_' . $species_code, 'MB', '31');
                    $uploader->uploader_set($_FILES['fauna_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);

					if ($uploader->uploaded) 
					{
                        if (!empty($_POST["picture_pathname"]) && !empty($_POST["fauna_filename"]))
                            unlink($_POST["picture_pathname"] . $_POST["fauna_filename"]);
                        $fauna_filename = $uploader->uploaded_files[0];
                        $picture_pathname = $path;
                    } else {
                        show_notification("error", "", $uploader->error);
                    }
                } else {
                    if (isset($_POST["picture_pathname"]) && !empty($_POST["picture_pathname"]) && isset($_POST["fauna_filename"]) && !empty($_POST["fauna_filename"])) {
                        $fauna_filename = $_POST["fauna_filename"];
                        $picture_pathname = $_POST["picture_pathname"];
                    }
                }

                $dist_filename = "";
                $picture_pathname = "";

                if (is_uploaded_file($_FILES['dist_filename']['tmp_name'])) 
				{
                    $today = date('Y-m-d');

                    $file = "files/index.php";
                    $year = date("Y", strtotime($today));
                    $path = "upload/" . $year;
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $_MY_CONF["REDBOOK_PATH"];
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $species_code . "/";
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }

                    $uploader = new file_upload();
                    $uploader->first_values('', '_' . $species_code, 'MB', '31');
                    $uploader->uploader_set($_FILES['dist_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);
                  
                 	if ($uploader->uploaded) 
					{
                        if (!empty($_POST["picture_pathname"]) && !empty($_POST["dist_filename"]))
                            unlink($_POST["picture_pathname"] . $_POST["dist_filename"]);
                        $dist_filename = $uploader->uploaded_files[0];
                        $picture_pathname = $path;
                    } else {
                        show_notification("error", "", $uploader->error);
                    }
                } else {
                    if (isset($_POST["picture_pathname"]) && !empty($_POST["picture_pathname"]) && isset($_POST["dist_filename"]) && !empty($_POST["dist_filename"])) {
                        $dist_filename = $_POST["dist_filename"];
                        $picture_pathname = $_POST["picture_pathname"];
                    }
                }

                $fields = array("species_code", "approved_year", "species_status", "status_endemic", "status_relict", "status_mn", "status_en", "description_mn", "description_en", "habitat_mn", "habitat_en", "growth_mn", "growth_en", "population_threats_mn", "population_threats_en", "convervation_measures_mn", "convervation_measures_en", "further_action_mn", "further_action_en", "source_mn", "source_en", "fauna_filename", "dist_filename", "picture_pathname", "user_id");


                $checkvalues = array((int) $_POST["species_code"],(int) $_POST["approved_year"],(int) $_POST["species_status"], $_POST["status_endemic"], $_POST["status_relict"], $_POST["status_mn"], $_POST["status_en"], $_POST["description_mn"], $_POST["description_en"], $_POST["habitat_mn"], $_POST["habitat_en"], $_POST["growth_mn"], $_POST["growth_en"], $_POST["population_threats_mn"], $_POST["population_threats_en"], $_POST["convervation_measures_mn"], $_POST["convervation_measures_en"], $_POST["further_action_mn"], $_POST["further_action_en"], $_POST["source_mn"], $_POST["source_en"], $fauna_filename,  $dist_filename, $picture_pathname, (int) $_POST["user_id"]);


                $values = array();
                for ($i = 0; $i < sizeof($checkvalues); $i++) {
                    $values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
                }

                $result = $db->update("" . $schemas . ".taredbook", $fields, $values, $wherevalues);
                if (!$result)
                    show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
                else
                    show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
            }
        }

        if (($action == "delete") && isset($_GET["redbook_id"])) 
		{
            $redbook_id = (int) $_GET["redbook_id"];

            if ($sess_profile == 1)
                $wherevalues = "redbook_id = " . $redbook_id;
            else
                $wherevalues = "redbook_id = " . $redbook_id . " AND user_id = " . $sess_user_id;
         
            $result = $db->delete("" . $schemas . ".taredbook", $wherevalues);
            if (!$result) {
                show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
            } else {
                show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
                if (!empty($rowfile)) {
                    if (!empty($rowfile[0]["picture_pathname"]) && !empty($rowfile[0]["fauna_filename"]))
                        unlink($rowfile[0]["picture_pathname"] . $rowfile[0]["fauna_filename"]);
                    if (!empty($rowfile[0]["picture_pathname"]) && !empty($rowfile[0]["dist_filename"]))
                        unlink($rowfile[0]["picture_pathname"] . $rowfile[0]["dist_filename"]);
                }
            }
        }
    }

    $page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
    $my_page = "&page=" . $page;

    $searchQuery = "";
    $search_url = "";
   
    $species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
	$species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";
    $class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
    $family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
    $order_name_mn = (isset($_GET["order_name_mn"])) ? $_GET["order_name_mn"] : "";
	$species_status = (isset($_GET["species_status"])) ? (int) $_GET["species_status"] : 0;	
	
	if($species_status==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND tareb.species_status = ".$species_status;
	    $search_url .= "&species_status=".$species_status;
	}

    if (empty($class_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%" . $class_name_mn . "%')";
        $search_url .= "&class_name_mn=" . $class_name_mn;
    }

    if (empty($family_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tafn.family_name_mn) LIKE lower('%" . $family_name_mn . "%')";
        $search_url .= "&family_name_mn=" . $family_name_mn;
    }

    if (empty($order_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(taon.order_name_mn) LIKE lower('%" . $order_name_mn . "%')";
        $search_url .= "&order_name_mn=" . $order_name_mn;
    }

   if(empty($species_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name_mn) LIKE lower('%".$species_name_mn."%') OR lower(tagn.genus_name_mn) LIKE lower('%".$species_name_mn."%') )";
		$search_url .= "&species_name_mn=".$species_name_mn;
	}
	
	if(empty($species_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name) LIKE lower('%".$species_name."%') OR lower(tagn.genus_name) LIKE lower('%".$species_name."%') )";
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
        require("taredbook/inc.edit_redbookform.php");
    } elseif ($action == "add") {
        require("taredbook/inc.add_redbookform.php");
    } elseif ($action == "more") {
        require("taredbook/inc.more_redbookform.php");
    } else {
        require("taredbook/inc.list_redbookform.php");
    }
} else {
    $notify = "Таны хандалт буруу байна.";
    show_notification("error", "", $notify);
}
?>
