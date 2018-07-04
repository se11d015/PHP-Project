<?php

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1)) 
{
	require("modules/generategeom.class.php");
	require("modules/upload_document.class.php");
	
	$my_url .= "?menuitem=" . $menuitem;
	if (isset($_GET["action"])) {
		$action = $_GET["action"];
	} else {
		$action = "";
	}
	
	if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) 
	{
		if (isset($_POST["insertherbariumbttn"]) && (int) $_POST["insertherbariumbttn"] == 1) 
		{
			if (isset($_POST["species_code"]) && isset($_POST["collected_date"]) && isset($_POST["herbarium_name"])) 
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
	
				$herbarium_filename = "";
				$herbarium_pathname = "";	
				$species_code  = (int) $_POST["species_code"];
				
				if (is_uploaded_file($_FILES['herbarium_filename']['tmp_name']))
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
					$path = $path."/".$_MY_CONF["HERBARIUMPICTURE_PATH"];
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path."/".$species_code. "/";;
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
							
					$uploader = new file_upload();
					$uploader->first_values('','_'.$species_code,'MB','20') ;
					$uploader->uploader_set($_FILES['herbarium_filename'], date("Y", strtotime($today)).date("m", strtotime($today)).date("d", strtotime ($today)), $path, $PICTURE_TYPES);
					
					if ($uploader->uploaded)
					{
						$herbarium_filename = $uploader->uploaded_files[0];
						$herbarium_pathname = $path;
					} else 
					{
						show_notification("error", "", $uploader->error);
					}	
				}
					
				if ($_POST["collected_date"] != '0000-00-00')
					$collected_date = $_POST["collected_date"];
				else
					$collected_date = date('Y-m-d');
					
				$fields = array("species_code", "herbarium_type", "collected_date", "herbarium_name", "collecting_number", "aimag_name", "soum_name", "place_name", "collector_name", "determiner_name", "herbarium_description", "herbarium_filename", "herbarium_pathname", "save_condition", "geom", "user_id");
				$checkvalues = array($_POST["species_code"], $_POST["herbarium_type"], $collected_date, $_POST["herbarium_name"],  $_POST["collecting_number"],  $_POST["aimag_name"],  $_POST["soum_name"],  $_POST["place_name"],  $_POST["collector_name"],  $_POST["determiner_name"],  $_POST["herbarium_description"], $herbarium_filename, $herbarium_pathname, $_POST["save_condition"]);
	
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}
				array_push($values, $geomvalues, $sess_user_id);
	
				$result = $db->insert("" . $schemas . ".tganimalherbarium", $fields, $values);
				if (!$result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
					
				
			}
		}
	
		if (isset($_POST["updateherbariumbttn"]) && (int) $_POST["updateherbariumbttn"] == 1) 
		{
			
			if (isset($_POST["species_code"]) && isset($_POST["collected_date"]) && isset($_POST["herbarium_name"]) && isset($_POST["herbarium_id"])) 
			{
				$wherevalues = "herbarium_id=" . (int) $_POST["herbarium_id"];
					
				$herbarium_filename = "";
				$herbarium_pathname = "";	
				
				$species_code  = (int) $_POST["species_code"];
				
				if (is_uploaded_file($_FILES['herbarium_filename']['tmp_name']))
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
					$path = $path."/".$_MY_CONF["HERBARIUMPICTURE_PATH"];
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path."/".$species_code. "/";;
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
							
					$uploader = new file_upload();
					$uploader->first_values('','_'.$species_code,'MB','20') ;
					$uploader->uploader_set($_FILES['herbarium_filename'], date("Y", strtotime($today)).date("m", strtotime($today)).date("d", strtotime ($today)), $path, $PICTURE_TYPES);
					
					if ($uploader->uploaded)
					{
						if(!empty($_POST["herbarium_pathname"]) && !empty($_POST["herbarium_filename"]))
							unlink($_POST["herbarium_pathname"]."/".$_POST["herbarium_filename"]);			
						$herbarium_filename = $uploader->uploaded_files[0];
						$herbarium_pathname = $path;
					} else 
					{
						show_notification("error", "", $uploader->error);
					}
				} else {
					if(isset($_POST["herbarium_pathname"]) && !empty($_POST["herbarium_pathname"]) && isset($_POST["herbarium_filename"]) && !empty($_POST["herbarium_filename"]))
					{
						$herbarium_filename = $_POST["herbarium_filename"];
						$herbarium_pathname = $_POST["herbarium_pathname"];				
					}		
				}
			
				if ($_POST["collected_date"] != '0000-00-00')
						$collected_date = $_POST["collected_date"];
					else
						$collected_date = date('Y-m-d');
				
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
	
				$fields = array("species_code", "herbarium_type", "collected_date", "herbarium_name", "collecting_number", "aimag_name", "soum_name", "place_name", "collector_name", "determiner_name", "herbarium_description", "herbarium_filename", "herbarium_pathname", "save_condition", "geom", "user_id");
				 
				$checkvalues = array($_POST["species_code"], $_POST["herbarium_type"], $collected_date, $_POST["herbarium_name"],  $_POST["collecting_number"],  $_POST["aimag_name"],  $_POST["soum_name"],  $_POST["place_name"],  $_POST["collector_name"],  $_POST["determiner_name"],  $_POST["herbarium_description"], $herbarium_filename, $herbarium_pathname, $_POST["save_condition"]);
				
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
				}
				array_push($values, $geomvalues, (int) $_POST["user_id"]);
				
				$result = $db->update("".$schemas.".tganimalherbarium", $fields, $values, $wherevalues);
				if(! $result) {
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				} else {
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
				}
			}
		}
	
		if (($action == "delete") && isset($_GET["herbarium_id"])) 
		{
			$herbarium_id = (int) $_GET["herbarium_id"];
	
			if ($sess_profile == 1)
				$wherevalues = "herbarium_id = " . $herbarium_id;
			else
				$wherevalues = "herbarium_id = " . $herbarium_id . " AND user_id = " . $sess_user_id;
	
			$selQuery = "SELECT herbarium_filename, herbarium_pathname FROM " . $schemas . ".tganimalherbarium WHERE " . $wherevalues;
			$rowfile = $db->query($selQuery);
	
			$result = $db->delete("" . $schemas . ".tganimalherbarium", $wherevalues);
			if (!$result) {
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			} else {
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
				if (!empty($rowfile)) {
	
					if (!empty($rowfile[0]["herbarium_pathname"]) && !empty($rowfile[0]["herbarium_filename"]))
						unlink($rowfile[0]["herbarium_pathname"] . $rowfile[0]["herbarium_filename"]);
				}
			}
		}
	}
	
	$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
	$my_page = "&page=" . $page;
	
	$searchQuery = "";
	$search_url = "";
	
	$collected_date = (isset($_GET["collected_date"])) ? (int) $_GET["collected_date"] : 0;
	$herbarium_type = (isset($_GET["herbarium_type"])) ? (int) $_GET["herbarium_type"] : 0;
	$species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
	$species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";
	$class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
	$family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
	$order_name_mn = (isset($_GET["order_name_mn"])) ? $_GET["order_name_mn"] : "";
		
	if($herbarium_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND tgph.herbarium_type = ".$herbarium_type;
	    $search_url .= "&herbarium_type=".$herbarium_type;
	}

	if(empty($class_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%".$class_name_mn."%')";
		$search_url .= "&class_name_mn=".$class_name_mn;
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

	if(empty($order_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(taon.order_name_mn) LIKE lower('%".$order_name_mn."%')";
		$search_url .= "&order_name_mn=".$order_name_mn;
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
	
	if($collected_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgph.collected_date) = ".$collected_date;
		$search_url .= "&collected_date=".$collected_date;
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
		require("tganimalherbarium/inc.add_animalherbariumform.php");
	} elseif ($action == "output") {
		require("tganimalherbarium/inc.output_animalherbariumform.php");
	} elseif ($action == "more") {
		require("tganimalherbarium/inc.more_animalherbariumform.php");
	} elseif ($action == "edit") {
		require("tganimalherbarium/inc.edit_animalherbariumform.php");
	} else {
		require("tganimalherbarium/inc.list_animalherbariumform.php");
	}
} else {
	$notify = "Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}
?>
