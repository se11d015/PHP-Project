<?php

if (isset($_POST["searchuserbttn"]))
{
	$groupid = (isset($_POST["groupid"])) ? (int) $_POST["groupid"]: 0;	
	$userid = (isset($_POST["userid"])) ? (int) $_POST["userid"]: 0;	
					
	if($groupid==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND taug.group_id = ".$groupid;
		$search_url .= "&groupid=".$groupid;
	}
	
	if($userid==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND taug.user_id = ".$userid;
		$search_url .= "&userid=".$userid;
	}
} 

$valueQuery = "SELECT taug.group_id, taug.user_id, tag.group_name, tau.lastname FROM ".$schemas.".tausergroups taug, ".$schemas.".tagroups tag, ".$schemas.".tausers tau";
$whereQuery = "WHERE	taug.group_id = tag.group_id AND taug.user_id = tau.user_id";
		
$selQuery = $valueQuery." ".$whereQuery." ".$searchQuery;
$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);

require("tausergroups/inc.search_usergroups.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="7"><span class="title">Бүлгийн хэрэглэгч</span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>        
        <th>Бүлгийн нэр</th>
        <th>Нэвтрэх нэр</th>
        <th>Хэрэглэгчийн төрөл</th>
        <th>Хэрэглэгчийн нэр</th>        
        <th>Байгууллагын нэр</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
			$limit = $count." OFFSET ".($page-1)*$count;
			$sortQuery = "ORDER BY tau.lastname, tag.group_name";
			$valueQuery = "SELECT taug.group_id, taug.user_id, tag.group_name, tau.organization, tau.lastname, tau.login_name, tau.profile FROM ".$schemas.".tausergroups taug, ".$schemas.".tagroups tag, ".$schemas.".tausers tau";
			$whereQuery = "WHERE taug.group_id = tag.group_id AND taug.user_id = tau.user_id";
			
			$selQuery = $valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;	
		
			$rows = $db->query($selQuery);
			
			for ($i=0; $i < sizeof($rows); $i++) 
			{
			?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["group_name"]; ?></td>
        <td><?php echo $rows[$i]["login_name"]; ?></td>
        <td><?php echo getdata($USER_PROFILE, $rows[$i]["profile"]); ?></td>
        <td><?php echo $rows[$i]["lastname"]; ?></td>
        <td><?php echo $rows[$i]["organization"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$search_url."&action=delete&group_id=".$rows[$i]["group_id"]."&user_id=".$rows[$i]["user_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a> </td>
      </tr>
      <?php
			}
			?>
      <tr>
        <td colspan="5"><a class="btn btn-danger" href="<?php echo $my_url.$search_url."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a> </td>
      </tr>
    </tbody>
  </table>
  <?php
	require("pagination/inc.pagination1.php");
	pagelink1($count, $maxpage, $my_url, $page, $search_url);
	?>
</div>
