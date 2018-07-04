<?php
if (isset($_GET["reforest_id"]))
{
	$reforest_id = (int)$_GET["reforest_id"];
}else
{
	$reforest_id = 0;
}
	

$i = 0;
$startQuery = "SELECT";
$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en, tau.organization||' - '|| tau.lastname as user_name  FROM ".$schemas.".tareforestation taf, scadministrative.vasoumname vs,".$schemas.".tausers tau";
$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.user_id = tau.user_id AND taf.reforest_id = ".$reforest_id;
		
if($checkaimag==1) 
{
	$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
}	

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);

if (!empty($row))
{
	$user_id  = $row[$i]["user_id"];
	$reforest_id  = $row[$i]["reforest_id"];
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="5"><?php echo _p("MoreText1")." "._p("ResourceSubTitle5")." "._p("MoreText2"); ?></th>
      </tr>
      <tr>
        <th style="width: 5%">№</th>
        <th colspan="2" style="width: 35%"><?php echo _p("ResourceSub5ColumnText1");?></th>
        <th style="width: 10%"><?php echo _p("ResourceSub5ColumnText2");?></th>
        <th><?php echo _p("ResourceSub5ColumnText3");?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th rowspan="3">1.</th>
        <td rowspan="3"><?php echo _p("ResourceSub5ColumnText4");?></td>
        <td><?php echo _p("ResourceSub5MoreColumn1");?></td>
        <td><?php echo _p("ResourceSub5Unit1");?></td>
        <td><?php echo $row[$i]["planted_area"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub5MoreColumn2");?></td>
        <td><?php echo _p("ResourceSub5Unit1");?></td>
        <td><?php echo $row[$i]["regenerate_area"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub5MoreColumn3");?></td>
        <td><?php echo _p("ResourceSub5Unit1");?></td>
        <td><?php echo $row[$i]["forest_belt_area"]; ?></td>
      </tr>
      <tr>
        <th>2.</th>
        <td colspan="2"><?php echo _p("ResourceSub5MoreColumn4");?></td>
        <td><?php echo _p("ResourceSub5Unit5");?></td>
        <td><?php echo $row[$i]["reforestation_location"]; ?></td>
      </tr>	  
      <tr>
        <th>3.</th>
        <td colspan="2"><?php echo _p("ResourceSub5MoreColumn5");?></td>
        <td><?php echo _p("ResourceSub5Unit1");?></td>
        <td><?php echo $row[$i]["planted_forest_area"]; ?></td>
      </tr>
      <tr>
        <th>4.</th>
        <td colspan="2"><?php echo _p("ResourceSub5MoreColumn6");?></td>
        <td><?php echo _p("ResourceSub5Unit5");?></td>
        <td><?php echo $row[$i]["planted_location"]; ?></td>
      </tr>	  
      <tr>
        <th>5.</th>
        <td colspan="2"><?php echo _p("ResourceSub5MoreColumn7");?></td>
        <td><?php echo _p("ResourceSub5Unit2");?></td>
        <td><?php echo $row[$i]["reforestation_percent"]; ?></td>
      </tr>
      <tr>
        <th rowspan="3">6.</th>
        <td rowspan="3"><?php echo _p("ResourceSub5ColumnText5");?></td>
        <td><?php echo _p("ResourceSub5MoreColumn8");?></td>
        <td><?php echo _p("ResourceSub5Unit3");?></td>
        <td><?php echo $row[$i]["seedling_1age_number"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub5MoreColumn9");?></td>
        <td><?php echo _p("ResourceSub5Unit3");?></td>
        <td><?php echo $row[$i]["seedling_2age_number"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub5MoreColumn10");?></td>
        <td><?php echo _p("ResourceSub5Unit3");?></td>
        <td><?php echo $row[$i]["seedling_3age_number"]; ?></td>
      </tr>
      <tr>
        <th rowspan="3">7.</th>
        <td rowspan="3"><?php echo _p("ResourceSub5ColumnText6");?></td>
        <td><?php echo _p("ResourceSub5MoreColumn11");?></td>
        <td><?php echo _p("ResourceSub5Unit3");?></td>
        <td><?php echo $row[$i]["seedling_number_larch"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub5MoreColumn12");?></td>
        <td><?php echo _p("ResourceSub5Unit3");?></td>
        <td><?php echo $row[$i]["seedling_number_pine"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub5MoreColumn13");?></td>
        <td><?php echo _p("ResourceSub5Unit3");?></td>
        <td><?php echo $row[$i]["seedling_number_other"]; ?></td>
      </tr>
      <tr>
        <th rowspan="4">8.</th>
        <td rowspan="4"><?php echo _p("ResourceSub5ColumnText7");?></td>
        <td><?php echo _p("ResourceSub5MoreColumn14");?></td>
        <td><?php echo _p("ResourceSub5Unit4");?></td>
        <td><?php echo $row[$i]["prepared_seed_larch"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub5MoreColumn15");?></td>
        <td><?php echo _p("ResourceSub5Unit4");?></td>
        <td><?php echo $row[$i]["prepared_seed_pine"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub5MoreColumn16");?></td>
        <td><?php echo _p("ResourceSub5Unit4");?></td>
        <td><?php echo $row[$i]["prepared_seed_saxaul"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub5MoreColumn17");?></td>
        <td><?php echo _p("ResourceSub5Unit4");?></td>
        <td><?php echo $row[$i]["prepared_seed_other"]; ?></td>
      </tr>
	  <tr>
	    <th>9.</th>
        <td colspan="2"><?php echo _p("DataEntryUserName");?></td>
        <td colspan="2"><?php echo $row[$i]["user_name"]; ?></td>
      </tr>
    </tbody>
  </table>
</div>
<?php 	

	$startQuery1 = "SELECT";
	$valueQuery1 = "tgf.*, st_isvalidreason(tgf.geom) as geomvalid, st_xmax(tgf.geom) as geomxmax, st_ymax(tgf.geom) as geomymax, st_xmin(tgf.geom) as geomxmin, st_ymin(tgf.geom) as geomymin, 
	tau.organization||' - '|| tau.lastname as user_name 
	FROM ".$schemas.".tgreforestation tgf, ".$schemas.".tareforestation taf, scadministrative.vasoumname vs, ".$schemas.".tausers tau";
	$whereQuery1 = "WHERE tgf.reforest_id = taf.reforest_id AND taf.soum_code = vs.soum_code AND tgf.user_id = tau.user_id AND tgf.reforest_id = ".$reforest_id;
			
	if($checkaimag==1) 
	{
		$whereQuery1 .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
	}	

	$selQuery1 = $startQuery1." ".$valueQuery1." ".$whereQuery1;
	$row1 = $db->query($selQuery1);

	if (!empty($row1))
	{
?>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
	  <thead>
		<tr>
		  <th colspan="6"><?php echo _p("MoreText1")." "._p("GisSubTitle2")." "._p("MoreText2"); ?></th>
		</tr>
		<tr>
		  <th>№</th>
		  <th><?php echo _p("GisSub2Column4");?></th>
		  <th><?php echo _p("GisSub2Column5").", ". _p("GisSub2Unit2");?></th>
		  <th><?php echo _p("GeometryText1");?></th>
		  <th><?php echo _p("DataEntryUserName");?></th>
		  <th><?php echo _p("Operation");?></th>
		</tr>
	  </thead>
	  <tbody>
		<?php	for($j=0; $j<sizeof($row1); $j++) {	?>
		<tr>
		  <td><?php echo $j+1;?></td>
		  <td><?php if($row1[$j]["reforest_type"]==1) echo _p("GisSub2MoreColumn1"); 
			else if($row1[$j]["reforest_type"]==2) echo _p("GisSub2MoreColumn2");
			else if($row1[$j]["reforest_type"]==3) echo _p("GisSub2MoreColumn3"); ?></td>
		  <td><?php echo $row1[$j]["reforest_area"];?></td>
		  <td><?php if(empty($row1[$j]["geomvalid"])) 
					echo "<p class=\"text text-info\">"._p("GeometryStatus2")."</p><br>"; 
				else if($row1[$j]["geomvalid"] == "Valid Geometry") 
					echo ""; 
				else 
					echo "<p class=\"text text-danger\">"._p("GeometryStatus3")."</p><br>"; 
				
				if(empty($row1[$j]["geomymax"]) && empty($row1[$j]["geomxmax"]) && empty($row1[$j]["geomymin"]) && empty($row1[$j]["geomxmin"])) 
					echo ""; 
				else if(($row1[$j]["geomymin"] > 40 && $row1[$j]["geomymax"] < 53) && ($row1[$j]["geomxmin"] > 86 && $row1[$j]["geomxmax"] < 120)) 
					echo ""; 
				else 
					echo "<p class=\"text text-danger\">"._p("GeometryStatus4")."</p><br>";
				if (!empty($row1[$j]["geom"])) {
					echo "<a href=\"".$my_url."&action=outputgeom&outputtype=1&gid=".$row1[$j]["gid"]."\">"._p("GeometryText3")."</a> | ";
					echo "<a href=\"".$my_url."&action=outputgeom&outputtype=2&gid=".$row1[$j]["gid"]."\">"._p("GeometryText4")."</a>";
				} ?></td>     
		  <td><?php echo $row1[$j]["user_name"];?></td>	       
		  <td><?php if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 2)) { ?>
			<?php if($sess_profile==1) { ?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=editgeom&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a> 
		  <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=deletegeom&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a>
		  <?php if (!empty($row1[$j]["geom"])) { ?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=deletegisgeom&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("DeleteGeomTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteGeomText3"); ?>');"><i class="fa fa-minus"></i></a>
          <?php } ?>		  
          <?php	} else if($row1[$j]["user_id"]==$sess_user_id) { ?>
         <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=editgeom&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a> 
		 <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=deletegeom&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a>
		  <?php if (!empty($row1[$j]["geom"])) { ?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=deletegisgeom&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("DeleteGeomTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteGeomText3"); ?>');"><i class="fa fa-minus"></i></a>
          <?php } ?>
		  <?php } ?>
		  <?php } ?></td>	
		</tr>
		<?php } ?>
	  </tbody>
	</table>
</div>
<?php 	
	}
?>
<?php 	

	$startQuery1 = "SELECT";
	$valueQuery1 = "tgf.*, st_isvalidreason(tgf.geom) as geomvalid, st_xmax(tgf.geom) as geomxmax, st_ymax(tgf.geom) as geomymax, st_xmin(tgf.geom) as geomxmin, st_ymin(tgf.geom) as geomymin, 
	tau.organization||' - '|| tau.lastname as user_name 
	FROM ".$schemas.".tgplantedforest tgf, ".$schemas.".tareforestation taf, scadministrative.vasoumname vs, ".$schemas.".tausers tau";
	$whereQuery1 = "WHERE tgf.reforest_id = taf.reforest_id AND taf.soum_code = vs.soum_code AND tgf.user_id = tau.user_id AND tgf.reforest_id = ".$reforest_id;
			
	if($checkaimag==1) 
	{
		$whereQuery1 .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
	}	

	$selQuery1 = $startQuery1." ".$valueQuery1." ".$whereQuery1;
	$row1 = $db->query($selQuery1);

	if (!empty($row1))
	{
?>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
	  <thead>
		<tr>
		  <th colspan="5"><?php echo _p("MoreText1")." "._p("GisSubTitle3")." "._p("MoreText2"); ?></th>
		</tr>
		<tr>
		  <th>№</th>
		  <th><?php echo _p("GisSub3Column4").", ". _p("GisSub3Unit2");?></th>
		  <th><?php echo _p("GeometryText1");?></th>
		  <th><?php echo _p("DataEntryUserName");?></th>
		  <th><?php echo _p("Operation");?></th>
		</tr>
	  </thead>
	  <tbody>
		<?php	for($j=0; $j<sizeof($row1); $j++) {	?>
		<tr>
		  <td><?php echo $j+1;?></td>
		  <td><?php echo $row1[$j]["planted_area"];?></td>
		  <td><?php if(empty($row1[$j]["geomvalid"])) 
					echo "<p class=\"text text-info\">"._p("GeometryStatus2")."</p><br>"; 
				else if($row1[$j]["geomvalid"] == "Valid Geometry") 
					echo ""; 
				else 
					echo "<p class=\"text text-danger\">"._p("GeometryStatus3")."</p><br>"; 
				
				if(empty($row1[$j]["geomymax"]) && empty($row1[$j]["geomxmax"]) && empty($row1[$j]["geomymin"]) && empty($row1[$j]["geomxmin"])) 
					echo ""; 
				else if(($row1[$j]["geomymin"] > 40 && $row1[$j]["geomymax"] < 53) && ($row1[$j]["geomxmin"] > 86 && $row1[$j]["geomxmax"] < 120)) 
					echo ""; 
				else 
					echo "<p class=\"text text-danger\">"._p("GeometryStatus4")."</p><br>";
				if (!empty($row1[$j]["geom"])) {
					echo "<a href=\"".$my_url."&action=outputgeom1&outputtype=1&gid=".$row1[$j]["gid"]."\">"._p("GeometryText3")."</a> | ";
					echo "<a href=\"".$my_url."&action=outputgeom1&outputtype=2&gid=".$row1[$j]["gid"]."\">"._p("GeometryText4")."</a>";
				} ?></td>     
		  <td><?php echo $row1[$j]["user_name"];?></td>	       
		  <td><?php if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 13, 2)) { ?>
			<?php if($sess_profile==1) { ?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=editgeom1&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a> 
		  <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=deletegeom1&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a>
		  <?php if (!empty($row1[$j]["geom"])) { ?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=deletegisgeom1&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("DeleteGeomTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteGeomText3"); ?>');"><i class="fa fa-minus"></i></a>
          <?php } ?>		  
          <?php	} else if($row1[$j]["user_id"]==$sess_user_id) { ?>
         <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=editgeom1&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a> 
		 <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=deletegeom1&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a>
		  <?php if (!empty($row1[$j]["geom"])) { ?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=deletegisgeom1&gid=".$row1[$j]["gid"]; ?>" title="<?php echo _p("DeleteGeomTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteGeomText3"); ?>');"><i class="fa fa-minus"></i></a>
          <?php } ?>
		  <?php } ?>
		  <?php } ?></td>	
		</tr>
		<?php } ?>
	  </tbody>
	</table>
</div>
<?php 	
	}
?>
<div class="table-responsive">
  <table class="table">
    <tbody>
      <tr>
        <td><?php if($sess_profile==1) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&reforest_id=".$reforest_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
          <?php } else if($user_id==$sess_user_id) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&reforest_id=".$reforest_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
          <?php } ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?></a></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
} else {
	$notify = " <a class=\"btn btn-danger\" href=\"".$my_url.$my_page.$search_url.$sort_url."\"><i class=\"fa fa-undo\"></i> "._p("BackButton")." </a>";
	show_notification("error", _p("NotRowText"), $notify);
}
?>
