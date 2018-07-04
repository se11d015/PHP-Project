<?php
if (isset($_POST["searchphylumbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$kingdom_name_mn = (isset($_POST["kingdom_name_mn"])) ? $_POST["kingdom_name_mn"] : "";
	$phylum_name = (isset($_POST["phylum_name"])) ?  $_POST["phylum_name"] : "";
	$phylum_name_mn = (isset($_POST["phylum_name_mn"])) ? $_POST["phylum_name_mn"] : "";

	if(empty($kingdom_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(takn.kingdom_name_mn) LIKE lower('%".$kingdom_name_mn."%')";
		$search_url .= "&kingdom_name_mn=".$kingdom_name_mn;
	}
	if(empty($phylum_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapn.phylum_name) LIKE lower('%".$phylum_name."%')";
		$search_url .= "&phylum_name=".$phylum_name;
	}
	
	if(empty($phylum_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapn.phylum_name_mn) LIKE lower('%".$phylum_name_mn."%')";
		$search_url .= "&phylum_name_mn=".$phylum_name_mn;
	}
}

$sortQuery = " ORDER BY ";


if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==2)
	{
		$sortQuery .= " tapn.phylum_name";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " tapn.phylum_name_mn";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " takn.kingdom_name";		
	}else
	{
		$sortQuery .= " takn.kingdom_name_mn";
}
}else
{
	$sortQuery .= " tapn.phylum_code";
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
	$sorttype = 1;
	$sortQuery .= " ASC";
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
$valueQuery = "tapn.*, takn.kingdom_name, takn.kingdom_name FROM ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
$whereQuery = "WHERE tapn.kingdom_code = takn.kingdom_code";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
//echo $selQuery;
$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);

?>

<div class="list-table">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th><span class="title"><?php echo getdata($ITEM_TYPE, 2); ?></span></th>
      </tr>
    </thead>
  </table>
  <?php
	require("includes/taphylumname/inc.search_phylumname.php");
	
	$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
	show_notification("info", "", $notify);  
	
	if(!empty($rows))
	{
	?>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Аймгийн латин нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Аймгийн монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хүрээний латин нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хүрээний монгол нэр</a></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT";
		$valueQuery = "tapn.*, takn.kingdom_name_mn, takn.kingdom_name FROM ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
		$whereQuery = "WHERE tapn.kingdom_code = takn.kingdom_code";

		$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;

		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["kingdom_name"]; ?></td>
        <td><?php echo $rows[$i]["kingdom_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["phylum_name"]; ?></td>
        <td><?php echo $rows[$i]["phylum_name_mn"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&phylum_id=".$rows[$i]["phylum_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a></td> 
      </tr>
      <?php 
		}	
		?>
    </tbody>
  </table>
  <?php
		require("pagination/inc.pagination1.php");
		pagelink1($count, $maxpage, $my_url, $page, $search_url.$sort_url);
	}
	?>
</div>
