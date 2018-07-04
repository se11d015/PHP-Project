<?php
if (isset($_POST["searchanimalorgpermissionbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$org_name = (isset($_POST["org_name"])) ? $_POST["org_name"] : "";	
	$aimag_code = (isset($_POST["aimag_code"])) ? (int) $_POST["aimag_code"]: 0;
	$permission_number = (isset($_POST["permission_number"])) ? $_POST["permission_number"] : "";
	$end_date = (isset($_POST["end_date"])) ? (int) $_POST["end_date"]: 0;	
	$approved_date = (isset($_POST["approved_date"])) ? (int) $_POST["approved_date"]: 0;
	$type_name = (isset($_POST["type_name"])) ? $_POST["type_name"]: "";	
	
	if(empty($type_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapp.activity_name) LIKE lower('%".$type_name."%')";
		$search_url .= "&type_name=".$type_name;
	}
	
	if(empty($org_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgpo.org_name) LIKE lower('%".$org_name."%')";
		$search_url .= "&org_name=".$org_name;
	}
	
	if($aimag_code==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tgpo.aimag_name = ".$aimag_code;
		$search_url .= "&aimag_code=".$aimag_code;
	}
	
	if(empty($permission_number))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapp.permission_number) LIKE lower('%".$permission_number."%')";
		$search_url .= "&permission_number=".$permission_number;
	}

	if($approved_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND date_part('year',tapp.approved_date) = ".$approved_date;
		$search_url .= "&approved_date=".$approved_date;
	}
	
	if($end_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND date_part('year',tapp.end_date) = ".$end_date;
		$search_url .= "&end_date=".$end_date;
	}
	
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==1)
	{
		$sortQuery .= " tgpo.org_name";		
	}elseif ($_GET["sort"]==2)
	{
		$sortQuery .= " vas.aimag_name_mn";	
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " tapp.approved_date";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tapp.permission_number";	
	}elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " tapp.end_date";
	}elseif ($_GET["sort"]==6)
	{
		$sortQuery .= " tapp.activity_name";
	}else
	{
		$sortQuery .= " tapp.permission_id";
	}
}else
{
	$sortQuery .= " tapp.permission_id";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".taanimalorgpermission tapp, ".$schemas.".tganimalorg tgpo, scadministrative.vasoumname vas";
$whereQuery = "WHERE tapp.org_name = tgpo.org_id AND tgpo.soum_name = vas.soum_code";


$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;

$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
	
$count = 10;
$maxpage = ceil( $sum / $count);


require("taanimalorgpermission/inc.search_animalorgpermissionform.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="10"><span class="title"><?php echo getdata($ITEM_TYPE, 41); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th class="span1">№</th>
        <th class="span4"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Аймаг, сумын нэр</a></th>
        <th class="span3"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Мэргэжлийн байгууллагын нэр </a></th>
        <th class="span3"><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Эрхийн гэрчилгээний дугаар</a></th>
        <th class="span3"><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Эрх олгосон огноо </a></th>
        <th class="span3"><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Эрх дуусах огноо</a></th>
		<th class="span3"><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Эрх авсан чиглэл</a></th>
        <th class="span2"></th>
      </tr>
    </thead>
    <tbody>
      <?php

			$startQuery = "SELECT";
			$limit = $count." OFFSET ".($page-1)*$count;
			$valueQuery = "tapp.*, tgpo.org_name, vas.aimag_name_mn, vas.soum_name_mn FROM ".$schemas.".taanimalorgpermission tapp, ".$schemas.".tganimalorg tgpo, scadministrative.vasoumname vas";
			$whereQuery = "WHERE  tapp.org_name = tgpo.org_id AND tgpo.soum_name = vas.soum_code";	
			
			$selQuery = $startQuery." ".$valueQuery." ".$whereQuery."  ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
//echo $selQuery;
			$rows = $db->query($selQuery);
		
			for ($i=0; $i < sizeof($rows); $i++) 
			{
			?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["aimag_name_mn"]." аймаг,  ".$rows[$i]["soum_name_mn"]." сум"; ?></td>
        <td><?php echo $rows[$i]["org_name"]; ?></td>
        <td><?php echo $rows[$i]["permission_number"]; ?></td>
        <td><?php echo $rows[$i]["approved_date"]; ?></td>
        <td><?php echo $rows[$i]["end_date"]; ?></td>
        <td><?php
			$activity_name = "";
			$fldCode = explode(', ', $rows[$i]["activity_name"]);

			if(is_array($fldCode)){
				for($j=0; $j<sizeof($fldCode); $j++){
					if(!empty($fldCode[$j])){
						$values = $db->query("SELECT tct.type_name FROM ".$schemas.".tcactivitytype tct WHERE tct.type_id = ".$fldCode[$j]."");	
						$activity_name .= (empty($values[0]) ? " ": $values[0]["type_name"].", ");
					}
				}
			}		
			echo $activity_name; 
			?></td>
        <td align="center"><a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=more&permission_id=" . $rows[$i]["permission_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>
          <?php 
				if($sess_profile==1)
				{ 
				?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&permission_id=".$rows[$i]["permission_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&permission_id=".$rows[$i]["permission_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a>
          <?php 
				} else if($rows[$i]["user_id"]==$sess_user_id) {
				?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&permission_id=".$rows[$i]["permission_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&permission_id=".$rows[$i]["permission_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a>
          <?php	
				}
				?></td>
      </tr>
      <?php
		}
				
		if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2))
		{		
		?>
      <tr>
        <td colspan="10"><a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=select"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a></td>
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
