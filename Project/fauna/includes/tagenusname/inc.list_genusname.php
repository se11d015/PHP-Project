<?php
if (isset($_POST["searchgenusbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$genus_name = (isset($_POST["genus_name"])) ?  $_POST["genus_name"] : "";
	$genus_name_mn = (isset($_POST["genus_name_mn"])) ? $_POST["genus_name_mn"] : "";
	$family_name_mn = (isset($_POST["family_name_mn"])) ? $_POST["family_name_mn"] : "";
	$order_name_mn = (isset($_POST["order_name_mn"])) ? $_POST["order_name_mn"] : "";
	$class_name_mn = (isset($_POST["class_name_mn"])) ? $_POST["class_name_mn"] : "";

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
		$searchQuery .= " AND (lower(taon.order_name_mn) LIKE lower('%".$order_name_mn."%') OR lower(taon.alternative_name) LIKE lower('%".$order_name_mn."%'))";
		$search_url .= "&order_name_mn=".$order_name_mn;
	}

	if(empty($family_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tafn.family_name_mn) LIKE lower('%".$family_name_mn."%') OR lower(tafn.alternative_name) LIKE lower('%".$family_name_mn."%'))";
		$search_url .= "&family_name_mn=".$family_name_mn;
	}
		
	if(empty($genus_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%".$genus_name."%') OR lower(tagn.synonyms_name) LIKE lower('%".$genus_name."%') OR lower(tagn.basionum_name) LIKE lower('%".$genus_name."%') )";
		$search_url .= "&genus_name=".$genus_name;
	}
	
	if(empty($genus_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%".$genus_name_mn."%') OR lower(tagn.synonyms_name) LIKE lower('%".$genus_name_mn."%') OR lower(tagn.basionum_name) LIKE lower('%".$genus_name_mn."%') )";
		$search_url .= "&genus_name_mn=".$genus_name_mn;
	}
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==2)
	{
		$sortQuery .= " tagn.genus_name_mn";
	}elseif ($_GET["sort"]==3)
	{
		$sortQuery .= " tafn.family_name_mn";
	}elseif ($_GET["sort"]==4)
	{
		$sortQuery .= " tafn.family_name";
	}elseif ($_GET["sort"]==5)
	{
		$sortQuery .= " taon.order_name_mn";
	}elseif ($_GET["sort"]==6)
	{
		$sortQuery .= " taon.order_name";	
	}elseif ($_GET["sort"]==7)
	{
		$sortQuery .= " tacn.class_name_mn";
	}elseif ($_GET["sort"]==8)
	{
		$sortQuery .= " tacn.class_name";	
	}elseif ($_GET["sort"]==9)
	{
		$sortQuery .= " tapn.phylum_name_mn";	
	}elseif ($_GET["sort"]==10)
	{
		$sortQuery .= " tapn.phylum_name";	
	}elseif ($_GET["sort"]==11)
	{
		$sortQuery .= " takn.kingdom_name_mn";
	}elseif ($_GET["sort"]==12)
	{
		$sortQuery .= " takn.kingdom_name";				
	}else
	{
		$sortQuery .= " tagn.genus_name";
	}
}else
{
	$sortQuery .= " tagn.genus_code";
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
$valueQuery = "tagn.*, tafn.family_name_mn, tafn.family_name, taon.order_name_mn, taon.order_name, tacn.class_name, tacn.class_name_mn, tapn.phylum_name, tapn.phylum_name_mn, takn.kingdom_name, takn.kingdom_name_mn FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
$whereQuery = "WHERE tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
//echo $selQuery;
$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);

?>

<div class="list-table">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th><span class="title"><?php echo getdata($ITEM_TYPE, 6); ?></span></th>
      </tr>
    </thead>
    <thead>
  </table>
  <?php
    require("includes/tagenusname/inc.title_list_genusname.php");
	require("includes/tagenusname/inc.search_genusname.php");
	
	$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
	show_notification("info", "", $notify);

	if(!empty($rows))
	{
		require("includes/tagenusname/inc.title_genusname.php");	
			
		if($ltype==1) 
		{		
	?>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=9&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хүрээний монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=7&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Ангийн монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Овгийн монгол нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Төрлийн монгол нэр</a></th>      
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page-1)*$count;

		$startQuery = "SELECT";
		$valueQuery = "tagn.*, tafn.family_name_mn, tafn.family_name, taon.order_name_mn, taon.order_name, tacn.class_name, tacn.class_name_mn, tapn.phylum_name, tapn.phylum_name_mn, takn.kingdom_name, takn.kingdom_name_mn FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
		$whereQuery = "WHERE tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

		
		$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;

		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["phylum_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["class_name_mn"]; ?></td>        
        <td><?php echo $rows[$i]["order_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["family_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["genus_name_mn"]; ?></td> 
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url."&action=more&genus_id=".$rows[$i]["genus_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a></td>
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
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=10&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хүрээний латин нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=8&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Ангийн латин нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Багийн латин нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Овгийн латин нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url.$list_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Төрлийн латин нэр</a></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page-1)*$count;

		$startQuery = "SELECT";
		$valueQuery = "tagn.*, tafn.family_name_mn, tafn.family_name, taon.order_name_mn, taon.order_name, tacn.class_name, tacn.class_name_mn, tapn.phylum_name, tapn.phylum_name_mn, takn.kingdom_name, takn.kingdom_name_mn FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
		$whereQuery = "WHERE tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

		
		$selQuery = $startQuery." ".$valueQuery."  ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		//echo $selQuery;

		$rows = $db->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["phylum_name"]; ?></td>
        <td><?php echo $rows[$i]["class_name"]; ?></td>        
        <td><?php echo $rows[$i]["order_name"]; ?></td>
        <td><?php echo $rows[$i]["family_name"]; ?></td>
        <td><?php echo $rows[$i]["genus_name"]; ?></td> 
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url."&action=more&genus_id=".$rows[$i]["genus_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a></td>
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
