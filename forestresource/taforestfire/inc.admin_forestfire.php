<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-tree"></i> <?php echo _p("OMReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("ResourceSubTitle3"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 1)) 
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

				require("taforestfire/inc.admin_export_forestfire.php");
				
				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 2)) 
				{
					if (isset($_POST["insertforestfirebttn"]) && (int) $_POST["insertforestfirebttn"] == 1) 
					{
						if (isset($_POST["fire_year"]) && isset($_POST["soum_code"]) )
						{

							$fire_year = (int) $_POST["fire_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$burnt_forest_area = floatval(str_replace(",",".",$_POST["burnt_forest_area"]));
							$burnt_pasture_area = floatval(str_replace(",",".",$_POST["burnt_pasture_area"]));
							$burnt_argiculture_area = floatval(str_replace(",",".",$_POST["burnt_argiculture_area"]));
							$burnt_grassland_area = floatval(str_replace(",",".",$_POST["burnt_grassland_area"]));
							$total_burnt_area = $burnt_forest_area + $burnt_pasture_area + $burnt_argiculture_area + $burnt_grassland_area;
							
							$burnt_larch_area = floatval(str_replace(",",".",$_POST["burnt_larch_area"]));
							$burnt_pine_area = floatval(str_replace(",",".",$_POST["burnt_pine_area"]));
							$burnt_evergreen_area = floatval(str_replace(",",".",$_POST["burnt_evergreen_area"]));
							$burnt_othertree_area = floatval(str_replace(",",".",$_POST["burnt_othertree_area"]));
							
							$forest_damage_cost = floatval(str_replace(",",".",$_POST["forest_damage_cost"]));
							$pasture_damage_cost = floatval(str_replace(",",".",$_POST["pasture_damage_cost"]));
							$wildlife_damage_cost = floatval(str_replace(",",".",$_POST["wildlife_damage_cost"]));
							$animal_damage_cost = floatval(str_replace(",",".",$_POST["animal_damage_cost"]));
							$ger_damage_cost = floatval(str_replace(",",".",$_POST["ger_damage_cost"]));
							$house_damage_cost = floatval(str_replace(",",".",$_POST["house_damage_cost"]));
							$fence_damage_cost = floatval(str_replace(",",".",$_POST["fence_damage_cost"]));
							$car_damage_cost = floatval(str_replace(",",".",$_POST["car_damage_cost"]));
							$grass_damage_cost = floatval(str_replace(",",".",$_POST["grass_damage_cost"]));
							$other_property_cost = floatval(str_replace(",",".",$_POST["other_property_cost"]));
							
							$total_damage_cost = $forest_damage_cost + $pasture_damage_cost + $wildlife_damage_cost + $animal_damage_cost + $ger_damage_cost + $house_damage_cost + $fence_damage_cost + $car_damage_cost + $grass_damage_cost + $other_property_cost;

							$damp_food_cost = floatval(str_replace(",",".",$_POST["damp_food_cost"]));
							$damp_petrol_cost = floatval(str_replace(",",".",$_POST["damp_petrol_cost"]));
							$damp_aeroplain_cost = floatval(str_replace(",",".",$_POST["damp_aeroplain_cost"]));
							$damp_salary_cost = floatval(str_replace(",",".",$_POST["damp_salary_cost"]));
							$damp_moving_cost = floatval(str_replace(",",".",$_POST["damp_moving_cost"]));
							$damp_other_cost = floatval(str_replace(",",".",$_POST["damp_other_cost"]));
							
							$total_damp_cost = $damp_food_cost + $damp_petrol_cost + $damp_aeroplain_cost + $damp_salary_cost + $damp_moving_cost + $damp_other_cost;

							$prevention_technics_cost = floatval(str_replace(",",".",$_POST["prevention_technics_cost"]));
							$prevention_canvass_cost = floatval(str_replace(",",".",$_POST["prevention_canvass_cost"]));
							$prevention_firewarden_cost = floatval(str_replace(",",".",$_POST["prevention_firewarden_cost"]));
							$prevention_training_cost = floatval(str_replace(",",".",$_POST["prevention_training_cost"]));
							$prevention_dustbelt_cost = floatval(str_replace(",",".",$_POST["prevention_dustbelt_cost"]));
							$prevention_burntbelt_cost = floatval(str_replace(",",".",$_POST["prevention_burntbelt_cost"]));
							$prevention_clearing_cost = floatval(str_replace(",",".",$_POST["prevention_clearing_cost"]));
							
							$damage_indemnity_put = floatval(str_replace(",",".",$_POST["damage_indemnity_put"]));
							$damage_indemnity_exhaustive = floatval(str_replace(",",".",$_POST["damage_indemnity_exhaustive"]));
							
							$fields = array("fire_year", "soum_code", "fire_number", "place_name", "fire_date", 
							"burnt_forest_area", "burnt_pasture_area", "burnt_argiculture_area", "burnt_grassland_area", "total_burnt_area", 
							"burnt_larch_area", "burnt_pine_area", "burnt_evergreen_area","burnt_othertree_area", 
							"mobilized_people_number" ,"mobilized_car_number","mobilized_tractor_number","mobilized_motorcycle_number","mobilized_cart_number",
							"forest_damage_cost","pasture_damage_cost","wildlife_damage_cost","animal_damage_cost","ger_damage_cost",
							"house_damage_cost","fence_damage_cost","car_damage_cost","grass_damage_cost","other_property_cost","total_damage_cost",
							"died_people_number","burnt_people_number","affected_people_number","fire_source_human","fire_source_natural","fire_source_outside",
							"damp_food_cost","damp_petrol_cost","damp_aeroplain_cost","damp_salary_cost","damp_moving_cost","damp_other_cost","total_damp_cost",
							"prevention_technics_cost","prevention_canvass_cost","prevention_firewarden_cost","prevention_training_cost","prevention_dustbelt_cost","prevention_burntbelt_cost", "prevention_clearing_cost",
							"damage_indemnity_put", "damage_indemnity_exhaustive","causer_address","provision_causer_crime","provision_causer_administrative","provision_causer_fine", "other", "user_id");
							
							$checkvalues = array($fire_year, $soum_code, (int) $_POST["fire_number"], $_POST["place_name"], $_POST["fire_date"], 
							$burnt_forest_area,  $burnt_pasture_area, $burnt_argiculture_area, $burnt_grassland_area, $total_burnt_area, 
							$burnt_larch_area,  $burnt_pine_area,  $burnt_evergreen_area,  $burnt_othertree_area, 
							(int) $_POST["mobilized_people_number"], (int) $_POST["mobilized_car_number"], (int) $_POST["mobilized_tractor_number"], (int) $_POST["mobilized_motorcycle_number"], (int) $_POST["mobilized_cart_number"], 
							$forest_damage_cost, $pasture_damage_cost, $wildlife_damage_cost, $animal_damage_cost, $ger_damage_cost, 
							$house_damage_cost, $fence_damage_cost, $car_damage_cost, $grass_damage_cost, $other_property_cost, $total_damage_cost, 
							(int) $_POST["died_people_number"], (int) $_POST["burnt_people_number"], (int) $_POST["affected_people_number"], $_POST["fire_source_human"], $_POST["fire_source_natural"], $_POST["fire_source_outside"], 
							$damp_food_cost, $damp_petrol_cost, $damp_aeroplain_cost, $damp_salary_cost, $damp_moving_cost, $damp_other_cost, $total_damp_cost, 
							$prevention_technics_cost, $prevention_canvass_cost, $prevention_firewarden_cost, $prevention_training_cost, $prevention_dustbelt_cost, $prevention_burntbelt_cost, $prevention_clearing_cost,
							$damage_indemnity_put, $damage_indemnity_exhaustive, $_POST["causer_address"], $_POST["provision_causer_crime"], $_POST["provision_causer_administrative"], $_POST["provision_causer_fine"], $_POST["other"], $sess_user_id);
								
							$values = array();
							for ($i=0; $i<sizeof($checkvalues); $i++)
							{
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
							
							$result = $db->insert("".$schemas.".taforestfire", $fields, $values);
							if(! $result)
								show_notification("error", _p("AddText1"), "");
							else
								show_notification("success", _p("AddText2"), "");
						}
					}
			   
					if (isset($_POST["updateforestfirebttn"]) && (int) $_POST["updateforestfirebttn"] == 1) 
					{
			
						if (isset($_POST["fire_year"]) && isset($_POST["soum_code"]) && isset($_POST["fire_id"]))
						{
							$wherevalues = "fire_id=".(int) $_POST["fire_id"];
							
							$fire_year = (int) $_POST["fire_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$burnt_forest_area = floatval(str_replace(",",".",$_POST["burnt_forest_area"]));
							$burnt_pasture_area = floatval(str_replace(",",".",$_POST["burnt_pasture_area"]));
							$burnt_argiculture_area = floatval(str_replace(",",".",$_POST["burnt_argiculture_area"]));
							$burnt_grassland_area = floatval(str_replace(",",".",$_POST["burnt_grassland_area"]));
							$total_burnt_area = $burnt_forest_area + $burnt_pasture_area + $burnt_argiculture_area + $burnt_grassland_area;
							
							$burnt_larch_area = floatval(str_replace(",",".",$_POST["burnt_larch_area"]));
							$burnt_pine_area = floatval(str_replace(",",".",$_POST["burnt_pine_area"]));
							$burnt_evergreen_area = floatval(str_replace(",",".",$_POST["burnt_evergreen_area"]));
							$burnt_othertree_area = floatval(str_replace(",",".",$_POST["burnt_othertree_area"]));
							
							$forest_damage_cost = floatval(str_replace(",",".",$_POST["forest_damage_cost"]));
							$pasture_damage_cost = floatval(str_replace(",",".",$_POST["pasture_damage_cost"]));
							$wildlife_damage_cost = floatval(str_replace(",",".",$_POST["wildlife_damage_cost"]));
							$animal_damage_cost = floatval(str_replace(",",".",$_POST["animal_damage_cost"]));
							$ger_damage_cost = floatval(str_replace(",",".",$_POST["ger_damage_cost"]));
							$house_damage_cost = floatval(str_replace(",",".",$_POST["house_damage_cost"]));
							$fence_damage_cost = floatval(str_replace(",",".",$_POST["fence_damage_cost"]));
							$car_damage_cost = floatval(str_replace(",",".",$_POST["car_damage_cost"]));
							$grass_damage_cost = floatval(str_replace(",",".",$_POST["grass_damage_cost"]));
							$other_property_cost = floatval(str_replace(",",".",$_POST["other_property_cost"]));
							
							$total_damage_cost = $forest_damage_cost + $pasture_damage_cost + $wildlife_damage_cost + $animal_damage_cost + $ger_damage_cost + $house_damage_cost + $fence_damage_cost + $car_damage_cost + $grass_damage_cost + $other_property_cost;

							$damp_food_cost = floatval(str_replace(",",".",$_POST["damp_food_cost"]));
							$damp_petrol_cost = floatval(str_replace(",",".",$_POST["damp_petrol_cost"]));
							$damp_aeroplain_cost = floatval(str_replace(",",".",$_POST["damp_aeroplain_cost"]));
							$damp_salary_cost = floatval(str_replace(",",".",$_POST["damp_salary_cost"]));
							$damp_moving_cost = floatval(str_replace(",",".",$_POST["damp_moving_cost"]));
							$damp_other_cost = floatval(str_replace(",",".",$_POST["damp_other_cost"]));
							
							$total_damp_cost = $damp_food_cost + $damp_petrol_cost + $damp_aeroplain_cost + $damp_salary_cost + $damp_moving_cost + $damp_other_cost;

							$prevention_technics_cost = floatval(str_replace(",",".",$_POST["prevention_technics_cost"]));
							$prevention_canvass_cost = floatval(str_replace(",",".",$_POST["prevention_canvass_cost"]));
							$prevention_firewarden_cost = floatval(str_replace(",",".",$_POST["prevention_firewarden_cost"]));
							$prevention_training_cost = floatval(str_replace(",",".",$_POST["prevention_training_cost"]));
							$prevention_dustbelt_cost = floatval(str_replace(",",".",$_POST["prevention_dustbelt_cost"]));
							$prevention_burntbelt_cost = floatval(str_replace(",",".",$_POST["prevention_burntbelt_cost"]));
							$prevention_clearing_cost = floatval(str_replace(",",".",$_POST["prevention_clearing_cost"]));
							
							$damage_indemnity_put = floatval(str_replace(",",".",$_POST["damage_indemnity_put"]));
							$damage_indemnity_exhaustive = floatval(str_replace(",",".",$_POST["damage_indemnity_exhaustive"]));
							
							$fields = array("fire_year", "soum_code", "fire_number", "place_name", "fire_date", 
							"burnt_forest_area", "burnt_pasture_area", "burnt_argiculture_area", "burnt_grassland_area", "total_burnt_area", 
							"burnt_larch_area", "burnt_pine_area", "burnt_evergreen_area","burnt_othertree_area", 
							"mobilized_people_number" ,"mobilized_car_number","mobilized_tractor_number","mobilized_motorcycle_number","mobilized_cart_number",
							"forest_damage_cost","pasture_damage_cost","wildlife_damage_cost","animal_damage_cost","ger_damage_cost",
							"house_damage_cost","fence_damage_cost","car_damage_cost","grass_damage_cost","other_property_cost","total_damage_cost",
							"died_people_number","burnt_people_number","affected_people_number","fire_source_human","fire_source_natural","fire_source_outside",
							"damp_food_cost","damp_petrol_cost","damp_aeroplain_cost","damp_salary_cost","damp_moving_cost","damp_other_cost","total_damp_cost",
							"prevention_technics_cost","prevention_canvass_cost","prevention_firewarden_cost","prevention_training_cost","prevention_dustbelt_cost","prevention_burntbelt_cost", "prevention_clearing_cost",
							"damage_indemnity_put", "damage_indemnity_exhaustive","causer_address","provision_causer_crime","provision_causer_administrative","provision_causer_fine", "other", "user_id");
							
							$checkvalues = array($fire_year, $soum_code, (int) $_POST["fire_number"], $_POST["place_name"], $_POST["fire_date"], 
							$burnt_forest_area,  $burnt_pasture_area, $burnt_argiculture_area, $burnt_grassland_area, $total_burnt_area, 
							$burnt_larch_area,  $burnt_pine_area,  $burnt_evergreen_area,  $burnt_othertree_area, 
							(int) $_POST["mobilized_people_number"], (int) $_POST["mobilized_car_number"], (int) $_POST["mobilized_tractor_number"], (int) $_POST["mobilized_motorcycle_number"], (int) $_POST["mobilized_cart_number"], 
							$forest_damage_cost, $pasture_damage_cost, $wildlife_damage_cost, $animal_damage_cost, $ger_damage_cost, 
							$house_damage_cost, $fence_damage_cost, $car_damage_cost, $grass_damage_cost, $other_property_cost, $total_damage_cost, 
							(int) $_POST["died_people_number"], (int) $_POST["burnt_people_number"], (int) $_POST["affected_people_number"], $_POST["fire_source_human"], $_POST["fire_source_natural"], $_POST["fire_source_outside"], 
							$damp_food_cost, $damp_petrol_cost, $damp_aeroplain_cost, $damp_salary_cost, $damp_moving_cost, $damp_other_cost, $total_damp_cost, 
							$prevention_technics_cost, $prevention_canvass_cost, $prevention_firewarden_cost, $prevention_training_cost, $prevention_dustbelt_cost, $prevention_burntbelt_cost, $prevention_clearing_cost,
							$damage_indemnity_put, $damage_indemnity_exhaustive, $_POST["causer_address"], $_POST["provision_causer_crime"], $_POST["provision_causer_administrative"], $_POST["provision_causer_fine"], $_POST["other"], (int) $_POST["user_id"]);
			
							$values = array();
							for ($i = 0; $i < sizeof($checkvalues); $i++) {
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
			
							$result = $db->update("".$schemas.".taforestfire", $fields, $values, $wherevalues);
							if (!$result) {
								show_notification("error", _p("EditText1"), "");
							} else {
								show_notification("success", _p("EditText2"), "");
							}
						}
					}
			
					if (($action == "delete") && isset($_GET["fire_id"])) 
					{
						$fire_id = (int) $_GET["fire_id"];
				
						if ($sess_profile == 1)
							$wherevalues = "fire_id = ".$fire_id;
						else
							$wherevalues = "fire_id = ".$fire_id." AND user_id = ".$sess_user_id;;
				
						$result = $db->delete("".$schemas.".taforestfire", $wherevalues);
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
			
				$sfire_year = (isset($_GET["sfire_year"])) ? (int) $_GET["sfire_year"] : 0;		
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
					
				if($sfire_year==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.fire_year = ".$sfire_year;
					$search_url .= "&sfire_year=".$sfire_year;
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
					require("taforestfire/inc.edit_forestfire.php");
				} elseif ($action == "add")
				{
					require("taforestfire/inc.add_forestfire.php");		
				}elseif ($action=="export")
				{
					require("taforestfire/inc.export_forestfire.php");
				} elseif ($action == "more")
				{
					require("taforestfire/inc.more_forestfire.php");		
				} else
				{
					require("taforestfire/inc.list_forestfire.php");
				}
			} else {				
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  