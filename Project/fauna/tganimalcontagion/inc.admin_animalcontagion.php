<?php

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 1)) {
require("modules/generategeom.class.php");
require("modules/upload_document.class.php");

$my_url .= "?menuitem=" . $menuitem;
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 2)) {

    if (isset($_POST["insertcontagionbttn"]) && (int) $_POST["insertcontagionbttn"] == 1) {
        if (isset($_POST["place_name"])) {
		    $species_code  = (int) $_POST["species_code"];
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
					
				
            if ($_POST["contagion_date"] != '0000-00-00')
                $contagion_date = $_POST["contagion_date"];
            else
                $contagion_date = date('Y-m-d');				
				
            $fields = array("species_name",  "contagion_date", "place_name", "contagion_name", "aimag_name", "soum_name", "sick_number", "dead_number", 
			"total_expense", "additional_info", "geom", "user_id");
            $checkvalues = array($_POST["species_code"], $contagion_date, $_POST["place_name"],  $_POST["contagion_name"],  $_POST["aimag_name"],  $_POST["soum_name"],  $_POST["sick_number"],  $_POST["dead_number"],  
			$_POST["total_expense"],  $_POST["additional_info"]);

            $values = array();
            for ($i = 0; $i < sizeof($checkvalues); $i++) {
                $values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
            }
            array_push($values, $geomvalues, $sess_user_id);

            $result = $db->insert("" . $schemas . ".tganimalcontagion", $fields, $values);
            if (!$result)
                show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
            else
                show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
				
			
        }
    }

    if (isset($_POST["updatecontagionbttn"]) && (int) $_POST["updatecontagionbttn"] == 1) {
        
        if (isset($_POST["contagion_date"])) {
            $wherevalues = "contagion_id=" . (int) $_POST["contagion_id"];	
				
				$species_code  = (int) $_POST["species_code"];
                
				if ($_POST["contagion_date"] != '0000-00-00')
							$contagion_date = $_POST["contagion_date"];
						else
							$contagion_date = date('Y-m-d');
			
			
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
			if($geomtype==5) {
					$fields = array("species_name",  "contagion_date", "place_name", "contagion_name", "aimag_name", "soum_name", "sick_number", "dead_number", 
					"total_expense", "additional_info",  "user_id");
					 
					$checkvalues = array($_POST["species_code"],  $contagion_date, $_POST["place_name"],  $_POST["contagion_name"],  $_POST["aimag_name"],  $_POST["soum_name"],  $_POST["sick_number"],  $_POST["dead_number"],  
					$_POST["total_expense"],  $_POST["additional_info"],    (int) $_POST["user_id"]);
			
					$values = array();
					for ($i=0; $i<sizeof($checkvalues); $i++)
					{
						$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
					}
					
				} else 
				{
					$fields = array("species_name", "contagion_date", "place_name", "contagion_name", "aimag_name", "soum_name", "sick_number", "dead_number", 
					"total_expense",  "additional_info",  "geom", "user_id");
					 
					$checkvalues = array($_POST["species_code"], $contagion_date, $_POST["place_name"],  $_POST["contagion_name"],  $_POST["aimag_name"],  $_POST["soum_name"],  $_POST["sick_number"],  $_POST["dead_number"],  
					$_POST["total_expense"],  $_POST["additional_info"]);
					
					$values = array();
					for ($i=0; $i<sizeof($checkvalues); $i++)
					{
						$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
					}
					array_push($values, $geomvalues, (int) $_POST["user_id"]);
				}	
				
				$result = $db->update("".$schemas.".tganimalcontagion", $fields, $values, $wherevalues);
				if(! $result) {
					show_notification("error", "", "Эвдрэлд орсон талбайн мэдээлэл өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				} else {
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
				}
        }
    }

    if (($action == "delete") && isset($_GET["contagion_id"])) {
        $contagion_id = (int) $_GET["contagion_id"];

        if ($sess_profile == 1)
            $wherevalues = "contagion_id = " . $contagion_id;
        else
            $wherevalues = "contagion_id = " . $contagion_id . " AND user_id = " . $sess_user_id;

        $result = $db->delete("" . $schemas . ".tganimalcontagion", $wherevalues);
        if (!$result)
            show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
        else
            show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
    }
}

$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
$my_page = "&page=" . $page;
$searchQuery = "";
$search_url = "";

$contagion_date = (isset($_GET["contagion_date"])) ? (int) $_GET["contagion_date"] : 0;
$contagion_type = (isset($_GET["contagion_type"])) ? (int) $_GET["contagion_type"] : 0;
$species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
$species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";

$family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";

$aimag_name_mn = (isset($_GET["aimag_name_mn"])) ? $_GET["aimag_name_mn"] : "";
$soum_name_mn = (isset($_GET["soum_name_mn"])) ? $_GET["soum_name_mn"] : "";
$contagion_name = (isset($_GET["contagion_name"])) ? $_GET["contagion_name"] : "";

if(empty($contagion_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgaco.contagion_name) LIKE lower('%".$contagion_name."%')";
		$search_url .= "&contagion_name=".$contagion_name;
	}
	
if(empty($aimag_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(taaim.aimag_name_mn) LIKE lower('%".$aimag_name_mn."%')";
		$search_url .= "&aimag_name_mn=".$aimag_name_mn;
	}
	
	if(empty($soum_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
	
		$searchQuery .= " AND lower(tasou.soum_name_mn) LIKE lower('%".$soum_name_mn."%')";
		$search_url .= "&soum_name_mn=".$soum_name_mn;
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
	
	if($contagion_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgaco.contagion_date) = ".$contagion_date;
		$search_url .= "&contagion_date=".$contagion_date;
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
    require("tganimalcontagion/inc.add_animalcontagionform.php");
} elseif ($action == "output") {
    require("tganimalcontagion/inc.output_animalcontagionform.php");
} elseif ($action == "more") {
    require("tganimalcontagion/inc.more_animalcontagionform.php");
} elseif ($action == "edit") {
    require("tganimalcontagion/inc.edit_animalcontagionform.php");
} else {
    require("tganimalcontagion/inc.list_animalcontagionform.php");
}
} else {
$notify = "Таны хандалт буруу байна.";
show_notification("error", "", $notify);
}
?>
