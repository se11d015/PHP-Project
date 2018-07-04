<?php
require("modules/generategeom.class.php");
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1)) {
    $my_url .= "?menuitem=" . $menuitem;
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "";
    }

    if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2))
	{	
    if (isset($_POST["insertanimalzonebttn"]) && (int) $_POST["insertanimalzonebttn"] == 1) {
        if (isset($_POST["species_names"]) && isset($_POST["zone_year"]) && isset($_POST["zone_name"])) {
            $class_code = (int) $_POST["class_code"];
            $geom = new generategeom();
            $geomvalues = "";

             $geomsrid = (int) $_POST["geom_srid"];
            $geomtype = (int) $_POST["geom_type"];

            // polygon
            if ($geomtype == 2) {
                $points = array();

                $points[0][0] = $_POST["x1"];
                $points[0][1] = $_POST["y1"];
                $points[1][0] = $_POST["x2"];
                $points[1][1] = $_POST["y2"];
                $points[2][0] = $_POST["x3"];
                $points[2][1] = $_POST["y3"];
                $points[3][0] = $_POST["x4"];
                $points[3][1] = $_POST["y4"];
                $points[4][0] = $_POST["x5"];
                $points[4][1] = $_POST["y5"];
                $points[5][0] = $_POST["x6"];
                $points[5][1] = $_POST["y6"];
                $points[6][0] = $_POST["x7"];
                $points[6][1] = $_POST["y7"];
                $points[7][0] = $_POST["x8"];
                $points[7][1] = $_POST["y8"];
                $points[8][0] = $_POST["x9"];
                $points[8][1] = $_POST["y9"];
                $points[9][0] = $_POST["x10"];
                $points[9][1] = $_POST["y10"];

                if ($geomsrid == 4326)
                    $geomvalues = $geom->generatePolygonGeom($points, 4326);
                else
                    $geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POLYGON");
            }

            // file
            if($geomtype==3)
				{
					$filename = $_FILES['geom_file']['name'];		
					if(!empty($filename)){
						$fullname = "upload/".$filename;
						echo $fullname;
						move_uploaded_file($_FILES['geom_file']['tmp_name'],$fullname);
						$handle = fopen($fullname, "r");
						if ($handle){					
							$i=0;
							$points = array();
							while ($buffer = fgets($handle, 4096)){					
								$elements = explode("\t", $buffer);
								$points[$i][0] = $elements[1];
								$points[$i][1] = $elements[2];
								$i++;
							}
						
							fclose($handle);
			
							if($geomsrid ==4326)
								$geomvalues = $geom->generatePolygonGeom($points, 4326);
							else
								$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POLYGON");			
						}
						unlink($fullname);
					}
				}

            // geom
            if ($geomtype == 4) {
                if ($geomsrid == 4326)
                    $geomvalues = $geom->generateGeometryGeom($_POST["geom_value"]);
                else
                    $geomvalues = $geom->transformGeom(4326, $geomsrid, $_POST["geom_value"], "GEOM");
            }

            if (empty($geomvalues))
                $geomvalues = "NULL";

				$fields = array("class_code",  "species_names", "aimag_name", "soum_name", "zone_name", "zone_year", "org_name", "place_name", "additional_info", "geom", "user_id");
                $checkvalues = array((int) $_POST["class_code"], $_POST["species_names"], (int) $_POST["aimag_name"], (int) $_POST["soum_name"], $_POST["zone_name"], (int) $_POST["zone_year"], $_POST["org_name"], $_POST["place_name"],  $_POST["additional_info"]);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
				}
				array_push($values, $geomvalues, $sess_user_id);
				
				$result = $db->insert("".$schemas.".tganimalzone", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");

               

       
        }
    }
	    if (isset($_POST["updateanimalzonebttn"]) && (int) $_POST["updateanimalzonebttn"] == 1) {
        if (isset($_POST["species_names"]) && isset($_POST["zone_year"]) && isset($_POST["zone_name"])) {
            $wherevalues = "gid=" . (int) $_POST["gid"];
			
            $geom = new generategeom();
            $geomvalues = "";

            $geomsrid = (int) $_POST["geom_srid"];
            $geomtype = (int) $_POST["geom_type"];

            // polygon
            if ($geomtype == 2) {
                $points = array();

                $points[0][0] = $_POST["x1"];
                $points[0][1] = $_POST["y1"];
                $points[1][0] = $_POST["x2"];
                $points[1][1] = $_POST["y2"];
                $points[2][0] = $_POST["x3"];
                $points[2][1] = $_POST["y3"];
                $points[3][0] = $_POST["x4"];
                $points[3][1] = $_POST["y4"];
                $points[4][0] = $_POST["x5"];
                $points[4][1] = $_POST["y5"];
                $points[5][0] = $_POST["x6"];
                $points[5][1] = $_POST["y6"];
                $points[6][0] = $_POST["x7"];
                $points[6][1] = $_POST["y7"];
                $points[7][0] = $_POST["x8"];
                $points[7][1] = $_POST["y8"];
                $points[8][0] = $_POST["x9"];
                $points[8][1] = $_POST["y9"];
                $points[9][0] = $_POST["x10"];
                $points[9][1] = $_POST["y10"];

                if ($geomsrid == 4326)
                    $geomvalues = $geom->generatePolygonGeom($points, 4326);
                else
                    $geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POLYGON");
            }

            // file
            if ($geomtype == 3) 
				{
					$filename = $_FILES['geom_file']['name'];
					if (!empty($filename)) {
						$fullname = "upload/" . $filename;
						move_uploaded_file($_FILES['geom_file']['tmp_name'], $fullname);
						$handle = fopen($fullname, "r");
						if ($handle) {
							$i = 0;
							$points = array();
							while ($buffer = fgets($handle, 4096)) {
								$elements = explode("\t", $buffer);
								$points[$i][0] = $elements[1];
								$points[$i][1] = $elements[2];
								$i++;
							}
							fclose($handle);
	
							if ($geomsrid == 4326)
								$geomvalues = $geom->generatePolygonGeom($points, 4326);
							else
								$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POLYGON");
						}
						unlink($fullname);
					}
				}

            // geom
            if ($geomtype == 4) {
                if ($geomsrid == 4326)
                    $geomvalues = $geom->generateGeometryGeom($_POST["geom_value"]);
                else
                    $geomvalues = $geom->transformGeom(4326, $geomsrid, $_POST["geom_value"], "GEOM");
            }
						
				if(empty($geomvalues))
					$geomvalues = "NULL";
					

				if($geomtype==5) {

					$fields = array("class_code", "species_names", "aimag_name", "soum_name",  "zone_name",  "zone_year", "org_name", "place_name",  "additional_info", "user_id");
                    $checkvalues = array((int) $_POST["class_code"], $_POST["species_names"], (int) $_POST["aimag_name"], (int) $_POST["soum_name"], $_POST["zone_name"], (int) $_POST["zone_year"], $_POST["org_name"], $_POST["place_name"], $_POST["additional_info"],  (int) $_POST["user_id"]);

			
					$values = array();
					for ($i=0; $i<sizeof($checkvalues); $i++)
					{
						$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
					}
					
				} else 
				{
					$fields = array("class_code", "species_names", "aimag_name", "soum_name", "zone_name", "zone_year", "org_name", "place_name",  "additional_info", "geom", "user_id");
                    $checkvalues = array((int) $_POST["class_code"], $_POST["species_names"], (int) $_POST["aimag_name"], (int) $_POST["soum_name"], $_POST["zone_name"], (int) $_POST["zone_year"], $_POST["org_name"], $_POST["place_name"], $_POST["additional_info"]);
					
					$values = array();
					for ($i=0; $i<sizeof($checkvalues); $i++)
					{
						$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
					}
					array_push($values, $geomvalues, (int) $_POST["user_id"]);
				}

				
				$result = $db->update("".$schemas.".tganimalzone", $fields, $values, $wherevalues);
				if(! $result) {
					show_notification("error", "", "Амьтны тархац, нөөцийн хэмжээн мэдээлэл өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				} else {
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
				}
        }
    
   
}
        if (($action == "delete") && isset($_GET["gid"])) {
            $gid = (int) $_GET["gid"];


            if ($sess_profile == 1)
                $wherevalues = "gid = " . $gid;
            else
                $wherevalues = "gid = " . $gid . " AND user_id = " . $sess_user_id;
           

            $result = $db->delete("" . $schemas . ".tganimalzone", $wherevalues);
            if (!$result) {
                show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
            } else {
                show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");               
            }
        }
		
    
   }
    $page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
    $my_page = "&page=" . $page;

    $searchQuery = "";
    $search_url = "";


    $zone_year = (isset($_GET["zone_year"])) ? $_GET["zone_year"] : 0;
	$species_names = (isset($_GET["species_names"])) ? $_GET["species_names"] : "";
	$aimag_name_mn = (isset($_GET["aimag_name_mn"])) ? $_GET["aimag_name_mn"] : "";
    $soum_name_mn = (isset($_GET["soum_name_mn"])) ? $_GET["soum_name_mn"] : "";
	$class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
	$zone_name = (isset($_GET["zone_name"])) ? $_GET["zone_name"] : "";
	
	if(empty($zone_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgazo.zone_name) LIKE lower('%".$zone_name."%')";
		$search_url .= "&zone_name=".$zone_name;
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

	if(empty($species_names))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgazo.species_names) LIKE lower('%".$species_names."%') ";
		$search_url .= "&species_names=".$species_names;
	}

    if($zone_year==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{  
		$searchQuery .= " AND tgazo.zone_year = ".$zone_year;
		$search_url .= "&zone_year=".$zone_year;
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
        require("tganimalzone/inc.edit_animalzoneform.php");
    } elseif ($action == "output") {
		require("tganimalzone/inc.output_animalzoneform.php");
	}  elseif ($action == "add") {
        require("tganimalzone/inc.add_animalzoneform.php");
    } elseif ($action == "more") {
        require("tganimalzone/inc.more_animalzoneform.php");
    } else {
        require("tganimalzone/inc.list_animalzoneform.php");
    }
} else {
    $notify = "Таны хандалт буруу байна.";
    show_notification("error", "", $notify);
}
?>
