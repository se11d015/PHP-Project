<?php 
if ($sess_profile==1 || $db->isGroupRole($schemas, $sess_profile, $sess_user_id, 10, 2)) 
{ 
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform(){
	if (document.getElementById("tree_code").value==""){
		alert("<?php echo _p("EnterText1")." "._p("ReferenceSub2Column1")." "._p("EnterText2");?>");
	}else if (document.getElementById("science_name").value==""){
		alert("<?php echo _p("EnterText1")." "._p("ReferenceSub2Column2")." "._p("EnterText2");?>");
	}else if (document.getElementById("tree_name_mn").value==""){
		alert("<?php echo _p("EnterText1")." "._p("ReferenceSub2Column3")." "._p("EnterText2");?>");
	}else {
		document.getElementById("inserttreebttn").value = "1";
		document.mainform.submit();
	}
}
</script>
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("AddText5")." "._p("ReferenceSubTitle2")." "._p("AddText6"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" role="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("ReferenceSub2Column1");?> *:</label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="tree_code" id="tree_code" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("ReferenceSub2Column2");?> *:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="science_name" id="science_name" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar35"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("ReferenceSub2Column3");?> *:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="tree_name_mn" id="tree_name_mn" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar35"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("ReferenceSub2Column4");?>:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="tree_name_en" id="tree_name_en" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar35"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("ReferenceSub2Column5");?>:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="tree_name_ru" id="tree_name_ru" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar35"); ?></span> </div>			  
            <input type="hidden" id="inserttreebttn" name="inserttreebttn" value="0"/>
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
