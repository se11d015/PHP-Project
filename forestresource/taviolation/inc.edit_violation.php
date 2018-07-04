<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 2)) 
{
	if (isset($_GET["violation_id"]))
	{
		$violation_id = (int) $_GET["violation_id"];
	}else
	{
		$violation_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "taf.*, vs.aimag_code FROM ".$schemas.".taviolation taf, scadministrative.vasoumname vs";
	
	if($sess_profile==1)
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.violation_id = ".$violation_id;
	else
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.violation_id = ".$violation_id." AND taf.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
    if (document.getElementById("violation_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub8Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub8Column2")." "._p("EnterText2");?>");
    }else {
        document.getElementById("updateviolationbttn").value = "1";
        document.mainform.submit();
    }
}

</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("EditText3")." "._p("ResourceSubTitle8")." "._p("EditText4"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="violation_id" id="violation_id" value="<?php echo $row[$i]["violation_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub8Column3"); ?> *:</label>
              <div class="col-md-2">
				<input type="text" class="form-control" name="violation_year" id="violation_year" value="<?php echo $row[$i]["violation_year"]; ?>"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub8Column1"); ?> *:</label>
              <div class="col-md-3">
                <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn";
					if($checkaimag==1)
						$selQuery = "SELECT va.aimag_code, va.aimag_name_mn FROM scadministrative.vaaimagname va 
						WHERE EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = va.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id.")) ORDER BY va.aimag_name_mn";
					$rows = $db->query($selQuery);
					echo seldatadb("aimag_code", "form-control", $rows, "aimag_code", "aimag_name_mn", $row[$i]["aimag_code"]);
					$aimagcode = $row[$i]["aimag_code"];
					?>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextSelect"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub8Column2"); ?> *:</label>
              <div class="col-md-3">
			    <?php
					$selQuery = "SELECT vs.soum_code, vs.soum_name_mn, vs.soum_name_en FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("soum_code", "form-control", $rows, "soum_code", "soum_name_mn", $row[$i]["soum_code"]);
					?>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextSelect"); ?></span> </div>
			  <div class="form-group row col-md-12">
			    <table>
				 <tbody>
				  <tr>
					<th style="width: 5%">№</th>
					<th colspan="2" style="width: 35%"><?php echo _p("ResourceSub8ColumnText1");?></th>
					<th style="width: 10%"><?php echo _p("ResourceSub8ColumnText2");?></th>
					<th><?php echo _p("ResourceSub8ColumnText3");?></th>
					<th><?php echo _p("Description");?></th>
				  </tr>
				  <tr>
					<th>1.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn1");?></td>
					<td><?php echo _p("ResourceSub8Unit1");?></td>
					<td><input type="text" class="form-control" name="violation_number" id="violation_number" value="<?php echo $row[$i]["violation_number"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<th>2.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn2");?></td>
					<td><?php echo _p("ResourceSub8Unit2");?></td>
					<td><input type="text" class="form-control" name="illegallogging_wood" id="illegallogging_wood" value="<?php echo $row[$i]["illegallogging_wood"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<th>3.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn3");?></td>
					<td><?php echo _p("ResourceSub8Unit3");?></td>
					<td><textarea class="form-control" name="place_name" id="place_name" rows="3"><?php echo $row[$i]["place_name"]; ?></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>	
				  </tr>
				  <tr>
					<th>4.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn4");?></td>
					<td><?php echo _p("ResourceSub8Unit1");?></td>
					<td><textarea class="form-control" name="escheat_tools_number" id="escheat_tools_number" rows="2"><?php echo $row[$i]["escheat_tools_number"]; ?></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span></td>	
				  </tr>	    
				  <tr>
					<th rowspan="2">5.</th>
					<td rowspan="2"><?php echo _p("ResourceSub8ColumnText4");?></td>
					<td><?php echo _p("ResourceSub8MoreColumn5");?></td>
					<td><?php echo _p("ResourceSub8Unit4");?></td>
					<td><input type="text" class="form-control" name="forfeit_cost" id="forfeit_cost" value="<?php echo $row[$i]["forfeit_cost"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub8MoreColumn6");?></td>
					<td><?php echo _p("ResourceSub8Unit4");?></td>
					<td><input type="text" class="form-control" name="indemnity_cost" id="indemnity_cost" value="<?php echo $row[$i]["indemnity_cost"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
				  </tr>
				  <tr>
					<th>6.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn7");?></td>
					<td><?php echo _p("ResourceSub8Unit5");?></td>
					<td><input type="text" class="form-control" name="illegal_nontimberproduct" id="illegal_nontimberproduct" value="<?php echo $row[$i]["illegal_nontimberproduct"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal8"); ?></span></td>
				  </tr>
				  <tr>
					<th>7.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn8");?></td>
					<td><?php echo _p("ResourceSub8Unit3");?></td>
					<td><textarea class="form-control" name="violation_note" id="violation_note" rows="3"><?php echo $row[$i]["violation_note"]; ?></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>	
				  </tr>	  
				 </tbody>
				</table>
			  </div>			  
            <input type="hidden" id="updateviolationbttn" name="updateviolationbttn" value="0"/>
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
