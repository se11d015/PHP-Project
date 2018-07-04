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
$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en, tau.organization||' - '|| tau.lastname as user_name  FROM ".$schemas.".taviolation taf, scadministrative.vasoumname vs,".$schemas.".tausers tau";
$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.user_id = tau.user_id AND taf.violation_id = ".$violation_id;
		
if($checkaimag==1) 
{
	$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
}	

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);

if (!empty($row))
{
	$user_id  = $row[$i]["user_id"];
	$violation_id  = $row[$i]["violation_id"];
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="5"><?php echo _p("MoreText1")." "._p("ResourceSubTitle8")." "._p("MoreText2"); ?></th>
      </tr>
      <tr>
        <th style="width: 5%">№</th>
        <th colspan="2" style="width: 35%"><?php echo _p("ResourceSub8ColumnText1");?></th>
        <th style="width: 10%"><?php echo _p("ResourceSub8ColumnText2");?></th>
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
	  <tr>
	    <th>8.</th>
        <td colspan="2"><?php echo _p("DataEntryUserName");?></td>
        <td colspan="2"><?php echo $row[$i]["user_name"]; ?></td>
      </tr>
    </tbody>
  </table>
</div>

<div class="table-responsive">
  <table class="table">
    <tbody>
      <tr>
        <td><?php if($sess_profile==1) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&violation_id=".$violation_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
          <?php } else if($user_id==$sess_user_id) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&violation_id=".$violation_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
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
