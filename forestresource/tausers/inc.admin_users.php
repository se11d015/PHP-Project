<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-user"></i> <?php echo _p("User"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("UsersTitle"); ?></h1>
		  <?php
			$my_url .= "?menuitem=".$menuitem;
			if (isset($_GET["action"]))
			{
				$action = pg_prep($_GET["action"]);
			}else
			{
				$action = "";
			}
				
			if($sess_profile==1) 
			{
				
				if (isset($_POST["insertuserbttn"]) && (int) $_POST["insertuserbttn"]==1)
				{
					if (isset($_POST["login_name"]) && isset($_POST["login_passwd"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["organization"]))
					{				
						$login_date = date("Y-m-d H:i:s");
						$login_session = generateSessionString(16);
					
						$fields = array("login_name", "login_passwd", "firstname", "lastname", "organization", "phone", "email", "profile", "login_status", "login_date", "login_session");
						$checkvalues = array($_POST["login_name"], md5($_POST["login_passwd"]), $_POST["firstname"], $_POST["lastname"],$_POST["organization"], $_POST["phone"], $_POST["email"], $_POST["profile"], $_POST["login_status"], $login_date, $login_session);
				
						$values = array();
						for ($i=0; $i<sizeof($checkvalues); $i++)
						{
							$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
						}
						
						$result = $db->insert("".$schemas.".tausers", $fields, $values);
						if(! $result)
							show_notification("error", _p("AddText1"), "");
						else 
							show_notification("success", _p("AddText2"), "");
					}
				}
				
				if (($action=="delete") && isset($_GET["user_id"]))
				{
					$wherevalues = "user_id=".(int) $_GET["user_id"];
					
					$result = $db->delete("".$schemas.".tausergroups", $wherevalues);
					$result = $db->delete("".$schemas.".taaimagusers", $wherevalues);
					$result = $db->delete("".$schemas.".tausers", $wherevalues);
					
					if(! $result) 
						show_notification("error", _p("DeleteText1"), "");
					else
						show_notification("success", _p("DeleteText2"), "");
				}
			}	
					
			if (isset($_POST["updateuserbttn"]) && (int) $_POST["updateuserbttn"]==1)
			{
				if (isset($_POST["login_name"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["user_id"]) && isset($_POST["organization"]))
				{	
					
					$wherevalues = "user_id=".(int) $_POST["user_id"];
					$fields = array("login_name", "firstname", "lastname", "organization", "phone", "email", "profile", "login_status");
					$checkvalues = array($_POST["login_name"], $_POST["firstname"], $_POST["lastname"],$_POST["organization"], $_POST["phone"], $_POST["email"], $_POST["profile"], $_POST["login_status"]);
			
					$values = array();
					for ($i=0; $i<sizeof($checkvalues); $i++)
					{
						$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
					}
					
					$result = $db->update("".$schemas.".tausers", $fields, $values, $wherevalues);
					if(! $result)
						show_notification("error", _p("EditText1"), "");
					else
						show_notification("success", _p("EditText2"), "");
				}
			}
							
			if (isset($_POST["updatepassbttn"]) && (int) $_POST["updatepassbttn"]==1)
			{
				if (isset($_POST["login_passwd"]) && isset($_POST["user_id"]))
				{	
					$wherevalues = "user_id=".(int) $_POST["user_id"];
					
					$fields = array("login_passwd");
					$values = array("'".md5($_POST["login_passwd"])."'");
					
					$result = $db->update("".$schemas.".tausers", $fields, $values, $wherevalues);
					if(! $result)
						show_notification("error", _p("EditText1"), "");
					else
						show_notification("success", _p("EditText2"), "");
				}
			}	
			
			$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
			$my_page = "&page=".$page;
			
			$searchQuery = "";
			$search_url = "";
				
			$valueQuery1 = "";
			$whereQuery1 = "";
			
			$lastname = (isset($_GET["lastname"])) ? pg_prep($_GET["lastname"]) : "";
			$group_id = (isset($_GET["group_id"])) ? (int) $_GET["group_id"] : 0;
			$login_name = (isset($_GET["login_name"])) ? pg_prep($_GET["login_name"]) : "";
			$profile = (isset($_GET["profile"])) ? (int) $_GET["profile"] : 0;
									
			if(empty($lastname))
			{
				$searchQuery .= "";
				$search_url .= "";
			}else
			{
				$searchQuery .= " AND lower(tau.lastname) LIKE lower('%".$lastname."%')";
				$search_url .= "&lastname=".$lastname;
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
				$whereQuery1 = " AND tau.user_id = tug.user_id";
			}
			
			if(empty($login_name))
			{
				$searchQuery .= "";
				$search_url .= "";
			}else
			{
				$searchQuery .= " AND lower(tau.login_name) LIKE lower('%".$login_name."%')";
				$search_url .= "&login_name=".$login_name;
			}
			
			if($profile==0)
			{
				$searchQuery .= "";
				$search_url .= "";
			} else
			{
				$searchQuery .= " AND tau.profile = ".$profile;
				$search_url .= "&profile=".$profile;
			}	
			
			$sort_url = "";
			$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
			$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;
			
			if($sort==0)
				$sort_url .= "";
			else
				$sort_url .= "&sort=".$sort;
			
			if($sort_type==0)
				$sort_url .= "";
			else
				$sort_url .= "&sorttype=".$sort_type; 		
				
			if ($action=="edit")
			{
				require("tausers/inc.edit_users.php");
			}elseif ($action=="add")
			{
				require("tausers/inc.add_users.php");
			}elseif ($action=="more")
			{
				require("tausers/inc.more_users.php");
			}elseif ($action=="usergroups")
			{
				require("tausers/inc.admin_usergroups.php");
			}elseif ($action=="aimagusers")
			{
				require("tausers/inc.admin_useraimags.php");
			}elseif ($action=="password")
			{
				require("tausers/inc.edit_password.php");
			}else
			{
				require("tausers/inc.list_users.php");
			}
			?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  