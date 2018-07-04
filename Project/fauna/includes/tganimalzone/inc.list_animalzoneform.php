<?php

if (isset($_POST["searchanimalzonebttn"]))
{
	$searchQuery = "";
	$search_url = "";
	

	$zone_year = (isset($_POST["zone_year"])) ? $_POST["zone_year"] : 0;
	$species_names = (isset($_POST["species_names"])) ? $_POST["species_names"] : "";
	$aimag_name_mn = (isset($_POST["aimag_name_mn"])) ? $_POST["aimag_name_mn"] : "";
    $soum_name_mn = (isset($_POST["soum_name_mn"])) ? $_POST["soum_name_mn"] : "";
	$class_name_mn = (isset($_POST["class_name_mn"])) ? $_POST["class_name_mn"] : "";
	$zone_name = (isset($_POST["zone_name"])) ? $_POST["zone_name"] : "";
	
	if(empty($zone_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgazo.zone_name) LIKE lower('%".$zone_name."%')";
		$search_url .= "&zone_name=".$zone_name;
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

	if(empty($species_names))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgazo.species_names) LIKE lower('%".$species_names."%') ";
		$search_url .= "&species_names=".$species_names;
	}

    if($zone_year==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{  
		$searchQuery .= " AND tgazo.zone_year = ".$zone_year;
		$search_url .= "&zone_year=".$zone_year;
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
if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==1)
	{
		$sortQuery .= " tacn.class_name_mn";
	}elseif ($_GET["sort"]==2)
	{
		$sortQuery .= " tgazo.species_names";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " taaim.aimag_name_mn";
	}
	elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tasou.soum_name_mn";
	}
	elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " tgazo.zone_name";
	}
	elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " tgazo.zone_year";
	}
	else
	{
		$sortQuery .= " tgazo.class_code";
}
}else
{
	$sortQuery .= " tgazo.gid";
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
        $startQuery = "SELECT ";
		$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".tganimalzone tgazo, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn";
$whereQuery = "WHERE  tgazo.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taaim.aimag_code=tgazo.aimag_name AND tasou.soum_code=tgazo.soum_name";
?>
<div class="list-table">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th><span class="title"><?php echo getdata($ITEM_TYPE, 19); ?></span></th>
      </tr>
    </thead>
  </table>
<?php
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
//echo $selQuery;
$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
	
$count = 10;
$maxpage = ceil( $sum / $count);

require("inc.search_animalzoneform.php");

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
	
?>

  <table class="table table-bordered table-striped table-hover">  
    <thead>
      <tr>
        <th class="span1">№</th>
        <th class="span4"><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i>Ангийн монгол нэр</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i>Зүйлийн нэрc</a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i>Аймгийн нэр </a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i>Сумын нэр </a></th>
        <th class="span4"><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i>Бүсийн нэр</a></th>
		<th class="span6"><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="  icon-tag icon-white"></i>Бүсийн зургийг хийсэн он</a></th> 
        <th class="span1"></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT ";
		$valueQuery = "tgazo.*, tacn.class_name_mn, taaim.aimag_name_mn, tasou.soum_name_mn  FROM ".$schemas.".tganimalzone tgazo, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn";
        $whereQuery = "WHERE  tgazo.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taaim.aimag_code=tgazo.aimag_name AND tasou.soum_code=tgazo.soum_name";

			$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
			//echo $selQuery;
			$rows = $db->query($selQuery);
		
			for ($i=0; $i < sizeof($rows); $i++) 
			{
			?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["class_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["species_names"]; ?></td>
        <td><?php echo $rows[$i]["aimag_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["zone_name"]; ?></td>
		<td><?php echo $rows[$i]["zone_year"]; ?></td>
		
	<td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url."&action=more&gid=".$rows[$i]["gid"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>         
        </td>
      </tr>
      <?php
			}	
			?>
    </tbody>
  </table>
		
  <?php
	require("pagination/inc.pagination1.php");
	pagelink1($count, $maxpage, $my_url, $page, $search_url.$list_url.$sort_url);
	
	?>
</div>
