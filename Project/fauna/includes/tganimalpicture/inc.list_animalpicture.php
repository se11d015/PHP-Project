<?php
	
if (isset($_POST["searchanimalpicturebttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$species_name = (isset($_POST["species_name"])) ? $_POST["species_name"] : "";
	$species_name_mn = (isset($_POST["species_name_mn"])) ? $_POST["species_name_mn"] : "";
    $class_name_mn = (isset($_POST["class_name_mn"])) ? $_POST["class_name_mn"] : "";
    $order_name_mn = (isset($_POST["order_name_mn"])) ? $_POST["order_name_mn"] : "";
    $family_name_mn = (isset($_POST["family_name_mn"])) ? $_POST["family_name_mn"] : "";
	$aimag_code = (isset($_POST["aimag_code"])) ? (int) $_POST["aimag_code"] : 0;

	if(empty($class_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%".$class_name_mn."%')";
		$search_url .= "&class_name_mn=".$class_name_mn;
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

	if(empty($family_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tafn.family_name_mn) LIKE lower('%".$family_name_mn."%')";
		$search_url .= "&family_name_mn=".$family_name_mn;
	}	

	if (empty($species_name)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND (lower(tagn.genus_name) LIKE lower('%" . $species_name . "%') OR  lower(tapl.species_name) LIKE lower('%" . $species_name . "%'))";
        $search_url .= "&species_name=" . $species_name;
    }
	
	if (empty($species_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%" . $species_name_mn . "%') OR  lower(tapl.species_name_mn) LIKE lower('%" . $species_name_mn . "%'))";
        $search_url .= "&species_name_mn=" . $species_name_mn;
    }	
	
	if ($aimag_code == 0) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND tganp.aimag_name = " . $aimag_code;
        $search_url .= "&aimag_name=" . $aimag_code;
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
	}elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " tapl.species_name_mn";
	}elseif ($_GET["sort"]==11)
	{
		$sortQuery .= " tacn.class_name";
	}elseif ($_GET["sort"]==12)
	{
		$sortQuery .= " taon.order_name";
	}elseif ($_GET["sort"]==13)
	{
		$sortQuery .= " tafn.family_name";
	}elseif ($_GET["sort"]==15)
	{
		$sortQuery .= " tapl.species_name";
	}elseif ($_GET["sort"]==6)
	{
		$sortQuery .= " taaim.aimag_name_mn";
	}else
	{
		$sortQuery .= " tapl.species_code";
	}
}else
{
	$sortQuery .= " tganp.picture_id";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".tganimalpicture tganp,".$schemas.".takingdomname takn,".$schemas.".taphylumname tadn,".$schemas.".taclassname tacn,".$schemas.".taordername taon,".$schemas.".tafamilyname tafn,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou ";
$whereQuery = "WHERE tganp.picture_id = tganp.picture_id AND tganp.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tadn.phylum_code  AND tadn.kingdom_code=takn.kingdom_code   AND taaim.aimag_code=tganp.aimag_name  AND tasou.soum_code=tganp.soum_name";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
//echo $selQuery;
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
        <th><span class="title"><?php echo getdata($ITEM_TYPE, 18); ?></span></th>
      </tr>
    </thead>
  </table>
  <?php 
	require("includes/tganimalpicture/inc.search_animalpicture.php");
	
	$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
	show_notification("info", "", $notify);
	
		if(!empty($rows))
	{
		require("includes/taanimalname/inc.title_animalname.php");
			
		if($ltype==1) 
		{	
	?>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th class="span1">№</th>
        <th class="span4"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Ангийн монгол нэр </a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн монгол нэр </a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Овгийн монгол нэр </a></th>
        <th class="span8"><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Амьтны монгол нэр </a></th>
        <th class="span6"><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зураг авсан аймгийн нэр</a></th>
        <th class="span4">Зураг авсан сумын нэр</th>
        <th class="span2"></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT";
		$valueQuery = "tganp.*, tacn.class_name_mn, taon.order_name_mn, tafn.family_name_mn,  tapl.species_name_mn,tapl.species_name, taaim.aimag_name_mn, tagn.genus_name, tagn.genus_name_mn, tasou.soum_name_mn  FROM ".$schemas.".tganimalpicture tganp,".$schemas.".takingdomname takn,".$schemas.".taphylumname tadn,".$schemas.".taclassname tacn,".$schemas.".taordername taon,".$schemas.".tafamilyname tafn,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou ";
		$whereQuery = "WHERE tganp.picture_id = tganp.picture_id AND tganp.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tadn.phylum_code  AND tadn.kingdom_code=takn.kingdom_code  AND taaim.aimag_code=tganp.aimag_name  AND tasou.soum_code=tganp.soum_name";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;
		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["class_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["order_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["family_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["species_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["aimag_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_mn"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url."&action=more&picture_id=".$rows[$i]["picture_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a> </td>
      </tr>
      <?php 
		}	
		?>
    </tbody>
  </table>
  <?php 
		} else {		
		?>
		
	<table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th class="span1">№</th>
        <th class="span4"><a href="<?php echo $my_url."&sort=11&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Ангийн латин нэр </a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=12&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн латин нэр </a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=13&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Овгийн латин нэр </a></th>
        <th class="span8"><a href="<?php echo $my_url."&sort=15&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Амьтны латин нэр </a></th>
        <th class="span6"><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Зураг авсан аймгийн нэр</a></th>
        <th class="span4">Зураг авсан сумын нэр</th>
        <th class="span2"></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT";
		$valueQuery = "tganp.*, tacn.class_name, taon.order_name, tafn.family_name,  tapl.species_name, taaim.aimag_name_mn, tagn.genus_name, tasou.soum_name_mn  FROM ".$schemas.".tganimalpicture tganp,".$schemas.".takingdomname takn,".$schemas.".taphylumname tadn,".$schemas.".taclassname tacn,".$schemas.".taordername taon,".$schemas.".tafamilyname tafn,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou ";
		$whereQuery = "WHERE tganp.picture_id = tganp.picture_id AND tganp.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tadn.phylum_code  AND tadn.kingdom_code=takn.kingdom_code  AND taaim.aimag_code=tganp.aimag_name  AND tasou.soum_code=tganp.soum_name";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;
		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["class_name"]; ?></td>
        <td><?php echo $rows[$i]["order_name"]; ?></td>
        <td><?php echo $rows[$i]["family_name"]; ?></td>
        <td><?php echo $rows[$i]["species_name"]; ?></td>
        <td><?php echo $rows[$i]["aimag_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_mn"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url."&action=more&picture_id=".$rows[$i]["picture_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a> </td>
      </tr>
      <?php 
		}	
		?>
    </tbody>
  </table>
		
		<?php 
		} 		
		?>
		
  <?php
	require("pagination/inc.pagination1.php");
	pagelink1($count, $maxpage, $my_url, $page, $search_url.$list_url.$sort_url);
	}
	?>
</div>
