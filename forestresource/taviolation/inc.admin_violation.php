<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-tree"></i> <?php echo _p("OMReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("ResourceSubTitle8"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 1)) 
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

				require("taviolation/inc.admin_export_violation.php");
				
				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 2)) 
				{
					if (isset($_POST["insertviolationbttn"]) && (int) $_POST["insertviolationbttn"] == 1) 
					{
						if (isset($_POST["violation_year"]) && isset($_POST["soum_code"]) )
						{

							$violation_year = (int) $_POST["violation_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$illegallogging_wood = floatval(str_replace(",",".",$_POST["illegallogging_wood"]));
							$forfeit_cost = floatval(str_replace(",",".",$_POST["forfeit_cost"]));							
							$indemnity_cost = floatval(str_replace(",",".",$_POST["indemnity_cost"]));
							$illegal_nontimberproduct = floatval(str_replace(",",".",$_POST["illegal_nontimberproduct"]));
							
							$fields = array("violation_year", "soum_code", 
							"violation_number", "illegallogging_wood", "place_name", "escheat_tools_number", "forfeit_cost", "indemnity_cost", 
							"illegal_nontimberproduct", "violation_note", "user_id");
							
							$checkvalues = array($violation_year, $soum_code, (int) $_POST["violation_number"], $illegallogging_wood, $_POST["place_name"], $_POST["escheat_tools_number"], 
							$forfeit_cost, $indemnity_cost, $illegal_nontimberproduct, $_POST["violation_note"], $sess_user_id);
								
							$values = array();
							for ($i=0; $i<sizeof($checkvalues); $i++)
							{
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
							
							$result = $db->insert("".$schemas.".taviolation", $fields, $values);
							if(! $result)
								show_notification("error", _p("AddText1"), "");
							else
								show_notification("success", _p("AddText2"), "");
						}
					}
			   
					if (isset($_POST["updateviolationbttn"]) && (int) $_POST["updateviolationbttn"] == 1) 
					{
			
						if (isset($_POST["violation_year"]) && isset($_POST["soum_code"]) && isset($_POST["violation_id"]))
						{
							$wherevalues = "violation_id=".(int) $_POST["violation_id"];
							
							$violation_year = (int) $_POST["violation_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$illegallogging_wood = floatval(str_replace(",",".",$_POST["illegallogging_wood"]));
							$forfeit_cost = floatval(str_replace(",",".",$_POST["forfeit_cost"]));							
							$indemnity_cost = floatval(str_replace(",",".",$_POST["indemnity_cost"]));
							$illegal_nontimberproduct = floatval(str_replace(",",".",$_POST["illegal_nontimberproduct"]));
							
							$fields = array("violation_year", "soum_code", 
							"violation_number", "illegallogging_wood", "place_name", "escheat_tools_number", "forfeit_cost", "indemnity_cost", 
							"illegal_nontimberproduct", "violation_note", "user_id");
							
							$checkvalues = array($violation_year, $soum_code, (int) $_POST["violation_number"], $illegallogging_wood, $_POST["place_name"], $_POST["escheat_tools_number"], 
							$forfeit_cost, $indemnity_cost, $illegal_nontimberproduct, $_POST["violation_note"], (int) $_POST["user_id"]);
			
							$values = array();
							for ($i = 0; $i < sizeof($checkvalues); $i++) {
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
			
							$result = $db->update("".$schemas.".taviolation", $fields, $values, $wherevalues);
							if (!$result) {
								show_notification("error", _p("EditText1"), "");
							} else {
								show_notification("success", _p("EditText2"), "");
							}
						}
					}
			
					if (($action == "delete") && isset($_GET["violation_id"])) 
					{
						$violation_id = (int) $_GET["violation_id"];
				
						if ($sess_profile == 1)
							$wherevalues = "violation_id = ".$violation_id;
						else
							$wherevalues = "violation_id = ".$violation_id." AND user_id = ".$sess_user_id;;
				
						$result = $db->delete("".$schemas.".taviolation", $wherevalues);
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
			
				$sviolation_year = (isset($_GET["sviolation_year"])) ? (int) $_GET["sviolation_year"] : 0;		
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
					
				if($sviolation_year==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.violation_year = ".$sviolation_year;
					$search_url .= "&sviolation_year=".$sviolation_year;
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
					require("taviolation/inc.edit_violation.php");
				} elseif ($action == "add")
				{
					require("taviolation/inc.add_violation.php");		
				}elseif ($action=="export")
				{
					require("taviolation/inc.export_violation.php");
				} elseif ($action == "more")
				{
					require("taviolation/inc.more_violation.php");		
				} else
				{
					require("taviolation/inc.list_violation.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  