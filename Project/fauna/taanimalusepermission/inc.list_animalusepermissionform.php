<?php
if (isset($_POST["searchanimaluseentitybttn"]))
{
	$searchQuery = "";
	$search_url = "";

	$entity_name = (isset($_POST["entity_name"])) ? $_POST["entity_name"] : "";
	$permission_number = (isset($_POST["permission_number"])) ? $_POST["permission_number"] : "";
	$approved_date = (isset($_POST["approved_date"])) ? (int) $_POST["approved_date"] : 0;
	$end_date = (isset($_POST["end_date"])) ? (int) $_POST["end_date"] : 0;
	$permission_type = (isset($_POST["permission_type"])) ? (int) $_POST["permission_type"] : 0;

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
	
}

$sortQuery = " ORDER BY ";
if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==1)
	{
		$sortQuery .= " tgcen.entity_name";
	}elseif ($_GET["sort"]==2)
	{
		$sortQuery .= " tgcpe.approved_org";
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
		$sortQuery .= " tgcen.entity_id";
	}
}else
{
	$sortQuery .= " tgcen.entity_id";
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
$valueQuery = " COUNT(*) AS num_count   FROM ".$schemas.".taanimalusepermission tgcpe, ".$schemas.".tganimaluseentity tgcen";
$whereQuery = "WHERE tgcpe.entity_name = tgcen.entity_id";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
//echo $selQuery;
$rows = $db->query($selQuery);


$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
	
$count = 10;
$maxpage = ceil( $sum / $count);


require("inc.search_animalusepermissionform.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="9"><span class="title"><?php echo getdata($ITEM_TYPE, 71); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <td>№</td>
        <th class="span4"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Нөөц ашиглагчийн нэр</a></th>
        <th class="span3"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зөвшөөрлийн төрөл</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зөвшөөрөл олгосон байгууллагын нэр</a></th>
        <th class="span3"><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зөвшөөрлийн дугаар</a></th>
        <th class="span3"><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зөвшөөрөл олгосон огноо</a></th>
        <th class="span3"><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зөвшөөрөл дуусах огноо</a></th>
        <th class="span2">Үйлдэл</th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page-1)*$count;
	
		$startQuery = "SELECT";
		$valueQuery = "tgcpe.*, tgcen.entity_name FROM ".$schemas.".taanimalusepermission tgcpe, ".$schemas.".tganimaluseentity tgcen";
		$whereQuery = "WHERE tgcpe.entity_name = tgcen.entity_id";

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
        <td><?php echo $rows[$i]["approved_org"]; ?></td>
        <td><?php echo $rows[$i]["permission_number"]; ?></td>
        <td><?php echo $rows[$i]["approved_date"]; ?></td>
        <td><?php echo $rows[$i]["end_date"]; ?></td>
        <td><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&permission_id=".$rows[$i]["permission_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>
          <?php
			if($sess_profile==1)
			{
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&permission_id=".$rows[$i]["permission_id"]; ?>"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&permission_id=".$rows[$i]["permission_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"> <i class="icon-trash"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=useadd&permission_id=".$rows[$i]["permission_id"]; ?>" title="Амьтны жагсаалт нэмэх"> <i class="icon-plus"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=paymentadd&permission_id=".$rows[$i]["permission_id"]; ?>" title="Төлбөрийн мэдээлэл нэмэх"> <i class="icon-plus-sign"></i></a>
          <?php 
			} else if($userid==$sess_user_id) {
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&permission_id=".$rows[$i]["permission_id"]; ?>"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&permission_id=".$rows[$i]["permission_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"> <i class="icon-trash"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=useadd&permission_id=".$rows[$i]["permission_id"]; ?>" title="Амьтны жагсаалт нэмэх"> <i class="icon-plus"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=paymentadd&permission_id=".$rows[$i]["permission_id"]; ?>" title="Төлбөрийн мэдээлэл нэмэх"> <i class="icon-plus-sign"></i></a>
          <?php
			}
			?>
        </td>
      </tr>
      <?php
		}
		
		if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 2))
		{		
		?>
      <tr>
        <td colspan="9"><a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a> </td>
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
