<?php
if (isset($_GET["violation_id"]))
{
	$violation_id = (int)$_GET["violation_id"];
}else
{
	$violation_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "va.aimag_name_mn, va.soum_name_mn, va.aimag_name_en, va.soum_name_en, taf.* FROM ".$schemas.".taviolation taf, scadministrative.vasoumname va";
$whereQuery = "WHERE taf.soum_code = va.soum_code AND taf.violation_id=".$violation_id;
    
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
	$title = $row[$i]["aimag_name_$language_name"]." "._p("ForestResourceText1")." ".$row[$i]["soum_name_$language_name"]." "._p("ForestResourceText2").", ".$row[$i]["violation_year"]." "._p("ForestResourceText3");
?>

<h4 class="sub-omheader "><?php echo _p("ResourceSubTitle8"); ?></h4>
<div class="table-responsive-md">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="5"><?php echo $title; ?></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th colspan="2"><?php echo _p("ResourceSub8ColumnText1");?></th>
        <th><?php echo _p("ResourceSub8ColumnText2");?></th>
        <th><?php echo _p("ResourceSub8ColumnText3");?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>1.</th>
        <td colspan="2"><?php echo _p("ResourceSub8MoreColumn1");?></td>
        <td><?php echo _p("ResourceSub8Unit1");?></td>
        <td><?php echo $row[$i]["violation_number"]; ?></td>
      </tr>
      <tr>
        <th>2.</th>
        <td colspan="2"><?php echo _p("ResourceSub8MoreColumn2");?></td>
        <td><?php echo _p("ResourceSub8Unit2");?></td>
        <td><?php echo $row[$i]["illegallogging_wood"]; ?></td>
      </tr>
      <tr>
        <th>3.</th>
        <td colspan="2"><?php echo _p("ResourceSub8MoreColumn3");?></td>
        <td><?php echo _p("ResourceSub8Unit3");?></td>
        <td><?php echo $row[$i]["place_name"]; ?></td>
      </tr>
      <tr>
        <th>4.</th>
        <td colspan="2"><?php echo _p("ResourceSub8MoreColumn4");?></td>
        <td><?php echo _p("ResourceSub8Unit1");?></td>
        <td><?php echo $row[$i]["escheat_tools_number"]; ?></td>
      </tr>	    
      <tr>
        <th rowspan="2">5.</th>
        <td rowspan="2"><?php echo _p("ResourceSub8ColumnText4");?></td>
        <td><?php echo _p("ResourceSub8MoreColumn5");?></td>
        <td><?php echo _p("ResourceSub8Unit4");?></td>
        <td><?php echo $row[$i]["forfeit_cost"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub8MoreColumn6");?></td>
        <td><?php echo _p("ResourceSub8Unit4");?></td>
        <td><?php echo $row[$i]["indemnity_cost"]; ?></td>
      </tr>
      <tr>
        <th>6.</th>
        <td colspan="2"><?php echo _p("ResourceSub8MoreColumn7");?></td>
        <td><?php echo _p("ResourceSub8Unit5");?></td>
        <td><?php echo $row[$i]["illegal_nontimberproduct"]; ?></td>
      </tr>
      <tr>
        <th>7.</th>
        <td colspan="2"><?php echo _p("ResourceSub8MoreColumn8");?></td>
        <td><?php echo _p("ResourceSub8Unit3");?></td>
        <td><?php echo $row[$i]["violation_note"]; ?></td>
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
