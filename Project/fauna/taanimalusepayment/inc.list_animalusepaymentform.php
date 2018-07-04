<?php
if (isset($_POST["searchanimaluseentitybttn"]))
{
	$searchQuery = "";
	$search_url = "";

	$entity_name = (isset($_POST["entity_name"])) ? $_POST["entity_name"] : "";
	$permission_number = (isset($_POST["permission_number"])) ? $_POST["permission_number"] : "";
	$species_name_mn = (isset($_POST["species_name_mn"])) ? $_POST["species_name_mn"] : "";
    $species_name = (isset($_POST["species_name"])) ? $_POST["species_name"] : "";

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
		$searchQuery .= " AND (lower(taan.species_name_mn) LIKE lower('%".$species_name_mn."%') OR lower(tagn.genus_name_mn) LIKE lower('%".$species_name_mn."%') )";
		$search_url .= "&species_name_mn=".$species_name_mn;
	}
	
	if(empty($species_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taan.species_name) LIKE lower('%".$species_name."%') OR lower(tagn.genus_name) LIKE lower('%".$species_name."%') )";
		$search_url .= "&species_name=".$species_name;
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
        $sortQuery .= " tgcpe.permission_number";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " taan.species_name";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " taan.species_name_mn";
	}else 
	{
		$sortQuery .= " taupa.payment_id";
	}
}else
{
	$sortQuery .= " taupa.payment_id";
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
$valueQuery = " COUNT(*) AS num_count   FROM ".$schemas.".taanimalusepermission tgcpe, ".$schemas.".tganimaluseentity tgcen, ".$schemas.".taanimalusepayment taupa,".$schemas.".takingdomname takn,".$schemas.".taphylumname tadn,".$schemas.".taclassname tacn,".$schemas.".taordername taon,".$schemas.".tafamilyname tafn,".$schemas.".tagenusname tagn,".$schemas.".taanimalname taan";
$whereQuery = "WHERE tgcpe.entity_name = tgcen.entity_id  AND tgcpe.permission_id = taupa.permission_id AND taupa.species_name = taan.species_code AND taan.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tadn.phylum_code  AND tadn.kingdom_code=takn.kingdom_code";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
//echo $selQuery;
$rowss = $db->query($selQuery);


$sum = 0;
if(sizeof($rowss)>0)
	$sum = $rowss[0]["num_count"];
	
$count = 10;
$maxpage = ceil( $sum / $count);


require("inc.search_animalusepaymentform.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="8"><span class="title"><?php echo getdata($ITEM_TYPE, 73); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <td>№</td>
        <th class="span6"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i>Нөөц ашиглагчийн нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i>Зөвшөөрлийн дугаар</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i>Амьтны латин нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i>Амьтны монгол нэр</a></th>
        <th class="span4">Ашигласан амьтны тоо толгой</th>
        <th class="span3">Хэмжих нэгж</th>
        <th class="span3">Үйлдэл</th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT";
		$valueQuery = "taupa.*, tgcpe.*, tgcen.entity_name, tagn.genus_name, tagn.genus_name_mn, tadn.phylum_name_mn, taon.order_name_mn, tafn.family_name_mn,  taan.species_name_mn,taan.species_name  FROM ".$schemas.".taanimalusepermission tgcpe, ".$schemas.".tganimaluseentity tgcen, ".$schemas.".taanimalusepayment taupa,".$schemas.".takingdomname takn,".$schemas.".taphylumname tadn,".$schemas.".taclassname tacn,".$schemas.".taordername taon,".$schemas.".tafamilyname tafn,".$schemas.".tagenusname tagn,".$schemas.".taanimalname taan";
		$whereQuery = "WHERE tgcpe.entity_name = tgcen.entity_id  AND tgcpe.permission_id = taupa.permission_id AND taupa.species_name = taan.species_code AND taan.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tadn.phylum_code  AND tadn.kingdom_code=takn.kingdom_code";
		
		
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;
		$rows = $db->query($selQuery);
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["entity_name"]; ?></td>
        <td><?php echo $rows[$i]["permission_number"]; ?></td>
        <td><?php echo $rows[$i]["genus_name"]." ".$rows[$i]["species_name"]; ?></td>
        <td><?php echo $rows[$i]["species_name_mn"]." ".$rows[$i]["genus_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["used_amount"]; ?></td>
        <td><?php echo $rows[$i]["amount_unit"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&payment_id=".$rows[$i]["payment_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>
          <?php
				if($sess_profile==1)
				{
				?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&payment_id=".$rows[$i]["payment_id"]; ?>"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&payment_id=".$rows[$i]["payment_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a>
          <?php 
				} else if($userid==$sess_user_id)
				{
				?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&payment_id=".$rows[$i]["payment_id"]; ?>"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&payment_id=".$rows[$i]["payment_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a>
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
