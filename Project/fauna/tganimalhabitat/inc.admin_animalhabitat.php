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
    if (isset($_POST["insertanimalhabitatbttn"]) && (int) $_POST["insertanimalhabitatbttn"] == 1) {
        if (isset($_POST["species_code"]) && isset($_POST["gyear"])) {
            $species_code = (int) $_POST["species_code"];
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

				$fields = array("species_code", "gyear", "org_name", "place_name", "additional_info", "geom", "user_id");
                $checkvalues = array((int) $_POST["species_code"],(int) $_POST["gyear"], $_POST["org_name"], $_POST["place_name"],  $_POST["additional_info"]);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
				}
				array_push($values, $geomvalues, $sess_user_id);
				
				$result = $db->insert("".$schemas.".tganimalhabitat", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");

               

       
        }
    }
	    if (isset($_POST["updateanimalhabitatbttn"]) && (int) $_POST["updateanimalhabitatbttn"] == 1) {
        if (isset($_POST["species_code"]) && isset($_POST["gyear"])) {
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
						
					$fields = array("species_code", "gyear", "org_name", "place_name",  "additional_info", "user_id");
                    $checkvalues = array((int) $_POST["species_code"],(int) $_POST["gyear"], $_POST["org_name"], $_POST["place_name"], $_POST["additional_info"],  (int) $_POST["user_id"]);

			
					$values = array();
					for ($i=0; $i<sizeof($checkvalues); $i++)
					{
						$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
					}
					
				} else 
				{
					$fields = array("species_code", "gyear", "org_name", "place_name",  "additional_info", "geom", "user_id");
                    $checkvalues = array((int) $_POST["species_code"],(int) $_POST["gyear"], $_POST["org_name"], $_POST["place_name"], $_POST["additional_info"]);
					
					$values = array();
					for ($i=0; $i<sizeof($checkvalues); $i++)
					{
						$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
					}
					array_push($values, $geomvalues, (int) $_POST["user_id"]);
				}

				
				$result = $db->update("".$schemas.".tganimalhabitat", $fields, $values, $wherevalues);
				if(! $result) {
					show_notification("error", "", "Амьтны тархац, нөөцийн хэмжээн мэдээлэл өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				} else {
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
				}
        }
		}
        if (($action == "delete") && isset($_GET["gid"])) 
		{
            $gid = (int) $_GET["gid"];

            if ($sess_profile == 1)
                $wherevalues = "gid = " . $gid;
            else
                $wherevalues = "gid = " . $gid . " AND user_id = " . $sess_user_id;

            $result = $db->delete("" . $schemas . ".tganimalhabitat", $wherevalues);
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


    $gyear = (isset($_GET["gyear"])) ? $_GET["gyear"] : 0;	
	$species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
	$species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";
    $class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
    $family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
    $order_name_mn = (isset($_GET["order_name_mn"])) ? $_GET["order_name_mn"] : "";

    if (empty($class_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tapn.class_name_mn) LIKE lower('%" . $class_name_mn . "%')";
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
	
	if($gyear==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{  
		$searchQuery .= " AND taaht.gyear = ".$gyear;
		$search_url .= "&gyear=".$gyear;
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
        require("tganimalhabitat/inc.edit_animalhabitatform.php");
    } elseif ($action == "output") {
		require("tganimalhabitat/inc.output_animalhabitatform.php");
	}  elseif ($action == "add") {
        require("tganimalhabitat/inc.add_animalhabitatform.php");
    } elseif ($action == "more") {
        require("tganimalhabitat/inc.more_animalhabitatform.php");
    } else {
        require("tganimalhabitat/inc.list_animalhabitatform.php");
    }
} else {
    $notify = "Таны хандалт буруу байна.";
    show_notification("error", "", $notify);
}
?>
