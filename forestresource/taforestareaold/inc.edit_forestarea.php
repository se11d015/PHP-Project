<?php
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2)) 
{
	if (isset($_GET["area_id"]))
	{
		$area_id = (int) $_GET["area_id"];
	}else
	{
		$area_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "taf.*, vs.aimag_code FROM ".$schemas.".taforestarea taf, scadministrative.vasoumname vs";
	
	if($sess_profile==1)
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.area_id = ".$area_id;
	else
		$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.area_id = ".$area_id." AND taf.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
    if (document.getElementById("area_year").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub1Column3")." "._p("EnterText2");?>");
    }else if (document.getElementById("soum_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub1Column2")." "._p("EnterText2");?>");
    }else if (document.getElementById("type_code").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub1Column5")." "._p("EnterText2");?>");
    }else if (document.getElementById("forest_area").value == "") {
        alert("<?php echo _p("EnterText1")." "._p("ResourceSub1Column4")." "._p("EnterText2");?>");
    }else {
        document.getElementById("updateforestareabttn").value = "1";
        document.mainform.submit();
    }
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("EditText3")." "._p("ResourceSubTitle1")." "._p("EditText4"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="area_id" id="area_id" value="<?php echo $row[$i]["area_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub1Column3"); ?> *:</label>
              <div class="col-md-2">
				<input type="text" class="form-control" name="area_year" id="area_year" value="<?php echo $row[$i]["area_year"]; ?>"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub1Column1"); ?> *:</label>
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
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub1Column2"); ?> *:</label>
              <div class="col-md-3">
			    <?php
					$selQuery = "SELECT vs.soum_code, vs.soum_name_mn, vs.soum_name_en FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("soum_code", "form-control", $rows, "soum_code", "soum_name_$language_name", $row[$i]["soum_code"]);
					?>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextSelect"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub1Column5"); ?> *:</label>
              <div class="col-md-4">
                <?php
					$selQuery = "SELECT tct.type_code, tct.type_name_mn, tct.type_name_en FROM ".$schemas.".tclandtype tct ORDER BY tct.type_name_mn, tct.type_name_en ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("type_code", "form-control", $rows, "type_code", "type_name_$language_name", $row[$i]["type_code"]);
					?>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextSelect"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 text-danger"><?php echo _p("ResourceSub1Column4"); ?> *:</label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="forest_area" id="forest_area" value="<?php echo $row[$i]["forest_area"]; ?>"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextReal11"); ?></span> </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3"><?php echo _p("ResourceSub1Column6"); ?>:</label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="area_change" id="area_change" value="<?php echo $row[$i]["area_change"]; ?>"  />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextReal11"); ?> </span> </div>
            <input type="hidden" id="updateforestareabttn" name="updateforestareabttn" value="0"/>
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
