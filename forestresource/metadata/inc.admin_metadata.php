<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-bar-chart"></i> <?php echo _p("DataEntryReport"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("MetadataTitle"); ?> </h1>
		  <?php
			$my_url .= "?menuitem=".$menuitem;
			if (isset($_GET["action"]))
			{
				$action = pg_prep($_GET["action"]);
			}else
			{
				$action = "";
			}
			
			$searchQuery = "";
			$search_url = "";
			
			$metadata_id = (isset($_GET["metadata_id"])) ? (int) $_GET["metadata_id"] : 1;
			$table_id = (isset($_GET["table_id"])) ? (int) $_GET["table_id"] : 0;
			
			$action_date1 = (isset($_GET["action_date1"])) ? pg_prep($_GET["action_date1"]) : "";
			$action_date2 = (isset($_GET["action_date2"])) ? pg_prep($_GET["action_date2"]) : "";
			
			$user_id = (isset($_GET["user_id"])) ? (int) $_GET["user_id"] : 0;
			$group_id = (isset($_GET["group_id"])) ? (int) $_GET["group_id"] : 0;
			
			$search_url .= "&metadata_id=".$metadata_id;
			
			if($table_id==0)
			{
				$searchQuery .= "";
				$search_url .= "";
			} else
			{
				$searchQuery .= "";
				$search_url .= "&table_id=".$table_id;
			}
			
			$today = date('Y-m-d');
			
			if(empty($action_date1))
			{
				$action_date1 = "";
				$action_date2 = $today;
				$searchQuery .= "";
				$search_url .= "";
			}else
			{
				if($action_date1 > $today)
					$action_date1 = $today;
					
				if(empty($action_date2))
				{
					$action_date2 = $today;
					$searchQuery .= " AND (tm_h.action_date::date >= '$action_date1' AND tm_h.action_date::date <= '$action_date2')";
					$search_url .= "&action_date1=".$action_date1."&action_date2=".$action_date2;
				}else
				{
					if($action_date1 > $action_date2)
						$action_date2 = $action_date1;
					if($action_date2 > $today)
						$action_date2 = $today;
					$searchQuery .= " AND (tm_h.action_date::date >= '$action_date1' AND tm_h.action_date::date <= '$action_date2')";
					$search_url .= "&action_date1=".$action_date1."&action_date2=".$action_date2;
				}
			}
			
			if($user_id==0)
			{
				$searchQuery .= "";
				$search_url .= "";
			} else
			{
				$searchQuery .= " AND tm.user_id = ".$user_id;
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
			}
			
			$tableid = (isset($_GET["tableid"])) ? (int) $_GET["tableid"] : 0;
			$userid = (isset($_GET["userid"])) ? (int) $_GET["userid"] : 0;
			$groupid = (isset($_GET["groupid"])) ? (int) $_GET["groupid"] : 0;
			
			
			if ($action=="moreuser")
			{
				require("metadata/inc.moreuser_metadata.php");
			} else if ($action=="moreusertime")
			{
				require("metadata/inc.moreusertime_metadata.php");
			} else if ($action=="moregroup")
			{
				require("metadata/inc.moregroup_metadata.php");
			} else if ($action=="moregrouptime")
			{
				require("metadata/inc.moregrouptime_metadata.php");
			} else if ($action=="moretime")
			{
				require("metadata/inc.moretime_metadata.php");
			} else if ($action=="moretable")
			{
				require("metadata/inc.moretable_metadata.php");
			} else if ($action=="moretabletime")
			{
				require("metadata/inc.moretabletime_metadata.php");
			} else
			{
				require("metadata/inc.list_metadata.php");
			}
		?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  
