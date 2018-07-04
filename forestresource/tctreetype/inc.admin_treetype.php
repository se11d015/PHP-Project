<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-table"></i> <?php echo _p("Reference"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("ReferenceSubTitle2"); ?> </h1>
		  <?php
			if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 10, 1)) 
			{
				$my_url .= "?menuitem=".$menuitem;

				$count = (isset($_POST["count"]) && (int) $_POST["count"] > 0) ? (int) $_POST["count"] : ((isset($_GET["count"]) && (int) $_GET["count"] > 0) ? (int) $_GET["count"] : 10);
				$my_count = $my_url;
				$my_url .= "&count=".$count;
				
				if (isset($_GET["action"]))
				{
					$action = pg_prep($_GET["action"]);
				}else
				{
					$action = "";
				}

				if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 10, 2)) 
				{	
					if (isset($_POST["inserttreebttn"]) && (int) $_POST["inserttreebttn"]==1)
					{
						if (isset($_POST["tree_code"]) && isset($_POST["science_name"]) && isset($_POST["tree_name_mn"]))
						{
							$fields = array("tree_code", "science_name", "tree_name_mn", "tree_name_en", "tree_name_ru");
							$checkvalues = array((int) $_POST["tree_code"], $_POST["science_name"], $_POST["tree_name_mn"], $_POST["tree_name_en"], $_POST["tree_name_ru"]);
							
							$values = array();
							for ($i=0; $i<sizeof($checkvalues); $i++)
							{
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
							
							$result = $db->insert("".$schemas.".tctreetype", $fields, $values);
					
							if(! $result)
								show_notification("error", _p("AddText1"), "");
							else
								show_notification("success", _p("AddText2"), "");
						}
					}
			
					if (isset($_POST["updatetreebttn"]) && (int) $_POST["updatetreebttn"]==1)
					{
						if (isset($_POST["tree_code"]) && isset($_POST["science_name"]) && isset($_POST["tree_name_mn"]) && isset($_POST["tree_id"]))
						{	
							
							$wherevalues = "tree_id=".(int) $_POST["tree_id"];
							$fields = array("tree_code", "science_name", "tree_name_mn", "tree_name_en", "tree_name_ru");
							$checkvalues = array((int) $_POST["tree_code"], $_POST["science_name"], $_POST["tree_name_mn"], $_POST["tree_name_en"], $_POST["tree_name_ru"]);
					
							$values = array();
							for ($i=0; $i<sizeof($checkvalues); $i++)
							{
								$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
							}
							
							$result = $db->update("".$schemas.".tctreetype", $fields, $values, $wherevalues);
							if(! $result)
								show_notification("error", _p("EditText1"), "");
							else
								show_notification("success", _p("EditText2"), "");
						}
					}
									
					if (($action=="delete") && isset($_GET["tree_id"]))
					{
						$tree_id = (int) $_GET["tree_id"];
						$wherevalues = "tree_id = ".$tree_id;
						
						$result = $db->delete("".$schemas.".tctreetype", $wherevalues);
						if(! $result)
							show_notification("error", _p("DeleteText1"), "");
						else
							show_notification("success", _p("DeleteText2"),"");
					}
				}
				
				$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
				$my_page = "&page=".$page;
				
				$searchQuery = "";
				$search_url = "";
				
				$tree_name_mn = (isset($_GET["tree_name_mn"])) ? pg_prep($_GET["tree_name_mn"]) : "";
				
				if(empty($tree_name_mn))
				{
					$searchQuery .= "";
					$search_url .= "";
				}else
				{
					$searchQuery .= " AND lower(tct.tree_name_mn) LIKE lower('%".$tree_name_mn."%')";
					$search_url .= "&tree_name_mn=".$tree_name_mn;
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
						
				if ($action=="add")
				{
					require("tctreetype/inc.add_treetype.php");
				}elseif ($action=="edit")
				{
					require("tctreetype/inc.edit_treetype.php");			
				}else
				{
					require("tctreetype/inc.list_treetype.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), "");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  