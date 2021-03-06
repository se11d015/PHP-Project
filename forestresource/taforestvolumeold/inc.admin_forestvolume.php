<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-tree"></i> <?php echo _p("OMReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("ResourceSubTitle2"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1)) 
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

				require("taforestvolume/inc.admin_export_forestvolume.php");
				
				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) 
				{
					if (isset($_POST["insertforestvolumebttn"]) && (int) $_POST["insertforestvolumebttn"] == 1) 
					{
						if (isset($_POST["volume_year"]) && isset($_POST["soum_code"]) )
						{

							$volume_year = (int) $_POST["volume_year"];
							$soum_code = (int) $_POST["soum_code"];
							
							$treetype_list = array();
											
							for ($j = 1; $j < 11; $j++)
							{
								$treetype_count = "tree_code_".$j;
								$treetype_list[$j]["tree_code"] = (int) $_POST[$treetype_count];
								
								$treetype_count = "growing_volume_".$j;
								$treetype_list[$j]["growing_volume"] = floatval(str_replace(",",".",$_POST[$treetype_count]));
								
								$treetype_count = "volume_change_".$j;
								$treetype_list[$j]["volume_change"] = floatval(str_replace(",",".",$_POST[$treetype_count]));
								
								$treetype_count = "driedstanding_volume_".$j;
								$treetype_list[$j]["driedstanding_volume"] = floatval(str_replace(",",".",$_POST[$treetype_count]));
								
								$treetype_count = "fallen_volume_".$j;
								$treetype_list[$j]["fallen_volume"] = floatval(str_replace(",",".",$_POST[$treetype_count]));								
							}
							
							$treetype_error = $treetype_count = 0;

							for ($j = 1; $j < 11; $j++)
							{
								if(!empty($treetype_list[$j]["tree_code"]) && !empty($treetype_list[$j]["growing_volume"]))
								{
									$fields = array("volume_year", "soum_code", "tree_code", "growing_volume", "volume_change", "driedstanding_volume", "fallen_volume", "user_id");
									
									$checkvalues = array($volume_year, $soum_code ,$treetype_list[$j]["tree_code"], $treetype_list[$j]["growing_volume"], $treetype_list[$j]["volume_change"], $treetype_list[$j]["driedstanding_volume"], $treetype_list[$j]["fallen_volume"], $sess_user_id);
										
									$values = array();
									for ($i=0; $i<sizeof($checkvalues); $i++)
									{
										$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
									}
									
									$result = $db->insert("".$schemas.".taforestvolume", $fields, $values);
									if(! $result)
										$treetype_error++;
									else
										$treetype_count++; 
								}
							}
							
							if($treetype_error>0)
									show_notification("error", $treetype_error." "._p("AddText3"), "");
	
							if($treetype_count>0)
									show_notification("success", $treetype_count ." "._p("AddText4"), "");
						}
					}
			   
					if (isset($_POST["updateforestvolumebttn"]) && (int) $_POST["updateforestvolumebttn"] == 1) 
					{
			
						if (isset($_POST["volume_year"]) && isset($_POST["soum_code"]) && isset($_POST["tree_code"]) && isset($_POST["growing_volume"]) && isset($_POST["volume_id"]))
						{
							$wherevalues = "volume_id=".(int) $_POST["volume_id"];
							
							$growing_volume = floatval(str_replace(",",".",$_POST["growing_volume"]));
							$volume_change = floatval(str_replace(",",".",$_POST["volume_change"]));
							$driedstanding_volume = floatval(str_replace(",",".",$_POST["driedstanding_volume"]));
							$fallen_volume = floatval(str_replace(",",".",$_POST["fallen_volume"]));
							
							$fields = array("volume_year", "soum_code", "tree_code", "growing_volume", "volume_change", "driedstanding_volume", "fallen_volume", "user_id");
							
							$checkvalues = array((int) $_POST["volume_year"], (int) $_POST["soum_code"], (int) $_POST["tree_code"], $growing_volume, $volume_change, $driedstanding_volume, $fallen_volume, (int) $_POST["user_id"]);
			
							$values = array();
							for ($i = 0; $i < sizeof($checkvalues); $i++) {
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
			
							$result = $db->update("".$schemas.".taforestvolume", $fields, $values, $wherevalues);
							if (!$result) {
								show_notification("error", _p("EditText1"), "");
							} else {
								show_notification("success", _p("EditText2"), "");
							}
						}
					}
			
					if (($action == "delete") && isset($_GET["volume_id"])) 
					{
						$volume_id = (int) $_GET["volume_id"];
				
						if ($sess_profile == 1)
							$wherevalues = "volume_id = ".$volume_id;
						else
							$wherevalues = "volume_id = ".$volume_id." AND user_id = ".$sess_user_id;;
				
						$result = $db->delete("".$schemas.".taforestvolume", $wherevalues);
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
			
				$svolume_year = (isset($_GET["svolume_year"])) ? (int) $_GET["svolume_year"] : 0;		
				$saimag_code = (isset($_GET["saimag_code"])) ? (int) $_GET["saimag_code"] : 0;
				$stree_code = (isset($_GET["stree_code"])) ? (int) $_GET["stree_code"] : 0;
				
				if($saimag_code==0)
				{
					$searchQuery .= "";
					$search_url .= "";
				} else
				{
					$searchQuery .= " AND vs.aimag_code = ".$saimag_code;
					$search_url .= "&saimag_code=".$saimag_code;
				}
					
				if($svolume_year==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.volume_year = ".$svolume_year;
					$search_url .= "&svolume_year=".$svolume_year;
				}

				if($stree_code==0)
				{
					$searchQuery .= "";
					$search_url .= "";
					
				} else
				{
					$searchQuery .= " AND taf.tree_code = ".$stree_code;
					$search_url .= "&stree_code=".$stree_code;
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
					require("taforestvolume/inc.edit_forestvolume.php");
				} elseif ($action == "add")
				{
					require("taforestvolume/inc.add_forestvolume.php");		
				}elseif ($action=="export")
				{
					require("taforestvolume/inc.export_forestvolume.php");
				} elseif ($action == "more")
				{
					require("taforestvolume/inc.more_forestvolume.php");		
				} else
				{
					require("taforestvolume/inc.list_forestvolume.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  