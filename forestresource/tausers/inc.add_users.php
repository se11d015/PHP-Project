<?php 
if($sess_profile==1) 
{ 
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform(){
	if (document.getElementById("login_name").value==""){
		alert("<?php echo _p("EnterText1")." "._p("UsersColumn1")." "._p("EnterText2");?>");
	}else if (document.getElementById("login_passwd").value==""){
		alert("<?php echo _p("EnterText1")." "._p("UsersColumn9")." "._p("EnterText2");?>");
	}else if (document.getElementById("lastname").value==""){
		alert("<?php echo _p("EnterText1")." "._p("UsersColumn4")." "._p("EnterText2");?>");
	}else if (document.getElementById("firstname").value==""){
		alert("<?php echo _p("EnterText1")." "._p("UsersColumn3")." "._p("EnterText2");?>");
	}else if (document.getElementById("organization").value==""){
		alert("<?php echo _p("EnterText1")." "._p("UsersColumn5")." "._p("EnterText2");?>");
	}else {
		document.getElementById("insertuserbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("AddText5")." "._p("UsersTitle")." "._p("AddText6"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" role="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("UsersColumn1"); ?> *:</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="login_name"  id="login_name"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar35"); ?></span> </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("UsersColumn9"); ?> *:</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="login_passwd" id="login_passwd"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar35"); ?></span> </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("UsersColumn2"); ?> *:</label>
              <div class="col-md-3">
                <?php
					echo seldata("profile", "form-control", $USER_PROFILE, 1);
					?>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextSelect"); ?></span> </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("UsersColumn8"); ?> *:</label>
              <div class="col-md-3">
                <?php
					echo seldata("login_status", "form-control", $USER_ACTIVE, 1);
					?>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextSelect"); ?></span> </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("UsersColumn3"); ?> *:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="firstname" id="firstname" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span> </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("UsersColumn4"); ?> *:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="lastname" id="lastname"/>
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span> </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("UsersColumn5"); ?> *:</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="organization" id="organization" />
              </div>
              <span class="col-md-3 form-text text-muted">1<?php echo _p("AlertTextChar50"); ?></span> </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("UsersColumn6"); ?>:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="phone" id="phone" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span> </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("UsersColumn7"); ?>:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="email" id="email" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span> </div>
            <input type="hidden" id="insertuserbttn" name="insertuserbttn" value="0"/>
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
	show_notification("error", _p("NotAccessText"), $notify);
}
?>
