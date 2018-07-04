<?php

if (isset($_POST["searchuserbttn"]))
{
	$searchQuery = "";
	$search_url = "";

	$lastname = (isset($_POST["lastname"])) ? pg_prep($_POST["lastname"]) : "";
	$group_id = (isset($_POST["group_id"])) ? (int) $_POST["group_id"] : 0;
	$login_name = (isset($_POST["login_name"])) ? pg_prep($_POST["login_name"]) : "";
	$profile = (isset($_POST["profile"])) ? (int) $_POST["profile"] : 0;
	$login_status = (isset($_POST["login_status"])) ? pg_prep($_POST["login_status"]) : "";
						
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
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==2)
	{
		$sortQuery .= "tau.lastname ";
	}else if ($_GET["sort"]==3)
	{
		$sortQuery .= "tau.profile ";
	}else if ($_GET["sort"]==4)
	{
		$sortQuery .= "tau.organization ";
	}else if ($_GET["sort"]==5)
	{
		$sortQuery .= "tau.login_status ";		
	}else
	{
		$sortQuery .= "tau.login_name ";
	}
}else
{
	$sortQuery .= "tau.user_id ";
}

if (isset($_GET["sorttype"]))
{
	if ($_GET["sorttype"]==2)
	{
		$sorttype = 1;
		$sortQuery .= "ASC";
	}else
	{
		$sorttype = 2;
		$sortQuery .= "DESC";
	}
}else
{
	$sorttype = 1;
	$sortQuery .= "DESC";
}

if(isset($_GET["sort"]) && isset($_GET["sorttype"]))
{
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
}

if (isset($_GET["checkusergroups"]))
{
	$searchQuery .= " AND tau.user_id NOT IN (SELECT tug1.user_id FROM ".$schemas.".tausergroups tug1)";
	$search_url .= "&checkusergroups=1";
}
if (isset($_GET["checkaimagusers"]))
{
	$searchQuery .= "AND tau.user_id IN (SELECT tua.user_id FROM ".$schemas.".taaimagusers tua)";
	$search_url .= "&checkaimagusers=1";
}

$startQuery = "SELECT";
$valueQuery = "tau.* FROM ".$schemas.".tausers tau";
$whereQuery = "WHERE tau.user_id = tau.user_id";

if($sess_profile==1) 
	$whereQuery .= "";
else
	$whereQuery .= " AND tau.user_id = ".$sess_user_id;

$selQuery = $startQuery." ".$valueQuery." ".$valueQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery;

$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);

if($sess_profile==1) 
{ 
	if (isset($_GET["checkusergroups"]) || isset($_GET["checkaimagusers"]))
		$sname = "tausers/inc.search_users.php";
	else
		require("tausers/inc.search_users.php");
}

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("UsersColumn2"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("UsersColumn5"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("UsersColumn1"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("UsersColumn4"); ?></a></th>
        <th><?php echo _p("UsersColumn6"); ?></th>
        <th><?php echo _p("UsersColumn7"); ?></th>
        <th><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("UsersColumn8"); ?></a></th>
        <th><?php echo _p("Operation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page-1)*$count;
	
		$startQuery = "SELECT";
		$valueQuery = "tau.* FROM ".$schemas.".tausers tau";
		$whereQuery = "WHERE tau.user_id = tau.user_id";
		
		if($sess_profile==1) 
			$whereQuery .= "";
		else
			$whereQuery .= " AND tau.user_id = ".$sess_user_id;
		
		$selQuery = $startQuery." ".$valueQuery." ".$valueQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;

		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo getdata($USER_PROFILE, $rows[$i]["profile"]); ?></td>
        <td><?php echo $rows[$i]["organization"]; ?></td>
        <td><?php echo $rows[$i]["login_name"]; ?></td>
        <td><?php echo $rows[$i]["lastname"]; ?></td>
        <td><?php echo $rows[$i]["phone"]; ?></td>
        <td><?php echo $rows[$i]["email"]; ?></td>
        <td><?php echo getdata($USER_ACTIVE, $rows[$i]["login_status"]); ?></td>
        <td><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&user_id=".$rows[$i]["user_id"]; ?>" title="<?php echo _p("MoreTitle"); ?>"><i class="fa fa-list-alt"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&user_id=".$rows[$i]["user_id"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a>
          <?php 
			if($sess_profile==1)
			{ 
			?>
          <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&user_id=".$rows[$i]["user_id"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=usergroups&user_id=".$rows[$i]["user_id"]; ?>" title="<?php echo _p("UserGroupsTitle"); ?>" ><i class="fa fa-user"></i></a>
          <?php 
				if($rows[$i]["profile"]==2)
				{
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=aimagusers&user_id=".$rows[$i]["user_id"]; ?>" title="<?php echo _p("UserAimagsTitle"); ?>" ><i class="fa fa-th"></i></a>
          <?php 
				}	  
			} 
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=password&user_id=".$rows[$i]["user_id"]; ?>" title="<?php echo _p("UsersColumn9"); ?>" ><i class="fa fa-wrench"></i></a></td>
      </tr>
      <?php
		}
		
		if($sess_profile==1) 
		{ 
		?>
      <tr>
        <td colspan="9"><a class="btn btn-primary" href="<?php echo $my_url.$search_url.$sort_url."&action=add"; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a> 
          <?php if (isset($_GET["checkusergroups"]) || isset($_GET["checkaimagusers"])) { ?>
            <a class="btn btn-primary" href="<?php echo $my_url; ?>"><i class="fa fa-user"></i> <?php echo _p("UsersText1"); ?></a> 
            <?php } ?>
          <?php if (!isset($_GET["checkusergroups"])) { ?>
            <a class="btn btn-primary" href="<?php echo $my_url."&checkusergroups=1"; ?>"><i class="fa fa-user"></i> <?php echo _p("UsersText2"); ?></a> 
            <?php } ?>
          <?php if (!isset($_GET["checkaimagusers"])) { ?>
            <a class="btn btn-primary" href="<?php echo $my_url."&checkaimagusers=1"; ?>"><i class="fa fa-th"></i> <?php echo _p("UserAimagsTitle"); ?></a> 
            <?php } ?></td>
      </tr>
      <?php
		}	
		?>
    </tbody>
  </table>
  <?php
	require("pagination/inc.pagination1.php");
	pagelink1($count, $maxpage, $my_url, $page, $search_url.$sort_url);
	?>
</div>
