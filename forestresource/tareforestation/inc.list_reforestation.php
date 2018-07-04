<?php
if (isset($_POST["searchreforestationbttn"])) 
{
	$searchQuery = "";
	$search_url = "";

	$sreforest_year = (isset($_POST["sreforest_year"])) ? (int) $_POST["sreforest_year"] : 0;		
	$saimag_code = (isset($_POST["saimag_code"])) ? (int) $_POST["saimag_code"] : 0;

	if($saimag_code==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND vs.aimag_code = ".$saimag_code;
		$search_url .= "&saimag_code=".$saimag_code;
	}
		
	if($sreforest_year==0)
	{
		$searchQuery .= "";
		$search_url .= "";
		
	} else
	{
		$searchQuery .= " AND taf.reforest_year = ".$sreforest_year;
		$search_url .= "&sreforest_year=".$sreforest_year;
	}

	$user_id = (isset($_POST["user_id"])) ? (int) $_POST["user_id"] : 0;
	$group_id = (isset($_POST["group_id"])) ? (int) $_POST["group_id"] : 0;
	
	if($user_id==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND taf.user_id = ".$user_id;
		$search_url .= "&user_id=".$user_id;
	}

	if($group_id==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tug.group_id = ".$group_id;
		$search_url .= "&group_id=".$group_id;
		
		$valueQuery1 = ", ".$schemas.".tausergroups tug";
		$whereQuery1 = " AND taf.user_id = tug.user_id";
	}
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"])) 
{
    if ($_GET["sort"] == 2) 
	{
        $sortQuery .= " vs.aimag_name_mn";
    } else if ($_GET["sort"] == 3) 
	{
        $sortQuery .= " vs.soum_name_mn";
    } else if ($_GET["sort"] == 4) 
	{
        $sortQuery .= " taf.planted_area";
    } else if ($_GET["sort"] == 5) 
	{
        $sortQuery .= " taf.reforestation_percent";		
    } else if ($_GET["sort"] == 6) 
	{
        $sortQuery .= " taf.planted_forest_area";				
    } else
	{
        $sortQuery .= " taf.reforest_year";
    }
} else 
{
    $sortQuery .= " taf.reforest_id";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".tareforestation taf, scadministrative.vasoumname vs";
$whereQuery = "WHERE taf.soum_code = vs.soum_code";

if($checkaimag==1) 
{
	$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
}

$selQuery = $startQuery." ".$valueQuery." ".$valueQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery;
$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];

$maxpage = ceil( $sum / $count);

require("tareforestation/inc.search_reforestation.php");	

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");

?>

<div class="table-responsive">
  <table id="forestresource_datatables" class="table table-bordered table-hover" title_name="<?php echo _p("ResourceSubTitle5"); ?>" file_name="reforestation" column_name="0, 1, 2, 3, 4, 5, 6" language_name="<?php echo $language_name;?>" page_count="<?php echo $count;?>">
    <thead>
      <tr>
        <th colspan="8"><form class="form-inline pull-right" action="<?php echo $my_count.$search_url.$sort_url; ?>" method="post" name="changeform" id="changeform">
		  <label class="mr-2"><?php echo _p("ShowRowsText");?></label>
		  <?php echo seldata("count", "form-control", $RECORD_COUNTS, $count, ""); ?>
        </form></th>
      </tr>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub5Column3"); ?></a></th>		
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub5Column1"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub5Column2"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub5Column4"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub5Column5"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=6&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub5Column6"); ?></a></th>		
        <th><?php echo _p("Operation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page - 1) * $count;
		$startQuery = "SELECT";
		$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en FROM ".$schemas.".tareforestation taf, scadministrative.vasoumname vs";
		$whereQuery = "WHERE taf.soum_code = vs.soum_code";
		
		if($checkaimag==1) 
		{
			$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
		}	

		$selQuery = $startQuery." ".$valueQuery." ".$valueQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
	
		$rows = $db->query($selQuery);
		
		for ($i = 0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page - 1) * $count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["reforest_year"]; ?></td>
        <td><?php echo $rows[$i]["aimag_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["planted_area"]; ?></td>
        <td><?php echo $rows[$i]["reforestation_percent"]; ?></td>
        <td><?php echo $rows[$i]["planted_forest_area"]; ?></td>
        <td><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&reforest_id=".$rows[$i]["reforest_id"]; ?>" title="<?php echo _p("MoreTitle"); ?>"><i class="fa fa-list-alt"></i></a>
          <?php 
			if($sess_profile==1)
			{ 
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&reforest_id=".$rows[$i]["reforest_id"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a> 
		  <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&reforest_id=".$rows[$i]["reforest_id"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a>
		  <?php if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 2)) { ?>
			  <a href="<?php echo $my_url.$search_url.$sort_url."&action=addgeom&reforest_id=".$rows[$i]["reforest_id"]; ?>" title="<?php echo _p("GisSubTitle2"); ?>"><i class="fa fa-globe"></i></a>
		  <?php } ?>	
		  <?php if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 13, 2)) { ?>
			  <a href="<?php echo $my_url.$search_url.$sort_url."&action=addgeom1&reforest_id=".$rows[$i]["reforest_id"]; ?>" title="<?php echo _p("GisSubTitle3"); ?>"><i class="fa fa-plus"></i></a>
		  <?php } ?>
          <?php
			} else if($rows[$i]["user_id"]==$sess_user_id) {
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&reforest_id=".$rows[$i]["reforest_id"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a> 
		  <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&reforest_id=".$rows[$i]["reforest_id"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a>
		  <?php if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 2)) { ?>
			  <a href="<?php echo $my_url.$search_url.$sort_url."&action=addgeom&reforest_id=".$rows[$i]["reforest_id"]; ?>" title="<?php echo _p("GisSubTitle2"); ?>"><i class="fa fa-globe"></i></a>
		  <?php } ?>		  
		  <?php if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 13, 2)) { ?>
			  <a href="<?php echo $my_url.$search_url.$sort_url."&action=addgeom1&reforest_id=".$rows[$i]["reforest_id"]; ?>" title="<?php echo _p("GisSubTitle3"); ?>"><i class="fa fa-plus"></i></a>
		  <?php } ?>		  
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
		if($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 2)) {
		?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=add"; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a>
          <?php 
		}
		
		if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 2)) {
			if($sum > 0) { 
			?>
          <a class="btn btn-primary" href="<?php echo $my_url.$search_url.$sort_url."&action=export"; ?>"><i class="fa fa-file"></i> <?php echo _p("ExportButton");?></a>
          <?php 
			} 
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
