<?php
if (isset($_POST["searchorderbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$order_name = (isset($_POST["order_name"])) ?  $_POST["order_name"] : "";
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
	
	if(empty($order_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taon.order_name) LIKE lower('%".$order_name."%') OR lower(taon.alternative_name) LIKE lower('%".$order_name."%'))";
		$search_url .= "&order_name=".$order_name;
	}
	
	if(empty($order_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taon.order_name_mn) LIKE lower('%".$order_name_mn."%') OR lower(taon.alternative_name) LIKE lower('%".$order_name_mn."%') )";
		$search_url .= "&order_name_mn=".$order_name_mn;
	}
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==2)
	{
		$sortQuery .= " taon.order_name";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " taon.order_name_mn";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tapn.phylum_name_mn";
	}else
	{
		$sortQuery .= " taon.order_code";
	}
}else
{
	$sortQuery .= " taon.order_id";
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
$valueQuery = "taon.*, tapn.phylum_name_mn FROM ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
$whereQuery = "WHERE taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
//echo $selQuery;
$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);

require("inc.search_ordernameform.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="7"><span class="title"><?php echo getdata($ITEM_TYPE, 4); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хүрээний монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн код</a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн латин нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн монгол нэр</a></th>
        <th>Багийн англи нэр</th>
        <th>Үйлдэл</th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page-1)*$count;

		$startQuery = "SELECT";
		$valueQuery = "taon.*, tapn.phylum_name_mn, tacn.class_name_mn FROM ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
		$whereQuery = "WHERE taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

		$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;

		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["phylum_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["order_code"]; ?></td>
        <td><?php echo $rows[$i]["order_name"]; ?></td>
        <td><?php echo $rows[$i]["order_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["order_name_en"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&order_id=".$rows[$i]["order_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a><?php 
			if($sess_profile==1)
			{ 
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&order_id=".$rows[$i]["order_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&order_id=".$rows[$i]["order_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a>
          <?php
			} else if($rows[$i]["user_id"]==$sess_user_id)
			{
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&order_id=".$rows[$i]["order_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&order_id=".$rows[$i]["order_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a>
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
        <td colspan="7"><a class="btn btn-danger" href="<?php echo $my_url.$search_url.$sort_url."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a> </td>
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
