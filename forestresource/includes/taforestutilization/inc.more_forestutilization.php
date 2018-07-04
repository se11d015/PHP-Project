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
$valueQuery = "va.aimag_name_mn, va.soum_name_mn, va.aimag_name_en, va.soum_name_en, taf.* FROM ".$schemas.".taforestutilization taf, scadministrative.vasoumname va";
$whereQuery = "WHERE taf.soum_code = va.soum_code AND taf.utilization_id=".$utilization_id;
    
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
	$title = $row[$i]["aimag_name_$language_name"]." "._p("ForestResourceText1")." ".$row[$i]["soum_name_$language_name"]." "._p("ForestResourceText2").", ".$row[$i]["utilization_year"]." "._p("ForestResourceText3");
?>

<h4 class="sub-omheader "><?php echo _p("ResourceSubTitle6"); ?></h4>
<div class="table-responsive-md">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="5"><?php echo $title; ?></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th colspan="2"><?php echo _p("ResourceSub6ColumnText1");?></th>
        <th><?php echo _p("ResourceSub6ColumnText2");?></th>
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
    </tbody>
  </table>
  <table class="table">
    <tbody>
      <tr>
        <td><a class="btn btn-success" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?></a></td>
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
