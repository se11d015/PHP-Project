<?php

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1))
{
    $my_url .= "?menuitem=" . $menuitem;
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "";
    }
	
	require("modules/generategeom.class.php");
	require("modules/upload_document.class.php");   
   	
	if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) 
	{
		if (isset($_POST["insertanimalpicturebttn"]) && (int) $_POST["insertanimalpicturebttn"] == 1) 
		{
			if (isset($_POST["species_code"]) && isset($_POST["photo_date"]) && isset($_POST["photo_title"])) 
			{
				$species_code = (int) $_POST["species_code"];

				$photo_filename = "";
				$photo_pathname = "";
	
				if (is_uploaded_file($_FILES['photo_filename']['tmp_name'])) 
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
					$path = $path . "/" . $_MY_CONF["ANIMALPICTURE_PATH"];
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
					$uploader->first_values('', '_' . $species_code, 'MB', '14');
					$uploader->uploader_set($_FILES['photo_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);
	
					if ($uploader->uploaded) {
						$photo_filename = $uploader->uploaded_files[0];
						$photo_pathname = $path;
						$photo_filename = $photo_filename;
					} else {
						show_notification("error", "", $uploader->error);
					}
				}       
            
				$geom = new generategeom();
				$geomvalues = "";
	
				$geomsrid = (int) $_POST["geom_srid"];
				$geomtype = (int) $_POST["geom_type"];
	
				// point
				if ($geomtype == 2) 
				{
					$points = array();
	
					$points[0] = $_POST["x_coord"];
					$points[1] = $_POST["y_coord"];
				
					if($geomsrid ==4326)
						$geomvalues = $geom->generatePointGeom($points, 4326);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POINT");
				}

				// point
				if ($geomtype == 3) 
				{
					$points = array();
	
					$points[0] = ($_POST["x_coordinate_sec"]/60 + $_POST["x_coordinate_min"])/60 + $_POST["x_coordinate_deg"];
					$points[1] = ($_POST["y_coordinate_sec"]/60 + $_POST["y_coordinate_min"])/60 + $_POST["y_coordinate_deg"];
						  
					$geomvalues = $geom->generatePointGeom($points, 4326);
	
				}
	
				if (empty($geomvalues))
					$geomvalues = "NULL";			
					
				if ($_POST["photo_date"] != '0000-00-00')
					$photo_date = $_POST["photo_date"];
				else
					$photo_date = date('Y-m-d');
					
				$fields = array("species_code", "photo_date", "photo_title", "aimag_name", "soum_name", "photo_place", "photo_auhtor", "photo_description",  "photo_filename", "photo_pathname", "geom", "user_id");
				$checkvalues = array((int) $_POST["species_code"], $photo_date, $_POST["photo_title"],  $_POST["aimag_name"],  $_POST["soum_name"],   $_POST["photo_place"], $_POST["photo_auhtor"], $_POST["photo_description"],  $photo_filename,  $photo_pathname);
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}
				array_push($values, $geomvalues, $sess_user_id);
	
				$result = $db->insert("" . $schemas . ".tganimalpicture", $fields, $values);
				if (!$result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");	
			}
		}
    
        if (isset($_POST["updateanimalpicturebttn"]) && (int) $_POST["updateanimalpicturebttn"] == 1) 
		{

            if (isset($_POST["species_code"]) && isset($_POST["photo_date"]) && isset($_POST["photo_title"]) && isset($_POST["picture_id"])) 
			{
                $wherevalues = "picture_id=" . (int) $_POST["picture_id"];
               
			    $species_code = (int) $_POST["species_code"];

                $photo_filename = "";
                $photo_pathname = "";

                if (is_uploaded_file($_FILES['photo_filename']['tmp_name'])) 
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
                    $path = $path . "/" . $_MY_CONF["ANIMALPICTURE_PATH"];
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
                    $uploader->first_values('', '_' . $species_code, 'MB', '14');
                    $uploader->uploader_set($_FILES['photo_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);

					if ($uploader->uploaded) {

                        if (!empty($_POST["photo_pathname"]) && !empty($_POST["photo_filename"]))
                            unlink($_POST["photo_pathname"] . $_POST["photo_filename"]);
                        $photo_filename = $uploader->uploaded_files[0];
                        $photo_pathname = $path;
                    } else {
                        show_notification("error", "", $uploader->error);
                    }
                } else {
                    if (isset($_POST["photo_pathname"]) && !empty($_POST["photo_pathname"]) && isset($_POST["photo_filename"]) && !empty($_POST["photo_filename"])) {
                        $photo_filename = $_POST["photo_filename"];
                        $photo_pathname = $_POST["photo_pathname"];
                    }
                }
				
				$geom = new generategeom();
				$geomvalues = "";
	
				$geomsrid = (int) $_POST["geom_srid"];
				$geomtype = (int) $_POST["geom_type"];
	
				// point
				if ($geomtype == 2)
				{
					$points = array();
	
					$points[0] = $_POST["x_coord"];
					$points[1] = $_POST["y_coord"];
				
					if($geomsrid ==4326)
						$geomvalues = $geom->generatePointGeom($points, 4326);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POINT");
				}

				// point
				if ($geomtype == 3) 
				{
					$points = array();
	
					$points[0] = ($_POST["x_coordinate_sec"]/60 + $_POST["x_coordinate_min"])/60 + $_POST["x_coordinate_deg"];
					$points[1] = ($_POST["y_coordinate_sec"]/60 + $_POST["y_coordinate_min"])/60 + $_POST["y_coordinate_deg"];
						  
					$geomvalues = $geom->generatePointGeom($points, 4326);
	
				}
	
				if (empty($geomvalues))
					$geomvalues = "NULL";
				
				if ($_POST["photo_date"] != '0000-00-00')
					$photo_date = $_POST["photo_date"];
				else
					$photo_date = date('Y-m-d');				
			
				$fields = array("species_code", "photo_date", "photo_title", "aimag_name", "soum_name", "photo_place", 
				"photo_auhtor", "photo_description",  "photo_filename", "photo_pathname", "geom", "user_id");
                $checkvalues = array((int) $_POST["species_code"], $photo_date, $_POST["photo_title"], $_POST["aimag_name"],  $_POST["soum_name"],   $_POST["photo_place"], $_POST["photo_auhtor"], $_POST["photo_description"], $photo_filename,  $photo_pathname);
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
				}
				array_push($values, $geomvalues, (int) $_POST["user_id"]);
				
				$result = $db->update("".$schemas.".tganimalpicture", $fields, $values, $wherevalues);
				if(! $result) {
					  show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				} else {
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
                }
            }
        }

        if (($action == "delete") && isset($_GET["picture_id"])) 
		{
            $picture_id = (int) $_GET["picture_id"];

            if ($sess_profile == 1)
                $wherevalues = "picture_id = " . $picture_id;
            else
                $wherevalues = "picture_id = " . $picture_id . " AND user_id = " . $sess_user_id;
			
            $selQuery = "SELECT photo_filename, photo_pathname FROM " . $schemas . ".tganimalpicture WHERE " . $wherevalues;
            $rowfile = $db->query($selQuery);

            $result = $db->delete("" . $schemas . ".tganimalpicture", $wherevalues);
            if (!$result) {
                show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
            } else {
                show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
                if (!empty($rowfile)) {

                    if (!empty($rowfile[0]["photo_pathname"]) && !empty($rowfile[0]["photo_filename"]))
                    	unlink($rowfile[0]["photo_pathname"] . $rowfile[0]["photo_filename"]);
                }
            }
        }
    }

    $page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
    $my_page = "&page=" . $page;

    $searchQuery = "";
    $search_url = "";

    $species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";
	$species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
    $class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
    $order_name_mn = (isset($_GET["order_name_mn"])) ? $_GET["order_name_mn"] : "";
    $family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
	$aimag_code = (isset($_GET["aimag_code"])) ? (int) $_GET["aimag_code"] : 0;

	if(empty($class_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%".$class_name_mn."%')";
		$search_url .= "&class_name_mn=".$class_name_mn;
	}
	
	if(empty($order_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(taon.order_name_mn) LIKE lower('%".$order_name_mn."%')";
		$search_url .= "&order_name_mn=".$order_name_mn;
	}	

	if(empty($family_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tafn.family_name_mn) LIKE lower('%".$family_name_mn."%')";
		$search_url .= "&family_name_mn=".$family_name_mn;
	}	

	if (empty($species_name)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND (lower(tagn.genus_name) LIKE lower('%" . $species_name . "%') OR  lower(tapl.species_name) LIKE lower('%" . $species_name . "%'))";
        $search_url .= "&species_name=" . $species_name;
    }
	
	if (empty($species_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%" . $species_name_mn . "%') OR  lower(tapl.species_name_mn) LIKE lower('%" . $species_name_mn . "%'))";
        $search_url .= "&species_name_mn=" . $species_name_mn;
    }
		
	if ($aimag_code == 0) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND tganp.aimag_name = " . $aimag_code;
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
        require("tganimalpicture/inc.edit_animalpictureform.php");
    } elseif ($action == "output") {
    require("tganimalpicture/inc.output_animalpictureform.php");
    } elseif ($action == "add") {
        require("tganimalpicture/inc.add_animalpictureform.php");
    } elseif ($action == "more") {
        require("tganimalpicture/inc.more_animalpictureform.php");
    } else {
        require("tganimalpicture/inc.list_animalpictureform.php");
    }
} else {
    $notify = "Таны хандалт буруу байна.";
    show_notification("error", "", $notify);
}
?>
