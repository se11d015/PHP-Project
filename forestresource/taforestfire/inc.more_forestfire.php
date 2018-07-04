<?php
if (isset($_GET["fire_id"]))
{
	$fire_id = (int)$_GET["fire_id"];
}else
{
	$fire_id = 0;
}
	

$i = 0;
$startQuery = "SELECT";
$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en, tau.organization||' - '|| tau.lastname as user_name  FROM ".$schemas.".taforestfire taf, scadministrative.vasoumname vs,".$schemas.".tausers tau";
$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.user_id = tau.user_id AND taf.fire_id = ".$fire_id;
		
if($checkaimag==1) 
{
	$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
}	

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);

if (!empty($row))
{
	$user_id  = $row[$i]["user_id"];
	$fire_id  = $row[$i]["fire_id"];
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="5"><?php echo _p("MoreText1")." "._p("ResourceSubTitle3")." "._p("MoreText2"); ?></th>
      </tr>
      <tr>
        <th style="width: 5%">№</th>
        <th colspan="2" style="width: 35%"><?php echo _p("ResourceSub3ColumnText1");?></th>
        <th style="width: 10%"><?php echo _p("ResourceSub3ColumnText2");?></th>
        <th><?php echo _p("ResourceSub3ColumnText3");?></th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <th>1.</th>
          <td colspan="2"><?php echo _p("ResourceSub3MoreColumn1");?></td>
          <td><?php echo _p("ResourceSub3Unit1");?></td>
          <td><?php echo $row[$i]["fire_number"]; ?></td>
        </tr>
        <tr>
          <th>2.</th>
          <td colspan="2"><?php echo _p("ResourceSub3MoreColumn2");?></td>
          <td><?php echo _p("ResourceSub3Unit2");?></td>
          <td><?php echo $row[$i]["place_name"]; ?></td>
        </tr>
        <tr>
          <th>3.</th>
          <td colspan="2"><?php echo _p("ResourceSub3MoreColumn3");?></td>
          <td><?php echo _p("ResourceSub3Unit2");?></td>
          <td><?php echo $row[$i]["fire_date"]; ?></td>
        </tr>
        <tr>
          <th rowspan="5">4.</th>
          <td rowspan="5"><?php echo _p("ResourceSub3ColumnText4");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn4");?></td>
          <td><?php echo _p("ResourceSub3Unit3");?></td>
          <td><?php echo $row[$i]["burnt_forest_area"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn5");?></td>
          <td><?php echo _p("ResourceSub3Unit3");?></td>
          <td><?php echo $row[$i]["burnt_pasture_area"]; ?> </td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn6");?></td>
          <td><?php echo _p("ResourceSub3Unit3");?></td>
          <td><?php echo $row[$i]["burnt_argiculture_area"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn7");?></td>
          <td><?php echo _p("ResourceSub3Unit3");?></td>
          <td><?php echo $row[$i]["burnt_grassland_area"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn8");?></td>
          <td><?php echo _p("ResourceSub3Unit3");?></td>
          <td><?php echo $row[$i]["total_burnt_area"]; ?></td>
        </tr>
        <tr>
          <th rowspan="4">5.</th>
          <td rowspan="4"><?php echo _p("ResourceSub3ColumnText5");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn9");?></td>
          <td><?php echo _p("ResourceSub3Unit3");?></td>
          <td><?php echo $row[$i]["burnt_larch_area"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn10");?></td>
          <td><?php echo _p("ResourceSub3Unit3");?></td>
          <td><?php echo $row[$i]["burnt_pine_area"]; ?> </td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn11");?></td>
          <td><?php echo _p("ResourceSub3Unit3");?></td>
          <td><?php echo $row[$i]["burnt_evergreen_area"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn12");?></td>
          <td><?php echo _p("ResourceSub3Unit3");?></td>
          <td><?php echo $row[$i]["burnt_othertree_area"]; ?></td>
        </tr>
        <tr>
          <th rowspan="5">6.</th>
          <td rowspan="5"><?php echo _p("ResourceSub3ColumnText6");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn13");?></td>
          <td><?php echo _p("ResourceSub3Unit1");?></td>
          <td><?php echo $row[$i]["mobilized_people_number"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn14");?></td>
          <td><?php echo _p("ResourceSub3Unit1");?></td>
          <td><?php echo $row[$i]["mobilized_car_number"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn15");?></td>
          <td><?php echo _p("ResourceSub3Unit1");?></td>
          <td><?php echo $row[$i]["mobilized_tractor_number"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn16");?></td>
          <td><?php echo _p("ResourceSub3Unit1");?></td>
          <td><?php echo $row[$i]["mobilized_motorcycle_number"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn17");?></td>
          <td><?php echo _p("ResourceSub3Unit1");?></td>
          <td><?php echo $row[$i]["mobilized_cart_number"]; ?></td>
        </tr>
        <tr>
          <th rowspan="3">7.</th>
          <td rowspan="3"><?php echo _p("ResourceSub3ColumnText7");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn18");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["forest_damage_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn19");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["pasture_damage_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn20");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["wildlife_damage_cost"]; ?></td>
        </tr>
        <tr>
          <th rowspan="7">8.</th>
          <td rowspan="7"><?php echo _p("ResourceSub3ColumnText8");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn21");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["animal_damage_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn22");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["ger_damage_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn23");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["house_damage_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn24");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["fence_damage_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn25");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["car_damage_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn26");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["grass_damage_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn27");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["other_property_cost"]; ?></td>
        </tr>
        <tr>
          <th>9.</th>
          <td colspan="2"><?php echo _p("ResourceSub3MoreColumn28");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["total_damage_cost"]; ?></td>
        </tr>
        <tr>
          <th rowspan="3">10.</th>
          <td rowspan="3"><?php echo _p("ResourceSub3ColumnText9");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn29");?></td>
          <td><?php echo _p("ResourceSub3Unit1");?></td>
          <td><?php echo $row[$i]["died_people_number"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn30");?></td>
          <td><?php echo _p("ResourceSub3Unit1");?></td>
          <td><?php echo $row[$i]["burnt_people_number"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn31");?></td>
          <td><?php echo _p("ResourceSub3Unit1");?></td>
          <td><?php echo $row[$i]["affected_people_number"]; ?></td>
        </tr>
        <tr>
          <th rowspan="3">11.</th>
          <td rowspan="3"><?php echo _p("ResourceSub3ColumnText10");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn32");?></td>
          <td><?php echo _p("ResourceSub3Unit2");?></td>
          <td><?php echo $row[$i]["fire_source_human"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn33");?></td>
          <td><?php echo _p("ResourceSub3Unit2");?></td>
          <td><?php echo $row[$i]["fire_source_natural"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn34");?></td>
          <td><?php echo _p("ResourceSub3Unit2");?></td>
          <td><?php echo $row[$i]["fire_source_outside"]; ?></td>
        </tr>
        <tr>
          <th rowspan="7">12.</th>
          <td rowspan="7"><?php echo _p("ResourceSub3ColumnText11");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn35");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["damp_food_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn36");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["damp_petrol_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn37");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["damp_aeroplain_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn38");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["damp_salary_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn39");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["damp_moving_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn40");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["damp_other_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn41");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["total_damp_cost"]; ?></td>
        </tr>
        <tr>
          <th rowspan="4">13.</th>
          <td rowspan="4"><?php echo _p("ResourceSub3ColumnText12");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn42");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["prevention_technics_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn43");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["prevention_canvass_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn44");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["prevention_firewarden_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn45");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["prevention_training_cost"]; ?></td>
        </tr>
        <tr>
          <th rowspan="3">14.</th>
          <td rowspan="3"><?php echo _p("ResourceSub3ColumnText13");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn46");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["prevention_dustbelt_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn47");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["prevention_burntbelt_cost"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn48");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["prevention_clearing_cost"]; ?></td>
        </tr>
        <tr>
          <th rowspan="2">15.</th>
          <td rowspan="2"><?php echo _p("ResourceSub3ColumnText14");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn49");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["damage_indemnity_put"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn50");?></td>
          <td><?php echo _p("ResourceSub3Unit4");?></td>
          <td><?php echo $row[$i]["damage_indemnity_exhaustive"]; ?></td>
        </tr>
        <tr>
          <th>16.</th>
          <td colspan="2"><?php echo _p("ResourceSub3MoreColumn51");?></td>
          <td><?php echo _p("ResourceSub3Unit2");?></td>
          <td><?php echo $row[$i]["causer_address"]; ?></td>
        </tr>
        <tr>
          <th rowspan="3">17.</th>
          <td rowspan="3"><?php echo _p("ResourceSub3ColumnText14");?></td>	  
          <td><?php echo _p("ResourceSub3MoreColumn52");?></td>
          <td><?php echo _p("ResourceSub3Unit2");?></td>
          <td><?php echo $row[$i]["provision_causer_crime"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn53");?></td>
          <td><?php echo _p("ResourceSub3Unit2");?></td>
          <td><?php echo $row[$i]["provision_causer_administrative"]; ?></td>
        </tr>
        <tr>
          <td><?php echo _p("ResourceSub3MoreColumn54");?></td>
          <td><?php echo _p("ResourceSub3Unit2");?></td>
          <td><?php echo $row[$i]["provision_causer_fine"]; ?></td>
        </tr>
        <tr>
          <th>18.</th>
          <td colspan="2"><?php echo _p("ResourceSub3MoreColumn55");?></td>
          <td><?php echo _p("ResourceSub3Unit2");?></td>
          <td><?php echo $row[$i]["other"]; ?></td>
        </tr>
        <tr>
	      <th>19.</th>
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
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&fire_id=".$fire_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
          <?php } else if($user_id==$sess_user_id) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&fire_id=".$fire_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
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
