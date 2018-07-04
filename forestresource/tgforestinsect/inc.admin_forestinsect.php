<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-globe"></i> <?php echo _p("OMGisReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("GisSubTitle1"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 1)) 
			{
				$my_url .= "?menuitem=".$menuitem;
				
				$count = (isset($_POST["count"]) && (int) $_POST["count"] > 0) ? (int) $_POST["count"] : ((isset($_GET["count"]) && (int) $_GET["count"] > 0) ? (int) $_GET["count"] : 10);
				$my_count = $my_url;
				$my_url .= "&count=".$count;
				
				if (isset($_GET["action"])) {
					$action = pg_prep($_GET["action"]);
				} else {
					$action = "";
				}

				require("tgforestinsect/inc.admin_export_forestinsect.php");
				
				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 2)) 
				{
					require("modules/generategeom.class.php");

					if (isset($_POST["insertforestinsectgeombttn"]) && (int) $_POST["insertforestinsectgeombttn"] == 1) 
					{
						if (isset($_POST["insect_id"]) && isset($_POST["control_type"]))
						{
							$insect_id = (int) $_POST["insect_id"];
							$control_type = (int) $_POST["control_type"];
							
							$insect_damage_area = floatval(str_replace(",",".",$_POST["insect_damage_area"]));				
							$control_area = floatval(str_replace(",",".",$_POST["control_area"]));

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
								
							$fields = array("insect_id", "insect_name", "insect_damage_area", "control_type", "control_area", "geom", "user_id");
							
							$checkvalues = array($insect_id, $_POST["insect_name"], $insect_damage_area,  $control_type, $control_area);
								
							$values = array();
							for ($i=0; $i<sizeof($checkvalues); $i++)
							{
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
							array_push($values, $geomvalues, $sess_user_id);
							
							$result = $db->insert("".$schemas.".tgforestinsect", $fields, $values);
							if(! $result)
								show_notification("error", _p("AddText1"), "");
							else
								show_notification("success", _p("AddText2"), "");
						}
					}
			   
					if (isset($_POST["updateforestinsectgeombttn"]) && (int) $_POST["updateforestinsectgeombttn"] == 1) 
					{
			     
						if (isset($_POST["insect_id"]) && isset($_POST["control_type"]) && isset($_POST["gid"]))
						{
							$wherevalues = "gid=".(int) $_POST["gid"];
							
							$insect_id = (int) $_POST["insect_id"];
							$control_type = (int) $_POST["control_type"];
							
							$insect_damage_area = floatval(str_replace(",",".",$_POST["insect_damage_area"]));				
							$control_area = floatval(str_replace(",",".",$_POST["control_area"]));

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
								$fields = array("insect_id", "insect_name", "insect_damage_area", "control_type", "control_area", "user_id");
								
								$checkvalues = array($insect_id, $_POST["insect_name"], $insect_damage_area,  $control_type, $control_area);
				
								$values = array();
								for ($i = 0; $i < sizeof($checkvalues); $i++) {
									$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
								}
								array_push($values, (int) $_POST["user_id"]);
							} else
							{						
								$fields = array("insect_id", "insect_name", "insect_damage_area", "control_type", "control_area", "geom", "user_id");
								
								$checkvalues = array($insect_id, $_POST["insect_name"], $insect_damage_area,  $control_type, $control_area);
				
								$values = array();
								for ($i = 0; $i < sizeof($checkvalues); $i++) {
									$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
								}
								array_push($values, $geomvalues, (int) $_POST["user_id"]);
							}								
			
							$result = $db->update("".$schemas.".tgforestinsect", $fields, $values, $wherevalues);
							if (!$result) {
								show_notification("error", _p("EditText1"), "");
							} else {
								show_notification("success", _p("EditText2"), "");
							}
						}
					}
			
					if (($action == "delete") && isset($_GET["gid"])) 
					{
						$gid = (int) $_GET["gid"];
				
						if ($sess_profile == 1)
							$wherevalues = "gid = ".$gid;
						else
							$wherevalues = "gid = ".$gid." AND user_id = ".$sess_user_id;
				
						$result = $db->delete("".$schemas.".tgforestinsect", $wherevalues);
						if (!$result)
							show_notification("error", _p("DeleteText1"), "");
						else
							show_notification("success", _p("DeleteText2"),"");
					}
					
					if (($action == "deletegis") && isset($_GET["gid"])) 
					{
						$gid = (int) $_GET["gid"];
						
						if ($sess_profile == 1)
							$wherevalues = "gid = ".$gid;
						else
							$wherevalues = "gid = ".$gid." AND user_id = ".$sess_user_id;
						
						$fields = array("geom");
						$values = array("NULL");
						
						$result = $db->update("".$schemas.".tgforestinsect", $fields, $values, $wherevalues);
						if (!$result)
							show_notification("error", _p("DeleteGeomText1"), "");
						else
							show_notification("success", _p("DeleteGeomText2"),"");
					}					
				}
			
				$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
				$my_page = "&page=".$page;
			
				$searchQuery = "";
				$search_url = "";
			
				$sinsect_year = (isset($_GET["sinsect_year"])) ? (int) $_GET["sinsect_year"] : 0;		
				$saimag_code = (isset($_GET["saimag_code"])) ? (int) $_GET["saimag_code"] : 0;
				$sgeometry_status = (isset($_GET["sgeometry_status"])) ? (int) $_GET["sgeometry_status"] : 0;
				
				if($saimag_code==0)
				{
					$searchQuery .= "";
					$search_url .= "";
				} else
				{
					$searchQuery .= " AND vs.aimag_code = ".$saimag_code;
					$search_url .= "&saimag_code=".$saimag_code;
				}
					
				if($sinsect_year==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.insect_year = ".$sinsect_year;
					$search_url .= "&sinsect_year=".$sinsect_year;
				}
				
				if($sgeometry_status==0)
				{
					$searchQuery .= "";
					$search_url .= "";
				} else if($sgeometry_status==1)
				{
					$searchQuery .= " AND ST_IsValidReason(tgf.geom) = 'Valid Geometry' AND (ST_YMin(tgf.geom) > 40 AND ST_YMax(tgf.geom) < 53 AND ST_XMin(tgf.geom) > 86 AND ST_XMax(tgf.geom) < 120)";
					$search_url .= "&sgeometry_status=".$sgeometry_status;
				} else if($sgeometry_status==2)
				{
					$searchQuery .= " AND ST_IsValidReason(tgf.geom) IS NULL";
					$search_url .= "&sgeometry_status=".$sgeometry_status;
				} else if($sgeometry_status==3)
				{
					$searchQuery .= " AND ST_IsValidReason(tgf.geom) != 'Valid Geometry'";
					$search_url .= "&sgeometry_status=".$sgeometry_status;
				} else if($sgeometry_status==4)
				{
					$searchQuery .= " AND NOT (ST_YMin(tgf.geom) > 40 AND ST_YMax(tgf.geom) < 53 AND ST_XMin(tgf.geom) > 86 AND ST_XMax(tgf.geom) < 120)";
					$search_url .= "&sgeometry_status=".$sgeometry_status;
				}
				
				$valueQuery1 = "";
				$whereQuery1 = "";
				
				$user_id = (isset($_GET["user_id"])) ? (int) $_GET["user_id"] : 0;
				$group_id = (isset($_GET["group_id"])) ? (int) $_GET["group_id"] : 0;
					
				if($user_id==0)
				{
					$searchQuery .= "";
					$search_url .= "";
				} else
				{
					$searchQuery .= " AND tgf.user_id = ".$user_id;
					$search_url .= "&user_id=".$user_id;
				}
				
				if($group_id==0)
				{
					$searchQuery .= "";
					$search_url .= "";
				} else
				{
					$searchQuery .= " AND tug.group_id = ".$group_id;
					$search_url .= "&group_id=".$group_id;
					
					$valueQuery1 = ", ".$schemas.".tausergroups tug";
					$whereQuery1 = " AND tgf.user_id = tug.user_id";
				}
					
				$sort_url = "";
				$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
				$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;
			
				if ($sort == 0)
					$sort_url .= "";
				else
					$sort_url .= "&sort=".$sort;
			
				if ($sort_type == 0)
					$sort_url .= "";
				else
					$sort_url .= "&sorttype=".$sort_type;
			
				if ($action == "edit") {
					require("tgforestinsect/inc.edit_forestinsect.php");
				} elseif ($action == "add")
				{
					require("tgforestinsect/inc.add_forestinsect.php");
				} elseif ($action == "select")
				{
					require("tgforestinsect/inc.select_admin_forestinsect.php");
				}elseif ($action=="export")
				{
					require("tgforestinsect/inc.export_forestinsect.php");
				} elseif ($action == "more")
				{
					require("tgforestinsect/inc.more_forestinsect.php");
				} elseif ($action == "outputgeom")
				{
					require("tgforestinsect/inc.output_forestinsect.php");					
				} else
				{
					require("tgforestinsect/inc.list_forestinsect.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  