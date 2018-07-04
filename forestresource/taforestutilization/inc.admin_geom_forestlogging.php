<?php
	if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 14, 2)) 
	{
		if (isset($_POST["insertforestlogginggeombttn"]) && (int) $_POST["insertforestlogginggeombttn"] == 1) 
		{
			if (isset($_POST["utilization_id"]) && isset($_POST["logging_type"]))
			{
				$utilization_id = (int) $_POST["utilization_id"];
				$logging_type = (int) $_POST["logging_type"];
					
				$logging_area = floatval(str_replace(",",".",$_POST["logging_area"]));
				$logged_timber = floatval(str_replace(",",".",$_POST["logged_timber"]));
				$logged_firewood = floatval(str_replace(",",".",$_POST["logged_firewood"]));
				$logged_total = $logged_timber + $logged_firewood;
				
				$geom = new generategeom();
				$geomvalues = "";
	
				$points = array();
				
				$geomsrid = (int) $_POST["geom_srid"];
				$geomtype = (int) $_POST["geom_type"];

				// polygon DD
				if($geomtype==1){
					$points = array();

					$points[0][0] = floatval(str_replace(",",".",$_POST["x1"]));
					$points[0][1] = floatval(str_replace(",",".",$_POST["y1"]));
					$points[1][0] = floatval(str_replace(",",".",$_POST["x2"]));
					$points[1][1] = floatval(str_replace(",",".",$_POST["y2"]));
					$points[2][0] = floatval(str_replace(",",".",$_POST["x3"]));
					$points[2][1] = floatval(str_replace(",",".",$_POST["y3"]));
					$points[3][0] = floatval(str_replace(",",".",$_POST["x4"]));
					$points[3][1] = floatval(str_replace(",",".",$_POST["y4"]));
					$points[4][0] = floatval(str_replace(",",".",$_POST["x5"]));
					$points[4][1] = floatval(str_replace(",",".",$_POST["y5"]));
					$points[5][0] = floatval(str_replace(",",".",$_POST["x6"]));
					$points[5][1] = floatval(str_replace(",",".",$_POST["y6"]));
					$points[6][0] = floatval(str_replace(",",".",$_POST["x7"]));
					$points[6][1] = floatval(str_replace(",",".",$_POST["y7"]));
					$points[7][0] = floatval(str_replace(",",".",$_POST["x8"]));
					$points[7][1] = floatval(str_replace(",",".",$_POST["y8"]));
					$points[8][0] = floatval(str_replace(",",".",$_POST["x9"]));
					$points[8][1] = floatval(str_replace(",",".",$_POST["y9"]));
					$points[9][0] = floatval(str_replace(",",".",$_POST["x10"]));
					$points[9][1] = floatval(str_replace(",",".",$_POST["y10"]));
							
					if($geomsrid ==4326)
						$geomvalues = $geom->generatePolygonGeom($points, 4326);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POLYGON");
				}
			
				// file DD
				if($geomtype==2){
					$filename = $_FILES['geom_file']['name'];
					if(!empty($filename)){
						$fullname = "upload/".$filename;
						move_uploaded_file($_FILES['geom_file']['tmp_name'],$fullname);
						$handle = fopen($fullname, "r");
						if ($handle){
							$i=0;
							$points = array();
							while ($buffer = fgets($handle, 4096)){
								$elements = explode("\t", $buffer);
								if($elements[1]!=NULL && $elements[2]!=NULL)
								{									
									$points[$i][0] = floatval(str_replace(",",".",$elements[2]));
									$points[$i][1] = floatval(str_replace(",",".",$elements[1]));
									$i++;
								}						
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

				// polygon DMS
				if($geomtype==3){
					$points = array();

					$x1_sec = floatval(str_replace(",",".",$_POST["x1_sec"]));
					$x1_min = floatval(str_replace(",",".",$_POST["x1_min"]));
					$x1_deg = floatval(str_replace(",",".",$_POST["x1_deg"]));
					$y1_sec = floatval(str_replace(",",".",$_POST["y1_sec"]));
					$y1_min = floatval(str_replace(",",".",$_POST["y1_min"]));
					$y1_deg = floatval(str_replace(",",".",$_POST["y1_deg"]));
						
					$points[0][0]=($x1_sec/60 + $x1_min)/60 + $x1_deg;
					$points[0][1]=($y1_sec/60 + $y1_min)/60 + $y1_deg;

					$x2_sec = floatval(str_replace(",",".",$_POST["x2_sec"]));
					$x2_min = floatval(str_replace(",",".",$_POST["x2_min"]));
					$x2_deg = floatval(str_replace(",",".",$_POST["x2_deg"]));
					$y2_sec = floatval(str_replace(",",".",$_POST["y2_sec"]));
					$y2_min = floatval(str_replace(",",".",$_POST["y2_min"]));
					$y2_deg = floatval(str_replace(",",".",$_POST["y2_deg"]));
						
					$points[1][0]=($x2_sec/60 + $x2_min)/60 + $x2_deg;
					$points[1][1]=($y2_sec/60 + $y2_min)/60 + $y2_deg;
															
					$x3_sec = floatval(str_replace(",",".",$_POST["x3_sec"]));
					$x3_min = floatval(str_replace(",",".",$_POST["x3_min"]));
					$x3_deg = floatval(str_replace(",",".",$_POST["x3_deg"]));
					$y3_sec = floatval(str_replace(",",".",$_POST["y3_sec"]));
					$y3_min = floatval(str_replace(",",".",$_POST["y3_min"]));
					$y3_deg = floatval(str_replace(",",".",$_POST["y3_deg"]));
						
					$points[2][0]=($x3_sec/60 + $x3_min)/60 + $x3_deg;
					$points[2][1]=($y3_sec/60 + $y3_min)/60 + $y3_deg;

					$x4_sec = floatval(str_replace(",",".",$_POST["x4_sec"]));
					$x4_min = floatval(str_replace(",",".",$_POST["x4_min"]));
					$x4_deg = floatval(str_replace(",",".",$_POST["x4_deg"]));
					$y4_sec = floatval(str_replace(",",".",$_POST["y4_sec"]));
					$y4_min = floatval(str_replace(",",".",$_POST["y4_min"]));
					$y4_deg = floatval(str_replace(",",".",$_POST["y4_deg"]));
						
					$points[3][0]=($x4_sec/60 + $x4_min)/60 + $x4_deg;
					$points[3][1]=($y4_sec/60 + $y4_min)/60 + $y4_deg;
									
					$x5_sec = floatval(str_replace(",",".",$_POST["x5_sec"]));
					$x5_min = floatval(str_replace(",",".",$_POST["x5_min"]));
					$x5_deg = floatval(str_replace(",",".",$_POST["x5_deg"]));
					$y5_sec = floatval(str_replace(",",".",$_POST["y5_sec"]));
					$y5_min = floatval(str_replace(",",".",$_POST["y5_min"]));
					$y5_deg = floatval(str_replace(",",".",$_POST["y5_deg"]));
						
					$points[4][0]=($x5_sec/60 + $x5_min)/60 + $x5_deg;
					$points[4][1]=($y5_sec/60 + $y5_min)/60 + $y5_deg;

					$x6_sec = floatval(str_replace(",",".",$_POST["x6_sec"]));
					$x6_min = floatval(str_replace(",",".",$_POST["x6_min"]));
					$x6_deg = floatval(str_replace(",",".",$_POST["x6_deg"]));
					$y6_sec = floatval(str_replace(",",".",$_POST["y6_sec"]));
					$y6_min = floatval(str_replace(",",".",$_POST["y6_min"]));
					$y6_deg = floatval(str_replace(",",".",$_POST["y6_deg"]));
						
					$points[5][0]=($x6_sec/60 + $x6_min)/60 + $x6_deg;
					$points[5][1]=($y6_sec/60 + $y6_min)/60 + $y6_deg;
									
					$x7_sec = floatval(str_replace(",",".",$_POST["x7_sec"]));
					$x7_min = floatval(str_replace(",",".",$_POST["x7_min"]));
					$x7_deg = floatval(str_replace(",",".",$_POST["x7_deg"]));
					$y7_sec = floatval(str_replace(",",".",$_POST["y7_sec"]));
					$y7_min = floatval(str_replace(",",".",$_POST["y7_min"]));
					$y7_deg = floatval(str_replace(",",".",$_POST["y7_deg"]));
						
					$points[6][0]=($x7_sec/60 + $x7_min)/60 + $x7_deg;
					$points[6][1]=($y7_sec/60 + $y7_min)/60 + $y7_deg;

					$x8_sec = floatval(str_replace(",",".",$_POST["x8_sec"]));
					$x8_min = floatval(str_replace(",",".",$_POST["x8_min"]));
					$x8_deg = floatval(str_replace(",",".",$_POST["x8_deg"]));
					$y8_sec = floatval(str_replace(",",".",$_POST["y8_sec"]));
					$y8_min = floatval(str_replace(",",".",$_POST["y8_min"]));
					$y8_deg = floatval(str_replace(",",".",$_POST["y8_deg"]));
						
					$points[7][0]=($x8_sec/60 + $x8_min)/60 + $x8_deg;
					$points[7][1]=($y8_sec/60 + $y8_min)/60 + $y8_deg;
									
					$x9_sec = floatval(str_replace(",",".",$_POST["x9_sec"]));
					$x9_min = floatval(str_replace(",",".",$_POST["x9_min"]));
					$x9_deg = floatval(str_replace(",",".",$_POST["x9_deg"]));
					$y9_sec = floatval(str_replace(",",".",$_POST["y9_sec"]));
					$y9_min = floatval(str_replace(",",".",$_POST["y9_min"]));
					$y9_deg = floatval(str_replace(",",".",$_POST["y9_deg"]));
						
					$points[8][0]=($x9_sec/60 + $x9_min)/60 + $x9_deg;
					$points[8][1]=($y9_sec/60 + $y9_min)/60 + $y9_deg;

					$x10_sec = floatval(str_replace(",",".",$_POST["x10_sec"]));
					$x10_min = floatval(str_replace(",",".",$_POST["x10_min"]));
					$x10_deg = floatval(str_replace(",",".",$_POST["x10_deg"]));
					$y10_sec = floatval(str_replace(",",".",$_POST["y10_sec"]));
					$y10_min = floatval(str_replace(",",".",$_POST["y10_min"]));
					$y10_deg = floatval(str_replace(",",".",$_POST["y10_deg"]));
						
					$points[9][0]=($x10_sec/60 + $x10_min)/60 + $x10_deg;
					$points[9][1]=($y10_sec/60 + $y10_min)/60 + $y10_deg;
																																					
					$geomvalues = $geom->generatePolygonGeom($points, 4326);
					$geomsrid = 4326;
				}
			
				// file DMS 
				if($geomtype==4){
					$filename = $_FILES['geom_file_dms']['name'];
					if(!empty($filename)){
						$fullname = "upload/".$filename;
						move_uploaded_file($_FILES['geom_file_dms']['tmp_name'],$fullname);
						$handle = fopen($fullname, "r");
						if ($handle){
							$i=0;
							$points = array();
							while ($buffer = fgets($handle, 4096)){
								$elements = explode("\t", $buffer);
								if($elements[1]!=NULL && $elements[2]!=NULL && $elements[3]!=NULL && $elements[4]!=NULL && $elements[5]!=NULL && $elements[6]!=NULL)
								{									
									$x1_sec = floatval(str_replace(",",".",$elements[6]));
									$x1_min = floatval(str_replace(",",".",$elements[5]));
									$x1_deg = floatval(str_replace(",",".",$elements[4]));
									$y1_sec = floatval(str_replace(",",".",$elements[3]));
									$y1_min = floatval(str_replace(",",".",$elements[2]));
									$y1_deg = floatval(str_replace(",",".",$elements[1]));
										
									$points[$i][0]=($x1_sec/60 + $x1_min)/60 + $x1_deg;
									$points[$i][1]=($y1_sec/60 + $y1_min)/60 + $y1_deg;
									$i++;
								}
							}
							fclose($handle);
			
							$geomvalues = $geom->generatePolygonGeom($points, 4326);
						}
						unlink($fullname);
					}
					$geomsrid = 4326;
				}
			
				// geom DMS
				if($geomtype==5){
					$geom_value = $_POST["geom_value"];
					if($geomsrid ==4326)
						$geomvalues = $geom->generateGeometryGeom($geom_value);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $geom_value, "GEOM");						
				}
				
				if (empty($geomvalues))
					$geomvalues = "NULL";
					
				$fields = array("utilization_id", "logging_type", "logging_area", "logged_timber", "logged_firewood", "logged_total", "geom", "user_id");
				
				$checkvalues = array($utilization_id, $logging_type, $logging_area, $logged_timber, $logged_firewood, $logged_total);
					
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				array_push($values, $geomvalues, $sess_user_id);
				
				$result = $db->insert("".$schemas.".tgforestlogging", $fields, $values);
				if(! $result)
					show_notification("error", _p("AddText1"), "");
				else
					show_notification("success", _p("AddText2"), "");
			}
		}
   
		if (isset($_POST["updateforestlogginggeombttn"]) && (int) $_POST["updateforestlogginggeombttn"] == 1) 
		{
	 
			if (isset($_POST["utilization_id"]) && isset($_POST["logging_type"]) && isset($_POST["gid"]))
			{
				$wherevalues = "gid=".(int) $_POST["gid"];
				
				$utilization_id = (int) $_POST["utilization_id"];
				$logging_type = (int) $_POST["logging_type"];

				$logging_area = floatval(str_replace(",",".",$_POST["logging_area"]));
				$logged_timber = floatval(str_replace(",",".",$_POST["logged_timber"]));
				$logged_firewood = floatval(str_replace(",",".",$_POST["logged_firewood"]));
				$logged_total = $logged_timber + $logged_firewood;
				
				$geom = new generategeom();
				$geomvalues = "";
	
				$points = array();
				
				$geomsrid = (int) $_POST["geom_srid"];
				$geomtype = (int) $_POST["geom_type"];

				// polygon DD
				if($geomtype==1){
					$points = array();

					$points[0][0] = floatval(str_replace(",",".",$_POST["x1"]));
					$points[0][1] = floatval(str_replace(",",".",$_POST["y1"]));
					$points[1][0] = floatval(str_replace(",",".",$_POST["x2"]));
					$points[1][1] = floatval(str_replace(",",".",$_POST["y2"]));
					$points[2][0] = floatval(str_replace(",",".",$_POST["x3"]));
					$points[2][1] = floatval(str_replace(",",".",$_POST["y3"]));
					$points[3][0] = floatval(str_replace(",",".",$_POST["x4"]));
					$points[3][1] = floatval(str_replace(",",".",$_POST["y4"]));
					$points[4][0] = floatval(str_replace(",",".",$_POST["x5"]));
					$points[4][1] = floatval(str_replace(",",".",$_POST["y5"]));
					$points[5][0] = floatval(str_replace(",",".",$_POST["x6"]));
					$points[5][1] = floatval(str_replace(",",".",$_POST["y6"]));
					$points[6][0] = floatval(str_replace(",",".",$_POST["x7"]));
					$points[6][1] = floatval(str_replace(",",".",$_POST["y7"]));
					$points[7][0] = floatval(str_replace(",",".",$_POST["x8"]));
					$points[7][1] = floatval(str_replace(",",".",$_POST["y8"]));
					$points[8][0] = floatval(str_replace(",",".",$_POST["x9"]));
					$points[8][1] = floatval(str_replace(",",".",$_POST["y9"]));
					$points[9][0] = floatval(str_replace(",",".",$_POST["x10"]));
					$points[9][1] = floatval(str_replace(",",".",$_POST["y10"]));
							
					if($geomsrid ==4326)
						$geomvalues = $geom->generatePolygonGeom($points, 4326);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POLYGON");
				}
			
				// file DD
				if($geomtype==2){
					$filename = $_FILES['geom_file']['name'];
					if(!empty($filename)){
						$fullname = "upload/".$filename;
						move_uploaded_file($_FILES['geom_file']['tmp_name'],$fullname);
						$handle = fopen($fullname, "r");
						if ($handle){
							$i=0;
							$points = array();
							while ($buffer = fgets($handle, 4096)){
								$elements = explode("\t", $buffer);
								if($elements[1]!=NULL && $elements[2]!=NULL)
								{									
									$points[$i][0] = floatval(str_replace(",",".",$elements[2]));
									$points[$i][1] = floatval(str_replace(",",".",$elements[1]));
									$i++;
								}						
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

				// polygon DMS
				if($geomtype==3){
					$points = array();

					$x1_sec = floatval(str_replace(",",".",$_POST["x1_sec"]));
					$x1_min = floatval(str_replace(",",".",$_POST["x1_min"]));
					$x1_deg = floatval(str_replace(",",".",$_POST["x1_deg"]));
					$y1_sec = floatval(str_replace(",",".",$_POST["y1_sec"]));
					$y1_min = floatval(str_replace(",",".",$_POST["y1_min"]));
					$y1_deg = floatval(str_replace(",",".",$_POST["y1_deg"]));
						
					$points[0][0]=($x1_sec/60 + $x1_min)/60 + $x1_deg;
					$points[0][1]=($y1_sec/60 + $y1_min)/60 + $y1_deg;

					$x2_sec = floatval(str_replace(",",".",$_POST["x2_sec"]));
					$x2_min = floatval(str_replace(",",".",$_POST["x2_min"]));
					$x2_deg = floatval(str_replace(",",".",$_POST["x2_deg"]));
					$y2_sec = floatval(str_replace(",",".",$_POST["y2_sec"]));
					$y2_min = floatval(str_replace(",",".",$_POST["y2_min"]));
					$y2_deg = floatval(str_replace(",",".",$_POST["y2_deg"]));
						
					$points[1][0]=($x2_sec/60 + $x2_min)/60 + $x2_deg;
					$points[1][1]=($y2_sec/60 + $y2_min)/60 + $y2_deg;
															
					$x3_sec = floatval(str_replace(",",".",$_POST["x3_sec"]));
					$x3_min = floatval(str_replace(",",".",$_POST["x3_min"]));
					$x3_deg = floatval(str_replace(",",".",$_POST["x3_deg"]));
					$y3_sec = floatval(str_replace(",",".",$_POST["y3_sec"]));
					$y3_min = floatval(str_replace(",",".",$_POST["y3_min"]));
					$y3_deg = floatval(str_replace(",",".",$_POST["y3_deg"]));
						
					$points[2][0]=($x3_sec/60 + $x3_min)/60 + $x3_deg;
					$points[2][1]=($y3_sec/60 + $y3_min)/60 + $y3_deg;

					$x4_sec = floatval(str_replace(",",".",$_POST["x4_sec"]));
					$x4_min = floatval(str_replace(",",".",$_POST["x4_min"]));
					$x4_deg = floatval(str_replace(",",".",$_POST["x4_deg"]));
					$y4_sec = floatval(str_replace(",",".",$_POST["y4_sec"]));
					$y4_min = floatval(str_replace(",",".",$_POST["y4_min"]));
					$y4_deg = floatval(str_replace(",",".",$_POST["y4_deg"]));
						
					$points[3][0]=($x4_sec/60 + $x4_min)/60 + $x4_deg;
					$points[3][1]=($y4_sec/60 + $y4_min)/60 + $y4_deg;
									
					$x5_sec = floatval(str_replace(",",".",$_POST["x5_sec"]));
					$x5_min = floatval(str_replace(",",".",$_POST["x5_min"]));
					$x5_deg = floatval(str_replace(",",".",$_POST["x5_deg"]));
					$y5_sec = floatval(str_replace(",",".",$_POST["y5_sec"]));
					$y5_min = floatval(str_replace(",",".",$_POST["y5_min"]));
					$y5_deg = floatval(str_replace(",",".",$_POST["y5_deg"]));
						
					$points[4][0]=($x5_sec/60 + $x5_min)/60 + $x5_deg;
					$points[4][1]=($y5_sec/60 + $y5_min)/60 + $y5_deg;

					$x6_sec = floatval(str_replace(",",".",$_POST["x6_sec"]));
					$x6_min = floatval(str_replace(",",".",$_POST["x6_min"]));
					$x6_deg = floatval(str_replace(",",".",$_POST["x6_deg"]));
					$y6_sec = floatval(str_replace(",",".",$_POST["y6_sec"]));
					$y6_min = floatval(str_replace(",",".",$_POST["y6_min"]));
					$y6_deg = floatval(str_replace(",",".",$_POST["y6_deg"]));
						
					$points[5][0]=($x6_sec/60 + $x6_min)/60 + $x6_deg;
					$points[5][1]=($y6_sec/60 + $y6_min)/60 + $y6_deg;
									
					$x7_sec = floatval(str_replace(",",".",$_POST["x7_sec"]));
					$x7_min = floatval(str_replace(",",".",$_POST["x7_min"]));
					$x7_deg = floatval(str_replace(",",".",$_POST["x7_deg"]));
					$y7_sec = floatval(str_replace(",",".",$_POST["y7_sec"]));
					$y7_min = floatval(str_replace(",",".",$_POST["y7_min"]));
					$y7_deg = floatval(str_replace(",",".",$_POST["y7_deg"]));
						
					$points[6][0]=($x7_sec/60 + $x7_min)/60 + $x7_deg;
					$points[6][1]=($y7_sec/60 + $y7_min)/60 + $y7_deg;

					$x8_sec = floatval(str_replace(",",".",$_POST["x8_sec"]));
					$x8_min = floatval(str_replace(",",".",$_POST["x8_min"]));
					$x8_deg = floatval(str_replace(",",".",$_POST["x8_deg"]));
					$y8_sec = floatval(str_replace(",",".",$_POST["y8_sec"]));
					$y8_min = floatval(str_replace(",",".",$_POST["y8_min"]));
					$y8_deg = floatval(str_replace(",",".",$_POST["y8_deg"]));
						
					$points[7][0]=($x8_sec/60 + $x8_min)/60 + $x8_deg;
					$points[7][1]=($y8_sec/60 + $y8_min)/60 + $y8_deg;
									
					$x9_sec = floatval(str_replace(",",".",$_POST["x9_sec"]));
					$x9_min = floatval(str_replace(",",".",$_POST["x9_min"]));
					$x9_deg = floatval(str_replace(",",".",$_POST["x9_deg"]));
					$y9_sec = floatval(str_replace(",",".",$_POST["y9_sec"]));
					$y9_min = floatval(str_replace(",",".",$_POST["y9_min"]));
					$y9_deg = floatval(str_replace(",",".",$_POST["y9_deg"]));
						
					$points[8][0]=($x9_sec/60 + $x9_min)/60 + $x9_deg;
					$points[8][1]=($y9_sec/60 + $y9_min)/60 + $y9_deg;

					$x10_sec = floatval(str_replace(",",".",$_POST["x10_sec"]));
					$x10_min = floatval(str_replace(",",".",$_POST["x10_min"]));
					$x10_deg = floatval(str_replace(",",".",$_POST["x10_deg"]));
					$y10_sec = floatval(str_replace(",",".",$_POST["y10_sec"]));
					$y10_min = floatval(str_replace(",",".",$_POST["y10_min"]));
					$y10_deg = floatval(str_replace(",",".",$_POST["y10_deg"]));
						
					$points[9][0]=($x10_sec/60 + $x10_min)/60 + $x10_deg;
					$points[9][1]=($y10_sec/60 + $y10_min)/60 + $y10_deg;
																																					
					$geomvalues = $geom->generatePolygonGeom($points, 4326);
					$geomsrid = 4326;
				}
			
				// file DMS 
				if($geomtype==4){
					$filename = $_FILES['geom_file_dms']['name'];
					if(!empty($filename)){
						$fullname = "upload/".$filename;
						move_uploaded_file($_FILES['geom_file_dms']['tmp_name'],$fullname);
						$handle = fopen($fullname, "r");
						if ($handle){
							$i=0;
							$points = array();
							while ($buffer = fgets($handle, 4096)){
								$elements = explode("\t", $buffer);
								if($elements[1]!=NULL && $elements[2]!=NULL && $elements[3]!=NULL && $elements[4]!=NULL && $elements[5]!=NULL && $elements[6]!=NULL)
								{									
									$x1_sec = floatval(str_replace(",",".",$elements[6]));
									$x1_min = floatval(str_replace(",",".",$elements[5]));
									$x1_deg = floatval(str_replace(",",".",$elements[4]));
									$y1_sec = floatval(str_replace(",",".",$elements[3]));
									$y1_min = floatval(str_replace(",",".",$elements[2]));
									$y1_deg = floatval(str_replace(",",".",$elements[1]));
										
									$points[$i][0]=($x1_sec/60 + $x1_min)/60 + $x1_deg;
									$points[$i][1]=($y1_sec/60 + $y1_min)/60 + $y1_deg;
									$i++;
								}
							}
							fclose($handle);
			
							$geomvalues = $geom->generatePolygonGeom($points, 4326);
						}
						unlink($fullname);
					}
					$geomsrid = 4326;
				}
			
				// geom DMS
				if($geomtype==5){
					$geom_value = $_POST["geom_value"];
					if($geomsrid ==4326)
						$geomvalues = $geom->generateGeometryGeom($geom_value);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $geom_value, "GEOM");						
				}
				
				if (empty($geomvalues))
					$geomvalues = "NULL";

				if($geomtype==6)
				{
					$fields = array("utilization_id", "logging_type", "logging_area", "logged_timber", "logged_firewood", "logged_total", "user_id");
					
					$checkvalues = array($utilization_id, $logging_type, $logging_area, $logged_timber, $logged_firewood, $logged_total);
	
					$values = array();
					for ($i = 0; $i < sizeof($checkvalues); $i++) {
						$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
					}
					array_push($values, (int) $_POST["user_id"]);
				} else
				{						
					$fields = array("utilization_id", "logging_type", "logging_area", "logged_timber", "logged_firewood", "logged_total", "geom", "user_id");
					
					$checkvalues = array($utilization_id, $logging_type, $logging_area, $logged_timber, $logged_firewood, $logged_total);
	
					$values = array();
					for ($i = 0; $i < sizeof($checkvalues); $i++) {
						$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
					}
					array_push($values, $geomvalues, (int) $_POST["user_id"]);
				}								

				$result = $db->update("".$schemas.".tgforestlogging", $fields, $values, $wherevalues);
				if (!$result) {
					show_notification("error", _p("EditText1"), "");
				} else {
					show_notification("success", _p("EditText2"), "");
				}
			}
		}

		if (($action == "deletegeom") && isset($_GET["gid"])) 
		{
			$gid = (int) $_GET["gid"];
	
			if ($sess_profile == 1)
				$wherevalues = "gid = ".$gid;
			else
				$wherevalues = "gid = ".$gid." AND user_id = ".$sess_user_id;
	
			$result = $db->delete("".$schemas.".tgforestlogging", $wherevalues);
			if (!$result)
				show_notification("error", _p("DeleteText1"), "");
			else
				show_notification("success", _p("DeleteText2"),"");
		}
		
		if (($action == "deletegisgeom") && isset($_GET["gid"])) 
		{
			$gid = (int) $_GET["gid"];
			
			if ($sess_profile == 1)
				$wherevalues = "gid = ".$gid;
			else
				$wherevalues = "gid = ".$gid." AND user_id = ".$sess_user_id;
			
			$fields = array("geom");
			$values = array("NULL");
			
			$result = $db->update("".$schemas.".tgforestlogging", $fields, $values, $wherevalues);
			if (!$result)
				show_notification("error", _p("DeleteGeomText1"), "");
			else
				show_notification("success", _p("DeleteGeomText2"),"");
		}					
	}
?>