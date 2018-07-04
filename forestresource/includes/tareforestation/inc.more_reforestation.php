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
$valueQuery = "va.aimag_name_mn, va.soum_name_mn, va.aimag_name_en, va.soum_name_en, taf.* FROM ".$schemas.".tareforestation taf, scadministrative.vasoumname va";
$whereQuery = "WHERE taf.soum_code = va.soum_code AND taf.reforest_id=".$reforest_id;
    
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
	$title = $row[$i]["aimag_name_$language_name"]." "._p("ForestResourceText1")." ".$row[$i]["soum_name_$language_name"]." "._p("ForestResourceText2").", ".$row[$i]["reforest_year"]." "._p("ForestResourceText3");
?>

<h4 class="sub-omheader "><?php echo _p("ResourceSubTitle5"); ?></h4>
<div class="table-responsive-md">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="5"><?php echo $title; ?></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th colspan="2"><?php echo _p("ResourceSub5ColumnText1");?></th>
        <th><?php echo _p("ResourceSub5ColumnText2");?></th>
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
