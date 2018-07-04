<?php
if (isset($_POST["searchgrouprolebttn"]))
{
	$groupid = (isset($_POST["groupid"])) ? (int) $_POST["groupid"]: 0;					
	$itemid = (isset($_POST["itemid"])) ? (int) $_POST["itemid"]: 0;	
	$roleid = (isset($_POST["roleid"])) ? (int) $_POST["roleid"]: 0;
		
	if($groupid==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tagr.group_id = ".$groupid;
		$search_url .= "&groupid=".$groupid;
	}
	
	if($itemid==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tagr.item_id = ".$itemid;
		$search_url .= "&itemid=".$itemid;
	}

	if($roleid==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tagr.role_id = ".$roleid;
		$search_url .= "&roleid=".$roleid;
	}		
} 

$valueQuery = "SELECT tagr.*
	FROM ".$schemas.".tagrouproles tagr, ".$schemas.".tagroups tag
	WHERE	tagr.group_id = tag.group_id";
$whereQuery = "";

$selQuery = $valueQuery." ".$whereQuery." ".$searchQuery;

$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);

require("tagrouproles/inc.search_grouproles.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="5"><span class="title">Бүлгийн эрх, үүрэг</span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th>Бүлгийн нэр</th>
        <th>Мэдээний нэр</th>
        <th>Эрх, үүрэг</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
				$limit = $count." OFFSET ".($page-1)*$count;
				$sortQuery = "ORDER BY tag.group_name";
				$valueQuery = "SELECT tagr.*, tag.group_name FROM ".$schemas.".tagrouproles tagr, ".$schemas.".tagroups tag";
				$whereQuery = "WHERE tagr.group_id = tag.group_id";
				
				$selQuery = $valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;	
			
				$rows = $db->query($selQuery);
				
				for ($i=0; $i < sizeof($rows); $i++) 
				{
					?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["group_name"]; ?></td>
        <td><?php echo getdata($GROUP_ITEM_TYPE, $rows[$i]["item_id"]); ?></td>
        <td><?php echo getdata($ROLE_TYPE, $rows[$i]["role_id"]); ?></td>        
        <td align="center"><a href="<?php echo $my_url.$search_url."&action=delete&group_id=".$rows[$i]["group_id"]."&item_id=".$rows[$i]["item_id"]."&role_id=".$rows[$i]["role_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a> </td>
      </tr>
      <?php
				}
				?>
      <tr>
        <td colspan="5"><a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a> </td>
      </tr>
    </tbody>
  </table>
  <?php
		require("pagination/inc.pagination1.php");
		pagelink1($count, $maxpage, $my_url, $page, $search_url);
		?>
</div>
