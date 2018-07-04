<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 2)) 
{
	if (isset($_GET["cost_id"]))
	{
		$cost_id = (int) $_GET["cost_id"];
	}else
	{
		$cost_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "taf.*, vs.aimag_code FROM ".$schemas.".tacostreport taf, scadministrative.vasoumname vs";
	
	if($sess_profile==1)
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.cost_id = ".$cost_id;
	else
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.cost_id = ".$cost_id." AND taf.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
    if (document.getElementById("cost_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub9Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub9Column2")." "._p("EnterText2");?>");
    }else {
        document.getElementById("updatecostreportbttn").value = "1";
        document.mainform.submit();
    }
}
function summary_total_reforest(){
    var f1, f2, f3;
	if (document.getElementById("state_reforest").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_reforest").value)) f1=0;
		f1 = document.getElementById("state_reforest").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_reforest").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_reforest").value)) f2=0;
		 f2 = document.getElementById("local_reforest").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_reforest").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_reforest").value)) f3=0;
		 f3 = document.getElementById("other_reforest").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_reforest").value = parseFloat(f1+f2+f3);			
}
function summary_total_thin_clear(){
    var f1, f2, f3;
	if (document.getElementById("state_thin_clear").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_thin_clear").value)) f1=0;
		f1 = document.getElementById("state_thin_clear").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_thin_clear").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_thin_clear").value)) f2=0;
		 f2 = document.getElementById("local_thin_clear").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_thin_clear").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_thin_clear").value)) f3=0;
		 f3 = document.getElementById("other_thin_clear").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_thin_clear").value = parseFloat(f1+f2+f3);			
}
function summary_total_insect_study(){
    var f1, f2, f3;
	if (document.getElementById("state_insect_study").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_insect_study").value)) f1=0;
		f1 = document.getElementById("state_insect_study").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_insect_study").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_insect_study").value)) f2=0;
		 f2 = document.getElementById("local_insect_study").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_insect_study").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_insect_study").value)) f3=0;
		 f3 = document.getElementById("other_insect_study").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_insect_study").value = parseFloat(f1+f2+f3);			
}
function summary_total_insect_control(){
    var f1, f2, f3;
	if (document.getElementById("state_insect_control").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_insect_control").value)) f1=0;
		f1 = document.getElementById("state_insect_control").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_insect_control").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_insect_control").value)) f2=0;
		 f2 = document.getElementById("local_insect_control").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_insect_control").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_insect_control").value)) f3=0;
		 f3 = document.getElementById("other_insect_control").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_insect_control").value = parseFloat(f1+f2+f3);			
}
function summary_total_seed_prepare(){
    var f1, f2, f3;
	if (document.getElementById("state_seed_prepare").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_seed_prepare").value)) f1=0;
		f1 = document.getElementById("state_seed_prepare").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_seed_prepare").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_seed_prepare").value)) f2=0;
		 f2 = document.getElementById("local_seed_prepare").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_seed_prepare").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_seed_prepare").value)) f3=0;
		 f3 = document.getElementById("other_seed_prepare").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_seed_prepare").value = parseFloat(f1+f2+f3);			
}
function summary_total_forest_training(){
    var f1, f2, f3;
	if (document.getElementById("state_forest_training").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_forest_training").value)) f1=0;
		f1 = document.getElementById("state_forest_training").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_forest_training").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_forest_training").value)) f2=0;
		 f2 = document.getElementById("local_forest_training").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_forest_training").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_forest_training").value)) f3=0;
		 f3 = document.getElementById("other_forest_training").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_forest_training").value = parseFloat(f1+f2+f3);			
}
function summary_total_forest_equipment(){
    var f1, f2, f3;
	if (document.getElementById("state_forest_equipment").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_forest_equipment").value)) f1=0;
		f1 = document.getElementById("state_forest_equipment").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_forest_equipment").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_forest_equipment").value)) f2=0;
		 f2 = document.getElementById("local_forest_equipment").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_forest_equipment").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_forest_equipment").value)) f3=0;
		 f3 = document.getElementById("other_forest_equipment").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_forest_equipment").value = parseFloat(f1+f2+f3);			
}
function summary_total_other_cost(){
    var f1, f2, f3;
	if (document.getElementById("state_other_cost").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_other_cost").value)) f1=0;
		f1 = document.getElementById("state_other_cost").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_other_cost").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_other_cost").value)) f2=0;
		 f2 = document.getElementById("local_other_cost").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_other_cost").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_other_cost").value)) f3=0;
		 f3 = document.getElementById("other_other_cost").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_other_cost").value = parseFloat(f1+f2+f3);			
}
function summary_total_income_nonforest_product(){
    var f1, f2, f3;
	if (document.getElementById("state_income_nonforest_product").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_income_nonforest_product").value)) f1=0;
		f1 = document.getElementById("state_income_nonforest_product").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_income_nonforest_product").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_income_nonforest_product").value)) f2=0;
		 f2 = document.getElementById("local_income_nonforest_product").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_income_nonforest_product").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_income_nonforest_product").value)) f3=0;
		 f3 = document.getElementById("other_income_nonforest_product").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_income_nonforest_product").value = parseFloat(f1+f2+f3);			
}
function summary_total_income_logging(){
    var f1, f2, f3;
	if (document.getElementById("state_income_logging").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_income_logging").value)) f1=0;
		f1 = document.getElementById("state_income_logging").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_income_logging").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_income_logging").value)) f2=0;
		 f2 = document.getElementById("local_income_logging").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_income_logging").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_income_logging").value)) f3=0;
		 f3 = document.getElementById("other_income_logging").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_income_logging").value = parseFloat(f1+f2+f3);			
}
function summary_total_income_fire_indemnity(){
    var f1, f2, f3;
	if (document.getElementById("state_income_fire_indemnity").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_income_fire_indemnity").value)) f1=0;
		f1 = document.getElementById("state_income_fire_indemnity").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_income_fire_indemnity").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_income_fire_indemnity").value)) f2=0;
		 f2 = document.getElementById("local_income_fire_indemnity").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_income_fire_indemnity").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_income_fire_indemnity").value)) f3=0;
		 f3 = document.getElementById("other_income_fire_indemnity").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_income_fire_indemnity").value = parseFloat(f1+f2+f3);			
}
function summary_total_income_indemnity(){
    var f1, f2, f3;
	if (document.getElementById("state_income_indemnity").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_income_indemnity").value)) f1=0;
		f1 = document.getElementById("state_income_indemnity").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_income_indemnity").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_income_indemnity").value)) f2=0;
		 f2 = document.getElementById("local_income_indemnity").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_income_indemnity").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_income_indemnity").value)) f3=0;
		 f3 = document.getElementById("other_income_indemnity").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_income_indemnity").value = parseFloat(f1+f2+f3);			
}
function summary_total_income_seedling(){
    var f1, f2, f3;
	if (document.getElementById("state_income_seedling").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("state_income_seedling").value)) f1=0;
		f1 = document.getElementById("state_income_seedling").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("local_income_seedling").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("local_income_seedling").value)) f2=0;
		 f2 = document.getElementById("local_income_seedling").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("other_income_seedling").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("other_income_seedling").value)) f3=0;
		 f3 = document.getElementById("other_income_seedling").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	document.getElementById("total_income_seedling").value = parseFloat(f1+f2+f3);			
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("EditText3")." "._p("ResourceSubTitle9")." "._p("EditText4"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="cost_id" id="cost_id" value="<?php echo $row[$i]["cost_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub9Column3"); ?> *:</label>
              <div class="col-md-2">
				<input type="text" class="form-control" name="cost_year" id="cost_year" value="<?php echo $row[$i]["cost_year"]; ?>"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub9Column1"); ?> *:</label>
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
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub9Column2"); ?> *:</label>
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
				  <tr>
					<th>1.1</th>
					<td><?php echo _p("ResourceSub9MoreColumn1");?></td>
					<td><input type="text" class="form-control" name="state_reforest" id="state_reforest" value="<?php echo $row[$i]["state_reforest"]; ?>" onChange="summary_total_reforest()"/></td>
					<td><input type="text" class="form-control" name="local_reforest" id="local_reforest" value="<?php echo $row[$i]["local_reforest"]; ?>" onChange="summary_total_reforest()"/></td>
					<td><input type="text" class="form-control" name="other_reforest" id="other_reforest" value="<?php echo $row[$i]["other_reforest"]; ?>" onChange="summary_total_reforest()"/></td>
					<td><?php $total_reforest = $row[$i]["state_reforest"]+$row[$i]["local_reforest"]+$row[$i]["other_reforest"]; ?><input type="text" disabled class="form-control" name="total_reforest" id="total_reforest" value="<?php echo round($total_reforest,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>1.2</th>
					<td><?php echo _p("ResourceSub9MoreColumn2");?></td>
					<td><input type="text" class="form-control" name="state_thin_clear" id="state_thin_clear" value="<?php echo $row[$i]["state_thin_clear"]; ?>" onChange="summary_total_thin_clear()"/></td>
					<td><input type="text" class="form-control" name="local_thin_clear" id="local_thin_clear" value="<?php echo $row[$i]["local_thin_clear"]; ?>" onChange="summary_total_thin_clear()"/></td>
					<td><input type="text" class="form-control" name="other_thin_clear" id="other_thin_clear" value="<?php echo $row[$i]["other_thin_clear"]; ?>" onChange="summary_total_thin_clear()"/></td>
					<td><?php $total_thin_clear = $row[$i]["state_thin_clear"]+$row[$i]["local_thin_clear"]+$row[$i]["other_thin_clear"]; ?><input type="text" disabled class="form-control" name="total_thin_clear" id="total_thin_clear" value="<?php echo round($total_thin_clear,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>1.3</th>
					<td><?php echo _p("ResourceSub9MoreColumn3");?></td>
					<td><input type="text" class="form-control" name="state_insect_study" id="state_insect_study" value="<?php echo $row[$i]["state_insect_study"]; ?>" onChange="summary_total_insect_study()"/></td>
					<td><input type="text" class="form-control" name="local_insect_study" id="local_insect_study" value="<?php echo $row[$i]["local_insect_study"]; ?>" onChange="summary_total_insect_study()"/></td>
					<td><input type="text" class="form-control" name="other_insect_study" id="other_insect_study" value="<?php echo $row[$i]["other_insect_study"]; ?>" onChange="summary_total_insect_study()"/></td>
					<td><?php $total_insect_study = $row[$i]["state_insect_study"]+$row[$i]["local_insect_study"]+$row[$i]["other_insect_study"]; ?><input type="text" disabled class="form-control" name="total_insect_study" id="total_insect_study" value="<?php echo round($total_insect_study,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>1.4</th>
					<td><?php echo _p("ResourceSub9MoreColumn4");?></td>
					<td><input type="text" class="form-control" name="state_insect_control" id="state_insect_control" value="<?php echo $row[$i]["state_insect_control"]; ?>" onChange="summary_total_insect_control()"/></td>
					<td><input type="text" class="form-control" name="local_insect_control" id="local_insect_control" value="<?php echo $row[$i]["local_insect_control"]; ?>" onChange="summary_total_insect_control()"/></td>
					<td><input type="text" class="form-control" name="other_insect_control" id="other_insect_control" value="<?php echo $row[$i]["other_insect_control"]; ?>" onChange="summary_total_insect_control()"/></td>
					<td><?php $total_insect_control = $row[$i]["state_insect_control"]+$row[$i]["local_insect_control"]+$row[$i]["other_insect_control"]; ?><input type="text" disabled class="form-control" name="total_insect_control" id="total_insect_control" value="<?php echo round($total_insect_control,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>1.5</th>
					<td><?php echo _p("ResourceSub9MoreColumn5");?></td>
					<td><input type="text" class="form-control" name="state_seed_prepare" id="state_seed_prepare" value="<?php echo $row[$i]["state_seed_prepare"]; ?>" onChange="summary_total_seed_prepare()"/></td>
					<td><input type="text" class="form-control" name="local_seed_prepare" id="local_seed_prepare" value="<?php echo $row[$i]["local_seed_prepare"]; ?>" onChange="summary_total_seed_prepare()"/></td>
					<td><input type="text" class="form-control" name="other_seed_prepare" id="other_seed_prepare" value="<?php echo $row[$i]["other_seed_prepare"]; ?>" onChange="summary_total_seed_prepare()"/></td>
					<td><?php $total_seed_prepare =  $row[$i]["state_seed_prepare"]+$row[$i]["local_seed_prepare"]+$row[$i]["other_seed_prepare"]; ?><input type="text" disabled class="form-control" name="total_seed_prepare" id="total_seed_prepare" value="<?php echo round($total_seed_prepare,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>1.6</th>
					<td><?php echo _p("ResourceSub9MoreColumn6");?></td>
					<td><input type="text" class="form-control" name="state_forest_training" id="state_forest_training" value="<?php echo $row[$i]["state_forest_training"]; ?>" onChange="summary_total_forest_training()"/></td>
					<td><input type="text" class="form-control" name="local_forest_training" id="local_forest_training" value="<?php echo $row[$i]["local_forest_training"]; ?>" onChange="summary_total_forest_training()"/></td>
					<td><input type="text" class="form-control" name="other_forest_training" id="other_forest_training" value="<?php echo $row[$i]["other_forest_training"]; ?>" onChange="summary_total_forest_training()"/></td>
					<td><?php $total_forest_training = $row[$i]["state_forest_training"]+$row[$i]["local_forest_training"]+$row[$i]["other_forest_training"]; ?><input type="text" disabled class="form-control" name="total_forest_training" id="total_forest_training" value="<?php echo round($total_forest_training,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>1.7</th>
					<td><?php echo _p("ResourceSub9MoreColumn7");?></td>
					<td><input type="text" class="form-control" name="state_forest_equipment" id="state_forest_equipment" value="<?php echo $row[$i]["state_forest_equipment"]; ?>" onChange="summary_total_forest_equipment()"/></td>
					<td><input type="text" class="form-control" name="local_forest_equipment" id="local_forest_equipment" value="<?php echo $row[$i]["local_forest_equipment"]; ?>" onChange="summary_total_forest_equipment()"/></td>
					<td><input type="text" class="form-control" name="other_forest_equipment" id="other_forest_equipment" value="<?php echo $row[$i]["other_forest_equipment"]; ?>" onChange="summary_total_forest_equipment()"/></td>
					<td><?php $total_forest_equipment = $row[$i]["state_forest_equipment"]+$row[$i]["local_forest_equipment"]+$row[$i]["other_forest_equipment"]; ?><input type="text" disabled class="form-control" name="total_forest_equipment" id="total_forest_equipment" value="<?php echo round($total_forest_equipment,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>1.8</th>
					<td><?php echo _p("ResourceSub9MoreColumn8");?></td>
					<td><input type="text" class="form-control" name="state_other_cost" id="state_other_cost" value="<?php echo $row[$i]["state_other_cost"]; ?>" onChange="summary_total_other_cost()"/></td>
					<td><input type="text" class="form-control" name="local_other_cost" id="local_other_cost" value="<?php echo $row[$i]["local_other_cost"]; ?>" onChange="summary_total_other_cost()"/></td>
					<td><input type="text" class="form-control" name="other_other_cost" id="other_other_cost" value="<?php echo $row[$i]["other_other_cost"]; ?>" onChange="summary_total_other_cost()"/></td>
					<td><?php $total_other_cost = $row[$i]["state_other_cost"]+$row[$i]["local_other_cost"]+$row[$i]["other_other_cost"]; ?><input type="text" disabled class="form-control" name="total_other_cost" id="total_other_cost" value="<?php echo round($total_other_cost,2); ?>"/></td>
				  </tr>
				  <tr>
					<th colspan="6"><?php echo _p("ResourceSub9ColumnText8");?></th>
				  </tr>
				  <tr>
					<th>2.1</th>
					<td><?php echo _p("ResourceSub9MoreColumn9");?></td>
					<td><input type="text" class="form-control" name="state_income_nonforest_product" id="state_income_nonforest_product" value="<?php echo $row[$i]["state_income_nonforest_product"]; ?>" onChange="summary_total_income_nonforest_product()"/></td>
					<td><input type="text" class="form-control" name="local_income_nonforest_product" id="local_income_nonforest_product" value="<?php echo $row[$i]["local_income_nonforest_product"]; ?>" onChange="summary_total_income_nonforest_product()"/></td>
					<td><input type="text" class="form-control" name="other_income_nonforest_product" id="other_income_nonforest_product" value="<?php echo $row[$i]["other_income_nonforest_product"]; ?>" onChange="summary_total_income_nonforest_product()"/></td>
					<td><?php $total_income_nonforest_product = $row[$i]["state_income_nonforest_product"]+$row[$i]["local_income_nonforest_product"]+$row[$i]["other_income_nonforest_product"]; ?><input type="text" disabled class="form-control" name="total_income_nonforest_product" id="total_income_nonforest_product" value="<?php echo round($total_income_nonforest_product,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>2.2</th>
					<td><?php echo _p("ResourceSub9MoreColumn10");?></td>
					<td><input type="text" class="form-control" name="state_income_logging" id="state_income_logging" value="<?php echo $row[$i]["state_income_logging"]; ?>" onChange="summary_total_income_logging()"/></td>
					<td><input type="text" class="form-control" name="local_income_logging" id="local_income_logging" value="<?php echo $row[$i]["other_income_nonforest_product"]; ?>" onChange="summary_total_income_logging()"/></td>
					<td><input type="text" class="form-control" name="other_income_logging" id="other_income_logging" value="<?php echo $row[$i]["other_income_logging"]; ?>" onChange="summary_total_income_logging()"/></td>
					<td><?php $total_income_logging = $row[$i]["state_income_logging"]+$row[$i]["local_income_logging"]+$row[$i]["other_income_logging"]; ?><input type="text" disabled class="form-control" name="total_income_logging" id="total_income_logging" value="<?php echo round($total_income_logging,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>2.3</th>
					<td><?php echo _p("ResourceSub9MoreColumn11");?></td>
					<td><input type="text" class="form-control" name="state_income_fire_indemnity" id="state_income_fire_indemnity" value="<?php echo $row[$i]["state_income_fire_indemnity"]; ?>" onChange="summary_total_income_fire_indemnity()"/></td>
					<td><input type="text" class="form-control" name="local_income_fire_indemnity" id="local_income_fire_indemnity" value="<?php echo $row[$i]["local_income_fire_indemnity"]; ?>" onChange="summary_total_income_fire_indemnity()"/></td>
					<td><input type="text" class="form-control" name="other_income_fire_indemnity" id="other_income_fire_indemnity" value="<?php echo $row[$i]["other_income_fire_indemnity"]; ?>" onChange="summary_total_income_fire_indemnity()"/></td>
					<td><?php $total_income_fire_indemnity = $row[$i]["state_income_fire_indemnity"]+$row[$i]["local_income_fire_indemnity"]+$row[$i]["other_income_fire_indemnity"]; ?><input type="text" disabled class="form-control" name="total_income_fire_indemnity" id="total_income_fire_indemnity" value="<?php echo round($total_income_fire_indemnity,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>2.4</th>
					<td><?php echo _p("ResourceSub9MoreColumn12");?></td>
					<td><input type="text" class="form-control" name="state_income_indemnity" id="state_income_indemnity" value="<?php echo $row[$i]["state_income_indemnity"]; ?>" onChange="summary_total_income_indemnity()"/></td>
					<td><input type="text" class="form-control" name="local_income_indemnity" id="local_income_indemnity" value="<?php echo $row[$i]["local_income_indemnity"]; ?>" onChange="summary_total_income_indemnity()"/></td>
					<td><input type="text" class="form-control" name="other_income_indemnity" id="other_income_indemnity" value="<?php echo $row[$i]["other_income_indemnity"]; ?>" onChange="summary_total_income_indemnity()"/></td>
					<td><?php $total_income_indemnity = $row[$i]["state_income_indemnity"]+$row[$i]["local_income_indemnity"]+$row[$i]["other_income_indemnity"]; ?><input type="text" disabled class="form-control" name="total_income_indemnity" id="total_income_indemnity" value="<?php echo round($total_income_indemnity,2); ?>"/></td>
				  </tr>
				  <tr>
					<th>2.5</th>
					<td><?php echo _p("ResourceSub9MoreColumn13");?></td>
					<td><input type="text" class="form-control" name="state_income_seedling" id="state_income_seedling" value="<?php echo $row[$i]["state_income_seedling"]; ?>" onChange="summary_total_income_seedling()"/></td>
					<td><input type="text" class="form-control" name="local_income_seedling" id="local_income_seedling" value="<?php echo $row[$i]["local_income_seedling"]; ?>" onChange="summary_total_income_seedling()"/></td>
					<td><input type="text" class="form-control" name="other_income_seedling" id="other_income_seedling" value="<?php echo $row[$i]["other_income_seedling"]; ?>" onChange="summary_total_income_seedling()"/></td>
					<td><?php $total_income_seedling = $row[$i]["state_income_seedling"]+$row[$i]["local_income_seedling"]+$row[$i]["other_income_seedling"]; ?><input type="text" disabled class="form-control" name="total_income_seedling" id="total_income_seedling" value="<?php echo round($total_income_seedling,2); ?>"/></td>
				  </tr>
				 </tbody>
				</table>
			  </div>			  
            <input type="hidden" id="updatecostreportbttn" name="updatecostreportbttn" value="0"/>
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
