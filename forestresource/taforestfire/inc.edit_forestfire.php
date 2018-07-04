<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 2)) 
{
	if (isset($_GET["fire_id"]))
	{
		$fire_id = (int) $_GET["fire_id"];
	}else
	{
		$fire_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "taf.*, vs.aimag_code FROM ".$schemas.".taforestfire taf, scadministrative.vasoumname vs";
	
	if($sess_profile==1)
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.fire_id = ".$fire_id;
	else
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.fire_id = ".$fire_id." AND taf.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
    if (document.getElementById("fire_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub3Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub3Column2")." "._p("EnterText2");?>");
    }else {
        document.getElementById("updateforestfirebttn").value = "1";
        document.mainform.submit();
    }
}

function summary_area(){
    var f1, f2, f3, f4;
	if (document.getElementById("burnt_forest_area").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("burnt_forest_area").value)) f1=0;
		f1 = document.getElementById("burnt_forest_area").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("burnt_pasture_area").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("burnt_pasture_area").value)) f2=0;
		 f2 = document.getElementById("burnt_pasture_area").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("burnt_argiculture_area").value == "") {
		f3=0;
	} else {
		if (isNaN(document.getElementById("burnt_argiculture_area").value)) f3=0;
		f3 = document.getElementById("burnt_argiculture_area").value;
		f3 = parseFloat(f3.replace(",", "."));		
	}
	
	if (document.getElementById("burnt_grassland_area").value == "") {
		f4=0;
	} else { 
		if (isNaN(document.getElementById("burnt_grassland_area").value)) f4=0;
		f4 = document.getElementById("burnt_grassland_area").value; 
		f4 = parseFloat(f4.replace(",", "."));	
	}
	
	document.getElementById("total_burnt_area").value = parseFloat(f1+f2+f3+f4);	
		
}

function summary_damage(){
	var f1, f2, f3, f4, f5, f6, f7, f8, f9, f10;
	
	if (document.getElementById("forest_damage_cost").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("forest_damage_cost").value)) f1=0;
		f1 = document.getElementById("forest_damage_cost").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("pasture_damage_cost").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("pasture_damage_cost").value)) f2=0;
		 f2 = document.getElementById("pasture_damage_cost").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("wildlife_damage_cost").value == "") {
		f3=0;
	} else {
		if (isNaN(document.getElementById("wildlife_damage_cost").value)) f3=0;
		f3 = document.getElementById("wildlife_damage_cost").value;
		f3 = parseFloat(f3.replace(",", "."));		
	}
	
	if (document.getElementById("animal_damage_cost").value == "") {
		f4=0;
	} else { 
		if (isNaN(document.getElementById("animal_damage_cost").value)) f4=0;
		f4 = document.getElementById("animal_damage_cost").value; 
		f4 = parseFloat(f4.replace(",", "."));	
	}

	if (document.getElementById("ger_damage_cost").value == "") {
		f5=0;
	} else { 
		if (isNaN(document.getElementById("ger_damage_cost").value)) f5=0;
		f5 = document.getElementById("ger_damage_cost").value; 
		f5 = parseFloat(f5.replace(",", "."));	
	}
	
	if (document.getElementById("house_damage_cost").value == "") {
		f6=0;
	} else { 
		if (isNaN(document.getElementById("house_damage_cost").value)) f6=0;
		 f6 = document.getElementById("house_damage_cost").value;
         f6 = parseFloat(f6.replace(",", "."));		
	}
	
	if (document.getElementById("fence_damage_cost").value == "") {
		f7=0;
	} else {
		if (isNaN(document.getElementById("fence_damage_cost").value)) f7=0;
		f7 = document.getElementById("fence_damage_cost").value;
		f7 = parseFloat(f7.replace(",", "."));		
	}
	
	if (document.getElementById("car_damage_cost").value == "") {
		f8=0;
	} else { 
		if (isNaN(document.getElementById("car_damage_cost").value)) f8=0;
		f8 = document.getElementById("car_damage_cost").value; 
		f8 = parseFloat(f8.replace(",", "."));	
	}
	
	if (document.getElementById("grass_damage_cost").value == "") {
		f9=0;
	} else {
		if (isNaN(document.getElementById("grass_damage_cost").value)) f9=0;
		f9 = document.getElementById("grass_damage_cost").value;
		f9 = parseFloat(f9.replace(",", "."));		
	}
	
	if (document.getElementById("other_property_cost").value == "") {
		f10=0;
	} else { 
		if (isNaN(document.getElementById("other_property_cost").value)) f10=0;
		f10 = document.getElementById("other_property_cost").value; 
		f10 = parseFloat(f10.replace(",", "."));	
	}	
	document.getElementById("total_damage_cost").value = parseFloat(f1+f2+f3+f4+f5+f6+f7+f8+f9+f10);	
		
}

function summary_damp(){
	var f1, f2, f3, f4, f5, f6;
	
	if (document.getElementById("damp_food_cost").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("damp_food_cost").value)) f1=0;
		f1 = document.getElementById("damp_food_cost").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("damp_petrol_cost").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("damp_petrol_cost").value)) f2=0;
		 f2 = document.getElementById("damp_petrol_cost").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("damp_aeroplain_cost").value == "") {
		f3=0;
	} else {
		if (isNaN(document.getElementById("damp_aeroplain_cost").value)) f3=0;
		f3 = document.getElementById("damp_aeroplain_cost").value;
		f3 = parseFloat(f3.replace(",", "."));		
	}
	
	if (document.getElementById("damp_salary_cost").value == "") {
		f4=0;
	} else { 
		if (isNaN(document.getElementById("damp_salary_cost").value)) f4=0;
		f4 = document.getElementById("damp_salary_cost").value; 
		f4 = parseFloat(f4.replace(",", "."));	
	}

	if (document.getElementById("damp_moving_cost").value == "") {
		f5=0;
	} else { 
		if (isNaN(document.getElementById("damp_moving_cost").value)) f5=0;
		f5 = document.getElementById("damp_moving_cost").value; 
		f5 = parseFloat(f5.replace(",", "."));	
	}
	
	if (document.getElementById("damp_other_cost").value == "") {
		f6=0;
	} else { 
		if (isNaN(document.getElementById("damp_other_cost").value)) f6=0;
		 f6 = document.getElementById("damp_other_cost").value;
         f6 = parseFloat(f6.replace(",", "."));		
	}

	document.getElementById("total_damp_cost").value = parseFloat(f1+f2+f3+f4+f5+f6);	
		
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("EditText3")." "._p("ResourceSubTitle3")." "._p("EditText4"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="fire_id" id="fire_id" value="<?php echo $row[$i]["fire_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub3Column3"); ?> *:</label>
              <div class="col-md-2">
				<input type="text" class="form-control" name="fire_year" id="fire_year" value="<?php echo $row[$i]["fire_year"]; ?>"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub3Column1"); ?> *:</label>
              <div class="col-md-3">
                <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn";
					if($checkaimag==1)
						$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va 
						WHERE EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = va.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id.")) ORDER BY va.aimag_name_mn";
					$rows = $db->query($selQuery);
					echo seldatadb("aimag_code", "form-control", $rows, "aimag_code", "aimag_name_$language_name", $row[$i]["aimag_code"]);
					$aimagcode = $row[$i]["aimag_code"];
					?>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextSelect"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub3Column2"); ?> *:</label>
              <div class="col-md-3">
			    <?php
					$selQuery = "SELECT vs.soum_code, vs.soum_name_mn, vs.soum_name_en FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("soum_code", "form-control", $rows, "soum_code", "soum_name_$language_name", $row[$i]["soum_code"]);
					?>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextSelect"); ?></span> </div>
			  <div class="form-group row col-md-12">
			    <table>
				 <tbody>
				    <tr>
					  <th style="width: 5%">№</th>
					  <th colspan="2" style="width: 35%"><?php echo _p("ResourceSub3ColumnText1");?></th>
					  <th style="width: 10%"><?php echo _p("ResourceSub3ColumnText2");?></th>
					  <th><?php echo _p("ResourceSub3ColumnText3");?></th>
					  <th><?php echo _p("Description");?></th>
				    </tr>
					<tr>
					  <th>1.</th>
					  <td colspan="2"><?php echo _p("ResourceSub3MoreColumn1");?></td>
					  <td><?php echo _p("ResourceSub3Unit1");?></td>
					  <td><input type="text" class="form-control" name="fire_number" id="fire_number" value="<?php echo $row[$i]["fire_number"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
					</tr>
					<tr>
					  <th>2.</th>
					  <td colspan="2"><?php echo _p("ResourceSub3MoreColumn2");?></td>
					  <td><?php echo _p("ResourceSub3Unit2");?></td>
					  <td><textarea class="form-control" name="place_name" id="place_name" rows="3"><?php echo $row[$i]["place_name"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextChar100"); ?></span></td>
					</tr>
					<tr>
					  <th>3.</th>
					  <td colspan="2"><?php echo _p("ResourceSub3MoreColumn3");?></td>
					  <td><?php echo _p("ResourceSub3Unit2");?></td>
					  <td><textarea class="form-control" name="fire_date" id="fire_date" rows="2"><?php echo $row[$i]["fire_date"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextChar100"); ?></span></td>
					</tr>
					<tr>
					  <th rowspan="5">4.</th>
					  <td rowspan="5"><?php echo _p("ResourceSub3ColumnText4");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn4");?></td>
					  <td><?php echo _p("ResourceSub3Unit3");?></td>
					  <td><input type="text" class="form-control" name="burnt_forest_area" id="burnt_forest_area" value="<?php echo $row[$i]["burnt_forest_area"]; ?>" onChange="summary_area()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?> </span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn5");?></td>
					  <td><?php echo _p("ResourceSub3Unit3");?></td>
					  <td><input type="text" class="form-control" name="burnt_pasture_area" id="burnt_pasture_area" value="<?php echo $row[$i]["burnt_pasture_area"]; ?>" onChange="summary_area()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?> </span></td>					  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn6");?></td>
					  <td><?php echo _p("ResourceSub3Unit3");?></td>
					  <td><input type="text" class="form-control" name="burnt_argiculture_area" id="burnt_argiculture_area" value="<?php echo $row[$i]["burnt_argiculture_area"]; ?>" onChange="summary_area()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?> </span></td>	
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn7");?></td>
					  <td><?php echo _p("ResourceSub3Unit3");?></td>
					  <td><input type="text" class="form-control" name="burnt_grassland_area" id="burnt_grassland_area" value="<?php echo $row[$i]["burnt_grassland_area"]; ?>" onChange="summary_area()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?> </span></td>	
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn8");?></td>
					  <td><?php echo _p("ResourceSub3Unit3");?></td>
					  <td><input type="text" disabled class="form-control" name="total_burnt_area" id="total_burnt_area" value="<?php echo $row[$i]["total_burnt_area"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?> </span></td>	
					</tr>
					<tr>
					  <th rowspan="4">5.</th>
					  <td rowspan="4"><?php echo _p("ResourceSub3ColumnText5");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn9");?></td>
					  <td><?php echo _p("ResourceSub3Unit3");?></td>
					  <td><input type="text" class="form-control" name="burnt_larch_area" id="burnt_larch_area" value="<?php echo $row[$i]["burnt_larch_area"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?> </span></td>					  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn10");?></td>
					  <td><?php echo _p("ResourceSub3Unit3");?></td>
					  <td><input type="text" class="form-control" name="burnt_pine_area" id="burnt_pine_area" value="<?php echo $row[$i]["burnt_pine_area"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?> </span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn11");?></td>
					  <td><?php echo _p("ResourceSub3Unit3");?></td>
					  <td><input type="text" class="form-control" name="burnt_evergreen_area" id="burnt_evergreen_area" value="<?php echo $row[$i]["burnt_evergreen_area"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?> </span></td>	
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn12");?></td>
					  <td><?php echo _p("ResourceSub3Unit3");?></td>
					  <td><input type="text" class="form-control" name="burnt_othertree_area" id="burnt_othertree_area" value="<?php echo $row[$i]["burnt_othertree_area"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?> </span></td>						  
					</tr>
					<tr>
					  <th rowspan="5">6.</th>
					  <td rowspan="5"><?php echo _p("ResourceSub3ColumnText6");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn13");?></td>
					  <td><?php echo _p("ResourceSub3Unit1");?></td>
					  <td><input type="text" class="form-control" name="mobilized_people_number" id="mobilized_people_number" value="<?php echo $row[$i]["mobilized_people_number"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?> </span></td>	
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn14");?></td>
					  <td><?php echo _p("ResourceSub3Unit1");?></td>
					  <td><input type="text" class="form-control" name="mobilized_car_number" id="mobilized_car_number" value="<?php echo $row[$i]["mobilized_car_number"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?> </span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn15");?></td>
					  <td><?php echo _p("ResourceSub3Unit1");?></td>
					  <td><input type="text" class="form-control" name="mobilized_tractor_number" id="mobilized_tractor_number" value="<?php echo $row[$i]["mobilized_tractor_number"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?> </span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn16");?></td>
					  <td><?php echo _p("ResourceSub3Unit1");?></td>
					  <td><input type="text" class="form-control" name="mobilized_motorcycle_number" id="mobilized_motorcycle_number" value="<?php echo $row[$i]["mobilized_motorcycle_number"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?> </span></td>	
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn17");?></td>
					  <td><?php echo _p("ResourceSub3Unit1");?></td>
					  <td><input type="text" class="form-control" name="mobilized_cart_number" id="mobilized_cart_number" value="<?php echo $row[$i]["mobilized_cart_number"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?> </span></td>						  
					</tr>
					<tr>
					  <th rowspan="3">7.</th>
					  <td rowspan="3"><?php echo _p("ResourceSub3ColumnText7");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn18");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="forest_damage_cost" id="forest_damage_cost" value="<?php echo $row[$i]["forest_damage_cost"]; ?>" onChange="summary_damage()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn19");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="pasture_damage_cost" id="pasture_damage_cost" value="<?php echo $row[$i]["pasture_damage_cost"]; ?>" onChange="summary_damage()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn20");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="wildlife_damage_cost" id="wildlife_damage_cost" value="<?php echo $row[$i]["wildlife_damage_cost"]; ?>" onChange="summary_damage()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <th rowspan="7">8.</th>
					  <td rowspan="7"><?php echo _p("ResourceSub3ColumnText8");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn21");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="animal_damage_cost" id="animal_damage_cost" value="<?php echo $row[$i]["animal_damage_cost"]; ?>" onChange="summary_damage()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn22");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="ger_damage_cost" id="ger_damage_cost" value="<?php echo $row[$i]["ger_damage_cost"]; ?>" onChange="summary_damage()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn23");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="house_damage_cost" id="house_damage_cost" value="<?php echo $row[$i]["house_damage_cost"]; ?>" onChange="summary_damage()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn24");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="fence_damage_cost" id="fence_damage_cost" value="<?php echo $row[$i]["fence_damage_cost"]; ?>" onChange="summary_damage()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn25");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="car_damage_cost" id="car_damage_cost" value="<?php echo $row[$i]["car_damage_cost"]; ?>" onChange="summary_damage()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn26");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="grass_damage_cost" id="grass_damage_cost" value="<?php echo $row[$i]["grass_damage_cost"]; ?>" onChange="summary_damage()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn27");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="other_property_cost" id="other_property_cost" value="<?php echo $row[$i]["other_property_cost"]; ?>" onChange="summary_damage()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <th>9.</th>
					  <td colspan="2"><?php echo _p("ResourceSub3MoreColumn28");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" disabled class="form-control" name="total_damage_cost" id="total_damage_cost" value="<?php echo $row[$i]["total_damage_cost"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>						  
					</tr>
					<tr>
					  <th rowspan="3">10.</th>
					  <td rowspan="3"><?php echo _p("ResourceSub3ColumnText9");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn29");?></td>
					  <td><?php echo _p("ResourceSub3Unit1");?></td>
					  <td><input type="text" class="form-control" name="died_people_number" id="died_people_number" value="<?php echo $row[$i]["died_people_number"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?> </span></td>	
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn30");?></td>
					  <td><?php echo _p("ResourceSub3Unit1");?></td>
					  <td><input type="text" class="form-control" name="burnt_people_number" id="burnt_people_number" value="<?php echo $row[$i]["burnt_people_number"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?> </span></td>	
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn31");?></td>
					  <td><?php echo _p("ResourceSub3Unit1");?></td>
					  <td><input type="text" class="form-control" name="affected_people_number" id="affected_people_number" value="<?php echo $row[$i]["affected_people_number"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?> </span></td>	
					</tr>
					<tr>
					  <th rowspan="3">11.</th>
					  <td rowspan="3"><?php echo _p("ResourceSub3ColumnText10");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn32");?></td>
					  <td><?php echo _p("ResourceSub3Unit2");?></td>
					  <td><textarea class="form-control" name="fire_source_human" id="fire_source_human" rows="2"><?php echo $row[$i]["fire_source_human"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn33");?></td>
					  <td><?php echo _p("ResourceSub3Unit2");?></td>
					  <td><textarea class="form-control" name="fire_source_natural" id="fire_source_natural" rows="2"><?php echo $row[$i]["fire_source_natural"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span></td>						  
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn34");?></td>
					  <td><?php echo _p("ResourceSub3Unit2");?></td>
					  <td><textarea class="form-control" name="fire_source_outside" id="fire_source_outside" rows="2"><?php echo $row[$i]["fire_source_outside"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span></td>						  
					</tr>
					<tr>
					  <th rowspan="7">12.</th>
					  <td rowspan="7"><?php echo _p("ResourceSub3ColumnText11");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn35");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="damp_food_cost" id="damp_food_cost" value="<?php echo $row[$i]["damp_food_cost"]; ?>" onChange="summary_damp()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn36");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="damp_petrol_cost" id="damp_petrol_cost" value="<?php echo $row[$i]["damp_petrol_cost"]; ?>" onChange="summary_damp()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn37");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="damp_aeroplain_cost" id="damp_aeroplain_cost" value="<?php echo $row[$i]["damp_aeroplain_cost"]; ?>" onChange="summary_damp()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn38");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="damp_salary_cost" id="damp_salary_cost" value="<?php echo $row[$i]["damp_salary_cost"]; ?>" onChange="summary_damp()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn39");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="damp_moving_cost" id="damp_moving_cost" value="<?php echo $row[$i]["damp_moving_cost"]; ?>" onChange="summary_damp()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn40");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="damp_other_cost" id="damp_other_cost" value="<?php echo $row[$i]["damp_other_cost"]; ?>" onChange="summary_damp()"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn41");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" disabled class="form-control" name="total_damp_cost" id="total_damp_cost" value="<?php echo $row[$i]["total_damp_cost"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <th rowspan="4">13.</th>
					  <td rowspan="4"><?php echo _p("ResourceSub3ColumnText12");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn42");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="prevention_technics_cost" id="prevention_technics_cost" value="<?php echo $row[$i]["prevention_technics_cost"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn43");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="prevention_canvass_cost" id="prevention_canvass_cost" value="<?php echo $row[$i]["prevention_canvass_cost"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn44");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="prevention_firewarden_cost" id="prevention_firewarden_cost" value="<?php echo $row[$i]["prevention_firewarden_cost"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn45");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="prevention_training_cost" id="prevention_training_cost" value="<?php echo $row[$i]["prevention_training_cost"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <th rowspan="3">14.</th>
					  <td rowspan="3"><?php echo _p("ResourceSub3ColumnText13");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn46");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="prevention_dustbelt_cost" id="prevention_dustbelt_cost" value="<?php echo $row[$i]["prevention_dustbelt_cost"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn47");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="prevention_burntbelt_cost" id="prevention_burntbelt_cost" value="<?php echo $row[$i]["prevention_burntbelt_cost"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn48");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="prevention_clearing_cost" id="prevention_clearing_cost" value="<?php echo $row[$i]["prevention_clearing_cost"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <th rowspan="2">15.</th>
					  <td rowspan="2"><?php echo _p("ResourceSub3ColumnText14");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn49");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="damage_indemnity_put" id="damage_indemnity_put" value="<?php echo $row[$i]["damage_indemnity_put"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn50");?></td>
					  <td><?php echo _p("ResourceSub3Unit4");?></td>
					  <td><input type="text" class="form-control" name="damage_indemnity_exhaustive" id="damage_indemnity_exhaustive" value="<?php echo $row[$i]["damage_indemnity_exhaustive"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
					</tr>
					<tr>
					  <th>16.</th>
					  <td colspan="2"><?php echo _p("ResourceSub3MoreColumn51");?></td>
					  <td><?php echo _p("ResourceSub3Unit2");?></td>
					  <td><textarea class="form-control" name="causer_address" id="causer_address" rows="3"><?php echo $row[$i]["causer_address"]; ?></textarea></td>
					  <td><span class="form-text text-muted">1<?php echo _p("AlertTextChar50"); ?></span></td>
					</tr>
					<tr>
					  <th rowspan="3">17.</th>
					  <td rowspan="3"><?php echo _p("ResourceSub3ColumnText14");?></td>	  
					  <td><?php echo _p("ResourceSub3MoreColumn52");?></td>
					  <td><?php echo _p("ResourceSub3Unit2");?></td>
					  <td><textarea class="form-control" name="provision_causer_crime" id="provision_causer_crime" rows="2"><?php echo $row[$i]["provision_causer_crime"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn53");?></td>
					  <td><?php echo _p("ResourceSub3Unit2");?></td>
					  <td><textarea class="form-control" name="provision_causer_administrative" id="provision_causer_administrative" rows="2"><?php echo $row[$i]["provision_causer_administrative"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub3MoreColumn54");?></td>
					  <td><?php echo _p("ResourceSub3Unit2");?></td>
					  <td><textarea class="form-control" name="provision_causer_fine" id="provision_causer_fine" rows="2"><?php echo $row[$i]["provision_causer_fine"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span></td>
					</tr>
					<tr>
					  <th>18.</th>
					  <td colspan="2"><?php echo _p("ResourceSub3MoreColumn55");?></td>
					  <td><?php echo _p("ResourceSub3Unit2");?></td>
					  <td><textarea class="form-control" name="other" id="other" rows="3"><?php echo $row[$i]["other"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>
					</tr>
				  </tbody>
				</table>
			  </div>			  
            <input type="hidden" id="updateforestfirebttn" name="updateforestfirebttn" value="0"/>
            <div class="form-group row col-md-10 justify-content-center">
              <div>
                <button type="button" class="btn btn-primary" onclick="updatesubmitform()"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
                <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></a> </div>
            </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php 
	} else {
		$notify = " <a class=\"btn btn-danger\" href=\"".$my_url.$my_page.$search_url.$sort_url."\"><i class=\"fa fa-undo\"></i> "._p("BackButton")." </a>";
		show_notification("error", _p("NotRowText"), $notify);
	}
} else {
	show_notification("error", _p("NotAccessText"), "");
}		
?>
