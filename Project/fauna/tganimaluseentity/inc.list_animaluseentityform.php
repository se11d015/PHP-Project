<?php
if (isset($_POST["searchanimaluseentitybttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$entity_name = (isset($_POST["entity_name"])) ? $_POST["entity_name"] : "";
	$aimag_name_mn = (isset($_POST["aimag_name_mn"])) ? $_POST["aimag_name_mn"] : "";
	$soum_name_mn = (isset($_POST["soum_name_mn"])) ? $_POST["soum_name_mn"] : "";
	$entity_type = (isset($_POST["entity_type"])) ? (int) $_POST["entity_type"] : 1;

	if($entity_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND tgcen.entity_type = ".$entity_type;
	    $search_url .= "&entity_type=".$entity_type;
	}
	
	if(empty($aimag_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(taaim.aimag_name_mn) LIKE lower('%".$aimag_name_mn."%')";
		$search_url .= "&aimag_name_mn=".$aimag_name_mn;
	}
	
	if(empty($soum_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
	
		$searchQuery .= " AND lower(tasou.soum_name_mn) LIKE lower('%".$soum_name_mn."%')";
		$search_url .= "&soum_name_mn=".$soum_name_mn;
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
	
}

$sortQuery = " ORDER BY ";
if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==1)
	{
		$sortQuery .= " taaim.aimag_name_mn";
	}elseif ($_GET["sort"]==2)
	{
		$sortQuery .= " tasou.soum_name_mn";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " tgcen.entity_type";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tgcen.entity_name";
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
$valueQuery = "COUNT(*) AS num_count   FROM ".$schemas.".tganimaluseentity tgcen, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou ";
$whereQuery = "WHERE taaim.aimag_code=tgcen.aimag_name AND tasou.soum_code=tgcen.soum_name";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
//echo $selQuery;
$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
	
$count = 10;
$maxpage = ceil( $sum / $count);

require("inc.search_animaluseentityform.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="8"><span class="title"><?php echo getdata($ITEM_TYPE, 70); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th class="span1">№</th>
        <th class="span4"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Аймаг, хотын нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Сум, дүүргийн нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хуулийн этгээдийн төрөл </a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Нөөц ашиглагчийн нэр</a></th>
        <th class="span3">Утасны дугаар</th>
        <th class="span3">Имэйл </th>
        <th class="span2">Үйлдэл</th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT";
		$valueQuery = "tgcen.*, taaim.aimag_name_mn, tasou.soum_name_mn  FROM ".$schemas.".tganimaluseentity tgcen, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou ";
		$whereQuery = "WHERE taaim.aimag_code=tgcen.aimag_name  AND tasou.soum_code=tgcen.soum_name";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;
		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["aimag_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_mn"]; ?></td>
        <td><?php echo getdata($USE_ENTITY_TYPE, $rows[$i]["entity_type"]); ?></td>
        <td><?php echo $rows[$i]["entity_name"]; ?></td>
        <td><?php echo $rows[$i]["tel_number"]; ?></td>
        <td><?php echo $rows[$i]["email_address"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&entity_id=".$rows[$i]["entity_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>
          <?php 
				if($sess_profile==1)
				{ 
				?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&entity_id=".$rows[$i]["entity_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&entity_id=".$rows[$i]["entity_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=permissionadd&entity_id=".$rows[$i]["entity_id"]; ?>" title="Зөвшөөрлийн  мэдээлэл нэмэх"><i class="icon-plus"></i></a>
          <?php 
				} else if($rows[$i]["user_id"]==$sess_user_id)
				{
				?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&entity_id=".$rows[$i]["entity_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&entity_id=".$rows[$i]["entity_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=permissionadd&entity_id=".$rows[$i]["entity_id"]; ?>" title="Зөвшөөрлийн мэдээлэл нэмэх"><i class="icon-plus"></i></a>
          <?php	
				}
				?></td>
      </tr>
      <?php
		}
		
		if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 2))
		{		
		?>
      <tr>
        <td colspan="8"><a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a> </td>
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
