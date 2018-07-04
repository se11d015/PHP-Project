<?php
if (isset($_POST["searchanimalorgreportbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$report_name = (isset($_POST["report_name"])) ? $_POST["report_name"] : "";	
	$type_name = (isset($_POST["type_name"])) ? (int) $_POST["type_name"]: 0;	

	
	if(empty($report_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapr.report_name) LIKE lower('%".$report_name."%')";
		$search_url .= "&report_name=".$report_name;
	}
	
	if($type_name==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tapr.report_type = ".$type_name;
		$search_url .= "&type_name=".$type_name;
	}
	
	
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==1)
	{
		$sortQuery .= " tgpo.report_name";		
	}elseif ($_GET["sort"]==2)
	{
		$sortQuery .= " vas.aimag_name_mn";	
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " tapr.approved_date";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tapr.permission_number";	
	}elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " tapr.end_date";
	}else
	{
		$sortQuery .= " tapr.report_id";
	}
}else
{
	$sortQuery .= " tapr.report_id";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".taanimalorgreport tapr, ".$schemas.".tcreporttype tct,".$schemas . ".tganimalorg tgpo";
$whereQuery =  "WHERE tapr.report_type = tct.type_id AND tapr.org_name = tgpo.org_id";


$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;

$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
	
$count = 10;
$maxpage = ceil( $sum / $count);


require("taanimalorgreport/inc.search_animalorgreportform.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="7"><span class="title"><?php echo getdata($ITEM_TYPE, 42); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th class="span4">Тайлангийн төрөл</th>
        <th class="span4">Тайлангийн нэр</th>
        <th class="span4">Тайлан хамрах хугацаа</th>
        <th class="span4">Тайлангийн хураангуй </th>
        <th class="span4">Ажлын тайлангийн файл</th>
        <th class="span2"></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count . " OFFSET " . ($page - 1) * $count;	
		$startQuery = "SELECT";
		$valueQuery = "tapr.*, tct.type_name as type_name,  tgpo.org_name FROM ".$schemas.".taanimalorgreport tapr, ".$schemas.".tcreporttype tct,".$schemas . ".tganimalorg tgpo";
		$whereQuery = "WHERE tapr.report_type = tct.type_id AND tapr.org_name = tgpo.org_id";

			$selQuery = $startQuery." ".$valueQuery." ".$whereQuery."  ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
//echo $selQuery;
			$rows = $db->query($selQuery);
		
			for ($i=0; $i < sizeof($rows); $i++) 
			{
			?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["type_name"]; ?></td>
        <td><?php echo $rows[$i]["report_name"]; ?></td>
        <td><?php echo $rows[$i]["report_duration"]; ?></td>
        <td><?php echo $rows[$i]["report_summary"]; ?></td>
        <td><?php if(!empty($rows[$i]["report_file"])) { ?>
          <a href="<?php echo $rows[$i]["report_path"].$rows[$i]["report_file"]; ?>" target="_blank">Файл татах</a>
          <?php } ?></td>
        <td><a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=more&report_id=" . $rows[$i]["report_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&report_id=".$rows[$i]["report_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=reportdelete&report_id=".$rows[$i]["report_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a></td>
      </tr>
      <?php
		}
				
		if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2))
		{		
		?>
      <tr>
        <td colspan="7"><a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=select"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a></td>
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
