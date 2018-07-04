<?php
if (isset($_POST["searchgrouprolebttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$group_id = (isset($_POST["groupid"])) ? (int) $_POST["groupid"]: 0;					
	$item_id = (isset($_POST["itemid"])) ? (int) $_POST["itemid"]: 0;	
	$role_id = (isset($_POST["roleid"])) ? (int) $_POST["roleid"]: 0;
		
	if($group_id==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tagr.group_id = ".$group_id;
		$search_url .= "&groupid=".$group_id;
	}
	
	if($item_id==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tagr.item_id = ".$item_id;
		$search_url .= "&itemid=".$item_id;
	}

	if($role_id==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tagr.role_id = ".$role_id;
		$search_url .= "&roleid=".$role_id;
	}		
} 

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"])) 
{
	if ($_GET["sort"] == 2) 
	{
		$sortQuery .= " tagr.item_id";
	} else if ($_GET["sort"] == 3) 
	{
		$sortQuery .= " tagr.role_id";
	} else
	{
		$sortQuery .= " tag.group_name_mn";		
	}
} else 
{
    $sortQuery .= " tag.group_name_mn";
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
$valueQuery = "tagr.* FROM ".$schemas.".tagrouproles tagr, ".$schemas.".tagroups tag";
$whereQuery = "WHERE tagr.group_id = tag.group_id";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;

$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);

require("tagrouproles/inc.search_grouproles.php");

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("GroupRolesColumn1");?></a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("GroupRolesColumn2");?></a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("GroupRolesColumn3");?></a></th>
        <th><?php echo _p("Operation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT";		
		$valueQuery = "tagr.*, tag.group_name_mn, tag.group_name_en FROM ".$schemas.".tagrouproles tagr, ".$schemas.".tagroups tag";
		$whereQuery = "WHERE tagr.group_id = tag.group_id";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
	
		$rows = $db->query($selQuery);
		
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["group_name_$language_name"]; ?></td>
        <td><?php echo getdata($ITEM_TYPE, $rows[$i]["item_id"]); ?></td>
        <td><?php echo getdata($ROLE_TYPE, $rows[$i]["role_id"]); ?></td>
        <td><a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&group_id=".$rows[$i]["group_id"]."&item_id=".$rows[$i]["item_id"]."&role_id=".$rows[$i]["role_id"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a></td>
      </tr>
      <?php
		}
		?>
      <tr>
        <td colspan="5"><a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=add"; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a></td>
      </tr>
    </tbody>
  </table>
  <?php
	require("pagination/inc.pagination1.php");
	pagelink1($count, $maxpage, $my_url, $page, $search_url.$sort_url);
	?>
</div>
