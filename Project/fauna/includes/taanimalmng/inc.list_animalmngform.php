<?php
if (isset($_POST["searchmngbttn"])) {

$searchQuery = "";
$search_url = "";

$doc_date = (isset($_POST["doc_date"])) ? (int) $_POST["doc_date"] : 0;
$aimag_name_mn = (isset($_POST["aimag_name_mn"])) ? $_POST["aimag_name_mn"] : "";
$zone_name = (isset($_POST["zone_name"])) ? $_POST["zone_name"] : "";
$type_id = (isset($_POST["type_id"])) ? $_POST["type_id"] : 0;

if(empty($type_id))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND taamn.doc_type=".$type_id;
		$search_url .= "&doc_type=".$type_id;
	}

	if($doc_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',taamn.doc_date) = ".$doc_date;
		$search_url .= "&doc_date=".$doc_date;
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
	
	if(empty($zone_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
	
		$searchQuery .= " AND lower(tganz.zone_name) LIKE lower('%".$zone_name."%')";
		$search_url .= "&zone_name=".$zone_name;
	}

}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"])) {
 if ($_GET["sort"]==1)
	{ 
		$sortQuery .= "taaim.aimag_name_mn";		
	} elseif ($_GET["sort"] == 2) {
    $sortQuery .= "tasou.soum_name_mn";
	}
	  elseif ($_GET["sort"] == 3) {
    $sortQuery .= "tganz.zone_name";
	} elseif ($_GET["sort"] == 4) {
    $sortQuery .= "taamn.doc_type";
	} elseif ($_GET["sort"] == 5) {
	$sortQuery .= "taamn.doc_date";
	} 
} else {
$sortQuery .= " taamn.doc_id";
}

if (isset($_GET["sorttype"])) {
if ($_GET["sorttype"] == 2) {
    $sorttype = 1;
    $sortQuery .= " ASC";
} else {
    $sorttype = 2;
    $sortQuery .= " DESC";
}
} else {
$sorttype = 2;
$sortQuery .= " DESC";
}

if (isset($_GET["sort"]) && isset($_GET["sorttype"])) {
$sort_url = "";
$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;

if ($sort == 0)
    $sort_url .= "";
else
    $sort_url .= "&sort=" . $sort;

if ($sort_type == 0)
    $sort_url .= "";
else
    $sort_url .= "&sorttype=" . $sort_type;
}
$startQuery = "SELECT";
$valueQuery = "COUNT(*) AS num_count FROM scfauna.tganimalzone tganz, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas . ".tcfiletype tcfty, ".$schemas . ".taanimalmng taamn ";
		$whereQuery = "WHERE taaim.aimag_code=tganz.aimag_name AND tasou.soum_code=tganz.soum_name AND taamn.zone_name=tganz.gid AND taamn.doc_id=taamn.doc_id AND taamn.doc_type=tcfty.type_id";
$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery . " " . $searchQuery;

$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
$count = 10;
$maxpage = ceil( $sum / $count);


require("includes/taanimalmng/inc.search_animalmngform.php");
$notify = "<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="9"><span class="title"><?php echo getdata($ITEM_TYPE, 120); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th >№</th>
        <th class="span4"><a href="<?php echo $my_url . "&sort=1&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Аймгийн нэр </a></th>
		<th class="span4"><a href="<?php echo $my_url . "&sort=2&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Сумын нэр </a></th>
        <th class="span4"><a href="<?php echo $my_url . "&sort=3&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Бүсийн нэр</a></th>
		<th class="span4"><a href="<?php echo $my_url . "&sort=4&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Баримт бичгийн төрөл</a></th>
        <th class="span4"><a href="<?php echo $my_url . "&sort=5&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Баримт бичгийн боловсруулсан огноо</a></th>	
        <th class="span4">Төлөвлөгөөний файл</th>
		<th class="span4">Үйлдэл</th>
      </tr>
    </thead>
    <tbody>
      <?php
	    $startQuery = "SELECT";
		$limit = $count . " OFFSET " . ($page - 1) * $count;

		$valueQuery = "taamn.*, tganz.zone_name as zone_name_mn, taaim.aimag_name_mn, tasou.soum_name_mn, tcfty.type_name  FROM scfauna.tganimalzone tganz, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas . ".tcfiletype tcfty, ".$schemas . ".taanimalmng taamn ";
		$whereQuery = "WHERE taaim.aimag_code=tganz.aimag_name AND tasou.soum_code=tganz.soum_name AND taamn.zone_name=tganz.gid AND taamn.doc_id=taamn.doc_id AND taamn.doc_type=tcfty.type_id";
$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery . " " . $searchQuery . " " . $sortQuery . " LIMIT " . $limit;

$rows = $db->query($selQuery);
for ($i = 0; $i < sizeof($rows); $i++) {
?>
      <tr>
        <td><?php echo (($page - 1) * $count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["aimag_name_mn"]; ?></td>
		<td><?php echo $rows[$i]["soum_name_mn"]; ?></td>		
       <td><?php echo $rows[$i]["zone_name_mn"]; ?></td>
	   <td><?php echo $rows[$i]["type_name"]; ?></td>
	   <td><?php echo $rows[$i]["doc_date"]; ?></td>
	   <td><?php if(strlen($rows[$i]["doc_filename"])>0) { ?>
        <a href="<?php echo $rows[$i]["doc_pathname"]."/".$rows[$i]["doc_filename"]; ?>" target="_blank">Файл харах</a>&nbsp;
        <?php } ?></td>
        <td align="center"><a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=more&doc_id=" . $rows[$i]["doc_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>
          </td>
      </tr>
      <?php
        }
        ?>
    </tbody>
  </table>
  <?php
require("pagination/inc.pagination1.php");
pagelink1($count, $maxpage, $my_url, $page, $search_url . $sort_url);
?>
</div>
