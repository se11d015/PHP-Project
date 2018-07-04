<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 2)) 
{

?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
    if (document.getElementById("violation_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub8Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub8Column2")." "._p("EnterText2");?>");
    }else {
        document.getElementById("insertviolationbttn").value = "1";
        document.mainform.submit();
    }
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("AddText5")." "._p("ResourceSubTitle8")." "._p("AddText6"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
			  <div class="form-row">
				<div class="form-group col-md-3">
				  <label class="col-form-label text-danger"><?php echo _p("ResourceSub8Column1"); ?> *</label>
				  <?php
						$selQuery = "SELECT va.aimag_code, va.aimag_name_mn FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn";
						if($checkaimag==1)
							$selQuery = "SELECT va.aimag_code, va.aimag_name_mn FROM scadministrative.vaaimagname va 
							WHERE EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = va.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id.")) ORDER BY va.aimag_name_mn";
						$rows = $db->query($selQuery);
						echo seldatadb("aimag_code", "form-control", $rows, "aimag_code", "aimag_name_mn", $rows[0]["aimag_code"]);
						$aimagcode = $rows[0]["aimag_code"];
						?>
				</div>
				<div class="form-group col-md-3">
				  <label class="col-form-label text-danger"><?php echo _p("ResourceSub8Column2"); ?> *</label>
				  <?php
						$selQuery = "SELECT vs.soum_code, vs.soum_name_mn, vs.soum_name_en FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";
						$rows = $db->query($selQuery);
						echo seldatadb("soum_code", "form-control", $rows, "soum_code", "soum_name_mn", $rows[0]["soum_code"]);
						?>
				</div>	
				<div class="form-group col-md-2">
				  <label class="col-form-label text-danger"><?php echo _p("ResourceSub8Column3"); ?> *</label>
				  <input type="text" class="form-control" name="violation_year" id="violation_year">
				</div>				
			  </div>
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
					<td><input type="text" class="form-control" name="violation_number" id="violation_number"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<th>2.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn2");?></td>
					<td><?php echo _p("ResourceSub8Unit2");?></td>
					<td><input type="text" class="form-control" name="illegallogging_wood" id="illegallogging_wood"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal10"); ?></span></td>
				  </tr>
				  <tr>
					<th>3.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn3");?></td>
					<td><?php echo _p("ResourceSub8Unit3");?></td>
					<td><textarea class="form-control" name="place_name" id="place_name" rows="3"></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>	
				  </tr>
				  <tr>
					<th>4.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn4");?></td>
					<td><?php echo _p("ResourceSub8Unit1");?></td>
					<td><textarea class="form-control" name="escheat_tools_number" id="escheat_tools_number" rows="2"></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span></td>	
				  </tr>	    
				  <tr>
					<th rowspan="2">5.</th>
					<td rowspan="2"><?php echo _p("ResourceSub8ColumnText4");?></td>
					<td><?php echo _p("ResourceSub8MoreColumn5");?></td>
					<td><?php echo _p("ResourceSub8Unit4");?></td>
					<td><input type="text" class="form-control" name="forfeit_cost" id="forfeit_cost"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub8MoreColumn6");?></td>
					<td><?php echo _p("ResourceSub8Unit4");?></td>
					<td><input type="text" class="form-control" name="indemnity_cost" id="indemnity_cost"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal13"); ?></span></td>
				  </tr>
				  <tr>
					<th>6.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn7");?></td>
					<td><?php echo _p("ResourceSub8Unit5");?></td>
					<td><input type="text" class="form-control" name="illegal_nontimberproduct" id="illegal_nontimberproduct"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal8"); ?></span></td>
				  </tr>
				  <tr>
					<th>7.</th>
					<td colspan="2"><?php echo _p("ResourceSub8MoreColumn8");?></td>
					<td><?php echo _p("ResourceSub8Unit3");?></td>
					<td><textarea class="form-control" name="violation_note" id="violation_note" rows="3"></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>	
				  </tr>	  
				  </tbody>
				</table>
			  </div>			  
			  <input type="hidden" id="insertviolationbttn" name="insertviolationbttn" value="0"/>
              <div class="form-group row col-md-10 justify-content-center">
                <div>
                  <button type="button" class="btn btn-primary" onclick="addsubmitform()"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
                  <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></a> </div>
              </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
} else {
	show_notification("error", _p("NotAccessText"), "");
}
?>
