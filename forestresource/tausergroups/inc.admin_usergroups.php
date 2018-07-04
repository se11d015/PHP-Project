<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-user"></i> <?php echo _p("User"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("UserGroupsTitle"); ?></h1>
		  <?php
			if ($sess_profile==1)
			{
				$my_url .= "?menuitem=".$menuitem;
				if (isset($_GET["action"]))
				{
					$action = pg_prep($_GET["action"]);
				}else
				{
					$action = "";
				}
			
				if (isset($_POST["insertuserbttn"]))
				{
					if (isset($_POST["group_id"]) && isset($_POST["user_id"]))
					{
						$fields = array("group_id", "user_id");
						$checkvalues = array((int) $_POST["group_id"], (int) $_POST["user_id"]);
						
						$values = array();
						for ($i=0; $i<sizeof($checkvalues); $i++)
						{
							$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
						}
						
						$result = $db->insert("".$schemas.".tausergroups", $fields, $values);
				
						if(! $result)
							show_notification("error", _p("AddText1"), "");
						else
							show_notification("success", _p("AddText2"), "");
					}
				}
						
				if (($action=="delete") && isset($_GET["group_id"]) && isset($_GET["user_id"]))
				{
					$group_id = (int) $_GET["group_id"];
					$user_id = (int) $_GET["user_id"];
					$wherevalues = "group_id = ".$group_id." AND user_id=".$user_id;
					
					$result = $db->delete("".$schemas.".tausergroups", $wherevalues);
					if(! $result)
						show_notification("error", _p("DeleteText1"), "");
					else
						show_notification("success", _p("DeleteText2"), "");
				}
				
				$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
				$my_page = "&page=".$page;
				
				$searchQuery = "";
				$search_url = "";
				
				$groupid = (isset($_GET["groupid"])) ? (int) $_GET["groupid"] : 0;
				$lastname = (isset($_GET["lastname"])) ? pg_prep($_GET["lastname"]) : "";
								
				if($groupid==0)
				{
					$searchQuery .= "";
					$search_url .= "";
				} else
				{
					$searchQuery .= " AND taug.group_id = ".$groupid;
					$search_url .= "&groupid=".$groupid;
				}
				
				if(empty($lastname))
				{
					$searchQuery .= "";
					$search_url .= "";
				}else
				{
					$searchQuery .= " AND lower(tau.lastname) LIKE lower('%".$lastname."%')";
					$search_url .= "&lastname=".$lastname;
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
					require("tausergroups/inc.add_usergroups.php");
				}else
				{
					require("tausergroups/inc.list_usergroups.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), $notify);
			}
		?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  
