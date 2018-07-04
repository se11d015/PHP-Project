<?php
if (isset($_POST["searchresearchreportbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$research_name = (isset($_POST["research_name"])) ?  $_POST["research_name"] : "";
	$research_type = (isset($_POST["research_type"])) ?  (int)$_POST["research_type"] : 0;
	$executive_name = (isset($_POST["executive_name"])) ? $_POST["executive_name"] : "";
	
	if(empty($research_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapr.research_name) LIKE lower('%".$research_name."%')";
		$search_url .= "&research_name=".$research_name;
	}
	if($research_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tapr.research_type = ".$research_type;
		$search_url .= "&research_type=".$research_type;
	}
	
	if(empty($executive_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapr.executive_name) LIKE lower('%".$executive_name."%')";
		$search_url .= "&executive_name=".$executive_name;
	}
	
}

$sortQuery = " ORDER BY ";


if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==1)
	{
		$sortQuery .= " tct.type_name";
	}elseif ($_GET["sort"]==2)
	{
		$sortQuery .= " tapr.research_name";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " tapr.executive_name";
	}else
	{
		$sortQuery .= " tapr.research_id";
	}
}else
{
	$sortQuery .= " tapr.research_id";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".taanimalresearchreport tapr, ".$schemas.".tcresearchtype tct";
$whereQuery = "WHERE tapr.research_id = tapr.research_id AND tct.type_id=tapr.research_type";
	
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
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
        <th><span class="title"><?php echo getdata($ITEM_TYPE, 30); ?></span></th>
      </tr>
    </thead>
  </table>
  <?php
	require("includes/taanimalresearchreport/inc.search_animalresearchreport.php");
	
	$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
	show_notification("info", "", $notify);
	?>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th class="span1">№</th>
        <th class="span3"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Судалгааны төрөл</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Судалгааны нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Гүйцэтгэгч байгууллагын нэр</a></th>
        <th class="span4">Судалгаа хийсэн хугацаа</th>
        <th class="span3">Судалгааны тайлан</th>
        <th class="span2"></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT";
		$valueQuery = "tapr.*, tct.type_name FROM ".$schemas.".taanimalresearchreport tapr, ".$schemas.".tcresearchtype tct";
		$whereQuery = "WHERE tapr.research_id = tapr.research_id AND tct.type_id=tapr.research_type";
			
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		////echo $selQuery;

		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["type_name"]; ?></td>
        <td><?php echo $rows[$i]["research_name"]; ?></td>
        <td><?php echo $rows[$i]["executive_name"]; ?></td>
        <td><?php echo $rows[$i]["research_time"]; ?></td>
        <td><?php if(!empty($rows[$i]["research_filename"])) { ?>
        <a href="<?php echo $rows[$i]["research_pathname"]."/".$rows[$i]["research_filename"]; ?>" target="_blank">Тайлан харах</a>
        <?php } ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&research_id=".$rows[$i]["research_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a> 
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
