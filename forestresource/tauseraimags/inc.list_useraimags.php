<?php
if (isset($_POST["searchuserbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$aimagcode = (isset($_POST["aimagcode"])) ? (int) $_POST["aimagcode"] : 0;
	$lastname = (isset($_POST["lastname"])) ? pg_prep($_POST["lastname"]) : "";
					
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
} 

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"])) 
{
	if ($_GET["sort"] == 2) 
	{
		$sortQuery .= " tau.organization";
	} else if ($_GET["sort"] == 3) 
	{
		$sortQuery .= " tau.lastname";
	} else
	{
		$sortQuery .= " va.aimag_name_mn";		
	}
} else 
{
    $sortQuery .= " va.aimag_name_mn";
}

if (isset($_GET["sorttype"])) 
{
    if ($_GET["sorttype"] == 2) 
	{
        $sorttype = 1;
        $sortQuery .= " ASC";
    } else {
        $sorttype = 2;
        $sortQuery .= " DESC";
    }
} else {
    $sorttype = 2;
    $sortQuery .= " DESC";
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

$startQuery = "SELECT";		
$valueQuery = "taua.* FROM ".$schemas.".taaimagusers taua, scadministrative.vaaimagname va, ".$schemas.".tausers tau";
$whereQuery = "WHERE taua.aimag_code = va.aimag_code AND taua.user_id = tau.user_id";
		
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);

require("tauseraimags/inc.search_useraimags.php");

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("UsersColumn10"); ?></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("UsersColumn5"); ?></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("UsersColumn4"); ?></th>
        <th><?php echo _p("UsersColumn6"); ?></th>
        <th><?php echo _p("UsersColumn7"); ?></th>
        <th><?php echo _p("UsersColumn8"); ?></th>
        <th><?php echo _p("Operation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT";		
		$valueQuery = "taua.aimag_code, taua.user_id, va.aimag_name_mn, va.aimag_name_en, tau.organization, tau.lastname, tau.phone, tau.email, tau.login_status FROM ".$schemas.".taaimagusers taua, scadministrative.vaaimagname va, ".$schemas.".tausers tau";
		$whereQuery = "WHERE taua.aimag_code = va.aimag_code AND taua.user_id = tau.user_id";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
	
		$rows = $db->query($selQuery);
		
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["aimag_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["organization"]; ?></td>
        <td><?php echo $rows[$i]["lastname"]; ?></td>
        <td><?php echo $rows[$i]["phone"]; ?></td>
        <td><?php echo $rows[$i]["email"]; ?></td>
        <td><?php echo getdata($USER_ACTIVE, $rows[$i]["login_status"]); ?></td>
        <td><a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&aimag_code=".$rows[$i]["aimag_code"]."&user_id=".$rows[$i]["user_id"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a></td>
      </tr>
      <?php
		}
		?>
      <tr>
        <td colspan="8"><a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=add"; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a></td>
      </tr>
    </tbody>
  </table>
  <?php
	require("pagination/inc.pagination1.php");
	pagelink1($count, $maxpage, $my_url, $page, $search_url.$sort_url);
	?>
</div>
