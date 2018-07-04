<?php
if (isset($_POST["searchanimalprotectionbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$protect_type = (isset($_POST["protect_type"])) ?  (int)$_POST["protect_type"] : 0;
	$protect_date = (isset($_POST["protect_date"])) ? (int) $_POST["protect_date"] : 0;
	$aimag_code = (isset($_POST["aimag_code"])) ? (int) $_POST["aimag_code"] : 0;
	
	if($protect_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tgpp.protect_type = ".$protect_type;
		$search_url .= "&protect_type=".$protect_type;
	}
	
	if($protect_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgpp.protect_date) = ".$protect_date;
		$search_url .= "&protect_date=".$protect_date;
	}	
		
    if ($aimag_code == 0) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND tgpp.aimag_name = " . $aimag_code;
        $search_url .= "&aimag_code=" . $aimag_code;
    }

}

$sortQuery = " ORDER BY ";


if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==1) {
		$sortQuery .= " tcpt.type_name";
	}elseif ($_GET["sort"]==2) {
		$sortQuery .= " tgpp.protect_date";
	}elseif ($_GET["sort"] == 3) {
        $sortQuery .= " vas.aimag_name_mn";
    }elseif ($_GET["sort"] == 4) {
        $sortQuery .= " vas.soum_name_mn";
	}elseif ($_GET["sort"]==5) {
		$sortQuery .= " tgpp.place_name";
	}else {
		$sortQuery .= " tgpp.protect_id";
	}

}else
{
	$sortQuery .= " tgpp.protect_id";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".tganimalprotection tgpp, ".$schemas.".tcprotectiontype tcpt, scadministrative.vasoumname vas";
$whereQuery = "WHERE tgpp.soum_name = vas.soum_code AND tcpt.type_id=tgpp.protect_type";
	

$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery;
////echo $selQuery;
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
       <th colspan="7"><span class="title"><?php echo getdata($ITEM_TYPE, 50); ?></span></th>
      </tr>
    </thead>
  </table>
 <?php

require("includes/tganimalprotection/inc.search_animalprotection.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>


 <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th class="span1">№</th>
        <th class="span4"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хамгаалах арга хэмжээний төрөл</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хамгаалах арга хэмжээний авсан огноо</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=3&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Аймаг, хотын нэр </a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=4&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Сум, дүүргийн нэр </a></th>
        <th class="span5"><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хамгаалах арга хэмжээний авсан газрын нэр</a></th>
        <th class="span2"></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT";
		$valueQuery = "tgpp.*, tcpt.type_name, vas.aimag_name_mn, vas.soum_name_mn FROM ".$schemas.".tganimalprotection tgpp, ".$schemas.".tcprotectiontype tcpt, scadministrative.vasoumname vas";
		$whereQuery = "WHERE tgpp.soum_name = vas.soum_code AND tcpt.type_id=tgpp.protect_type";

		$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;

		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["type_name"]; ?></td>
        <td><?php echo $rows[$i]["protect_date"]; ?></td>
        <td><?php echo $rows[$i]["aimag_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["place_name"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&protect_id=".$rows[$i]["protect_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a> </td>
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
