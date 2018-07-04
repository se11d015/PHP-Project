<?php 
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 10, 2)) 
{ 
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform(){
	if (document.getElementById("insect_code").value==""){
		alert("<?php echo _p("EnterText1")." "._p("ReferenceSub4Column1")." "._p("EnterText2");?>");
	}else if (document.getElementById("species_name").value==""){
		alert("<?php echo _p("EnterText1")." "._p("ReferenceSub4Column4")." "._p("EnterText2");?>");
	}else if (document.getElementById("insect_name_mn").value==""){
		alert("<?php echo _p("EnterText1")." "._p("ReferenceSub4Column5")." "._p("EnterText2");?>");
	}else {
		document.getElementById("insertinsectbttn").value = "1";
		document.mainform.submit();
	}
}
</script>
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("AddText5")." "._p("ReferenceSubTitle4")." "._p("AddText6"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" role="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("ReferenceSub4Column1");?> *:</label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="insect_code" id="insect_code" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("ReferenceSub4Column2");?>:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="order_name_mn" id="order_name_mn" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar100"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("ReferenceSub4Column3");?>:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="family_name_mn" id="family_name_mn" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar100"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("ReferenceSub4Column4");?> *:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="species_name" id="species_name" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar100"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("ReferenceSub4Column5");?> *:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="insect_name_mn" id="insect_name_mn" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar100"); ?></span> </div>	
			<div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("ReferenceSub4Column6");?>:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="insect_name_en" id="insect_name_en" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar100"); ?></span> </div>	
			<div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("ReferenceSub4Column7");?>:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="insect_name_ru" id="insect_name_ru" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar100"); ?></span> </div>				  
            <input type="hidden" id="insertinsectbttn" name="insertinsectbttn" value="0"/>
            <div class="form-group row col-md-10 justify-content-center">
              <div>
                <button type="button" class="btn btn-primary" onclick="addsubmitform()"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
                <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></a></div>
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
