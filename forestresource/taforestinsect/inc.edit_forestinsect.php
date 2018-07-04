<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 4, 2)) 
{
	if (isset($_GET["insect_id"]))
	{
		$insect_id = (int) $_GET["insect_id"];
	}else
	{
		$insect_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "taf.*, vs.aimag_code FROM ".$schemas.".taforestinsect taf, scadministrative.vasoumname vs";
	
	if($sess_profile==1)
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.insect_id = ".$insect_id;
	else
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.insect_id = ".$insect_id." AND taf.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
    if (document.getElementById("insect_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub4Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub4Column2")." "._p("EnterText2");?>");
    }else {
        document.getElementById("updateforestinsectbttn").value = "1";
        document.mainform.submit();
    }
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("EditText3")." "._p("ResourceSubTitle4")." "._p("EditText4"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="insect_id" id="insect_id" value="<?php echo $row[$i]["insect_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub4Column3"); ?> *:</label>
              <div class="col-md-2">
				<input type="text" class="form-control" name="insect_year" id="insect_year" value="<?php echo $row[$i]["insect_year"]; ?>"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub4Column1"); ?> *:</label>
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
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub4Column2"); ?> *:</label>
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
					  <th colspan="2" style="width: 35%"><?php echo _p("ResourceSub4ColumnText1");?></th>
					  <th style="width: 10%"><?php echo _p("ResourceSub4ColumnText2");?></th>
					  <th><?php echo _p("ResourceSub4ColumnText3");?></th>
					  <th><?php echo _p("Description");?></th>
				    </tr>
					<tr>
					  <th>1.</th>
					  <td colspan="2"><?php echo _p("ResourceSub4MoreColumn1");?></td>
					  <td><?php echo _p("ResourceSub4Unit1");?></td>
					  <td><input type="text" class="form-control" name="insect_study_area" id="insect_study_area" value="<?php echo $row[$i]["insect_study_area"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					</tr>
					<tr>
					  <th>2.</th>
					  <td colspan="2"><?php echo _p("ResourceSub4MoreColumn2");?></td>
					  <td><?php echo _p("ResourceSub4Unit1");?></td>
					  <td><input type="text" class="form-control" name="insect_spread_area" id="insect_spread_area" value="<?php echo $row[$i]["insect_spread_area"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					</tr>
					<tr>
					  <th>3.</th>
					  <td colspan="2"><?php echo _p("ResourceSub4MoreColumn3");?></td>
					  <td><?php echo _p("ResourceSub4Unit1");?></td>
					  <td><input type="text" class="form-control" name="insect_damage_area" id="insect_damage_area" value="<?php echo $row[$i]["insect_damage_area"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					</tr>
					<tr>
					  <th>4.</th>
					  <td colspan="2"><?php echo _p("ResourceSub4MoreColumn4");?></td>
					  <td><?php echo _p("ResourceSub4Unit5");?></td>
					  <td><textarea class="form-control" name="insect_name" id="insect_name" rows="3"><?php echo $row[$i]["insect_name"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextChar150"); ?></span></td>
					</tr>		
					<tr>
					  <th rowspan="5">5.</th>
					  <td rowspan="5"><?php echo _p("ResourceSub4ColumnText4");?></td>	  
					  <td rowspan="2"><?php echo _p("ResourceSub4MoreColumn5");?></td>
					  <td><?php echo _p("ResourceSub4Unit2");?></td>
					  <td><input type="text" class="form-control" name="control_aeroplain_number" id="control_aeroplain_number" value="<?php echo $row[$i]["control_aeroplain_number"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub4Unit1");?></td>
					  <td><input type="text" class="form-control" name="control_aeroplain_area" id="control_aeroplain_area" value="<?php echo $row[$i]["control_aeroplain_area"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					</tr>		
					<tr>
					  <td><?php echo _p("ResourceSub4MoreColumn6");?></td>
					  <td><?php echo _p("ResourceSub4Unit1");?></td>
					  <td><input type="text" class="form-control" name="control_spray_area" id="control_spray_area" value="<?php echo $row[$i]["control_spray_area"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					</tr>
					<tr>
					  <td rowspan="2"><?php echo _p("ResourceSub4MoreColumn7");?></td>
					  <td><?php echo _p("ResourceSub4Unit3");?></td>
					  <td><input type="text" class="form-control" name="control_mechanics_size" id="control_mechanics_size" value="<?php echo $row[$i]["control_mechanics_size"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal8"); ?></span></td>
					</tr>
					<tr>
					  <td><?php echo _p("ResourceSub4Unit1");?></td>
					  <td><input type="text" class="form-control" name="control_mechanics_area" id="control_mechanics_area" value="<?php echo $row[$i]["control_mechanics_area"]; ?>"/></td>
					   <td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					</tr>		
					<tr>
					  <th>6.</th>
					  <td colspan="2"><?php echo _p("ResourceSub4MoreColumn8");?></td>
					  <td><?php echo _p("ResourceSub4Unit4");?></td>
					  <td><input type="text" class="form-control" name="control_result" id="control_result" value="<?php echo $row[$i]["control_result"]; ?>"/></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextReal6"); ?></span></td>
					</tr>
					<tr>
					  <th>7.</th>
					  <td colspan="2"><?php echo _p("ResourceSub4MoreColumn9");?></td>
					  <td><?php echo _p("ResourceSub4Unit5");?></td>
					  <td><textarea class="form-control" name="control_location" id="control_location" rows="3"><?php echo $row[$i]["control_location"]; ?></textarea></td>
					  <td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>
					</tr>					
				  </tbody>
				</table>
			  </div>			  
            <input type="hidden" id="updateforestinsectbttn" name="updateforestinsectbttn" value="0"/>
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
