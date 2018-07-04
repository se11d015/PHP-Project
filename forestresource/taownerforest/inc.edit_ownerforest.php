<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2)) 
{
	if (isset($_GET["owner_id"]))
	{
		$owner_id = (int) $_GET["owner_id"];
	}else
	{
		$owner_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "taf.*, vs.aimag_code FROM ".$schemas.".taownerforest taf, scadministrative.vasoumname vs";
	
	if($sess_profile==1)
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.owner_id = ".$owner_id;
	else
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.owner_id = ".$owner_id." AND taf.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
    if (document.getElementById("owner_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub7Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub7Column2")." "._p("EnterText2");?>");
    }else {
        document.getElementById("updateownerforestbttn").value = "1";
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
        <th><?php echo _p("EditText3")." "._p("ResourceSubTitle7")." "._p("EditText4"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="owner_id" id="owner_id" value="<?php echo $row[$i]["owner_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub7Column3"); ?> *:</label>
              <div class="col-md-2">
				<input type="text" class="form-control" name="owner_year" id="owner_year" value="<?php echo $row[$i]["owner_year"]; ?>"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub7Column1"); ?> *:</label>
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
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub7Column2"); ?> *:</label>
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
					<td><input type="text" class="form-control" name="owner_community_number" id="owner_community_number" value="<?php echo $row[$i]["owner_community_number"]; ?>" onChange="summary_number()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub7MoreColumn2");?></td>
					<td><?php echo _p("ResourceSub7Unit1");?></td>
					<td><input type="text" class="form-control" name="owner_organization_number" id="owner_organization_number" value="<?php echo $row[$i]["owner_organization_number"]; ?>" onChange="summary_number()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub7MoreColumn3");?></td>
					<td><?php echo _p("ResourceSub7Unit1");?></td>
					<td><input type="text" class="form-control" name="owner_other_number" id="owner_other_number" value="<?php echo $row[$i]["owner_other_number"]; ?>" onChange="summary_number()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub7MoreColumn4");?></td>
					<td><?php echo _p("ResourceSub7Unit1");?></td>
					<td><input type="text" disabled class="form-control" name="total_owner_number" id="total_owner_number" value="<?php echo $row[$i]["total_owner_number"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span></td>
				  </tr>	  
				  <tr>
					<th rowspan="4">2.</th>
					<td rowspan="4"><?php echo _p("ResourceSub7ColumnText5");?></td>
					<td><?php echo _p("ResourceSub7MoreColumn5");?></td>
					<td><?php echo _p("ResourceSub7Unit2");?></td>
					<td><input type="text" class="form-control" name="owner_community_area" id="owner_community_area" value="<?php echo $row[$i]["owner_community_area"]; ?>" onChange="summary_area()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub7MoreColumn6");?></td>
					<td><?php echo _p("ResourceSub7Unit2");?></td>
					<td><input type="text" class="form-control" name="owner_organization_area" id="owner_organization_area" value="<?php echo $row[$i]["owner_organization_area"]; ?>" onChange="summary_area()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub7MoreColumn7");?></td>
					<td><?php echo _p("ResourceSub7Unit2");?></td>
					<td><input type="text" class="form-control" name="owner_other_area" id="owner_other_area" value="<?php echo $row[$i]["owner_other_area"]; ?>" onChange="summary_area()"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>
				  <tr>
					<td><?php echo _p("ResourceSub7MoreColumn8");?></td>
					<td><?php echo _p("ResourceSub7Unit2");?></td>
					<td><input type="text" disabled class="form-control" name="total_owner_area" id="total_owner_area" value="<?php echo $row[$i]["total_owner_area"]; ?>"/></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span></td>
				  </tr>	  
				  <tr>
					<th>3.</th>
					<td colspan="2"><?php echo _p("ResourceSub7MoreColumn9");?></td>
					<td><?php echo _p("ResourceSub7Unit3");?></td>
					<td><textarea class="form-control" name="owner_location" id="owner_location" rows="3"><?php echo $row[$i]["owner_location"]; ?></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>
				  </tr>
				  <tr>
					<th>4.</th>
					<td colspan="2"><?php echo _p("ResourceSub7MoreColumn10");?></td>
					<td><?php echo _p("ResourceSub7Unit3");?></td>
					<td><textarea class="form-control" name="order_number" id="order_number" rows="3"><?php echo $row[$i]["order_number"]; ?></textarea></td>
					<td><span class="form-text text-muted"><?php echo _p("AlertTextCharAll"); ?></span></td>
				  </tr>
				 </tbody>
				</table>
			  </div>			  
            <input type="hidden" id="managementplan_pathname" name="managementplan_pathname" value="<?php echo $row[$i]["managementplan_pathname"]; ?>"/>
			<input type="hidden" id="managementplan_filename" name="managementplan_filename" value="<?php echo $row[$i]["managementplan_filename"]; ?>"/>
			<input type="hidden" id="updateownerforestbttn" name="updateownerforestbttn" value="0"/>
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
