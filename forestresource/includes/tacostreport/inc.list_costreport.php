<?php
if (isset($_POST["searchcostreportbttn"])) 
{
	$searchQuery = "";
	$search_url = "";

	$saimag_code = (isset($_POST["saimag_code"])) ? (int) $_POST["saimag_code"] : 0;
	$scost_year = (isset($_POST["scost_year"])) ? (int) $_POST["scost_year"] : 0;
	
	if($saimag_code==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND va.aimag_code = ".$saimag_code;
		$search_url .= "&saimag_code=".$saimag_code;
	}
	if($scost_year==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND taf.cost_year = ".$scost_year;
		$search_url .= "&scost_year=".$scost_year;
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
	} else {
        $sortQuery .= " taf.cost_year";
    }
} else {
    $sortQuery .= " taf.cost_year";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".tacostreport taf, scadministrative.vasoumname va";
$whereQuery = "WHERE taf.soum_code = va.soum_code";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;

$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
$maxpage = ceil( $sum / $count);

require("includes/tacostreport/inc.search_costreport.php");	

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");

?>

<div class="table-responsive-md">
  <table id="forestresource_datatables" class="table table-bordered table-hover" title_name="<?php echo _p("ResourceSubTitle9"); ?>" file_name="forestresourcedata" column_name="0, 1, 2, 3, 4, 5" language_name="<?php echo $language_name;?>" page_count="<?php echo $count;?>">
    <thead>
      <tr>
        <th colspan="8"><form class="form-inline pull-right" action="<?php echo $my_count.$search_url.$sort_url; ?>" method="post" name="changeform" id="changeform">
		  <label class="mr-2"><?php echo _p("ShowRowsText");?></label>
		  <?php echo seldata("count", "form-control", $RECORD_COUNTS, $count, ""); ?>
        </form></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub9Column3");?></a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub9Column1");?></a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub9Column2");?></a></th>
        <th><?php echo _p("ResourceSub9Column4");?></th>
        <th><?php echo _p("ResourceSub9Column5");?></th>			
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page - 1) * $count;
		$startQuery = "SELECT";
		$valueQuery = "taf.cost_id, taf.cost_year, va.aimag_name_mn, va.soum_name_mn, va.aimag_name_en, va.soum_name_en, taf.* FROM ".$schemas.".tacostreport taf, scadministrative.vasoumname va";
		$whereQuery = "WHERE taf.soum_code = va.soum_code";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
	
		$rows = $db->query($selQuery);
		
		for ($i = 0; $i < sizeof($rows); $i++) 
		{
		
			$budget = $income = 0;
			
			$budget1 = $rows[$i]["state_reforest"]+$rows[$i]["local_reforest"]+$rows[$i]["other_reforest"];
			$budget2 = $rows[$i]["state_thin_clear"]+$rows[$i]["local_thin_clear"]+$rows[$i]["other_thin_clear"];
			$budget3 = $rows[$i]["state_insect_study"]+$rows[$i]["local_insect_study"]+$rows[$i]["other_insect_study"];
			$budget4 = $rows[$i]["state_insect_control"]+$rows[$i]["local_insect_control"]+$rows[$i]["other_insect_control"];
			$budget5 = $rows[$i]["state_seed_prepare"]+$rows[$i]["local_seed_prepare"]+$rows[$i]["other_seed_prepare"];
			$budget6 = $rows[$i]["state_forest_training"]+$rows[$i]["local_forest_training"]+$rows[$i]["other_forest_training"]; 
			$budget7 = $rows[$i]["state_forest_equipment"]+$rows[$i]["local_forest_equipment"]+$rows[$i]["other_forest_equipment"];
			$budget8 = $rows[$i]["state_other_cost"]+$rows[$i]["local_other_cost"]+$rows[$i]["other_other_cost"];
			$budget = $budget1 + $budget2 + $budget3 + $budget4 + $budget5 + $budget6 + $budget7 + $budget8;
		 
			$income1 = $rows[$i]["state_income_nonforest_product"]+$rows[$i]["local_income_nonforest_product"]+$rows[$i]["other_income_nonforest_product"];
			$income2 = $rows[$i]["state_income_logging"]+$rows[$i]["local_income_logging"]+$rows[$i]["other_income_logging"];
			$income3 = $rows[$i]["state_income_fire_indemnity"]+$rows[$i]["local_income_fire_indemnity"]+$rows[$i]["other_income_fire_indemnity"];
			$income4 = $rows[$i]["state_income_indemnity"]+$rows[$i]["local_income_indemnity"]+$rows[$i]["other_income_indemnity"]; 
			$income5 = $rows[$i]["state_income_seedling"]+$rows[$i]["local_income_seedling"]+$rows[$i]["other_income_seedling"];
			$income = $income1 + $income2 + $income3 + $income4 + $income5; 
		?>
      <tr>
        <td><?php echo (($page - 1) * $count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["cost_year"]; ?></td>
        <td><?php echo $rows[$i]["aimag_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_$language_name"]; ?></td>
        <td><?php echo $budget; ?></td>
        <td><?php echo $income; ?></td>
        <td><a class="btn btn-success" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&cost_id=".$rows[$i]["cost_id"]; ?>" title="<?php echo _p("MoreTitle"); ?>"><?php echo _p("MoreButton"); ?></a></td>
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
