<?php
if (isset($_POST["searchspeciesbttn"]))
{
	$searchQuery = "";
	$search_url = "";

	$species_name = (isset($_POST["species_name"])) ?  $_POST["species_name"] : "";
	$species_name_mn = (isset($_POST["species_name_mn"])) ? $_POST["species_name_mn"] : "";
	$genus_name_mn = (isset($_POST["genus_name_mn"])) ? $_POST["genus_name_mn"] : "";
	$family_name_mn = (isset($_POST["family_name_mn"])) ? $_POST["family_name_mn"] : "";
	$order_name_mn = (isset($_POST["order_name_mn"])) ? $_POST["order_name_mn"] : "";
	$phylum_name_mn = (isset($_POST["phylum_name_mn"])) ? $_POST["phylum_name_mn"] : "";


	if(empty($phylum_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapn.phylum_name_mn) LIKE lower('%".$phylum_name_mn."%')";
		$search_url .= "&phylum_name_mn=".$phylum_name_mn;
	}
	
	if(empty($order_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taon.order_name_mn) LIKE lower('%".$order_name_mn."%') OR lower(taon.alternative_name) LIKE lower('%".$order_name_mn."%'))";
		$search_url .= "&order_name_mn=".$order_name_mn;
	}

	if(empty($family_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tafn.family_name_mn) LIKE lower('%".$family_name_mn."%') OR lower(tafn.alternative_name) LIKE lower('%".$family_name_mn."%'))";
		$search_url .= "&family_name_mn=".$family_name_mn;
	}
	
	if(empty($genus_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%".$genus_name_mn."%') OR lower(tagn.synonyms_name) LIKE lower('%".$genus_name_mn."%') OR lower(tagn.basionum_name) LIKE lower('%".$genus_name_mn."%') )";
		$search_url .= "&genus_name_mn=".$genus_name_mn;
	}
	
	if(empty($species_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name) LIKE lower('%".$species_name."%') OR lower(tapl.synonyms_name) LIKE lower('%".$species_name."%') OR lower(tapl.basionum_name) LIKE lower('%".$species_name."%') )";
		$search_url .= "&species_name=".$species_name;
	}
	
	if(empty($species_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name_mn) LIKE lower('%".$species_name_mn."%') OR lower(tapl.synonyms_name) LIKE lower('%".$species_name_mn."%') OR lower(tapl.basionum_name) LIKE lower('%".$species_name_mn."%'))";
		$search_url .= "&species_name_mn=".$species_name_mn;
	}
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==2)
	{
		$sortQuery .= " tapl.species_name";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " tapl.species_name_mn";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tagn.genus_name_mn";
	}elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " tafn.family_name_mn";
	}elseif ($_GET["sort"]==6)
	{
		$sortQuery .= " taon.order_name_mn";
	}elseif ($_GET["sort"]==7)
	{
		$sortQuery .= " tapn.phylum_name_mn";
	}else
	{
		$sortQuery .= " tapl.species_code";
	}
}else
{
	$sortQuery .= " tapl.species_id";
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
$valueQuery = "tapl.*, tapn.phylum_name_mn, taon.order_name_mn, tafn.family_name_mn, tagn.genus_name_mn FROM ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
$whereQuery = "WHERE tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
//echo $selQuery;
$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);

require("inc.search_animalnameform.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="9"><span class="title"><?php echo getdata($ITEM_TYPE, 7); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=7&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хүрээний монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Овгийн монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Төрлийн монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зүйлийн код</a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зүйлийн латин нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зүйлийн монгол нэр</a></th>
        <th class="span2">Үйлдэл</th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		
		$startQuery = "SELECT";
		$valueQuery = "tapl.*, tapn.phylum_name_mn, taon.order_name_mn, tafn.family_name_mn, tagn.genus_name_mn FROM ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
		$whereQuery = "WHERE tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

		$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;

		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["phylum_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["order_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["family_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["genus_name_mn"]; ?></td>        
        <td><?php echo $rows[$i]["species_code"]; ?></td>
        <td><?php echo $rows[$i]["species_name"]; ?></td>
        <td><?php echo $rows[$i]["species_name_mn"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&species_id=".$rows[$i]["species_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>
          <?php 
			if($sess_profile==1)
			{ 
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&species_id=".$rows[$i]["species_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&species_id=".$rows[$i]["species_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a>
          <?php
			} else if($rows[$i]["user_id"]==$sess_user_id)
			{
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&species_id=".$rows[$i]["species_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&species_id=".$rows[$i]["species_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a>
          <?php
			}
			?>
        </td>
      </tr>
      <?php
		}
		
		if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2))
		{		
		?>
      <tr>
        <td colspan="9"><a class="btn btn-danger" href="<?php echo $my_url.$search_url.$sort_url."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a> </td>
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
