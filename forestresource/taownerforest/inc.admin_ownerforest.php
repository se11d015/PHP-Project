<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-tree"></i> <?php echo _p("OMReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("ResourceSubTitle7"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 1)) 
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

				require("taownerforest/inc.admin_export_ownerforest.php");
				
				require("modules/generategeom.class.php");
				require("modules/upload_pdf.class.php");
				require("taownerforest/inc.admin_geom_ownerforest.php");
				
				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2)) 
				{
					if (isset($_POST["insertownerforestbttn"]) && (int) $_POST["insertownerforestbttn"] == 1) 
					{
						if (isset($_POST["owner_year"]) && isset($_POST["soum_code"]) )
						{

							$owner_year = (int) $_POST["owner_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$owner_community_number = (int)($_POST["owner_community_number"]);
							$owner_organization_number = (int)($_POST["owner_organization_number"]);
							$owner_other_number = (int)($_POST["owner_other_number"]);
							$total_owner_number = $owner_community_number + $owner_organization_number + $owner_other_number;
							
							$owner_community_area = floatval(str_replace(",",".",$_POST["owner_community_area"]));
							$owner_organization_area = floatval(str_replace(",",".",$_POST["owner_organization_area"]));
							$owner_other_area = floatval(str_replace(",",".",$_POST["owner_other_area"]));
							$total_owner_area = $owner_community_area + $owner_organization_area + $owner_other_area;
														
							$fields = array("owner_year", "soum_code", 
							"owner_community_number", "owner_organization_number", "owner_other_number", "total_owner_number", 
							"owner_community_area", "owner_organization_area", "owner_other_area", "total_owner_area", 
							"owner_location", "order_number", "user_id");
							
							$checkvalues = array($owner_year, $soum_code, 
							$owner_community_number, $owner_organization_number, $owner_other_number, $total_owner_number,
							$owner_community_area, $owner_organization_area, $owner_other_area, $total_owner_area, 
							$_POST["owner_location"], $_POST["order_number"], $sess_user_id);
								
							$values = array();
							for ($i=0; $i<sizeof($checkvalues); $i++)
							{
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
							
							$result = $db->insert("".$schemas.".taownerforest", $fields, $values);
							if(! $result) 
								show_notification("error", _p("AddText1"), "");
							else
								show_notification("success", _p("AddText2"), "");
						}
					}
			   
					if (isset($_POST["updateownerforestbttn"]) && (int) $_POST["updateownerforestbttn"] == 1) 
					{
			
						if (isset($_POST["owner_year"]) && isset($_POST["soum_code"]) && isset($_POST["owner_id"]))
						{
							$wherevalues = "owner_id=".(int) $_POST["owner_id"];
							
							$owner_year = (int) $_POST["owner_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$owner_community_number = (int)($_POST["owner_community_number"]);
							$owner_organization_number = (int)($_POST["owner_organization_number"]);
							$owner_other_number = (int)($_POST["owner_other_number"]);
							$total_owner_number = $owner_community_number + $owner_organization_number + $owner_other_number;
							
							$owner_community_area = floatval(str_replace(",",".",$_POST["owner_community_area"]));
							$owner_organization_area = floatval(str_replace(",",".",$_POST["owner_organization_area"]));
							$owner_other_area = floatval(str_replace(",",".",$_POST["owner_other_area"]));
							$total_owner_area = $owner_community_area + $owner_organization_area + $owner_other_area;
														
							$fields = array("owner_year", "soum_code", 
							"owner_community_number", "owner_organization_number", "owner_other_number", "total_owner_number", 
							"owner_community_area", "owner_organization_area", "owner_other_area", "total_owner_area", 
							"owner_location", "order_number", "user_id");
							
							$checkvalues = array($owner_year, $soum_code, 
							$owner_community_number, $owner_organization_number, $owner_other_number, $total_owner_number,
							$owner_community_area, $owner_organization_area, $owner_other_area, $total_owner_area, 
							$_POST["owner_location"], $_POST["order_number"], (int) $_POST["user_id"]);
			
							$values = array();
							for ($i = 0; $i < sizeof($checkvalues); $i++) {
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
			
							$result = $db->update("".$schemas.".taownerforest", $fields, $values, $wherevalues);
							if (!$result)
								show_notification("error", _p("EditText1"), "");
							else
								show_notification("success", _p("EditText2"), "");
						}
					}
			
					if (($action == "delete") && isset($_GET["owner_id"])) 
					{
						$owner_id = (int) $_GET["owner_id"];
				
						if ($sess_profile == 1)
							$wherevalues = "owner_id = ".$owner_id;
						else
							$wherevalues = "owner_id = ".$owner_id." AND user_id = ".$sess_user_id;;

						$result = $db->delete("".$schemas.".taownerforest", $wherevalues);
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
			
				$sowner_year = (isset($_GET["sowner_year"])) ? (int) $_GET["sowner_year"] : 0;		
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
					
				if($sowner_year==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.owner_year = ".$sowner_year;
					$search_url .= "&sowner_year=".$sowner_year;
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
					require("taownerforest/inc.edit_ownerforest.php");
				} elseif ($action == "add")
				{
					require("taownerforest/inc.add_ownerforest.php");		
				}elseif ($action=="export")
				{
					require("taownerforest/inc.export_ownerforest.php");
				}elseif ($action=="addgeom")
				{
					require("tgownerforest/inc.add_ownerforest.php");	
				}elseif ($action=="editgeom")
				{
					require("tgownerforest/inc.edit_ownerforest.php");
				} elseif ($action == "outputgeom")
				{
					require("tgownerforest/inc.output_ownerforest.php");
				} elseif ($action == "more")
				{
					require("taownerforest/inc.more_ownerforest.php");		
				} else
				{
					require("taownerforest/inc.list_ownerforest.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  