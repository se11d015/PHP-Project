<?php
if (isset($_POST["searchtreebttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$tree_name_mn = (isset($_POST["tree_name_mn"])) ? pg_prep($_POST["tree_name_mn"]) : "";
	
	if(empty($tree_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tct.tree_name_mn) LIKE lower('%".$tree_name_mn."%')";
		$search_url .= "&tree_name_mn=".$tree_name_mn;
	}
} 

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"])) 
{
    if ($_GET["sort"] == 2) 
	{
        $sortQuery .= " tct.science_name";
    } else if ($_GET["sort"] == 3) 
	{
        $sortQuery .= " tct.tree_name_mn";
    } else if ($_GET["sort"] == 4) 
	{
        $sortQuery .= " tct.tree_name_en";
    } else if ($_GET["sort"] == 5) 	
	{
		$sortQuery .= " tct.tree_name_ru";
    } else
	{
		$sortQuery .= " tct.tree_code";		
	}
} else 
{
    $sortQuery .= " tct.tree_id";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".tctreetype tct";
$whereQuery = "WHERE tct.tree_id = tct.tree_id";
		
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];

$maxpage = ceil( $sum / $count);

require("tctreetype/inc.search_treetype.php");

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");
?>

<div class="table-responsive">
  <table id="forestresource_datatables" class="table table-bordered table-hover" title_name="<?php echo _p("ReferenceSubTitle2"); ?>" file_name="treetype" column_name="0, 1, 2, 3, 4, 5" language_name="<?php echo $language_name;?>" page_count="<?php echo $count;?>">
    <thead>
      <tr>
        <th colspan="7"><form class="form-inline pull-right" action="<?php echo $my_count.$search_url.$sort_url; ?>" method="post" name="changeform" id="changeform">
		  <label class="mr-2"><?php echo _p("ShowRowsText");?></label>
		  <?php echo seldata("count", "form-control", $RECORD_COUNTS, $count, ""); ?>
        </form></th>
      </tr>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ReferenceSub2Column1");?></a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ReferenceSub2Column2");?></a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ReferenceSub2Column3");?></a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ReferenceSub2Column4");?></a></th>
        <th><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ReferenceSub2Column5");?></a></th>
        <th><?php echo _p("Operation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page-1)*$count;
		$startQuery = "SELECT";		
		$valueQuery = "tct.* FROM ".$schemas.".tctreetype tct";
		$whereQuery = "WHERE tct.tree_id = tct.tree_id";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
	
		$rows = $db->query($selQuery);
		
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["tree_code"]; ?></td>
        <td><?php echo $rows[$i]["science_name"]; ?></td>
        <td><?php echo $rows[$i]["tree_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["tree_name_en"]; ?></td>
        <td><?php echo $rows[$i]["tree_name_ru"]; ?></td>
        <td><?php 
			if($sess_profile==1)
			{ 
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&tree_id=".$rows[$i]["tree_id"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&tree_id=".$rows[$i]["tree_id"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a>
          <?php
			}
			?></td>
      </tr>
      <?php
		}
		?>
    </tbody>
  </table>
  <table>
    <tbody>
      <tr>
        <td><?php 
		if($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 10, 2)) {
		?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=add"; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a>
          <?php 
		}
		?></td>
      </tr>
    </tbody>
  </table>  
  <?php
	require("pagination/inc.pagination1.php");
	pagelink1($count, $maxpage, $my_url, $page, $search_url.$sort_url);
	?>
</div>
