<?php
if (isset($_GET["gid"]))
{
	$gid = (int)$_GET["gid"];
}else
{
	$gid = 0;
}
	

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tgf.*, st_isvalidreason(tgf.geom) as geomvalid, st_xmax(tgf.geom) as geomxmax, st_ymax(tgf.geom) as geomymax, st_xmin(tgf.geom) as geomxmin, st_ymin(tgf.geom) as geomymin,
taf.utilization_year, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en, tau.organization||' - '|| tau.lastname as user_name 
FROM ".$schemas.".tgforestlogging tgf, ".$schemas.".taforestutilization taf, scadministrative.vasoumname vs,".$schemas.".tausers tau";
$whereQuery = "WHERE tgf.utilization_id = taf.utilization_id AND taf.soum_code = vs.soum_code AND tgf.user_id = tau.user_id AND tgf.gid = ".$gid;
		
if($checkaimag==1) 
{
	$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
}	

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);

if (!empty($row))
{
	$user_id  = $row[$i]["user_id"];
	$gid  = $row[$i]["gid"];
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="5"><?php echo _p("MoreText1")." "._p("GisSubTitle4")." "._p("MoreText2"); ?></th>
      </tr>
      <tr>
        <th style="width: 5%">№</th>
        <th colspan="2" style="width: 35%"><?php echo _p("GisSub4ColumnText1");?></th>
        <th style="width: 10%"><?php echo _p("GisSub4ColumnText2");?></th>
        <th><?php echo _p("GisSub4ColumnText3");?></th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <th>1.</th>
          <td colspan="2"><?php echo _p("GisSub4Column3");?></td>
          <td><?php echo _p("GisSub4Unit1");?></td>
          <td><?php echo $row[$i]["utilization_year"]; ?></td>
        </tr>
        <tr>
          <th>2.</th>
          <td colspan="2"><?php echo _p("GisSub4Column1");?></td>
          <td><?php echo _p("GisSub4Unit1");?></td>
          <td><?php echo $row[$i]["aimag_name_$language_name"]; ?></td>
        </tr>
        <tr>
          <th>3.</th>
          <td colspan="2"><?php echo _p("GisSub4Column2");?></td>
          <td><?php echo _p("GisSub4Unit1");?></td>
          <td><?php echo $row[$i]["soum_name_$language_name"]; ?></td>
        </tr>
        <tr>
          <th>4.</th>
          <td colspan="2"><?php echo _p("GisSub4Column4");?></td>
          <td><?php echo _p("GisSub4Unit1");?></td>
          <td><?php 
		    if($row[$i]["logging_type"]==1) echo _p("GisSub4MoreColumn4"); 
			else if($row[$i]["logging_type"]==2) echo _p("GisSub4MoreColumn5");
			else if($row[$i]["logging_type"]==3) echo _p("GisSub4MoreColumn6");
		  ?></td>
        </tr>		
        <tr>
          <th>5.</th>
          <td colspan="2"><?php echo _p("GisSub4Column5");?></td>
          <td><?php echo _p("GisSub4Unit2");?></td>
          <td><?php echo $row[$i]["logging_area"]; ?></td>
        </tr>
		  <tr>
			<th rowspan="3">6.</th>
			<td rowspan="3"><?php echo _p("GisSub4Column6");?></td>
			<td><?php echo _p("GisSub4MoreColumn1");?></td>
			<td><?php echo _p("GisSub4Unit3");?></td>
			<td><?php echo $row[$i]["logged_timber"]; ?></td>
		  </tr>
		  <tr>
			<td><?php echo _p("GisSub4MoreColumn2");?></td>
			<td><?php echo _p("GisSub4Unit3");?></td>
			<td><?php echo $row[$i]["logged_firewood"]; ?></td>
		  </tr>
		  <tr>
			<td><?php echo _p("GisSub4MoreColumn3");?></td>
			<td><?php echo _p("GisSub4Unit3");?></td>
			<td><?php echo $row[$i]["logged_total"]; ?></td>
		  </tr>
        <tr>
          <th>7.</th>
          <td colspan="2"><?php echo _p("GeometryText1");?></td>
          <td><?php echo _p("GisSub4Unit1");?></td>
          <td><?php
				if(empty($row[$i]["geomvalid"])) 
					echo "<p class=\"text text-info\">"._p("GeometryStatus2")."</p><br>"; 
				else if($row[$i]["geomvalid"] == "Valid Geometry") 
					echo "-"; 
				else 
					echo "<p class=\"text text-danger\">"._p("GeometryStatus3")."</p><br>"; 
				
				if(empty($row[$i]["geomymax"]) && empty($row[$i]["geomxmax"]) && empty($row[$i]["geomymin"]) && empty($row[$i]["geomxmin"])) 
					echo ""; 
				else if(($row[$i]["geomymin"] > 40 && $row[$i]["geomymax"] < 53) && ($row[$i]["geomxmin"] > 86 && $row[$i]["geomxmax"] < 120)) 
					echo ""; 
				else 
					echo "<p class=\"text text-danger\">"._p("GeometryStatus4")."</p><br>"; 
		?></td>
        </tr>
        <tr>
          <th>8.</th>
          <td colspan="2"><?php echo _p("GeometryText2");?></td>
          <td><?php echo _p("GisSub4Unit1");?></td>
          <td><?php		 
			if (!empty($row[$i]["geom"])) {
				echo "<a href=\"".$my_url."&action=outputgeom&outputtype=1&gid=".$row[$i]["gid"]."\">"._p("GeometryText3")."</a> | ";
			  	echo "<a href=\"".$my_url."&action=outputgeom&outputtype=2&gid=".$row[$i]["gid"]."\">"._p("GeometryText4")."</a>";
			}
			?></td>
        </tr>		
		<tr>
	      <th>9.</th>
          <td colspan="2"><?php echo _p("DataEntryUserName");?></td>
		  <td><?php echo _p("GisSub4Unit1");?></td>
          <td><?php echo $row[$i]["user_name"]; ?></td>
        </tr>
    </tbody>
  </table>
</div>

<div class="table-responsive">
  <table class="table">
    <tbody>
      <tr>
        <td><?php if($sess_profile==1) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&gid=".$gid; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
          <?php } else if($user_id==$sess_user_id) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&gid=".$gid; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
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
