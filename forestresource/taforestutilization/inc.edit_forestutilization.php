<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 2)) 
{
	if (isset($_GET["utilization_id"]))
	{
		$utilization_id = (int) $_GET["utilization_id"];
	}else
	{
		$utilization_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "taf.*, vs.aimag_code FROM ".$schemas.".taforestutilization taf, scadministrative.vasoumname vs";
	
	if($sess_profile==1)
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.utilization_id = ".$utilization_id;
	else
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.utilization_id = ".$utilization_id." AND taf.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
    if (document.getElementById("utilization_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub6Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub6Column2")." "._p("EnterText2");?>");
    }else {
        document.getElementById("updateforestutilizationbttn").value = "1";
        document.mainform.submit();
    }
}

function summary_logged(){
    var f1, f2;
	if (document.getElementById("logged_timber").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("logged_timber").value)) f1=0;
		f1 = document.getElementById("logged_timber").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("logged_firewood").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("logged_firewood").value)) f2=0;
		 f2 = document.getElementById("logged_firewood").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}

	document.getElementById("total_logged_wood").value = parseFloat(f1+f2);			
}

function summary_thinning(){
    var f1, f2;
	if (document.getElementById("thinning_timber").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("thinning_timber").value)) f1=0;
		f1 = document.getElementById("thinning_timber").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("thinning_firewood").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("thinning_firewood").value)) f2=0;
		 f2 = document.getElementById("thinning_firewood").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}

	document.getElementById("total_thinning_wood").value = parseFloat(f1+f2);			
}

function summary_cleaning(){
    var f1, f2;
	if (document.getElementById("cleaning_timber").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("cleaning_timber").value)) f1=0;
		f1 = document.getElementById("cleaning_timber").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("cleaning_firewood").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("cleaning_firewood").value)) f2=0;
		 f2 = document.getElementById("cleaning_firewood").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}

	document.getElementById("total_cleaning_wood").value = parseFloat(f1+f2);			
}

</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("EditText3")." "._p("ResourceSubTitle6")." "._p("EditText4"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="utilization_id" id="utilization_id" value="<?php echo $row[$i]["utilization_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub6Column3"); ?> *:</label>
              <div class="col-md-2">
				<input type="text" class="form-control" name="utilization_year" id="utilization_year" value="<?php echo $row[$i]["utilization_year"]; ?>"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub6Column1"); ?> *:</label>
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
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub6Column2"); ?> *:</label>
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
					<th colspan="2" style="width: 35%"><?php echo _p("ResourceSub6ColumnText1");?></th>
					<th style="width: 10%"><?php echo _p("ResourceSub6ColumnText2");?></th>
					<th><?php echo _p("ResourceSub6ColumnText3");?></th>
					<th><?php echo _p("Description");?></th>
				  </tr>
				  <tr>
					<th rowspan="3">1.</th>
					<td rowspan="3"><?php echo _p("ResourceSub6ColumnText4");?></td>
					<td><?php echo _p("ResourceSub6MoreColumn1");?></td>
					<td><?php echo _p("ResourceSub6Unit1");?></td>
					<td><input type="text" class="form-control" name="logged_timber" id="logged_timber" value="<?php echo $row[$i]["logged_timber"]; ?>" onChange="summary_logged()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub6MoreColumn2");?></td>
					<td><?php echo _p("ResourceSub6Unit1");?></td>
					<td><input type="text" class="form-control" name="logged_firewood" id="logged_firewood" value="<?php echo $row[$i]["logged_firewood"]; ?>" onChange="summary_logged()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub6MoreColumn3");?></td>
					<td><?php echo _p("ResourceSub6Unit1");?></td>
					<td><input type="text" disabled class="form-control" name="total_logged_wood" id="total_logged_wood" value="<?php echo $row[$i]["total_logged_wood"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<th>2.</th>
					<td colspan="2"><?php echo _p("ResourceSub6MoreColumn4");?></td>
					<td><?php echo _p("ResourceSub6Unit2");?></td>
					<td><input type="text" class="form-control" name="insulated_area" id="insulated_area" value="<?php echo $row[$i]["insulated_area"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<th>3.</th>
					<td colspan="2"><?php echo _p("ResourceSub6MoreColumn5");?></td>
					<td><?php echo _p("ResourceSub6Unit2");?></td>
					<td><input type="text" class="form-control" name="logged_area" id="logged_area" value="<?php echo $row[$i]["logged_area"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<th>4.</th>
					<td colspan="2"><?php echo _p("ResourceSub6MoreColumn6");?></td>
					<td><?php echo _p("ResourceSub6Unit4");?></td>
					<td><textarea class="form-control" name="logged_location" id="logged_location" rows="3"><?php echo $row[$i]["logged_location"]; ?></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>		
				  </tr>
				  <tr>
					<th>5.</th>
					<td colspan="2"><?php echo _p("ResourceSub6MoreColumn7");?></td>
					<td><?php echo _p("ResourceSub6Unit2");?></td>
					<td><input type="text" class="form-control" name="thinning_area" id="thinning_area" value="<?php echo $row[$i]["thinning_area"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<th rowspan="3">6.</th>
					<td rowspan="3"><?php echo _p("ResourceSub6ColumnText5");?></td>
					<td><?php echo _p("ResourceSub6MoreColumn8");?></td>
					<td><?php echo _p("ResourceSub6Unit1");?></td>
					<td><input type="text" class="form-control" name="thinning_timber" id="thinning_timber" value="<?php echo $row[$i]["thinning_timber"]; ?>" onChange="summary_thinning()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub6MoreColumn9");?></td>
					<td><?php echo _p("ResourceSub6Unit1");?></td>
					<td><input type="text" class="form-control" name="thinning_firewood" id="thinning_firewood" value="<?php echo $row[$i]["thinning_firewood"]; ?>" onChange="summary_thinning()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub6MoreColumn10");?></td>
					<td><?php echo _p("ResourceSub6Unit1");?></td>
					<td><input type="text" disabled class="form-control" name="total_thinning_wood" id="total_thinning_wood" value="<?php echo $row[$i]["total_thinning_wood"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<th>7.</th>
					<td colspan="2"><?php echo _p("ResourceSub6MoreColumn11");?></td>
					<td><?php echo _p("ResourceSub6Unit2");?></td>
					<td><input type="text" class="form-control" name="cleaning_area" id="cleaning_area" value="<?php echo $row[$i]["cleaning_area"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<th rowspan="3">8.</th>
					<td rowspan="3"><?php echo _p("ResourceSub6ColumnText6");?></td>
					<td><?php echo _p("ResourceSub6MoreColumn12");?></td>
					<td><?php echo _p("ResourceSub6Unit1");?></td>
					<td><input type="text" class="form-control" name="cleaning_timber" id="cleaning_timber" value="<?php echo $row[$i]["cleaning_timber"]; ?>" onChange="summary_cleaning()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub6MoreColumn13");?></td>
					<td><?php echo _p("ResourceSub6Unit1");?></td>
					<td><input type="text" class="form-control" name="cleaning_firewood" id="cleaning_firewood" value="<?php echo $row[$i]["cleaning_firewood"]; ?>" onChange="summary_cleaning()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub6MoreColumn14");?></td>
					<td><?php echo _p("ResourceSub6Unit1");?></td>
					<td><input type="text" disabled class="form-control" name="total_cleaning_wood" id="total_cleaning_wood" value="<?php echo $row[$i]["total_cleaning_wood"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<th rowspan="3">9.</th>
					<td rowspan="3"><?php echo _p("ResourceSub6ColumnText7");?></td>
					<td><?php echo _p("ResourceSub6MoreColumn15");?></td>
					<td><?php echo _p("ResourceSub6Unit3");?></td>
					<td><input type="text" class="form-control" name="nontimber_pinenuts" id="nontimber_pinenuts" value="<?php echo $row[$i]["nontimber_pinenuts"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal8"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub6MoreColumn16");?></td>
					<td><?php echo _p("ResourceSub6Unit3");?></td>
					<td><input type="text" class="form-control" name="nontimber_fruits" id="nontimber_fruits" value="<?php echo $row[$i]["nontimber_fruits"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal8"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub6MoreColumn17");?></td>
					<td><?php echo _p("ResourceSub6Unit3");?></td>
					<td><input type="text" class="form-control" name="nontimber_other" id="nontimber_other" value="<?php echo $row[$i]["nontimber_other"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal8"); ?></span></td>
				  </tr>				  
				 </tbody>
				</table>
			  </div>			  
            <input type="hidden" id="updateforestutilizationbttn" name="updateforestutilizationbttn" value="0"/>
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
