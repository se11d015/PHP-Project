<?php
if (isset($_POST["searchanimaluseentitybttn"]))
{
	$entity_name = (isset($_POST["entity_name"])) ? $_POST["entity_name"] : "";
	$permission_number = (isset($_POST["permission_number"])) ? $_POST["permission_number"] : "";
	$approved_date = (isset($_POST["approved_date"])) ? (int) $_POST["approved_date"] : 0;
	$end_date = (isset($_POST["end_date"])) ? (int) $_POST["end_date"] : 0;
	$permission_type = (isset($_POST["permission_type"])) ? (int) $_POST["permission_type"] : 0;
	$species_name_mn = (isset($_POST["species_name_mn"])) ? $_POST["species_name_mn"] : "";
	$species_name = (isset($_POST["species_name"])) ? $_POST["species_name"] : "";
	
	if($permission_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND tgcpe.permission_type = ".$permission_type;
	    $search_url .= "&permission_type=".$permission_type;
	}
	
	if($end_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgcpe.end_date) = ".$end_date;
		$search_url .= "&end_date=".$end_date;
	}
	
    if($approved_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgcpe.approved_date) = ".$approved_date;
		$search_url .= "&approved_date=".$approved_date;
	}	

	if(empty($entity_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgcen.entity_name) LIKE lower('%".$entity_name."%')";
		$search_url .= "&entity_name=".$entity_name;
	}
	
	if(empty($permission_number))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgcpe.permission_number) LIKE lower('%".$permission_number."%')";
		$search_url .= "&permission_number=".$permission_number;
	}
	if(empty($species_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name_mn) LIKE lower('%".$species_name_mn."%') OR lower(tagn.genus_name_mn) LIKE lower('%".$species_name_mn."%') )";
		$search_url .= "&species_name_mn=".$species_name_mn;
	}
	
	if(empty($species_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name) LIKE lower('%".$species_name."%') OR lower(tagn.genus_name) LIKE lower('%".$species_name."%') )";
		$search_url .= "&species_name=".$species_name;
	}
}

$sortQuery = " ORDER BY ";
if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==1)
	{
		$sortQuery .= " tgcen.entity_name";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " tgcpe.permission_type";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tgcpe.permission_number";
	}elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " tgcpe.approved_date";
	}elseif ($_GET["sort"]==6)
	{
		$sortQuery .= " tgcpe.end_date";
	}else 
	{
		$sortQuery .= " tgcpe.approved_date";
	
	}
}else
{
	$sortQuery .= " tgcpe.approved_date";
}

if (isset($_GET["sorttype"]))
{
	if ($_GET["sorttype"]==2)
	{
		$sorttype = 1;
		$sortQuery .= " ASC";
	}else
	{
		$sorttype = 2;
		$sortQuery .= " DESC";
	}
}else
{
	$sorttype = 2;
	$sortQuery .= " DESC";
}
///
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
$valueQuery = " COUNT(*) AS num_count FROM ".$schemas.".taanimalusepermission tgcpe, ".$schemas.".tganimaluseentity tgcen, ".$schemas.".taanimalusepayment tgcna,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl";
$whereQuery = "WHERE tgcpe.entity_name = tgcen.entity_id AND tgcpe.permission_id = tgcna.permission_id AND tgcna.species_name = tapl.species_code AND tapl.genus_code = tagn.genus_code";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
//echo $selQuery;
$rows = $db->query($selQuery);
	

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
	
$count = 10;
$maxpage = ceil( $sum / $count);

?>

<div class="list-table">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th><span class="title"><?php echo getdata($GROUP_ITEM_TYPE, 8); ?></span></th>
      </tr>
    </thead>
  </table>
  <?php 
	require("includes/taanimalusepermission/inc.search_animalusepermission.php");
	$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
	show_notification("info", "", $notify); 
	?>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <td>№</td>
        <th class="span4"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Нөөц ашиглагчийн нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зөвшөөрлийн төрөл</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зөвшөөрлийн дугаар</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зөвшөөрөл олгосон огноо</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зөвшөөрөл дуусах огноо</a></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page-1)*$count;
	
		$startQuery = "SELECT";
		$valueQuery = "tgcpe.*, tgcen.entity_name FROM ".$schemas.".taanimalusepermission tgcpe, ".$schemas.".tganimaluseentity tgcen, ".$schemas.".taanimalusepayment tgcna,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl";
$whereQuery = "WHERE tgcpe.entity_name = tgcen.entity_id AND tgcpe.permission_id = tgcna.permission_id AND tgcna.species_name = tapl.species_code AND tapl.genus_code = tagn.genus_code";

		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;
		$rows = $db->query($selQuery);

		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["entity_name"]; ?></td>
        <td><?php echo getdata($USE_PERMISSION_TYPE, $rows[$i]["permission_type"]); ?></td>
        <td><?php echo $rows[$i]["permission_number"]; ?></td>
        <td><?php echo $rows[$i]["approved_date"]; ?></td>
        <td><?php echo $rows[$i]["end_date"]; ?></td>
        <td><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&permission_id=".$rows[$i]["permission_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a> </td>
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
