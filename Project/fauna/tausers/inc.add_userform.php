<?php 
if($sess_profile==1) 
{ 
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform(){
	if (document.getElementById("login_name").value==""){
		alert( "Хэрэглэгчийн нэвтрэх нэр оруулна уу" );
	}else if (document.getElementById("login_password").value==""){
		alert( "Хэрэглэгчийн нууц үгийг оруулна уу" );
	}else if (document.getElementById("lastname").value==""){
		alert( "Хэрэглэгчийн нэр оруулна уу" );
	}else if (document.getElementById("firstname").value==""){
		alert( "Хэрэглэгчийн овог нэр оруулна уу" );
	}else if (document.getElementById("organization").value==""){
		alert( "Байгууллагын нэр оруулна уу" );
	}else {
		document.getElementById("insertuserbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th>Хэрэглэгчийн мэдээлэл бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн нэвтрэх нэр:</label>
              <div class="controls">
                <input type="text" name="login_name"  id="login_name"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн нууц үг:</label>
              <div class="controls">
                <input type="text" name="login_password" id="login_password"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн төрөл:</label>
              <div class="controls">
                <?php
								echo seldata("profile", "span3", $USER_PROFILE, 1);
								?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн статус:</label>
              <div class="controls">
                <?php
								echo seldata("login_status", "span2", $USER_ACTIVE, 1);
								?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн овог:</label>
              <div class="controls">
                <input type="text" class="span4" name="firstname" id="firstname"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="lastname" id="lastname"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Байгууллагын нэр:</label>
              <div class="controls">
                <input type="text" class="span5" name="organization" id="organization"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Утас:</label>
              <div class="controls">
                <input type="text" class="span5" name="phone" id="phone"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">И-мэйл хаяг:</label>
              <div class="controls">
                <input type="text" class="span5" name="email" id="email"/>
              </div>
            </div>
            <input type="hidden" id="insertuserbttn" name="insertuserbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="addsubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <a class="btn btn-danger" href="<?php echo $my_url.$search_url.$sort_url; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a> </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php 
} else {
		$notify ="Таны хандалт буруу байна.";
		show_notification("error", "", $notify);
}
?>
