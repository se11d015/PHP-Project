<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 2)) 
{
	if (isset($_GET["reforest_id"]))
	{
		$reforest_id = (int) $_GET["reforest_id"];
	}else
	{
		$reforest_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "taf.*, vs.aimag_code FROM ".$schemas.".tareforestation taf, scadministrative.vasoumname vs";
	
	if($sess_profile==1)
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.reforest_id = ".$reforest_id;
	else
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.reforest_id = ".$reforest_id." AND taf.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
    if (document.getElementById("reforest_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub5Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub5Column2")." "._p("EnterText2");?>");
    }else {
        document.getElementById("updatereforestationbttn").value = "1";
        document.mainform.submit();
    }
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("EditText3")." "._p("ResourceSubTitle5")." "._p("EditText4"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="reforest_id" id="reforest_id" value="<?php echo $row[$i]["reforest_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub5Column3"); ?> *:</label>
              <div class="col-md-2">
				<input type="text" class="form-control" name="reforest_year" id="reforest_year" value="<?php echo $row[$i]["reforest_year"]; ?>"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub5Column1"); ?> *:</label>
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
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub5Column2"); ?> *:</label>
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
					<th colspan="2" style="width: 35%"><?php echo _p("ResourceSub5ColumnText1");?></th>
					<th style="width: 10%"><?php echo _p("ResourceSub5ColumnText2");?></th>
					<th><?php echo _p("ResourceSub5ColumnText3");?></th>
					<th><?php echo _p("Description");?></th>
				  </tr>
				  <tr>
					<th rowspan="3">1.</th>
					<td rowspan="3"><?php echo _p("ResourceSub5ColumnText4");?></td>
					<td><?php echo _p("ResourceSub5MoreColumn1");?></td>
					<td><?php echo _p("ResourceSub5Unit1");?></td>
					<td><input type="text" class="form-control" name="planted_area" id="planted_area" value="<?php echo $row[$i]["planted_area"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub5MoreColumn2");?></td>
					<td><?php echo _p("ResourceSub5Unit1");?></td>
					<td><input type="text" class="form-control" name="regenerate_area" id="regenerate_area" value="<?php echo $row[$i]["regenerate_area"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub5MoreColumn3");?></td>
					<td><?php echo _p("ResourceSub5Unit1");?></td>
					<td><input type="text" class="form-control" name="forest_belt_area" id="forest_belt_area" value="<?php echo $row[$i]["forest_belt_area"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<th>2.</th>
					<td colspan="2"><?php echo _p("ResourceSub5MoreColumn4");?></td>
					<td><?php echo _p("ResourceSub5Unit5");?></td>
					<td><textarea class="form-control" name="reforestation_location" id="reforestation_location" rows="3"><?php echo $row[$i]["reforestation_location"]; ?></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>
				  </tr>	  
				  <tr>
					<th>3.</th>
					<td colspan="2"><?php echo _p("ResourceSub5MoreColumn5");?></td>
					<td><?php echo _p("ResourceSub5Unit1");?></td>
					<td><input type="text" class="form-control" name="planted_forest_area" id="planted_forest_area" value="<?php echo $row[$i]["planted_forest_area"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<th>4.</th>
					<td colspan="2"><?php echo _p("ResourceSub5MoreColumn6");?></td>
					<td><?php echo _p("ResourceSub5Unit5");?></td>
					<td><textarea class="form-control" name="planted_location" id="planted_location" rows="3"><?php echo $row[$i]["planted_location"]; ?></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>
				  </tr>	  
				  <tr>
					<th>5.</th>
					<td colspan="2"><?php echo _p("ResourceSub5MoreColumn7");?></td>
					<td><?php echo _p("ResourceSub5Unit2");?></td>
					<td><input type="text" class="form-control" name="reforestation_percent" id="reforestation_percent" value="<?php echo $row[$i]["reforestation_percent"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal6"); ?></span></td>
				  </tr>
				  <tr>
					<th rowspan="3">6.</th>
					<td rowspan="3"><?php echo _p("ResourceSub5ColumnText5");?></td>
					<td><?php echo _p("ResourceSub5MoreColumn8");?></td>
					<td><?php echo _p("ResourceSub5Unit3");?></td>
					<td><input type="text" class="form-control" name="seedling_1age_number" id="seedling_1age_number" value="<?php echo $row[$i]["seedling_1age_number"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub5MoreColumn9");?></td>
					<td><?php echo _p("ResourceSub5Unit3");?></td>
					<td><input type="text" class="form-control" name="seedling_2age_number" id="seedling_2age_number" value="<?php echo $row[$i]["seedling_2age_number"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub5MoreColumn10");?></td>
					<td><?php echo _p("ResourceSub5Unit3");?></td>
					<td><input type="text" class="form-control" name="seedling_3age_number" id="seedling_3age_number" value="<?php echo $row[$i]["seedling_3age_number"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<th rowspan="3">7.</th>
					<td rowspan="3"><?php echo _p("ResourceSub5ColumnText6");?></td>
					<td><?php echo _p("ResourceSub5MoreColumn11");?></td>
					<td><?php echo _p("ResourceSub5Unit3");?></td>
					<td><input type="text" class="form-control" name="seedling_number_larch" id="seedling_number_larch" value="<?php echo $row[$i]["seedling_number_larch"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub5MoreColumn12");?></td>
					<td><?php echo _p("ResourceSub5Unit3");?></td>
					<td><input type="text" class="form-control" name="seedling_number_pine" id="seedling_number_pine" value="<?php echo $row[$i]["seedling_number_pine"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub5MoreColumn13");?></td>
					<td><?php echo _p("ResourceSub5Unit3");?></td>
					<td><input type="text" class="form-control" name="seedling_number_other" id="seedling_number_other" value="<?php echo $row[$i]["seedling_number_other"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<th rowspan="4">8.</th>
					<td rowspan="4"><?php echo _p("ResourceSub5ColumnText7");?></td>
					<td><?php echo _p("ResourceSub5MoreColumn14");?></td>
					<td><?php echo _p("ResourceSub5Unit4");?></td>
					<td><input type="text" class="form-control" name="prepared_seed_larch" id="prepared_seed_larch" value="<?php echo $row[$i]["prepared_seed_larch"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal8"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub5MoreColumn15");?></td>
					<td><?php echo _p("ResourceSub5Unit4");?></td>
					<td><input type="text" class="form-control" name="prepared_seed_pine" id="prepared_seed_pine" value="<?php echo $row[$i]["prepared_seed_pine"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal8"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub5MoreColumn16");?></td>
					<td><?php echo _p("ResourceSub5Unit4");?></td>
					<td><input type="text" class="form-control" name="prepared_seed_saxaul" id="prepared_seed_saxaul" value="<?php echo $row[$i]["prepared_seed_saxaul"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal8"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub5MoreColumn17");?></td>
					<td><?php echo _p("ResourceSub5Unit4");?></td>
					<td><input type="text" class="form-control" name="prepared_seed_other" id="prepared_seed_other" value="<?php echo $row[$i]["prepared_seed_other"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal8"); ?></span></td>
				  </tr>
				 </tbody>
				</table>
			  </div>			  
            <input type="hidden" id="updatereforestationbttn" name="updatereforestationbttn" value="0"/>
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
