<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-tree"></i> <?php echo _p("OMReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("ResourceSubTitle9"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 1)) 
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

				require("tacostreport/inc.admin_export_costreport.php");
				
				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 2)) 
				{
					if (isset($_POST["insertcostreportbttn"]) && (int) $_POST["insertcostreportbttn"] == 1) 
					{
						if (isset($_POST["cost_year"]) && isset($_POST["soum_code"]) )
						{

							$cost_year = (int) $_POST["cost_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$state_reforest = floatval(str_replace(",",".",$_POST["state_reforest"]));
							$local_reforest = floatval(str_replace(",",".",$_POST["local_reforest"]));
							$other_reforest = floatval(str_replace(",",".",$_POST["other_reforest"]));
							$state_thin_clear = floatval(str_replace(",",".",$_POST["state_thin_clear"]));
							$local_thin_clear = floatval(str_replace(",",".",$_POST["local_thin_clear"]));
							$other_thin_clear = floatval(str_replace(",",".",$_POST["other_thin_clear"]));

							$state_insect_study = floatval(str_replace(",",".",$_POST["state_insect_study"]));
							$local_insect_study = floatval(str_replace(",",".",$_POST["local_insect_study"]));
							$other_insect_study = floatval(str_replace(",",".",$_POST["other_insect_study"]));
							$state_insect_control = floatval(str_replace(",",".",$_POST["state_insect_control"]));
							$local_insect_control = floatval(str_replace(",",".",$_POST["local_insect_control"]));
							$other_insect_control = floatval(str_replace(",",".",$_POST["other_insect_control"]));
							
							$state_seed_prepare = floatval(str_replace(",",".",$_POST["state_seed_prepare"]));
							$local_seed_prepare = floatval(str_replace(",",".",$_POST["local_seed_prepare"]));
							$other_seed_prepare = floatval(str_replace(",",".",$_POST["other_seed_prepare"]));
							$state_forest_training = floatval(str_replace(",",".",$_POST["state_forest_training"]));
							$local_forest_training = floatval(str_replace(",",".",$_POST["local_forest_training"]));
							$other_forest_training = floatval(str_replace(",",".",$_POST["other_forest_training"]));
								
							$state_forest_equipment = floatval(str_replace(",",".",$_POST["state_forest_equipment"]));
							$local_forest_equipment = floatval(str_replace(",",".",$_POST["local_forest_equipment"]));
							$other_forest_equipment = floatval(str_replace(",",".",$_POST["other_forest_equipment"]));
							$state_other_cost = floatval(str_replace(",",".",$_POST["state_other_cost"]));
							$local_other_cost = floatval(str_replace(",",".",$_POST["local_other_cost"]));
							$other_other_cost = floatval(str_replace(",",".",$_POST["other_other_cost"]));
							
							$state_income_nonforest_product = floatval(str_replace(",",".",$_POST["state_income_nonforest_product"]));
							$local_income_nonforest_product = floatval(str_replace(",",".",$_POST["local_income_nonforest_product"]));
							$other_income_nonforest_product = floatval(str_replace(",",".",$_POST["other_income_nonforest_product"]));
							$state_income_logging = floatval(str_replace(",",".",$_POST["state_income_logging"]));
							$local_income_logging = floatval(str_replace(",",".",$_POST["local_income_logging"]));
							$other_income_logging = floatval(str_replace(",",".",$_POST["other_income_logging"]));
							
							$state_income_fire_indemnity = floatval(str_replace(",",".",$_POST["state_income_fire_indemnity"]));
							$local_income_fire_indemnity = floatval(str_replace(",",".",$_POST["local_income_fire_indemnity"]));
							$other_income_fire_indemnity = floatval(str_replace(",",".",$_POST["other_income_fire_indemnity"]));
							$state_income_indemnity = floatval(str_replace(",",".",$_POST["state_income_indemnity"]));
							$local_income_indemnity = floatval(str_replace(",",".",$_POST["local_income_indemnity"]));
							$other_income_indemnity = floatval(str_replace(",",".",$_POST["other_income_indemnity"]));
							
							$state_income_seedling = floatval(str_replace(",",".",$_POST["state_income_seedling"]));
							$local_income_seedling = floatval(str_replace(",",".",$_POST["local_income_seedling"]));
							$other_income_seedling = floatval(str_replace(",",".",$_POST["other_income_seedling"]));
							
							$fields = array("cost_year", "soum_code", 
							"state_reforest", "local_reforest", "other_reforest", "state_thin_clear", "local_thin_clear", "other_thin_clear", 
							"state_insect_study", "local_insect_study", "other_insect_study", "state_insect_control", "local_insect_control", "other_insect_control", 
							"state_seed_prepare", "local_seed_prepare", "other_seed_prepare", "state_forest_training", "local_forest_training", "other_forest_training", 
							"state_forest_equipment", "local_forest_equipment", "other_forest_equipment", "state_other_cost", "local_other_cost", "other_other_cost", 
							"state_income_nonforest_product", "local_income_nonforest_product", "other_income_nonforest_product", "state_income_logging", "local_income_logging", "other_income_logging", "state_income_fire_indemnity", "local_income_fire_indemnity", "other_income_fire_indemnity", "state_income_indemnity", "local_income_indemnity", "other_income_indemnity", "state_income_seedling", "local_income_seedling", "other_income_seedling", "user_id");
							
							$checkvalues = array($cost_year, $soum_code, 
							$state_reforest, $local_reforest, $other_reforest, $state_thin_clear, $local_thin_clear, $other_thin_clear, 
							$state_insect_study, $local_insect_study, $other_insect_study, $state_insect_control, $local_insect_control, $other_insect_control, 
							$state_seed_prepare, $local_seed_prepare, $other_seed_prepare, $state_forest_training, $local_forest_training, $other_forest_training, 
							$state_forest_equipment, $local_forest_equipment, $other_forest_equipment, $state_other_cost, $local_other_cost, $other_other_cost, 
							$state_income_nonforest_product, $local_income_nonforest_product, $other_income_nonforest_product, $state_income_logging, $local_income_logging, $other_income_logging, 
							$state_income_fire_indemnity, $local_income_fire_indemnity, $other_income_fire_indemnity, $state_income_indemnity, $local_income_indemnity, $other_income_indemnity, 
							$state_income_seedling, $local_income_seedling, $other_income_seedling, $sess_user_id);
								
							$values = array();
							for ($i=0; $i<sizeof($checkvalues); $i++)
							{
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
							
							$result = $db->insert("".$schemas.".tacostreport", $fields, $values);
							if(! $result)
								show_notification("error", _p("AddText1"), "");
							else
								show_notification("success", _p("AddText2"), "");
						}
					}
			   
					if (isset($_POST["updatecostreportbttn"]) && (int) $_POST["updatecostreportbttn"] == 1) 
					{
			
						if (isset($_POST["cost_year"]) && isset($_POST["soum_code"]) && isset($_POST["cost_id"]))
						{
							$wherevalues = "cost_id=".(int) $_POST["cost_id"];
							
							$cost_year = (int) $_POST["cost_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$state_reforest = floatval(str_replace(",",".",$_POST["state_reforest"]));
							$local_reforest = floatval(str_replace(",",".",$_POST["local_reforest"]));
							$other_reforest = floatval(str_replace(",",".",$_POST["other_reforest"]));
							$state_thin_clear = floatval(str_replace(",",".",$_POST["state_thin_clear"]));
							$local_thin_clear = floatval(str_replace(",",".",$_POST["local_thin_clear"]));
							$other_thin_clear = floatval(str_replace(",",".",$_POST["other_thin_clear"]));

							$state_insect_study = floatval(str_replace(",",".",$_POST["state_insect_study"]));
							$local_insect_study = floatval(str_replace(",",".",$_POST["local_insect_study"]));
							$other_insect_study = floatval(str_replace(",",".",$_POST["other_insect_study"]));
							$state_insect_control = floatval(str_replace(",",".",$_POST["state_insect_control"]));
							$local_insect_control = floatval(str_replace(",",".",$_POST["local_insect_control"]));
							$other_insect_control = floatval(str_replace(",",".",$_POST["other_insect_control"]));
							
							$state_seed_prepare = floatval(str_replace(",",".",$_POST["state_seed_prepare"]));
							$local_seed_prepare = floatval(str_replace(",",".",$_POST["local_seed_prepare"]));
							$other_seed_prepare = floatval(str_replace(",",".",$_POST["other_seed_prepare"]));
							$state_forest_training = floatval(str_replace(",",".",$_POST["state_forest_training"]));
							$local_forest_training = floatval(str_replace(",",".",$_POST["local_forest_training"]));
							$other_forest_training = floatval(str_replace(",",".",$_POST["other_forest_training"]));
								
							$state_forest_equipment = floatval(str_replace(",",".",$_POST["state_forest_equipment"]));
							$local_forest_equipment = floatval(str_replace(",",".",$_POST["local_forest_equipment"]));
							$other_forest_equipment = floatval(str_replace(",",".",$_POST["other_forest_equipment"]));
							$state_other_cost = floatval(str_replace(",",".",$_POST["state_other_cost"]));
							$local_other_cost = floatval(str_replace(",",".",$_POST["local_other_cost"]));
							$other_other_cost = floatval(str_replace(",",".",$_POST["other_other_cost"]));
							
							$state_income_nonforest_product = floatval(str_replace(",",".",$_POST["state_income_nonforest_product"]));
							$local_income_nonforest_product = floatval(str_replace(",",".",$_POST["local_income_nonforest_product"]));
							$other_income_nonforest_product = floatval(str_replace(",",".",$_POST["other_income_nonforest_product"]));
							$state_income_logging = floatval(str_replace(",",".",$_POST["state_income_logging"]));
							$local_income_logging = floatval(str_replace(",",".",$_POST["local_income_logging"]));
							$other_income_logging = floatval(str_replace(",",".",$_POST["other_income_logging"]));
							
							$state_income_fire_indemnity = floatval(str_replace(",",".",$_POST["state_income_fire_indemnity"]));
							$local_income_fire_indemnity = floatval(str_replace(",",".",$_POST["local_income_fire_indemnity"]));
							$other_income_fire_indemnity = floatval(str_replace(",",".",$_POST["other_income_fire_indemnity"]));
							$state_income_indemnity = floatval(str_replace(",",".",$_POST["state_income_indemnity"]));
							$local_income_indemnity = floatval(str_replace(",",".",$_POST["local_income_indemnity"]));
							$other_income_indemnity = floatval(str_replace(",",".",$_POST["other_income_indemnity"]));
							
							$state_income_seedling = floatval(str_replace(",",".",$_POST["state_income_seedling"]));
							$local_income_seedling = floatval(str_replace(",",".",$_POST["local_income_seedling"]));
							$other_income_seedling = floatval(str_replace(",",".",$_POST["other_income_seedling"]));
							
							$fields = array("cost_year", "soum_code", 
							"state_reforest", "local_reforest", "other_reforest", "state_thin_clear", "local_thin_clear", "other_thin_clear", 
							"state_insect_study", "local_insect_study", "other_insect_study", "state_insect_control", "local_insect_control", "other_insect_control", 
							"state_seed_prepare", "local_seed_prepare", "other_seed_prepare", "state_forest_training", "local_forest_training", "other_forest_training", 
							"state_forest_equipment", "local_forest_equipment", "other_forest_equipment", "state_other_cost", "local_other_cost", "other_other_cost", 
							"state_income_nonforest_product", "local_income_nonforest_product", "other_income_nonforest_product", "state_income_logging", "local_income_logging", "other_income_logging", "state_income_fire_indemnity", "local_income_fire_indemnity", "other_income_fire_indemnity", "state_income_indemnity", "local_income_indemnity", "other_income_indemnity", "state_income_seedling", "local_income_seedling", "other_income_seedling", "user_id");
							
							$checkvalues = array($cost_year, $soum_code, 
							$state_reforest, $local_reforest, $other_reforest, $state_thin_clear, $local_thin_clear, $other_thin_clear, 
							$state_insect_study, $local_insect_study, $other_insect_study, $state_insect_control, $local_insect_control, $other_insect_control, 
							$state_seed_prepare, $local_seed_prepare, $other_seed_prepare, $state_forest_training, $local_forest_training, $other_forest_training, 
							$state_forest_equipment, $local_forest_equipment, $other_forest_equipment, $state_other_cost, $local_other_cost, $other_other_cost, 
							$state_income_nonforest_product, $local_income_nonforest_product, $other_income_nonforest_product, $state_income_logging, $local_income_logging, $other_income_logging, 
							$state_income_fire_indemnity, $local_income_fire_indemnity, $other_income_fire_indemnity, $state_income_indemnity, $local_income_indemnity, $other_income_indemnity, 
							$state_income_seedling, $local_income_seedling, $other_income_seedling, (int) $_POST["user_id"]);
			
							$values = array();
							for ($i = 0; $i < sizeof($checkvalues); $i++) {
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
			
							$result = $db->update("".$schemas.".tacostreport", $fields, $values, $wherevalues);
							if (!$result) {
								show_notification("error", _p("EditText1"), "");
							} else {
								show_notification("success", _p("EditText2"), "");
							}
						}
					}
			
					if (($action == "delete") && isset($_GET["cost_id"])) 
					{
						$cost_id = (int) $_GET["cost_id"];
				
						if ($sess_profile == 1)
							$wherevalues = "cost_id = ".$cost_id;
						else
							$wherevalues = "cost_id = ".$cost_id." AND user_id = ".$sess_user_id;;
				
						$result = $db->delete("".$schemas.".tacostreport", $wherevalues);
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
			
				$scost_year = (isset($_GET["scost_year"])) ? (int) $_GET["scost_year"] : 0;		
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
					
				if($scost_year==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.cost_year = ".$scost_year;
					$search_url .= "&scost_year=".$scost_year;
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
					require("tacostreport/inc.edit_costreport.php");
				} elseif ($action == "add")
				{
					require("tacostreport/inc.add_costreport.php");		
				}elseif ($action=="export")
				{
					require("tacostreport/inc.export_costreport.php");
				} elseif ($action == "more")
				{
					require("tacostreport/inc.more_costreport.php");		
				} else
				{
					require("tacostreport/inc.list_costreport.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  