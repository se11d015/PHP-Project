<?php
if (isset($_POST["searchherbariumbttn"])) 
{

	$searchQuery = "";
	$search_url = "";
	
	$collected_date = (isset($_POST["collected_date"])) ? (int) $_POST["collected_date"] : 0;
	$herbarium_type = (isset($_POST["herbarium_type"])) ? (int) $_POST["herbarium_type"] : 0;
	$species_name_mn = (isset($_POST["species_name_mn"])) ? $_POST["species_name_mn"] : "";
	$species_name = (isset($_POST["species_name"])) ? $_POST["species_name"] : "";
	$class_name_mn = (isset($_POST["class_name_mn"])) ? $_POST["class_name_mn"] : "";
	$family_name_mn = (isset($_POST["family_name_mn"])) ? $_POST["family_name_mn"] : "";
	$order_name_mn = (isset($_POST["order_name_mn"])) ? $_POST["order_name_mn"] : "";
	
	if($herbarium_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND tgph.herbarium_type = ".$herbarium_type;
	    $search_url .= "&herbarium_type=".$herbarium_type;
	}

	if(empty($class_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%".$class_name_mn."%')";
		$search_url .= "&class_name_mn=".$class_name_mn;
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

	if(empty($order_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(taon.order_name_mn) LIKE lower('%".$order_name_mn."%')";
		$search_url .= "&order_name_mn=".$order_name_mn;
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
	
	if($collected_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgph.collected_date) = ".$collected_date;
		$search_url .= "&collected_date=".$collected_date;
	}

}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"])) 
{
 	if ($_GET["sort"]==1)
	{
		$sortQuery .= " tacn.class_name_mn";
	}elseif ($_GET["sort"]==2)
	{
		$sortQuery .= " taon.order_name_mn";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " tafn.family_name_mn";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tagn.genus_name";
	}elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " tapl.species_name_mn";
		
	}elseif ($_GET["sort"] == 6) {  
	
		$sortQuery .= "tgph.collected_date";
		
	}elseif ($_GET["sort"] == 7) {
    	$sortQuery .= "tgph.herbarium_type";
	} 
	else {
    	$sortQuery .= " tgph.herbarium_id";
	}
} else {
	$sortQuery .= " tgph.herbarium_id";
}

if (isset($_GET["sorttype"])) 
{
	if ($_GET["sorttype"] == 2) 
	{
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

if (isset($_GET["sort"]) && isset($_GET["sorttype"])) 
{
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas . ".tganimalherbarium tgph,".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn,".$schemas.".tafamilyname tafn,".$schemas.".taordername taon,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl";
		$whereQuery = "WHERE tgph.herbarium_id=tgph.herbarium_id AND tapl.species_code = tgph.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code";

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery . " " . $searchQuery;
$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
	
$count = 10;
$maxpage = ceil( $sum / $count);

require("tganimalherbarium/inc.search_animalherbariumform.php");

$notify = "<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="9"><span class="title"><?php echo getdata($ITEM_TYPE, 15); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th class="span4"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Ангийн монгол нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн монгол нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Овгийн монгол нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Амьтны латин нэр</a></th>
        <th class="span6"><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Амьтны монгол нэр</a></th>
        <th class="span6"><a href="<?php echo $my_url . "&sort=6&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Цуглуулга хийсэн огноо</a></th>
        <th class="span4"><a href="<?php echo $my_url . "&sort=7&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Цуглуулгын төрөл</a></th>
        <th class="span2">Үйлдэл</th>
      </tr>
    </thead>
    <tbody>
      <?php
	    $startQuery = "SELECT";
		$limit = $count . " OFFSET " . ($page - 1) * $count;

		$valueQuery = "tgph.*, tacn.class_name_mn, tafn.family_name_mn, taon.order_name_mn, tagn.genus_name, tagn.genus_name_mn, tapl.species_name_mn, tapl.species_name  FROM ".$schemas . ".tganimalherbarium tgph,".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn,".$schemas.".tafamilyname tafn,".$schemas.".taordername taon,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl";
		$whereQuery = "WHERE tgph.herbarium_id=tgph.herbarium_id AND tapl.species_code = tgph.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code";
		
		$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery . " " . $searchQuery . " " . $sortQuery . " LIMIT " . $limit;
		$rows = $db->query($selQuery);
		for ($i = 0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page - 1) * $count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["class_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["order_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["family_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["species_name"]; ?></td>
        <td><?php echo $rows[$i]["species_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["collected_date"]; ?></td>
        <td><?php echo getdata($HERBARIUM_TYPE, $rows[$i]["herbarium_type"]); ?></td>
        <td align="center"><a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=more&herbarium_id=" . $rows[$i]["herbarium_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>
          <?php
			if ($sess_profile == 1) {
			?>
          <a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=edit&herbarium_id=" . $rows[$i]["herbarium_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url . $search_url . $sort_url . "&action=delete&herbarium_id=" . $rows[$i]["herbarium_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a>
          <?php
            } else if ($rows[$i]["user_id"] == $sess_user_id) {
            ?>
          <a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=edit&herbarium_id=" . $rows[$i]["herbarium_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url . $search_url . $sort_url . "&action=delete&herbarium_id=" . $rows[$i]["herbarium_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a></td>
        <?php
            }
            ?>
        </td>
      </tr>
      <?php
        }

        if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) 
		{
        ?>
      <tr>
        <td colspan="9"><a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a></td>
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
