<?php 
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 1)) 
{
?>
<script language="JavaScript" type="text/javascript">
function excelsubmitform(){
	document.getElementById("excelbttn").value = "1";
	document.mainform.submit();
}
</script>
<div class="table-responsive">
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th><?php echo _p("ExportText1")." "._p("ResourceSubTitle1")." "._p("ExportText2"); ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <form class="form" role="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
		  <div class="form-group row col-md-6">
			<label class="col-md-5 col-form-label"><?php echo _p("ResourceSub1SearchText1"); ?>:</label>
			<div class="col-md-3">
			  <input type="text" class="form-control" name="export_area_year" id="export_area_year"/>
			</div>
		  </div>		  
		  <div class="form-group row col-md-6">
			<label class="col-md-5 col-form-label"><?php echo _p("ResourceSub1SearchText2"); ?>:</label>
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
		  <div class="form-group row col-md-6">
			<label class="col-md-5 col-form-label"><?php echo _p("ResourceSub1SearchText3"); ?>:</label>
			<div class="col-md-7">
			  <?php
				$selQuery = "SELECT tct.type_code, tct.type_name_mn, tct.type_name_en FROM ".$schemas.".tclandtype tct ORDER BY tct.type_code ASC";
				$rows = $db->query($selQuery);
				echo seldatadb("export_type_code", "form-control", $rows, "type_code", "type_name_$language_name", 0, "", _p("AllTypes"));
				?>
			</div>
		  </div>		  
		  <input type="hidden" id="excelbttn" name="excelbttn" value="0"/>
		  <div class="form-group row col-md-6 justify-content-center">
			<div><button type="button" class="btn btn-primary" onclick="excelsubmitform()"><i class="fa fa-bar-chart"></i> <?php echo _p("ExcelButton");?></button> 
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
