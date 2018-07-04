<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-tree"></i> <?php echo _p("OMReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("ResourceSubTitle4"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 4, 1)) 
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

				require("taforestinsect/inc.admin_export_forestinsect.php");
				
				require("modules/generategeom.class.php");
				require("taforestinsect/inc.admin_geom_forestinsect.php");
				
				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 4, 2)) 
				{
					if (isset($_POST["insertforestinsectbttn"]) && (int) $_POST["insertforestinsectbttn"] == 1) 
					{
						if (isset($_POST["insect_year"]) && isset($_POST["soum_code"]) )
						{

							$insect_year = (int) $_POST["insect_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$insect_study_area = floatval(str_replace(",",".",$_POST["insect_study_area"]));
							$insect_spread_area = floatval(str_replace(",",".",$_POST["insect_spread_area"]));
							$insect_damage_area = floatval(str_replace(",",".",$_POST["insect_damage_area"]));
							
							$control_aeroplain_area = floatval(str_replace(",",".",$_POST["control_aeroplain_area"]));						
							$control_spray_area = floatval(str_replace(",",".",$_POST["control_spray_area"]));
							$control_mechanics_area = floatval(str_replace(",",".",$_POST["control_mechanics_area"]));
							$control_mechanics_size = floatval(str_replace(",",".",$_POST["control_mechanics_size"]));
							$control_result = floatval(str_replace(",",".",$_POST["control_result"]));
							
							$fields = array("insect_year", "soum_code", "insect_study_area", "insect_spread_area", "insect_damage_area", "insect_name",
							"control_aeroplain_number", "control_aeroplain_area", "control_spray_area", "control_mechanics_area", "control_mechanics_size", 
							"control_result", "control_location", "user_id");
							
							$checkvalues = array($insect_year, $soum_code, $insect_study_area,  $insect_spread_area, $insect_damage_area, $_POST["insect_name"], 
							(int) $_POST["control_aeroplain_number"], $control_aeroplain_area, $control_spray_area, $control_mechanics_area,  $control_mechanics_size, 
							$control_result, $_POST["control_location"], $sess_user_id);
								
							$values = array();
							for ($i=0; $i<sizeof($checkvalues); $i++)
							{
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
							
							$result = $db->insert("".$schemas.".taforestinsect", $fields, $values);
							if(! $result)
								show_notification("error", _p("AddText1"), "");
							else
								show_notification("success", _p("AddText2"), "");
						}
					}
			   
					if (isset($_POST["updateforestinsectbttn"]) && (int) $_POST["updateforestinsectbttn"] == 1) 
					{
			     
						if (isset($_POST["insect_year"]) && isset($_POST["soum_code"]) && isset($_POST["insect_id"]))
						{
							$wherevalues = "insect_id=".(int) $_POST["insect_id"];
							
							$insect_year = (int) $_POST["insect_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$insect_study_area = floatval(str_replace(",",".",$_POST["insect_study_area"]));
							$insect_spread_area = floatval(str_replace(",",".",$_POST["insect_spread_area"]));
							$insect_damage_area = floatval(str_replace(",",".",$_POST["insect_damage_area"]));
							
							$control_aeroplain_area = floatval(str_replace(",",".",$_POST["control_aeroplain_area"]));						
							$control_spray_area = floatval(str_replace(",",".",$_POST["control_spray_area"]));
							$control_mechanics_area = floatval(str_replace(",",".",$_POST["control_mechanics_area"]));
							$control_mechanics_size = floatval(str_replace(",",".",$_POST["control_mechanics_size"]));
							$control_result = floatval(str_replace(",",".",$_POST["control_result"]));
							
							$fields = array("insect_year", "soum_code", "insect_study_area", "insect_spread_area", "insect_damage_area", "insect_name",
							"control_aeroplain_number", "control_aeroplain_area", "control_spray_area", "control_mechanics_area", "control_mechanics_size", 
							"control_result", "control_location", "user_id");
							
							$checkvalues = array($insect_year, $soum_code, $insect_study_area,  $insect_spread_area, $insect_damage_area, $_POST["insect_name"], 
							(int) $_POST["control_aeroplain_number"], $control_aeroplain_area, $control_spray_area, $control_mechanics_area,  $control_mechanics_size, 
							$control_result, $_POST["control_location"], (int) $_POST["user_id"]);
			
							$values = array();
							for ($i = 0; $i < sizeof($checkvalues); $i++) {
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
			
							$result = $db->update("".$schemas.".taforestinsect", $fields, $values, $wherevalues);
							if (!$result) {
								show_notification("error", _p("EditText1"), "");
							} else {
								show_notification("success", _p("EditText2"), "");
							}
						}
					}
			
					if (($action == "delete") && isset($_GET["insect_id"])) 
					{
						$insect_id = (int) $_GET["insect_id"];
				
						if ($sess_profile == 1)
							$wherevalues = "insect_id = ".$insect_id;
						else
							$wherevalues = "insect_id = ".$insect_id." AND user_id = ".$sess_user_id;;
				
						$result = $db->delete("".$schemas.".taforestinsect", $wherevalues);
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
			
				$sinsect_year = (isset($_GET["sinsect_year"])) ? (int) $_GET["sinsect_year"] : 0;		
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
					
				if($sinsect_year==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.insect_year = ".$sinsect_year;
					$search_url .= "&sinsect_year=".$sinsect_year;
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
					require("taforestinsect/inc.edit_forestinsect.php");
				} elseif ($action == "add")
				{
					require("taforestinsect/inc.add_forestinsect.php");		
				}elseif ($action=="export")
				{
					require("taforestinsect/inc.export_forestinsect.php");
				}elseif ($action=="addgeom")
				{
					require("tgforestinsect/inc.add_forestinsect.php");	
				}elseif ($action=="editgeom")
				{
					require("tgforestinsect/inc.edit_forestinsect.php");
				} elseif ($action == "outputgeom")
				{
					require("tgforestinsect/inc.output_forestinsect.php");		
				} elseif ($action == "more")
				{
					require("taforestinsect/inc.more_forestinsect.php");		
				} else
				{
					require("taforestinsect/inc.list_forestinsect.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  