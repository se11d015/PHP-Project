<?php
if (isset($_POST["searchanimalstatusbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$species_name_mn = (isset($_POST["species_name_mn"])) ? $_POST["species_name_mn"] : "";
	$species_name = (isset($_POST["species_name"])) ? $_POST["species_name"] : "";
	$class_name_mn = (isset($_POST["class_name_mn"])) ? $_POST["class_name_mn"] : "";
	$family_name_mn = (isset($_POST["family_name_mn"])) ? $_POST["family_name_mn"] : "";
	$order_name_mn = (isset($_POST["order_name_mn"])) ? $_POST["order_name_mn"] : "";
	$reference_code = (isset($_POST["reference_code"])) ? (int) $_POST["reference_code"] : 0;
		
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
	if($reference_code==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND taps.reference_code = ".$reference_code;
		$search_url .= "&reference_code=".$reference_code;
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
	}	
	elseif ($_GET["sort"]==5)
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
	}	
	elseif ($_GET["sort"]==15)
	{
		$sortQuery .= " tapl.species_name";
	}
	elseif ($_GET["sort"]==6)
	{
		$sortQuery .= " tcrn.reference_name";
	}else
	{
		$sortQuery .= " taps.status_id";
}
}else
{
	$sortQuery .= " taps.status_id";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn,".$schemas.".tafamilyname tafn,".$schemas.".taordername taon,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl,".$schemas.".taanimalstatus taps, ".$schemas.".tcreferencestatus tcrn ";
$whereQuery = "WHERE tapl.species_code = taps.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taps.status_id = taps.status_id AND taps.reference_code=tcrn.reference_code";

$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery;
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
        <th><span class="title"><?php echo getdata($ITEM_TYPE, 12); ?></span></th>
      </tr>
    </thead>
  </table>
  <?php  
	require("includes/taanimalstatus/inc.search_animalstatus.php");
	
	$notify = "<strong>Нийт $sum бичлэг байна.</strong>";
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
        <th class="span3"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Ангийн монгол нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн монгол нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Овгийн монгол нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Амьтны монгол нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Төлөв байдлын нэр</a></th>
        <th class="span2"></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		
		$startQuery = "SELECT";
		$valueQuery = "taps.*, tacn.class_name_mn, tafn.family_name_mn, taon.order_name_mn, tagn.genus_name, tagn.genus_name_mn, tapl.species_name_mn, tapl.species_name, tcrn.reference_name  FROM ".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn,".$schemas.".tafamilyname tafn,".$schemas.".taordername taon,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl,".$schemas.".taanimalstatus taps, ".$schemas.".tcreferencestatus tcrn ";
		$whereQuery = "WHERE tapl.species_code = taps.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taps.status_id = taps.status_id AND taps.reference_code=tcrn.reference_code";

		$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
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
        <td><?php echo $rows[$i]["reference_name"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url."&action=more&status_id=".$rows[$i]["status_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a> </td>
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
        <th class="span3"><a href="<?php echo $my_url."&sort=11&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Ангийн латин нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=12&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн латин нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=13&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Овгийн латин нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=15&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Амьтны латин нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Төлөв байдлын нэр</a></th>
        <th class="span2"></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		
		$startQuery = "SELECT";
		$valueQuery = "taps.*, tacn.class_name, tafn.family_name, taon.order_name, tagn.genus_name, tapl.species_name, tcrn.reference_name  FROM ".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn,".$schemas.".tafamilyname tafn,".$schemas.".taordername taon,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl,".$schemas.".taanimalstatus taps, ".$schemas.".tcreferencestatus tcrn ";
		$whereQuery = "WHERE tapl.species_code = taps.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taps.status_id = taps.status_id AND taps.reference_code=tcrn.reference_code";

		$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
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
        <td><?php echo $rows[$i]["reference_name"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url."&action=more&status_id=".$rows[$i]["status_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a> </td>
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
