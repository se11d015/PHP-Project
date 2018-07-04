<?php
if (isset($_POST["searchplantedforestgeombttn"])) 
{
	$searchQuery = "";
	$search_url = "";

	$sreforest_year = (isset($_POST["sreforest_year"])) ? (int) $_POST["sreforest_year"] : 0;		
	$saimag_code = (isset($_POST["saimag_code"])) ? (int) $_POST["saimag_code"] : 0;
	$sgeometry_status = (isset($_POST["sgeometry_status"])) ? (int) $_POST["sgeometry_status"] : 0;
	
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
	
	if($sgeometry_status==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else if($sgeometry_status==1)
	{
		$searchQuery .= " AND ST_IsValidReason(tgf.geom) = 'Valid Geometry' AND (ST_YMin(tgf.geom) > 40 AND ST_YMax(tgf.geom) < 53 AND ST_XMin(tgf.geom) > 86 AND ST_XMax(tgf.geom) < 120)";
		$search_url .= "&sgeometry_status=".$sgeometry_status;
	} else if($sgeometry_status==2)
	{
		$searchQuery .= " AND ST_IsValidReason(tgf.geom) IS NULL";
		$search_url .= "&sgeometry_status=".$sgeometry_status;
	} else if($sgeometry_status==3)
	{
		$searchQuery .= " AND ST_IsValidReason(tgf.geom) != 'Valid Geometry'";
		$search_url .= "&sgeometry_status=".$sgeometry_status;
	} else if($sgeometry_status==4)
	{
		$searchQuery .= " AND NOT (ST_YMin(tgf.geom) > 40 AND ST_YMax(tgf.geom) < 53 AND ST_XMin(tgf.geom) > 86 AND ST_XMax(tgf.geom) < 120)";
		$search_url .= "&sgeometry_status=".$sgeometry_status;
	}
	
	$user_id = (isset($_POST["user_id"])) ? (int) $_POST["user_id"] : 0;
	$group_id = (isset($_POST["group_id"])) ? (int) $_POST["group_id"] : 0;
	
	if($user_id==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tgf.user_id = ".$user_id;
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
		$whereQuery1 = " AND tgf.user_id = tug.user_id";
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
        $sortQuery .= " tgf.planted_area";
    } else
	{
        $sortQuery .= " taf.reforest_year";
    }
} else 
{
    $sortQuery .= " tgf.gid";
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
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".tgplantedforest tgf, ".$schemas.".tareforestation taf, scadministrative.vasoumname vs";
$whereQuery = "WHERE tgf.reforest_id = taf.reforest_id AND taf.soum_code = vs.soum_code";

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

require("tgplantedforest/inc.search_plantedforest.php");	

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");

?>

<div class="table-responsive">
  <table id="forestresource_datatables" class="table table-bordered table-hover" title_name="<?php echo _p("GisSubTitle3"); ?>" file_name="reforestation" column_name="0, 1, 2, 3, 4, 5" language_name="<?php echo $language_name;?>" page_count="<?php echo $count;?>">
    <thead>
      <tr>
        <th colspan="7"><form class="form-inline pull-right" action="<?php echo $my_count.$search_url.$sort_url; ?>" method="post" name="changeform" id="changeform">
		  <label class="mr-2"><?php echo _p("ShowRowsText");?></label>
		  <?php echo seldata("count", "form-control", $RECORD_COUNTS, $count, ""); ?>
        </form></th>
      </tr>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("GisSub3Column3"); ?></a></th>		
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("GisSub3Column1"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("GisSub3Column2"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("GisSub3Column4").", ". _p("GisSub3Unit2"); ?></a></th>
        <th><?php echo _p("GeometryText1"); ?></th>		
        <th><?php echo _p("Operation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page - 1) * $count;
		$startQuery = "SELECT";
		$valueQuery = "tgf.*, st_isvalidreason(tgf.geom) as geomvalid, st_xmax(tgf.geom) as geomxmax, st_ymax(tgf.geom) as geomymax, st_xmin(tgf.geom) as geomxmin, st_ymin(tgf.geom) as geomymin,
		taf.reforest_year, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en FROM ".$schemas.".tgplantedforest tgf, ".$schemas.".tareforestation taf, scadministrative.vasoumname vs";
		$whereQuery = "WHERE tgf.reforest_id = taf.reforest_id AND taf.soum_code = vs.soum_code";
		
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
        <td><?php 
				if(empty($rows[$i]["geomvalid"])) 
					echo "<p class=\"text text-info\">"._p("GeometryStatus2")."</p><br>"; 
				else if($rows[$i]["geomvalid"] == "Valid Geometry") 
					echo "-"; 
				else 
					echo "<p class=\"text text-danger\">"._p("GeometryStatus3")."</p><br>"; 
				
				if(empty($rows[$i]["geomymax"]) && empty($rows[$i]["geomxmax"]) && empty($rows[$i]["geomymin"]) && empty($rows[$i]["geomxmin"])) 
					echo ""; 
				else if(($rows[$i]["geomymin"] > 40 && $rows[$i]["geomymax"] < 53) && ($rows[$i]["geomxmin"] > 86 && $rows[$i]["geomxmax"] < 120)) 
					echo ""; 
				else 
					echo "<p class=\"text text-danger\">"._p("GeometryStatus4")."</p><br>"; 
				
		?></td>
        <td><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&gid=".$rows[$i]["gid"]; ?>" title="<?php echo _p("MoreTitle"); ?>"><i class="fa fa-list-alt"></i></a>
          <?php 
			if($sess_profile==1)
			{ 
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&gid=".$rows[$i]["gid"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a> 
		  <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&gid=".$rows[$i]["gid"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a>
		  <?php if (!empty($rows[$i]["geom"])) { ?>
          <a href="<?php echo $my_url.$search_url.$sort_url."&action=deletegis&gid=".$rows[$i]["gid"]; ?>" title="<?php echo _p("DeleteGeomTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteGeomText3"); ?>');"><i class="fa fa-minus"></i></a>
          <?php } ?>		  
          <?php
			} else if($rows[$i]["user_id"]==$sess_user_id) {
			?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&gid=".$rows[$i]["gid"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a> 
		  <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&gid=".$rows[$i]["gid"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a>
		  <?php if (!empty($rows[$i]["geom"])) { ?>
          <a href="<?php echo $my_url.$search_url.$sort_url."&action=deletegis&gid=".$rows[$i]["gid"]; ?>" title="<?php echo _p("DeleteGeomTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteGeomText3"); ?>');"><i class="fa fa-minus"></i></a>
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
		if($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 13, 2)) {
		?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=select"; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a>
          <?php 
		}
		
		if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 13, 2)) {
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
