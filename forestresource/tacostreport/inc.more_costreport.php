<?php
if (isset($_GET["cost_id"]))
{
	$cost_id = (int)$_GET["cost_id"];
}else
{
	$cost_id = 0;
}
	

$i = 0;
$startQuery = "SELECT";
$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en, tau.organization||' - '|| tau.lastname as user_name  FROM ".$schemas.".tacostreport taf, scadministrative.vasoumname vs,".$schemas.".tausers tau";
$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.user_id = tau.user_id AND taf.cost_id = ".$cost_id;
		
if($checkaimag==1) 
{
	$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
}	

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);

if (!empty($row))
{
	$user_id  = $row[$i]["user_id"];
	$cost_id  = $row[$i]["cost_id"];
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="6"><?php echo _p("MoreText1")." "._p("ResourceSubTitle9")." "._p("MoreText2"); ?></th>
      </tr>
      <tr>
        <th rowspan="2" style="width: 5%">№</th>
        <th rowspan="2" style="width: 30%"><?php echo _p("ResourceSub9ColumnText1");?></th>
        <th colspan="4"><?php echo _p("ResourceSub9ColumnText2");?></th>
      </tr>
      <tr>
        <th><?php echo _p("ResourceSub9ColumnText3");?></th>
        <th><?php echo _p("ResourceSub9ColumnText4");?></th>
        <th><?php echo _p("ResourceSub9ColumnText5");?></th>
        <th><?php echo _p("ResourceSub9ColumnText6");?></th>
      </tr>
      <tr>
        <th colspan="6"><?php echo _p("ResourceSub9ColumnText7");?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>1.1</th>
        <td><?php echo _p("ResourceSub9MoreColumn1");?></td>
        <td><?php echo $row[$i]["state_reforest"]; ?></td>
        <td><?php echo $row[$i]["local_reforest"]; ?></td>
        <td><?php echo $row[$i]["other_reforest"]; ?></td>
        <td><?php echo $row[$i]["state_reforest"]+$row[$i]["local_reforest"]+$row[$i]["other_reforest"]; ?></td>
      </tr>
      <tr>
        <th>1.2</th>
        <td><?php echo _p("ResourceSub9MoreColumn2");?></td>
        <td><?php echo $row[$i]["state_thin_clear"]; ?></td>
        <td><?php echo $row[$i]["local_thin_clear"]; ?></td>
        <td><?php echo $row[$i]["other_thin_clear"]; ?></td>
        <td><?php echo $row[$i]["state_thin_clear"]+$row[$i]["local_thin_clear"]+$row[$i]["other_thin_clear"]; ?></td>
      </tr>
      <tr>
        <th>1.3</th>
        <td><?php echo _p("ResourceSub9MoreColumn3");?></td>
        <td><?php echo $row[$i]["state_insect_study"]; ?></td>
        <td><?php echo $row[$i]["local_insect_study"]; ?></td>
        <td><?php echo $row[$i]["other_insect_study"]; ?></td>
        <td><?php echo $row[$i]["state_insect_study"]+$row[$i]["local_insect_study"]+$row[$i]["other_insect_study"]; ?></td>
      </tr>
      <tr>
        <th>1.4</th>
        <td><?php echo _p("ResourceSub9MoreColumn4");?></td>
        <td><?php echo $row[$i]["state_insect_control"]; ?></td>
        <td><?php echo $row[$i]["local_insect_control"]; ?></td>
        <td><?php echo $row[$i]["other_insect_control"]; ?></td>
        <td><?php echo $row[$i]["state_insect_control"]+$row[$i]["local_insect_control"]+$row[$i]["other_insect_control"]; ?></td>
      </tr>
      <tr>
        <th>1.5</th>
        <td><?php echo _p("ResourceSub9MoreColumn5");?></td>
        <td><?php echo $row[$i]["state_seed_prepare"]; ?></td>
        <td><?php echo $row[$i]["local_seed_prepare"]; ?></td>
        <td><?php echo $row[$i]["other_seed_prepare"]; ?></td>
        <td><?php echo $row[$i]["state_seed_prepare"]+$row[$i]["local_seed_prepare"]+$row[$i]["other_seed_prepare"]; ?></td>
      </tr>
      <tr>
        <th>1.6</th>
        <td><?php echo _p("ResourceSub9MoreColumn6");?></td>
        <td><?php echo $row[$i]["state_forest_training"]; ?></td>
        <td><?php echo $row[$i]["local_forest_training"]; ?></td>
        <td><?php echo $row[$i]["other_forest_training"]; ?></td>
        <td><?php echo $row[$i]["state_forest_training"]+$row[$i]["local_forest_training"]+$row[$i]["other_forest_training"]; ?></td>
      </tr>
      <tr>
        <th>1.7</th>
        <td><?php echo _p("ResourceSub9MoreColumn7");?></td>
        <td><?php echo $row[$i]["state_forest_equipment"]; ?></td>
        <td><?php echo $row[$i]["local_forest_equipment"]; ?></td>
        <td><?php echo $row[$i]["other_forest_equipment"]; ?></td>
        <td><?php echo $row[$i]["state_forest_equipment"]+$row[$i]["local_forest_equipment"]+$row[$i]["other_forest_equipment"]; ?></td>
      </tr>
      <tr>
        <th>1.8</th>
        <td><?php echo _p("ResourceSub9MoreColumn8");?></td>
        <td><?php echo $row[$i]["state_other_cost"]; ?></td>
        <td><?php echo $row[$i]["local_other_cost"]; ?></td>
        <td><?php echo $row[$i]["other_other_cost"]; ?></td>
        <td><?php echo $row[$i]["state_other_cost"]+$row[$i]["local_other_cost"]+$row[$i]["other_other_cost"]; ?></td>
      </tr>
    </tbody>
    <thead>
      <tr>
        <th colspan="6"><?php echo _p("ResourceSub9ColumnText8");?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>2.1</th>
        <td><?php echo _p("ResourceSub9MoreColumn9");?></td>
        <td><?php echo $row[$i]["state_income_nonforest_product"]; ?></td>
        <td><?php echo $row[$i]["local_income_nonforest_product"]; ?></td>
        <td><?php echo $row[$i]["other_income_nonforest_product"]; ?></td>
        <td><?php echo $row[$i]["state_income_nonforest_product"]+$row[$i]["local_income_nonforest_product"]+$row[$i]["other_income_nonforest_product"]; ?></td>
      </tr>
      <tr>
        <th>2.2</th>
        <td><?php echo _p("ResourceSub9MoreColumn10");?></td>
        <td><?php echo $row[$i]["state_income_logging"]; ?></td>
        <td><?php echo $row[$i]["local_income_logging"]; ?></td>
        <td><?php echo $row[$i]["other_income_logging"]; ?></td>
        <td><?php echo $row[$i]["state_income_logging"]+$row[$i]["local_income_logging"]+$row[$i]["other_income_logging"]; ?></td>
      </tr>
      <tr>
        <th>2.3</th>
        <td><?php echo _p("ResourceSub9MoreColumn11");?></td>
        <td><?php echo $row[$i]["state_income_fire_indemnity"]; ?></td>
        <td><?php echo $row[$i]["local_income_fire_indemnity"]; ?></td>
        <td><?php echo $row[$i]["other_income_fire_indemnity"]; ?></td>
        <td><?php echo $row[$i]["state_income_fire_indemnity"]+$row[$i]["local_income_fire_indemnity"]+$row[$i]["other_income_fire_indemnity"]; ?></td>
      </tr>
      <tr>
        <th>2.4</th>
        <td><?php echo _p("ResourceSub9MoreColumn12");?></td>
        <td><?php echo $row[$i]["state_income_indemnity"]; ?></td>
        <td><?php echo $row[$i]["local_income_indemnity"]; ?></td>
        <td><?php echo $row[$i]["other_income_indemnity"]; ?></td>
        <td><?php echo $row[$i]["state_income_indemnity"]+$row[$i]["local_income_indemnity"]+$row[$i]["other_income_indemnity"]; ?></td>
      </tr>
      <tr>
        <th>2.5</th>
        <td><?php echo _p("ResourceSub9MoreColumn13");?></td>
        <td><?php echo $row[$i]["state_income_seedling"]; ?></td>
        <td><?php echo $row[$i]["local_income_seedling"]; ?></td>
        <td><?php echo $row[$i]["other_income_seedling"]; ?></td>
        <td><?php echo $row[$i]["state_income_seedling"]+$row[$i]["local_income_seedling"]+$row[$i]["other_income_seedling"]; ?></td>
      </tr>
      <tr>
        <th colspan="2"><?php echo _p("DataEntryUserName");?>:</th>
        <td colspan="4"><?php echo $row[$i]["user_name"]; ?></td>
      </tr>
    </tbody>
  </table>
</div>

<div class="table-responsive">
  <table class="table">
    <tbody>
      <tr>
        <td><?php if($sess_profile==1) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&cost_id=".$cost_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
          <?php } else if($user_id==$sess_user_id) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&cost_id=".$cost_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
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
