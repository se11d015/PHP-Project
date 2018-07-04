<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-tree"></i> <?php echo _p("OMReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("ResourceSubTitle6"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 1)) 
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

				require("taforestutilization/inc.admin_export_forestutilization.php");
				
				require("modules/generategeom.class.php");
				require("taforestutilization/inc.admin_geom_forestlogging.php");
				
				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 2)) 
				{
					if (isset($_POST["insertforestutilizationbttn"]) && (int) $_POST["insertforestutilizationbttn"] == 1) 
					{
						if (isset($_POST["utilization_year"]) && isset($_POST["soum_code"]) )
						{

							$utilization_year = (int) $_POST["utilization_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$logged_timber = floatval(str_replace(",",".",$_POST["logged_timber"]));
							$logged_firewood = floatval(str_replace(",",".",$_POST["logged_firewood"]));
							$total_logged_wood = $logged_timber + $logged_firewood;
							
							$insulated_area = floatval(str_replace(",",".",$_POST["insulated_area"]));
							$logged_area = floatval(str_replace(",",".",$_POST["logged_area"]));
							$thinning_area = floatval(str_replace(",",".",$_POST["thinning_area"]));
							$cleaning_area = floatval(str_replace(",",".",$_POST["cleaning_area"]));
							
							$thinning_timber = floatval(str_replace(",",".",$_POST["thinning_timber"]));
							$thinning_firewood = floatval(str_replace(",",".",$_POST["thinning_firewood"]));
							$total_thinning_wood = $thinning_timber + $thinning_firewood;
							
							$cleaning_timber = floatval(str_replace(",",".",$_POST["cleaning_timber"]));
							$cleaning_firewood = floatval(str_replace(",",".",$_POST["cleaning_firewood"]));
							$total_cleaning_wood = $cleaning_timber + $cleaning_firewood;
							
							$nontimber_pinenuts = floatval(str_replace(",",".",$_POST["nontimber_pinenuts"]));
							$nontimber_fruits = floatval(str_replace(",",".",$_POST["nontimber_fruits"]));
							$nontimber_other = floatval(str_replace(",",".",$_POST["nontimber_other"]));
							
							$fields = array("utilization_year", "soum_code", 
							"logged_timber", "logged_firewood", "total_logged_wood", "insulated_area", "logged_area", "logged_location", 
							"thinning_area", "thinning_timber", "thinning_firewood", "total_thinning_wood", 
							"cleaning_area", "cleaning_timber", "cleaning_firewood", "total_cleaning_wood", 
							"nontimber_pinenuts", "nontimber_fruits", "nontimber_other", "user_id");
							
							$checkvalues = array($utilization_year, $soum_code, 
							$logged_timber, $logged_firewood, $total_logged_wood, $insulated_area, $logged_area, $_POST["logged_location"], 
							$thinning_area, $thinning_timber, $thinning_firewood, $total_thinning_wood, 
							$cleaning_area, $cleaning_timber, $cleaning_firewood, $total_cleaning_wood, 
							$nontimber_pinenuts, $nontimber_fruits, $nontimber_other, $sess_user_id);
								
							$values = array();
							for ($i=0; $i<sizeof($checkvalues); $i++)
							{
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
							
							$result = $db->insert("".$schemas.".taforestutilization", $fields, $values);
							if(! $result)
								show_notification("error", _p("AddText1"), "");
							else
								show_notification("success", _p("AddText2"), "");
						}
					}
			   
					if (isset($_POST["updateforestutilizationbttn"]) && (int) $_POST["updateforestutilizationbttn"] == 1) 
					{
			
						if (isset($_POST["utilization_year"]) && isset($_POST["soum_code"]) && isset($_POST["utilization_id"]))
						{
							$wherevalues = "utilization_id=".(int) $_POST["utilization_id"];
							
							$utilization_year = (int) $_POST["utilization_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$logged_timber = floatval(str_replace(",",".",$_POST["logged_timber"]));
							$logged_firewood = floatval(str_replace(",",".",$_POST["logged_firewood"]));
							$total_logged_wood = $logged_timber + $logged_firewood;
							
							$insulated_area = floatval(str_replace(",",".",$_POST["insulated_area"]));
							$logged_area = floatval(str_replace(",",".",$_POST["logged_area"]));
							$thinning_area = floatval(str_replace(",",".",$_POST["thinning_area"]));
							$cleaning_area = floatval(str_replace(",",".",$_POST["cleaning_area"]));
							
							$thinning_timber = floatval(str_replace(",",".",$_POST["thinning_timber"]));
							$thinning_firewood = floatval(str_replace(",",".",$_POST["thinning_firewood"]));
							$total_thinning_wood = $thinning_timber + $thinning_firewood;
							
							$cleaning_timber = floatval(str_replace(",",".",$_POST["cleaning_timber"]));
							$cleaning_firewood = floatval(str_replace(",",".",$_POST["cleaning_firewood"]));
							$total_cleaning_wood = $cleaning_timber + $cleaning_firewood;
							
							$nontimber_pinenuts = floatval(str_replace(",",".",$_POST["nontimber_pinenuts"]));
							$nontimber_fruits = floatval(str_replace(",",".",$_POST["nontimber_fruits"]));
							$nontimber_other = floatval(str_replace(",",".",$_POST["nontimber_other"]));
							
							$fields = array("utilization_year", "soum_code", 
							"logged_timber", "logged_firewood", "total_logged_wood", "insulated_area", "logged_area", "logged_location", 
							"thinning_area", "thinning_timber", "thinning_firewood", "total_thinning_wood", 
							"cleaning_area", "cleaning_timber", "cleaning_firewood", "total_cleaning_wood", 
							"nontimber_pinenuts", "nontimber_fruits", "nontimber_other", "user_id");
							
							$checkvalues = array($utilization_year, $soum_code, 
							$logged_timber, $logged_firewood, $total_logged_wood, $insulated_area, $logged_area, $_POST["logged_location"], 
							$thinning_area, $thinning_timber, $thinning_firewood, $total_thinning_wood, 
							$cleaning_area, $cleaning_timber, $cleaning_firewood, $total_cleaning_wood, 
							$nontimber_pinenuts, $nontimber_fruits, $nontimber_other, (int) $_POST["user_id"]);
			
							$values = array();
							for ($i = 0; $i < sizeof($checkvalues); $i++) {
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
			
							$result = $db->update("".$schemas.".taforestutilization", $fields, $values, $wherevalues);
							if (!$result) {
								show_notification("error", _p("EditText1"), "");
							} else {
								show_notification("success", _p("EditText2"), "");
							}
						}
					}
			
					if (($action == "delete") && isset($_GET["utilization_id"])) 
					{
						$utilization_id = (int) $_GET["utilization_id"];
				
						if ($sess_profile == 1)
							$wherevalues = "utilization_id = ".$utilization_id;
						else
							$wherevalues = "utilization_id = ".$utilization_id." AND user_id = ".$sess_user_id;;
				
						$result = $db->delete("".$schemas.".taforestutilization", $wherevalues);
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
			
				$sutilization_year = (isset($_GET["sutilization_year"])) ? (int) $_GET["sutilization_year"] : 0;		
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
					
				if($sutilization_year==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.utilization_year = ".$sutilization_year;
					$search_url .= "&sutilization_year=".$sutilization_year;
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
					require("taforestutilization/inc.edit_forestutilization.php");
				} elseif ($action == "add")
				{
					require("taforestutilization/inc.add_forestutilization.php");		
				}elseif ($action=="export")
				{
					require("taforestutilization/inc.export_forestutilization.php");
				}elseif ($action=="addgeom")
				{
					require("tgforestlogging/inc.add_forestlogging.php");	
				}elseif ($action=="editgeom")
				{
					require("tgforestlogging/inc.edit_forestlogging.php");
				} elseif ($action == "outputgeom")
				{
					require("tgforestlogging/inc.output_forestlogging.php");
				} elseif ($action == "more")
				{
					require("taforestutilization/inc.more_forestutilization.php");		
				} else
				{
					require("taforestutilization/inc.list_forestutilization.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  