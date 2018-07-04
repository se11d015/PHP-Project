<?php
if (isset($_POST["searchviolationbttn"])) 
{
	$searchQuery = "";
	$search_url = "";

	$saimag_code = (isset($_POST["saimag_code"])) ? (int) $_POST["saimag_code"] : 0;
	$sviolation_year = (isset($_POST["sviolation_year"])) ? (int) $_POST["sviolation_year"] : 0;
	
	if($saimag_code==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND va.aimag_code = ".$saimag_code;
		$search_url .= "&saimag_code=".$saimag_code;
	}
	if($sviolation_year==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND taf.violation_year = ".$sviolation_year;
		$search_url .= "&sviolation_year=".$sviolation_year;
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
		$sortQuery .= " taf.violation_number";
    } else if($_GET["sort"]==5) {
		$sortQuery .= " taf.illegallogging_wood";		
	} else {
        $sortQuery .= " taf.violation_year";
    }
} else {
    $sortQuery .= " taf.violation_year";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".taviolation taf, scadministrative.vasoumname va";
$whereQuery = "WHERE taf.soum_code = va.soum_code";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;

$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
$maxpage = ceil( $sum / $count);

require("includes/taviolation/inc.search_violation.php");	

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");

?>

<div class="table-responsive-md">
  <table id="forestresource_datatables" class="table table-bordered table-hover" title_name="<?php echo _p("ResourceSubTitle8"); ?>" file_name="forestresourcedata" column_name="0, 1, 2, 3, 4, 5" language_name="<?php echo $language_name;?>" page_count="<?php echo $count;?>">
    <thead>
      <tr>
        <th colspan="8"><form class="form-inline pull-right" action="<?php echo $my_count.$search_url.$sort_url; ?>" method="post" name="changeform" id="changeform">
		  <label class="mr-2"><?php echo _p("ShowRowsText");?></label>
		  <?php echo seldata("count", "form-control", $RECORD_COUNTS, $count, ""); ?>
        </form></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub8Column3");?></a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub8Column1");?></a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub8Column2");?></a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub8Column4");?></a></th>
        <th><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub8Column5");?></a></th>			
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page - 1) * $count;
		$startQuery = "SELECT";
		$valueQuery = "taf.violation_id, taf.violation_year, va.aimag_name_mn, va.soum_name_mn, va.aimag_name_en, va.soum_name_en, taf.violation_number, taf.illegallogging_wood FROM ".$schemas.".taviolation taf, scadministrative.vasoumname va";
		$whereQuery = "WHERE taf.soum_code = va.soum_code";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
	
		$rows = $db->query($selQuery);
		
		for ($i = 0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page - 1) * $count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["violation_year"]; ?></td>
        <td><?php echo $rows[$i]["aimag_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["violation_number"]; ?></td>
        <td><?php echo $rows[$i]["illegallogging_wood"]; ?></td>
        <td><a class="btn btn-success" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&violation_id=".$rows[$i]["violation_id"]; ?>" title="<?php echo _p("MoreTitle"); ?>"><?php echo _p("MoreButton"); ?></a></td>
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
