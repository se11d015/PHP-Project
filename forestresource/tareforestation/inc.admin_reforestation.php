<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-tree"></i> <?php echo _p("OMReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("ResourceSubTitle5"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 1)) 
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

				require("tareforestation/inc.admin_export_reforestation.php");
				
				require("modules/generategeom.class.php");
				require("tareforestation/inc.admin_geom_reforestation.php");
				require("tareforestation/inc.admin_geom_plantedforest.php");				
				
				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 2)) 
				{
					if (isset($_POST["insertreforestationbttn"]) && (int) $_POST["insertreforestationbttn"] == 1) 
					{
						if (isset($_POST["reforest_year"]) && isset($_POST["soum_code"]) )
						{

							$reforest_year = (int) $_POST["reforest_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$planted_area = floatval(str_replace(",",".",$_POST["planted_area"]));
							$regenerate_area = floatval(str_replace(",",".",$_POST["regenerate_area"]));
							$forest_belt_area = floatval(str_replace(",",".",$_POST["forest_belt_area"]));
							
							$planted_forest_area = floatval(str_replace(",",".",$_POST["planted_forest_area"]));
							
							$reforestation_percent = floatval(str_replace(",",".",$_POST["reforestation_percent"]));
							
							$prepared_seed_larch = floatval(str_replace(",",".",$_POST["prepared_seed_larch"]));
							$prepared_seed_pine = floatval(str_replace(",",".",$_POST["prepared_seed_pine"]));
							$prepared_seed_saxaul = floatval(str_replace(",",".",$_POST["prepared_seed_saxaul"]));
							$prepared_seed_other = floatval(str_replace(",",".",$_POST["prepared_seed_other"]));
							
							$fields = array("reforest_year", "soum_code", "planted_area", "regenerate_area", "forest_belt_area", "reforestation_location",
							"planted_forest_area", "planted_location", "reforestation_percent", 
							"seedling_1age_number", "seedling_2age_number", "seedling_3age_number", 
							"seedling_number_larch", "seedling_number_pine", "seedling_number_other", 
							"prepared_seed_larch", "prepared_seed_pine", "prepared_seed_saxaul", "prepared_seed_other", "user_id");
							
							$checkvalues = array($reforest_year, $soum_code, $planted_area, $regenerate_area, $forest_belt_area, $_POST["reforestation_location"], 
							$planted_forest_area, $_POST["planted_location"], $reforestation_percent, 
							(int) $_POST["seedling_1age_number"], (int) $_POST["seedling_2age_number"], (int) $_POST["seedling_3age_number"], 
							(int) $_POST["seedling_number_larch"], (int) $_POST["seedling_number_pine"], (int) $_POST["seedling_number_other"], 
							$prepared_seed_larch,  $prepared_seed_pine,	$prepared_seed_saxaul, $prepared_seed_other, $sess_user_id);
								
							$values = array();
							for ($i=0; $i<sizeof($checkvalues); $i++)
							{
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
							
							$result = $db->insert("".$schemas.".tareforestation", $fields, $values);
							if(! $result)
								show_notification("error", _p("AddText1"), "");
							else
								show_notification("success", _p("AddText2"), "");
						}
					}
			   
					if (isset($_POST["updatereforestationbttn"]) && (int) $_POST["updatereforestationbttn"] == 1) 
					{
			
						if (isset($_POST["reforest_year"]) && isset($_POST["soum_code"]) && isset($_POST["reforest_id"]))
						{
							$wherevalues = "reforest_id=".(int) $_POST["reforest_id"];
							
							$reforest_year = (int) $_POST["reforest_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$planted_area = floatval(str_replace(",",".",$_POST["planted_area"]));
							$regenerate_area = floatval(str_replace(",",".",$_POST["regenerate_area"]));
							$forest_belt_area = floatval(str_replace(",",".",$_POST["forest_belt_area"]));
							
							$planted_forest_area = floatval(str_replace(",",".",$_POST["planted_forest_area"]));
							
							$reforestation_percent = floatval(str_replace(",",".",$_POST["reforestation_percent"]));
							
							$prepared_seed_larch = floatval(str_replace(",",".",$_POST["prepared_seed_larch"]));
							$prepared_seed_pine = floatval(str_replace(",",".",$_POST["prepared_seed_pine"]));
							$prepared_seed_saxaul = floatval(str_replace(",",".",$_POST["prepared_seed_saxaul"]));
							$prepared_seed_other = floatval(str_replace(",",".",$_POST["prepared_seed_other"]));
							
							$fields = array("reforest_year", "soum_code", "planted_area", "regenerate_area", "forest_belt_area", "reforestation_location",
							"planted_forest_area", "planted_location", "reforestation_percent", 
							"seedling_1age_number", "seedling_2age_number", "seedling_3age_number", 
							"seedling_number_larch", "seedling_number_pine", "seedling_number_other", 
							"prepared_seed_larch", "prepared_seed_pine", "prepared_seed_saxaul", "prepared_seed_other", "user_id");
							
							$checkvalues = array($reforest_year, $soum_code, $planted_area, $regenerate_area, $forest_belt_area, $_POST["reforestation_location"], 
							$planted_forest_area, $_POST["planted_location"], $reforestation_percent, 
							(int) $_POST["seedling_1age_number"], (int) $_POST["seedling_2age_number"], (int) $_POST["seedling_3age_number"], 
							(int) $_POST["seedling_number_larch"], (int) $_POST["seedling_number_pine"], (int) $_POST["seedling_number_other"], 
							$prepared_seed_larch,  $prepared_seed_pine,	$prepared_seed_saxaul, $prepared_seed_other, (int) $_POST["user_id"]);
			
							$values = array();
							for ($i = 0; $i < sizeof($checkvalues); $i++) {
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
			
							$result = $db->update("".$schemas.".tareforestation", $fields, $values, $wherevalues);
							if (!$result) {
								show_notification("error", _p("EditText1"), "");
							} else {
								show_notification("success", _p("EditText2"), "");
							}
						}
					}
			
					if (($action == "delete") && isset($_GET["reforest_id"])) 
					{
						$reforest_id = (int) $_GET["reforest_id"];
				
						if ($sess_profile == 1)
							$wherevalues = "reforest_id = ".$reforest_id;
						else
							$wherevalues = "reforest_id = ".$reforest_id." AND user_id = ".$sess_user_id;;
				
						$result = $db->delete("".$schemas.".tareforestation", $wherevalues);
						if (!$result)
							show_notification("error", _p("DeleteText1"), "");
						else
							show_notification("success", _p("DeleteText2"),"");
					}
				}
			
				$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
				$my_page = "&page=".$page;
			
				$searchQuery = "";
				$search_url = "";
			
				$sreforest_year = (isset($_GET["sreforest_year"])) ? (int) $_GET["sreforest_year"] : 0;		
				$saimag_code = (isset($_GET["saimag_code"])) ? (int) $_GET["saimag_code"] : 0;
				
				if($saimag_code==0)
				{
					$searchQuery .= "";
					$search_url .= "";
				} else
				{
					$searchQuery .= " AND vs.aimag_code = ".$saimag_code;
					$search_url .= "&saimag_code=".$saimag_code;
				}
					
				if($sreforest_year==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.reforest_year = ".$sreforest_year;
					$search_url .= "&sreforest_year=".$sreforest_year;
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
					$searchQuery .= " AND taf.user_id = ".$user_id;
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
					$whereQuery1 = " AND taf.user_id = tug.user_id";
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
					require("tareforestation/inc.edit_reforestation.php");
				} elseif ($action == "add")
				{
					require("tareforestation/inc.add_reforestation.php");		
				}elseif ($action=="export")
				{
					require("tareforestation/inc.export_reforestation.php");
				}elseif ($action=="addgeom")
				{
					require("tgreforestation/inc.add_reforestation.php");	
				}elseif ($action=="editgeom")
				{
					require("tgreforestation/inc.edit_reforestation.php");
				} elseif ($action == "outputgeom")
				{
					require("tgreforestation/inc.output_reforestation.php");
				}elseif ($action=="addgeom1")
				{
					require("tgplantedforest/inc.add_plantedforest.php");	
				}elseif ($action=="editgeom1")
				{
					require("tgplantedforest/inc.edit_plantedforest.php");
				} elseif ($action == "outputgeom1")
				{
					require("tgplantedforest/inc.output_plantedforest.php");
				} elseif ($action == "more")
				{
					require("tareforestation/inc.more_reforestation.php");		
				} else
				{
					require("tareforestation/inc.list_reforestation.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  