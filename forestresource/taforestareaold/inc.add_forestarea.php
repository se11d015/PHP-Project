<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2)) 
{

?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
    if (document.getElementById("area_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub1Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub1Column2")." "._p("EnterText2");?>");
    }else {
        document.getElementById("insertforestareabttn").value = "1";
        document.mainform.submit();
    }
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("AddText5")." "._p("ResourceSubTitle1")." "._p("AddText6"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
			  <div class="form-row">
				<div class="form-group col-md-3">
				  <label class="col-form-label text-danger"><?php echo _p("ResourceSub1Column1"); ?> *</label>
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
				  <label class="col-form-label text-danger"><?php echo _p("ResourceSub1Column2"); ?> *</label>
				  <?php
						$selQuery = "SELECT vs.soum_code, vs.soum_name_mn, vs.soum_name_en FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";
						$rows = $db->query($selQuery);
						echo seldatadb("soum_code", "form-control", $rows, "soum_code", "soum_name_$language_name", $rows[0]["soum_code"]);
						?>
				</div>			
				<div class="form-group col-md-2">
				  <label class="col-form-label text-danger"><?php echo _p("ResourceSub1Column3"); ?> *</label>
				  <input type="text" class="form-control" name="area_year" id="area_year">
				</div>				
			  </div>
			  <div class="form-group row col-md-10">
			    <table>
				 <tbody>
				    <tr>
					  <th>№</th>
					  <th class="text-danger"><?php echo _p("ResourceSub1Column5"); ?> *</th>
					  <th class="text-danger"><?php echo _p("ResourceSub1Column4"); ?> *</th>
					  <th><?php echo _p("ResourceSub1Column6"); ?></th>
					</tr>
					<?php 
						for($i=1; $i<11; $i++){
					?>
				    <tr>
					  <th><?php echo $i;?></th>
					  <td><?php 
							$selQuery = "SELECT tct.type_code, tct.type_name_mn, tct.type_name_en FROM ".$schemas.".tclandtype tct ORDER BY tct.type_code";
							$rows = $db->query($selQuery);
							echo seldatadb("type_code_$i", "form-control", $rows, "type_code", "type_name_$language_name", $rows[0]["type_code"]);
					  ?></td>
					  <td><input type="text" class="form-control" name="forest_area_<?php echo $i;?>" id="forest_area_<?php echo $i;?>"/></td>
					  <td><input type="text" class="form-control" name="area_change_<?php echo $i;?>" id="area_change_<?php echo $i;?>"/></td>
					</tr>
					<?php 
						}
					 ?>
				  </tbody>
				</table>
			  </div>
			  <input type="hidden" id="insertforestareabttn" name="insertforestareabttn" value="0"/>
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
