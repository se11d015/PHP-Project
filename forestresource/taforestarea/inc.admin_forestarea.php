<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-tree"></i> <?php echo _p("OMReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("ResourceSubTitle1"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 1)) 
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

				require("taforestarea/inc.admin_export_forestarea.php");
				
				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2)) 
				{
					if (isset($_POST["insertforestareabttn"]) && (int) $_POST["insertforestareabttn"] == 1) 
					{
						if (isset($_POST["area_year"]) && isset($_POST["soum_code"]) && isset($_POST["attach_count"]))
						{

							$area_year = (int) $_POST["area_year"];
							$soum_code = (int) $_POST["soum_code"];
							$attach_count = (int) $_POST["attach_count"];
							
							if($attach_count>0)
							{
								$attach_list = array();
								
								for ($i=0, $j=1; $j < $attach_count+1; $j++, $i++)
								{
									$type_code = "type_code".$j;
									$forest_area = "forest_area".$j;
									$area_change = "area_change".$j;
									$attach_list[$i]['type_code'] = empty($_POST[$type_code]) ? NULL : (int) $_POST[$type_code];
									$attach_list[$i]['forest_area'] = empty($_POST[$forest_area]) ? NULL : floatval(str_replace(",",".",$_POST[$forest_area]));
									$attach_list[$i]['area_change'] = empty($_POST[$area_change]) ? NULL : floatval(str_replace(",",".",$_POST[$area_change]));
								}
								
								$attach_list_error = $attach_list_count = 0;
								
								for ($j = 0; $j < sizeof($attach_list); $j++)
								{
									if (!empty($attach_list[$j]['type_code']) && !empty($attach_list[$j]['forest_area']))
									{
										$fields = array("area_year", "soum_code", "type_code", "forest_area", "area_change", "user_id");
										
										$checkvalues = array($area_year, $soum_code, $attach_list[$j]['type_code'], $attach_list[$j]['forest_area'], $attach_list[$j]['area_change'], $sess_user_id);
											
										$values = array();
										for ($i=0; $i<sizeof($checkvalues); $i++)
										{
											$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
										}
										
										$result = $db->insert("".$schemas.".taforestarea", $fields, $values);
										if(! $result) {
											$attach_list_error++;
										} else {
											$attach_list_count++; 
										}
									}
								}
								if($attach_list_error>0)
									show_notification("error", $attach_list_error." "._p("AddText3"), "");
		
								if($attach_list_count>0)
									show_notification("success", $attach_list_count." "._p("AddText4"), "");
							}
						}
					}
 
					if (isset($_POST["updateforestareabttn"]) && (int) $_POST["updateforestareabttn"] == 1) 
					{
			
						if (isset($_POST["area_year"]) && isset($_POST["soum_code"]) && isset($_POST["type_code"]) && isset($_POST["forest_area"]) && isset($_POST["area_id"]))
						{
							$wherevalues = "area_id=".(int) $_POST["area_id"];
							
							$forest_area = floatval(str_replace(",",".",$_POST["forest_area"]));
							$area_change = floatval(str_replace(",",".",$_POST["area_change"]));
							
							$fields = array("area_year", "soum_code", "type_code", "forest_area", "area_change", "user_id");
							
							$checkvalues = array((int) $_POST["area_year"], (int) $_POST["soum_code"], (int) $_POST["type_code"], $forest_area, $area_change, (int) $_POST["user_id"]);
			
							$values = array();
							for ($i = 0; $i < sizeof($checkvalues); $i++) {
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
			
							$result = $db->update("".$schemas.".taforestarea", $fields, $values, $wherevalues);
							if (!$result) {
								show_notification("error", _p("EditText1"), "");
							} else {
								show_notification("success", _p("EditText2"), "");
							}
						}
					}
			
					if (($action == "delete") && isset($_GET["area_id"])) 
					{
						$area_id = (int) $_GET["area_id"];
				
						if ($sess_profile == 1)
							$wherevalues = "area_id = ".$area_id;
						else
							$wherevalues = "area_id = ".$area_id." AND user_id = ".$sess_user_id;;
				
						$result = $db->delete("".$schemas.".taforestarea", $wherevalues);
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
			
				$sarea_year = (isset($_GET["sarea_year"])) ? (int) $_GET["sarea_year"] : 0;		
				$saimag_code = (isset($_GET["saimag_code"])) ? (int) $_GET["saimag_code"] : 0;
				$stype_code = (isset($_GET["stype_code"])) ? (int) $_GET["stype_code"] : 0;
				
				if($saimag_code==0)
				{
					$searchQuery .= "";
					$search_url .= "";
				} else
				{
					$searchQuery .= " AND vs.aimag_code = ".$saimag_code;
					$search_url .= "&saimag_code=".$saimag_code;
				}
					
				if($sarea_year==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.area_year = ".$sarea_year;
					$search_url .= "&sarea_year=".$sarea_year;
				}

				if($stype_code==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.type_code = ".$stype_code;
					$search_url .= "&stype_code=".$stype_code;
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
					require("taforestarea/inc.edit_forestarea.php");
				} elseif ($action == "add")
				{
					require("taforestarea/inc.add_forestarea.php");		
				}elseif ($action=="export")
				{
					require("taforestarea/inc.export_forestarea.php");
				} elseif ($action == "more")
				{
					require("taforestarea/inc.more_forestarea.php");		
				} else
				{
					require("taforestarea/inc.list_forestarea.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  