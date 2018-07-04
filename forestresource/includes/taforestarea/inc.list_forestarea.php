<?php
if (isset($_POST["searchforestareabttn"])) 
{
	$searchQuery = "";
	$search_url = "";

	$saimag_code = (isset($_POST["saimag_code"])) ? (int) $_POST["saimag_code"] : 0;
	$sarea_year = (isset($_POST["sarea_year"])) ? (int) $_POST["sarea_year"] : 0;
	
	if($saimag_code==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND va.aimag_code = ".$saimag_code;
		$search_url .= "&saimag_code=".$saimag_code;
	}
	if($sarea_year==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND taf.area_year = ".$sarea_year;
		$search_url .= "&sarea_year=".$sarea_year;
	}	
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"])) 
{
    if ($_GET["sort"] == 2) 
	{
       $sortQuery .= " va.aimag_name_mn";
    } else if($_GET["sort"]==3) {
		$sortQuery .= " va.soum_name_mn";
    } else if($_GET["sort"]==4) {
		$sortQuery .= " forest_area";		
	} else {
        $sortQuery .= " taf.area_year";
    }
} else {
    $sortQuery .= " taf.area_year";
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
$valueQuery = "COUNT(list_count) AS num_count FROM (SELECT COUNT(*) AS list_count FROM ".$schemas.".taforestarea taf, scadministrative.vasoumname va";
$whereQuery = "WHERE taf.soum_code = va.soum_code";
$groupQuery = "GROUP BY taf.soum_code, taf.area_year) AS table_count";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$groupQuery;

$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
$maxpage = ceil( $sum / $count);

require("includes/taforestarea/inc.search_forestarea.php");	

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");

?>

<div class="table-responsive-md">
  <table id="forestresource_datatables" class="table table-bordered table-hover" title_name="<?php echo _p("ResourceSubTitle1"); ?>" file_name="forestresourcedata" column_name="0, 1, 2, 3, 4" language_name="<?php echo $language_name;?>" page_count="<?php echo $count;?>">
    <thead>
      <tr>
        <th colspan="6"><form class="form-inline pull-right" action="<?php echo $my_count.$search_url.$sort_url; ?>" method="post" name="changeform" id="changeform">
		  <label class="mr-2"><?php echo _p("ShowRowsText");?></label>
		  <?php echo seldata("count", "form-control", $RECORD_COUNTS, $count, ""); ?>
        </form></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub1Column3");?></a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub1Column1");?></a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub1Column2");?></a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub1Column4");?></a></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page - 1) * $count;
		$startQuery = "SELECT";
		$valueQuery = "taf.soum_code, taf.area_year, va.aimag_name_mn, va.soum_name_mn, va.aimag_name_en, va.soum_name_en, sum(forest_area) as forest_area FROM ".$schemas.".taforestarea taf, scadministrative.vasoumname va";
		$whereQuery = "WHERE taf.soum_code = va.soum_code";
		$groupQuery = "GROUP BY taf.soum_code, taf.area_year, va.aimag_name_mn, va.soum_name_mn, va.aimag_name_en, va.soum_name_en";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$groupQuery." ".$sortQuery." LIMIT ".$limit;
	
		$rows = $db->query($selQuery);
		
		for ($i = 0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page - 1) * $count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["area_year"]; ?></td>
        <td><?php echo $rows[$i]["aimag_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["forest_area"]; ?></td>
        <td><a class="btn btn-success" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&soum_code=".$rows[$i]["soum_code"]."&area_year=".$rows[$i]["area_year"]; ?>" title="<?php echo _p("MoreTitle"); ?>"><?php echo _p("MoreButton"); ?></a></td>
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
