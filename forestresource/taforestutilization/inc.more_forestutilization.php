<?php
if (isset($_GET["utilization_id"]))
{
	$utilization_id = (int)$_GET["utilization_id"];
}else
{
	$utilization_id = 0;
}
	

$i = 0;
$startQuery = "SELECT";
$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en, tau.organization||' - '|| tau.lastname as user_name  FROM ".$schemas.".taforestutilization taf, scadministrative.vasoumname vs,".$schemas.".tausers tau";
$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.user_id = tau.user_id AND taf.utilization_id = ".$utilization_id;
		
if($checkaimag==1) 
{
	$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
}	

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);

if (!empty($row))
{
	$user_id  = $row[$i]["user_id"];
	$utilization_id  = $row[$i]["utilization_id"];
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="5"><?php echo _p("MoreText1")." "._p("ResourceSubTitle6")." "._p("MoreText2"); ?></th>
      </tr>
      <tr>
        <th style="width: 5%">№</th>
        <th colspan="2" style="width: 35%"><?php echo _p("ResourceSub6ColumnText1");?></th>
        <th style="width: 10%"><?php echo _p("ResourceSub6ColumnText2");?></th>
        <th><?php echo _p("ResourceSub6ColumnText3");?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th rowspan="3">1.</th>
        <td rowspan="3"><?php echo _p("ResourceSub6ColumnText4");?></td>
        <td><?php echo _p("ResourceSub6MoreColumn1");?></td>
        <td><?php echo _p("ResourceSub6Unit1");?></td>
        <td><?php echo $row[$i]["logged_timber"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub6MoreColumn2");?></td>
        <td><?php echo _p("ResourceSub6Unit1");?></td>
        <td><?php echo $row[$i]["logged_firewood"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub6MoreColumn3");?></td>
        <td><?php echo _p("ResourceSub6Unit1");?></td>
        <td><?php echo $row[$i]["total_logged_wood"]; ?></td>
      </tr>
      <tr>
        <th>2.</th>
        <td colspan="2"><?php echo _p("ResourceSub6MoreColumn4");?></td>
        <td><?php echo _p("ResourceSub6Unit2");?></td>
        <td><?php echo $row[$i]["insulated_area"]; ?></td>
      </tr>
      <tr>
        <th>3.</th>
        <td colspan="2"><?php echo _p("ResourceSub6MoreColumn5");?></td>
        <td><?php echo _p("ResourceSub6Unit2");?></td>
        <td><?php echo $row[$i]["logged_area"]; ?></td>
      </tr>
      <tr>
        <th>4.</th>
        <td colspan="2"><?php echo _p("ResourceSub6MoreColumn6");?></td>
        <td><?php echo _p("ResourceSub6Unit4");?></td>
        <td><?php echo $row[$i]["logged_location"]; ?></td>
      </tr>
      <tr>
        <th>5.</th>
        <td colspan="2"><?php echo _p("ResourceSub6MoreColumn7");?></td>
        <td><?php echo _p("ResourceSub6Unit2");?></td>
        <td><?php echo $row[$i]["thinning_area"]; ?></td>
      </tr>
      <tr>
        <th rowspan="3">6.</th>
        <td rowspan="3"><?php echo _p("ResourceSub6ColumnText5");?></td>
        <td><?php echo _p("ResourceSub6MoreColumn8");?></td>
        <td><?php echo _p("ResourceSub6Unit1");?></td>
        <td><?php echo $row[$i]["thinning_timber"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub6MoreColumn9");?></td>
        <td><?php echo _p("ResourceSub6Unit1");?></td>
        <td><?php echo $row[$i]["thinning_firewood"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub6MoreColumn10");?></td>
        <td><?php echo _p("ResourceSub6Unit1");?></td>
        <td><?php echo $row[$i]["total_thinning_wood"]; ?></td>
      </tr>
      <tr>
        <th>7.</th>
        <td colspan="2"><?php echo _p("ResourceSub6MoreColumn11");?></td>
        <td><?php echo _p("ResourceSub6Unit2");?></td>
        <td><?php echo $row[$i]["cleaning_area"]; ?></td>
      </tr>
      <tr>
        <th rowspan="3">8.</th>
        <td rowspan="3"><?php echo _p("ResourceSub6ColumnText6");?></td>
        <td><?php echo _p("ResourceSub6MoreColumn12");?></td>
        <td><?php echo _p("ResourceSub6Unit1");?></td>
        <td><?php echo $row[$i]["cleaning_timber"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub6MoreColumn13");?></td>
        <td><?php echo _p("ResourceSub6Unit1");?></td>
        <td><?php echo $row[$i]["cleaning_firewood"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub6MoreColumn14");?></td>
        <td><?php echo _p("ResourceSub6Unit1");?></td>
        <td><?php echo $row[$i]["total_cleaning_wood"]; ?></td>
      </tr>
      <tr>
        <th rowspan="3">9.</th>
        <td rowspan="3"><?php echo _p("ResourceSub6ColumnText7");?></td>
        <td><?php echo _p("ResourceSub6MoreColumn15");?></td>
        <td><?php echo _p("ResourceSub6Unit3");?></td>
        <td><?php echo $row[$i]["nontimber_pinenuts"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub6MoreColumn16");?></td>
        <td><?php echo _p("ResourceSub6Unit3");?></td>
        <td><?php echo $row[$i]["nontimber_fruits"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub6MoreColumn17");?></td>
        <td><?php echo _p("ResourceSub6Unit3");?></td>
        <td><?php echo $row[$i]["nontimber_other"]; ?></td>
      </tr>
	  <tr>
	    <th>10.</th>
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
	FROM ".$schemas.".tgforestlogging tgf, ".$schemas.".taforestutilization taf, scadministrative.vasoumname vs, ".$schemas.".tausers tau";
	$whereQuery1 = "WHERE tgf.utilization_id = taf.utilization_id AND taf.soum_code = vs.soum_code AND tgf.user_id = tau.user_id AND tgf.utilization_id = ".$utilization_id;
			
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
		  <th colspan="9"><?php echo _p("MoreText1")." "._p("GisSubTitle4")." "._p("MoreText2"); ?></th>
		</tr>
		<tr>
		  <th rowspan="2">№</th>
		  <th rowspan="2"><?php echo _p("GisSub4Column4");?></th>
		  <th rowspan="2"><?php echo _p("GisSub4Column5").", ". _p("GisSub4Unit2");?></th>
		  <th colspan="3"><?php echo _p("GisSub4Column6").", ". _p("GisSub4Unit3");?></th>
		  <th rowspan="2"><?php echo _p("GeometryText1");?></th>
		  <th rowspan="2"><?php echo _p("DataEntryUserName");?></th>
		  <th rowspan="2"><?php echo _p("Operation");?></th>
		</tr>
		<tr>
		  <th><?php echo _p("GisSub4MoreColumn1");?></th>
		  <th><?php echo _p("GisSub4MoreColumn2");?></th>
		  <th><?php echo _p("GisSub4MoreColumn3");?></th>
		</tr>		
	  </thead>
	  <tbody>
		<?php	for($j=0; $j<sizeof($row1); $j++) {	?>
		<tr>
		  <td><?php echo $j+1;?></td>
		  <td><?php if($row1[$j]["logging_type"]==1) echo _p("GisSub4MoreColumn4"); 
			else if($row1[$j]["logging_type"]==2) echo _p("GisSub4MoreColumn5");
			else if($row1[$j]["logging_type"]==3) echo _p("GisSub4MoreColumn6"); ?></td>
		  <td><?php echo $row1[$j]["logging_area"];?></td>
		  <td><?php echo $row1[$j]["logged_timber"];?></td>
		  <td><?php echo $row1[$j]["logged_firewood"];?></td>
		  <td><?php echo $row1[$j]["logged_total"];?></td>
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
		  <td><?php if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 14, 2)) { ?>
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
<div class="table-responsive">
  <table class="table">
    <tbody>
      <tr>
        <td><?php if($sess_profile==1) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&utilization_id=".$utilization_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
          <?php } else if($user_id==$sess_user_id) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&utilization_id=".$utilization_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
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
