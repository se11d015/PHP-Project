<?php
if (isset($_POST["searchclassbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$class_name = (isset($_POST["class_name"])) ?  $_POST["class_name"] : "";
	$class_name_mn = (isset($_POST["class_name_mn"])) ? $_POST["class_name_mn"] : "";
	$phylum_name_mn = (isset($_POST["phylum_name_mn"])) ?  $_POST["phylum_name_mn"] : "";
	
	if(empty($phylum_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapn.phylum_name_mn) LIKE lower('%".$phylum_name_mn."%')";
		$search_url .= "&phylum_name_mn=".$phylum_name_mn;
	}
	
	if(empty($class_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tacn.class_name) LIKE lower('%".$class_name."%')";
		$search_url .= "&class_name=".$class_name;
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
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==2)
	{
		$sortQuery .= " tacn.class_name_mn";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " tapn.phylum_name_mn";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tapn.phylum_name";
	}elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " takn.kingdom_name_mn";
	}elseif ($_GET["sort"]==6)
	{
		$sortQuery .= " takn.kingdom_name";
	}else
	{
		$sortQuery .= " tacn.class_name";
	}
}else
{
	$sortQuery .= " tacn.class_code";
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
	$sorttype = 1;
	$sortQuery .= " ASC";
}

$startQuery = "SELECT";
$valueQuery = "tacn.*, tapn.phylum_name, tapn.phylum_name_mn, takn.kingdom_name, takn.kingdom_name_mn FROM ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
$whereQuery = "WHERE tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code = takn.kingdom_code";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;

$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);
?>

<div class="list-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th><span class="title"><?php echo getdata($ITEM_TYPE, 3); ?></span></th>
      </tr>
    </thead>
    <thead>
  </table>
  <?php
	require("includes/taclassname/inc.search_classname.php");	

	$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
	show_notification("info", "", $notify);
	
	if(!empty($rows))
	{
		require("includes/taclassname/inc.title_classname.php");
			
		if($ltype==1) 
		{				
	?>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Аймгийн монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хүрээний монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Ангийн монгол нэр</a></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		
		$startQuery = "SELECT";
		$valueQuery = "tacn.*, tapn.phylum_name, tapn.phylum_name_mn, takn.kingdom_name, takn.kingdom_name_mn FROM ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
		$whereQuery = "WHERE tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code = takn.kingdom_code";

		$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;

		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["kingdom_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["phylum_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["class_name_mn"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url."&action=more&class_id=".$rows[$i]["class_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a></td>
      </tr>
      <?php 
		}	
		?>
    </tbody>
  </table>
  <?php
  		} else {
	?>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Аймгийн латин нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хүрээний латин нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Ангийн латин нэр</a></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
		
		$startQuery = "SELECT";
		$valueQuery = "tacn.*, tapn.phylum_name, tapn.phylum_name_mn, takn.kingdom_name, takn.kingdom_name_mn FROM ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
		$whereQuery = "WHERE tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code = takn.kingdom_code";

		$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;

		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["kingdom_name"]; ?></td>
        <td><?php echo $rows[$i]["phylum_name"]; ?></td>
        <td><?php echo $rows[$i]["class_name"]; ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url."&action=more&class_id=".$rows[$i]["class_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a></td>
      </tr>
      <?php 
		}	
		?>
    </tbody>
  </table>
  <?php		
		}
		
		require("pagination/inc.pagination1.php");
		pagelink1($count, $maxpage, $my_url, $page, $search_url.$list_url.$sort_url);
	}
	?>
</div>
