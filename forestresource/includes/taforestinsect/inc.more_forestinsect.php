<?php
if (isset($_GET["insect_id"]))
{
	$insect_id = (int)$_GET["insect_id"];
}else
{
	$insect_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "va.aimag_name_mn, va.soum_name_mn, va.aimag_name_en, va.soum_name_en, taf.* FROM ".$schemas.".taforestinsect taf, scadministrative.vasoumname va";
$whereQuery = "WHERE taf.soum_code = va.soum_code AND taf.insect_id=".$insect_id;
    
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
	$title = $row[$i]["aimag_name_$language_name"]." "._p("ForestResourceText1")." ".$row[$i]["soum_name_$language_name"]." "._p("ForestResourceText2").", ".$row[$i]["insect_year"]." "._p("ForestResourceText3");
?>
<h4 class="sub-omheader "><?php echo _p("ResourceSubTitle4"); ?></h4>	  
<div class="table-responsive-md">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="5"><?php echo $title; ?></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th colspan="2"><?php echo _p("ResourceSub4ColumnText1");?></th>
        <th><?php echo _p("ResourceSub4ColumnText2");?></th>
        <th><?php echo _p("ResourceSub4ColumnText3");?></th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <th>1.</th>
          <td colspan="2"><?php echo _p("ResourceSub4MoreColumn1");?></td>
          <td><?php echo _p("ResourceSub4Unit1");?></td>
          <td><?php echo $row[$i]["insect_study_area"]; ?></td>
        </tr>
        <tr>
          <th>2.</th>
          <td colspan="2"><?php echo _p("ResourceSub4MoreColumn2");?></td>
          <td><?php echo _p("ResourceSub4Unit1");?></td>
          <td><?php echo $row[$i]["insect_spread_area"]; ?></td>
        </tr>
        <tr>
          <th>3.</th>
          <td colspan="2"><?php echo _p("ResourceSub4MoreColumn3");?></td>
          <td><?php echo _p("ResourceSub4Unit1");?></td>
          <td><?php echo $row[$i]["insect_damage_area"]; ?></td>
        </tr>
        <tr>
          <th>4.</th>
          <td colspan="2"><?php echo _p("ResourceSub4MoreColumn4");?></td>
          <td><?php echo _p("ResourceSub4Unit5");?></td>
          <td><?php echo $row[$i]["insect_name"]; ?></td>
        </tr>		
        <tr>
          <th rowspan="5">5.</th>
          <td rowspan="5"><?php echo _p("ResourceSub4ColumnText4");?></td>	  
          <td rowspan="2"><?php echo _p("ResourceSub4MoreColumn5");?></td>
          <td><?php echo _p("ResourceSub4Unit2");?></td>
          <td><?php echo $row[$i]["control_aeroplain_number"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub4Unit1");?></td>
          <td><?php echo $row[$i]["control_aeroplain_area"]; ?></td>
        </tr>		
        <tr>
          <td><?php echo _p("ResourceSub4MoreColumn6");?></td>
          <td><?php echo _p("ResourceSub4Unit1");?></td>
          <td><?php echo $row[$i]["control_spray_area"]; ?></td>
        </tr>
        <tr>
          <td rowspan="2"><?php echo _p("ResourceSub4MoreColumn7");?></td>
          <td><?php echo _p("ResourceSub4Unit3");?></td>
          <td><?php echo $row[$i]["control_mechanics_size"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub4Unit1");?></td>
          <td><?php echo $row[$i]["control_mechanics_area"]; ?></td>
        </tr>		
        <tr>
          <th>6.</th>
          <td colspan="2"><?php echo _p("ResourceSub4MoreColumn8");?></td>
          <td><?php echo _p("ResourceSub4Unit4");?></td>
          <td><?php echo $row[$i]["control_result"]; ?></td>
        </tr>	
        <tr>
          <th>7.</th>
          <td colspan="2"><?php echo _p("ResourceSub4MoreColumn9");?></td>
          <td><?php echo _p("ResourceSub4Unit5");?></td>
          <td><?php echo $row[$i]["control_location"]; ?></td>
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
