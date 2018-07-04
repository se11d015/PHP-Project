<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-user"></i> <?php echo _p("User"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("UserAimagsTitle"); ?> </h1>
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
					if (isset($_POST["aimag_code"]) && isset($_POST["user_id"]))
					{
						$fields = array("aimag_code", "user_id");
						$checkvalues = array((int) $_POST["aimag_code"],(int) $_POST["user_id"]);
						
						$values = array();
						for ($i=0; $i<sizeof($checkvalues); $i++)
						{
							$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
						}
						
						$result = $db->insert("".$schemas.".taaimagusers", $fields, $values);
				
						if(! $result)
							show_notification("error", _p("AddText1"), "");
						else
							show_notification("success", _p("AddText2"), "");
					}
				}
						
				if (($action=="delete") && isset($_GET["aimag_code"]) && isset($_GET["user_id"]))
				{
					$aimag_code = (int) $_GET["aimag_code"];
					$user_id = (int) $_GET["user_id"];
					$wherevalues = "aimag_code = ".$aimag_code." AND user_id=".$user_id;
					
					$result = $db->delete("".$schemas.".taaimagusers", $wherevalues);
					if(! $result)
						show_notification("error", _p("DeleteText1"), "");
					else
						show_notification("success", _p("DeleteText2"), "");
				}
				
				$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
				$my_page = "&page=".$page;
				
				$searchQuery = "";
				$search_url = "";
				
				$aimagcode = (isset($_GET["aimagcode"])) ? (int) $_GET["aimagcode"] : 0;
				$lastname = (isset($_GET["lastname"])) ? pg_prep($_GET["lastname"]) : "";
								
				if($aimagcode==0)
				{
					$searchQuery .= "";
					$search_url .= "";
				} else
				{
					$searchQuery .= " AND taua.aimag_code = ".$aimagcode;
					$search_url .= "&aimagcode=".$aimagcode;
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
					require("tauseraimags/inc.add_useraimags.php");
				}else
				{
					require("tauseraimags/inc.list_useraimags.php");
				}
			} else {
				show_notification("error", _p("NotAccessText"), $notify);
			}
		?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  
