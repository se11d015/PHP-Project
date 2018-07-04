<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2)) 
{

?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
    if (document.getElementById("owner_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub7Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub7Column2")." "._p("EnterText2");?>");
    }else {
        document.getElementById("insertownerforestbttn").value = "1";
        document.mainform.submit();
    }
}


function summary_number(){
    var f1, f2, f3;
	if (document.getElementById("owner_community_number").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("owner_community_number").value)) f1=0;
		f1 = document.getElementById("owner_community_number").value; 
		f1 = parseInt(f1);	
	}
	
	if (document.getElementById("owner_organization_number").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("owner_organization_number").value)) f2=0;
		 f2 = document.getElementById("owner_organization_number").value;
         f2 = parseInt(f2);		
	}
	
	if (document.getElementById("owner_other_number").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("owner_other_number").value)) f3=0;
		 f3 = document.getElementById("owner_other_number").value;
         f3 = parseInt(f3);		
	}
	
	document.getElementById("total_owner_number").value = parseInt(f1+f2+f3);			
}

function summary_area(){
    var f1, f2, f3;
	if (document.getElementById("owner_community_area").value == "") {
		f1=0;
	} else { 
		if (isNaN(document.getElementById("owner_community_area").value)) f1=0;
		f1 = document.getElementById("owner_community_area").value; 
		f1 = parseFloat(f1.replace(",", "."));	
	}
	
	if (document.getElementById("owner_organization_area").value == "") {
		f2=0;
	} else { 
		if (isNaN(document.getElementById("owner_organization_area").value)) f2=0;
		 f2 = document.getElementById("owner_organization_area").value;
         f2 = parseFloat(f2.replace(",", "."));		
	}
	
	if (document.getElementById("owner_other_area").value == "") {
		f3=0;
	} else { 
		if (isNaN(document.getElementById("owner_other_area").value)) f3=0;
		 f3 = document.getElementById("owner_other_area").value;
         f3 = parseFloat(f3.replace(",", "."));		
	}
	
	document.getElementById("total_owner_area").value = parseFloat(f1+f2+f3);				
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("AddText5")." "._p("ResourceSubTitle7")." "._p("AddText6"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
			  <div class="form-row">
				<div class="form-group col-md-3">
				  <label class="col-form-label text-danger"><?php echo _p("ResourceSub7Column1"); ?> *</label>
				  <?php
						$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn";
						if($checkaimag==1)
							$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va 
							WHERE EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = va.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id.")) ORDER BY va.aimag_name_mn";
						$rows = $db->query($selQuery);
						echo seldatadb("aimag_code", "form-control", $rows, "aimag_code", "aimag_name_$language_name", $rows[0]["aimag_code"]);
						$aimagcode = $rows[0]["aimag_code"];
						?>
				</div>
				<div class="form-group col-md-3">
				  <label class="col-form-label text-danger"><?php echo _p("ResourceSub7Column2"); ?> *</label>
				  <?php
						$selQuery = "SELECT vs.soum_code, vs.soum_name_mn, vs.soum_name_en FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";
						$rows = $db->query($selQuery);
						echo seldatadb("soum_code", "form-control", $rows, "soum_code", "soum_name_$language_name", $rows[0]["soum_code"]);
						?>
				</div>	
				<div class="form-group col-md-2">
				  <label class="col-form-label text-danger"><?php echo _p("ResourceSub7Column3"); ?> *</label>
				  <input type="text" class="form-control" name="owner_year" id="owner_year">
				</div>				
			  </div>
			  <div class="form-group row col-md-12">
			    <table>
				 <tbody>
					  <tr>
						<th style="width: 5%">№</th>
						<th colspan="2" style="width: 35%"><?php echo _p("ResourceSub7ColumnText1");?></th>
						<th style="width: 10%"><?php echo _p("ResourceSub7ColumnText2");?></th>
						<th><?php echo _p("ResourceSub7ColumnText3");?></th>
						<th><?php echo _p("Description");?></th>
					  </tr>
					  <tr>
						<th rowspan="4">1.</th>
						<td rowspan="4"><?php echo _p("ResourceSub7ColumnText4");?></td>
						<td><?php echo _p("ResourceSub7MoreColumn1");?></td>
						<td><?php echo _p("ResourceSub7Unit1");?></td>
						<td><input type="text" class="form-control" name="owner_community_number" id="owner_community_number" onChange="summary_number()"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
					  </tr>
					  <tr>
						<td><?php echo _p("ResourceSub7MoreColumn2");?></td>
						<td><?php echo _p("ResourceSub7Unit1");?></td>
						<td><input type="text" class="form-control" name="owner_organization_number" id="owner_organization_number" onChange="summary_number()"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
					  </tr>
					  <tr>
						<td><?php echo _p("ResourceSub7MoreColumn3");?></td>
						<td><?php echo _p("ResourceSub7Unit1");?></td>
						<td><input type="text" class="form-control" name="owner_other_number" id="owner_other_number" onChange="summary_number()"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
					  </tr>
					  <tr>
						<td><?php echo _p("ResourceSub7MoreColumn4");?></td>
						<td><?php echo _p("ResourceSub7Unit1");?></td>
						<td><input type="text" disabled class="form-control" name="total_owner_number" id="total_owner_number"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
					  </tr>	  
					  <tr>
						<th rowspan="4">2.</th>
						<td rowspan="4"><?php echo _p("ResourceSub7ColumnText5");?></td>
						<td><?php echo _p("ResourceSub7MoreColumn5");?></td>
						<td><?php echo _p("ResourceSub7Unit2");?></td>
						<td><input type="text" class="form-control" name="owner_community_area" id="owner_community_area" onChange="summary_area()"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					  </tr>
					  <tr>
						<td><?php echo _p("ResourceSub7MoreColumn6");?></td>
						<td><?php echo _p("ResourceSub7Unit2");?></td>
						<td><input type="text" class="form-control" name="owner_organization_area" id="owner_organization_area" onChange="summary_area()"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					  </tr>
					  <tr>
						<td><?php echo _p("ResourceSub7MoreColumn7");?></td>
						<td><?php echo _p("ResourceSub7Unit2");?></td>
						<td><input type="text" class="form-control" name="owner_other_area" id="owner_other_area" onChange="summary_area()"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					  </tr>
					  <tr>
						<td><?php echo _p("ResourceSub7MoreColumn8");?></td>
						<td><?php echo _p("ResourceSub7Unit2");?></td>
						<td><input type="text" disabled class="form-control" name="total_owner_area" id="total_owner_area"/></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
					  </tr>	  
					  <tr>
						<th>3.</th>
						<td colspan="2"><?php echo _p("ResourceSub7MoreColumn9");?></td>
						<td><?php echo _p("ResourceSub7Unit3");?></td>
						<td><textarea class="form-control" name="owner_location" id="owner_location" rows="3"></textarea></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>
					  </tr>
					  <tr>
						<th>4.</th>
						<td colspan="2"><?php echo _p("ResourceSub7MoreColumn10");?></td>
						<td><?php echo _p("ResourceSub7Unit3");?></td>
						<td><textarea class="form-control" name="order_number" id="order_number" rows="3"></textarea></td>
						<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>
					  </tr>
				  </tbody>
				</table>
			  </div>			  
			  <input type="hidden" id="insertownerforestbttn" name="insertownerforestbttn" value="0"/>
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
