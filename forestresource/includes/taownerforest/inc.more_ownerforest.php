<?php
if (isset($_GET["owner_id"]))
{
	$owner_id = (int)$_GET["owner_id"];
}else
{
	$owner_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "va.aimag_name_mn, va.soum_name_mn, va.aimag_name_en, va.soum_name_en, taf.* FROM ".$schemas.".taownerforest taf, scadministrative.vasoumname va";
$whereQuery = "WHERE taf.soum_code = va.soum_code AND taf.owner_id=".$owner_id;
    
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
	$title = $row[$i]["aimag_name_$language_name"]." "._p("ForestResourceText1")." ".$row[$i]["soum_name_$language_name"]." "._p("ForestResourceText2").", ".$row[$i]["owner_year"]." "._p("ForestResourceText3");
?>

<h4 class="sub-omheader "><?php echo _p("ResourceSubTitle7"); ?></h4>
<div class="table-responsive-md">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="5"><?php echo $title; ?></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th colspan="2"><?php echo _p("ResourceSub7ColumnText1");?></th>
        <th><?php echo _p("ResourceSub7ColumnText2");?></th>
        <th><?php echo _p("ResourceSub7ColumnText3");?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th rowspan="4">1.</th>
        <td rowspan="4"><?php echo _p("ResourceSub7ColumnText4");?></td>
        <td><?php echo _p("ResourceSub7MoreColumn1");?></td>
        <td><?php echo _p("ResourceSub7Unit1");?></td>
        <td><?php echo $row[$i]["owner_community_number"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub7MoreColumn2");?></td>
        <td><?php echo _p("ResourceSub7Unit1");?></td>
        <td><?php echo $row[$i]["owner_organization_number"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub7MoreColumn3");?></td>
        <td><?php echo _p("ResourceSub7Unit1");?></td>
        <td><?php echo $row[$i]["owner_other_number"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub7MoreColumn4");?></td>
        <td><?php echo _p("ResourceSub7Unit1");?></td>
        <td><?php echo $row[$i]["total_owner_number"]; ?></td>
      </tr>	  
      <tr>
        <th rowspan="4">2.</th>
        <td rowspan="4"><?php echo _p("ResourceSub7ColumnText5");?></td>
        <td><?php echo _p("ResourceSub7MoreColumn5");?></td>
        <td><?php echo _p("ResourceSub7Unit2");?></td>
        <td><?php echo $row[$i]["owner_community_area"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub7MoreColumn6");?></td>
        <td><?php echo _p("ResourceSub7Unit2");?></td>
        <td><?php echo $row[$i]["owner_organization_area"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub7MoreColumn7");?></td>
        <td><?php echo _p("ResourceSub7Unit2");?></td>
        <td><?php echo $row[$i]["owner_other_area"]; ?></td>
      </tr>
      <tr>
        <td><?php echo _p("ResourceSub7MoreColumn8");?></td>
        <td><?php echo _p("ResourceSub7Unit2");?></td>
        <td><?php echo $row[$i]["total_owner_area"]; ?></td>
      </tr>	  
      <tr>
        <th>3.</th>
        <td colspan="2"><?php echo _p("ResourceSub7MoreColumn9");?></td>
        <td><?php echo _p("ResourceSub7Unit3");?></td>
        <td><?php echo $row[$i]["owner_location"]; ?></td>
      </tr>
      <tr>
        <th>4.</th>
        <td colspan="2"><?php echo _p("ResourceSub7MoreColumn10");?></td>
        <td><?php echo _p("ResourceSub7Unit3");?></td>
        <td><?php echo $row[$i]["order_number"]; ?></td>
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
