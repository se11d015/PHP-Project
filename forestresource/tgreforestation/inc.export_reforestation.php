<?php 
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 2)) 
{
?>
<script language="JavaScript" type="text/javascript">
function excelsubmitform(){
	document.getElementById("excelbttn").value = "1";
	document.getElementById("kmlbttn").value = "0";
	document.mainform.submit();
}
function kmlsubmitform(){
	document.getElementById("excelbttn").value = "0";
	document.getElementById("kmlbttn").value = "1";
	document.mainform.submit();
}
</script>
<div class="table-responsive">
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th><?php echo _p("ExportText1")." "._p("GisSubTitle2")." "._p("ExportText2"); ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <form class="form" role="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
		  <div class="form-group row col-md-6">
			<label class="col-md-5 col-form-label"><?php echo _p("GisSub2SearchText1"); ?>:</label>
			<div class="col-md-3">
			  <input type="text" class="form-control" name="export_reforest_year" id="export_reforest_year"/>
			</div>
		  </div>		  
		  <div class="form-group row col-md-6">
			<label class="col-md-5 col-form-label"><?php echo _p("GisSub2SearchText2"); ?>:</label>
			<div class="col-md-5">
			  <?php
				$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn ASC";
				
				if($checkaimag==1)
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va 
					WHERE EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = va.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id.")) ORDER BY va.aimag_name_mn";
					
				$rows = $db->query($selQuery);
				echo seldatadb("export_aimag_code", "form-control", $rows, "aimag_code", "aimag_name_$language_name", 0, "", _p("AllAimags"));
				?>
			</div>
		  </div>
		  <input type="hidden" id="excelbttn" name="excelbttn" value="0"/>
		  <input type="hidden" id="kmlbttn" name="kmlbttn" value="0"/>
		  <div class="form-group row col-md-6 justify-content-center">
			<div><button type="button" class="btn btn-primary" onclick="excelsubmitform()"><i class="fa fa-bar-chart"></i> <?php echo _p("ExcelButton");?></button> 
			 <button type="button" class="btn btn-primary" onclick="kmlsubmitform()"><i class="fa fa-globe"></i> <?php echo _p("KmlButton");?></button> 
			 <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?></a> </div>
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
