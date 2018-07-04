<?php
if (isset($_POST["searchcontagionbttn"])) {

$searchQuery = "";
$search_url = "";

$contagion_date = (isset($_POST["contagion_date"])) ? (int) $_POST["contagion_date"] : 0;
$species_name_mn = (isset($_POST["species_name_mn"])) ? $_POST["species_name_mn"] : "";
$species_name = (isset($_POST["species_name"])) ? $_POST["species_name"] : "";
$family_name_mn = (isset($_POST["family_name_mn"])) ? $_POST["family_name_mn"] : "";
$aimag_name_mn = (isset($_POST["aimag_name_mn"])) ? $_POST["aimag_name_mn"] : "";
$soum_name_mn = (isset($_POST["soum_name_mn"])) ? $_POST["soum_name_mn"] : "";
$contagion_name = (isset($_POST["contagion_name"])) ? $_POST["contagion_name"] : "";

if(empty($contagion_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgaco.contagion_name) LIKE lower('%".$contagion_name."%')";
		$search_url .= "&contagion_name=".$contagion_name;
	}

	
	if(empty($family_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
	
		$searchQuery .= " AND lower(tafn.family_name_mn) LIKE lower('%".$family_name_mn."%')";
		$search_url .= "&family_name_mn=".$family_name_mn;
	}	

	if(empty($species_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name_mn) LIKE lower('%".$species_name_mn."%') OR lower(tagn.genus_name_mn) LIKE lower('%".$species_name_mn."%') )";
		$search_url .= "&species_name_mn=".$species_name_mn;
	}
	if(empty($species_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name) LIKE lower('%".$species_name."%') OR lower(tagn.genus_name) LIKE lower('%".$species_name."%') )";
		$search_url .= "&species_name=".$species_name;
	}
	
	if($contagion_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgaco.contagion_date) = ".$contagion_date;
		$search_url .= "&contagion_date=".$contagion_date;
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

}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"])) {
 if ($_GET["sort"]==3)
	{
		$sortQuery .= " tafn.family_name_mn";
	}
	elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tagn.genus_name";
	}
	elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " tapl.species_name_mn";
		
	} elseif ($_GET["sort"] == 6) {  
	
		$sortQuery .= "taaim.aimag_name_mn";
		
	} elseif ($_GET["sort"] == 7) {
    $sortQuery .= "tasou.soum_name_mn";
	}
	  elseif ($_GET["sort"] == 8) {
    $sortQuery .= "tgaco.contagion_date";
	} 
	else {
    $sortQuery .= " tgaco.contagion_id";
}
} else {
$sortQuery .= " tgaco.contagion_id";
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
$valueQuery = "COUNT(*) AS num_count FROM scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas . ".tganimalcontagion tgaco,".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn,".$schemas.".tafamilyname tafn,".$schemas.".taordername taon,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl";
		$whereQuery = "WHERE taaim.aimag_code=tgaco.aimag_name AND tasou.soum_code=tgaco.soum_name AND tgaco.contagion_id=tgaco.contagion_id AND tapl.species_code = tgaco.species_name AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code";

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery . " " . $searchQuery;
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
        <th><span class="title"><?php echo getdata($ITEM_TYPE, 110); ?></span></th>
      </tr>
    </thead>
  </table>
  <?php 

require("includes/tganimalcontagion/inc.search_animalcontagionform.php");
$notify = "<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th >№</th>
       <th class="span4"><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i>Овгийн монгол нэр</a></th>
	   <th class="span4"><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i>Амьтны латин нэр</a></th>
	   <th class="span4"><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i>Амьтны монгол нэр</a></th>
        <th class="span5"><a href="<?php echo $my_url . "&sort=6&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Аймгийн нэр </a></th>
		<th class="span4"><a href="<?php echo $my_url . "&sort=7&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Сумын нэр </a></th>
        <th class="span6"><a href="<?php echo $my_url . "&sort=8&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Халдварт өвчин  гарсан огноо</a></th>
        <th class="span4"><a href="<?php echo $my_url . "&sort=8&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i> Халдварт өвчний нэр</a></th>		
		<th class="span2"></th>
      </tr>
    </thead>
    <tbody>
      <?php
	    $startQuery = "SELECT";
		$limit = $count . " OFFSET " . ($page - 1) * $count;

		$valueQuery = "tgaco.*, taaim.aimag_name_mn, tasou.soum_name_mn, tapn.phylum_name_mn, tafn.family_name_mn, taon.order_name_mn, tagn.genus_name, tagn.genus_name_mn, tapl.species_name_mn, tapl.species_name  FROM scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas . ".tganimalcontagion tgaco,".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn,".$schemas.".tafamilyname tafn,".$schemas.".taordername taon,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl";
		$whereQuery = "WHERE taaim.aimag_code=tgaco.aimag_name AND tasou.soum_code=tgaco.soum_name AND tgaco.contagion_id=tgaco.contagion_id AND tapl.species_code = tgaco.species_name AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code";
		
$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery . " " . $searchQuery . " " . $sortQuery . " LIMIT " . $limit;
//echo $selQuery;
$rows = $db->query($selQuery);
for ($i = 0; $i < sizeof($rows); $i++) {
?>
      <tr>
        <td><?php echo (($page - 1) * $count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["family_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["genus_name"]." ".$rows[$i]["species_name"]; ?></td>
        <td><?php echo $rows[$i]["species_name_mn"]." ".$rows[$i]["genus_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["aimag_name_mn"]; ?></td>
		<td><?php echo $rows[$i]["soum_name_mn"]; ?></td>		
       <td><?php echo $rows[$i]["contagion_date"]; ?></td>
	   <td><?php echo $rows[$i]["contagion_name"]; ?></td>
        <td align="center"><a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=more&contagion_id=" . $rows[$i]["contagion_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>
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
