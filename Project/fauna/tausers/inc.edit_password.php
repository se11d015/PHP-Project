<?php
if (isset($_GET["user_id"]))
{
	$user_id = (int)$_GET["user_id"];
}else
{
	$user_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "tu.* FROM ".$schemas.".tausers tu";
$whereQuery = "";

if($sess_profile==1) 
	$whereQuery .= "WHERE tu.user_id = ".$user_id;
else
	$whereQuery .= "WHERE tu.user_id = ".$sess_user_id;


$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform(){
	if (document.getElementById("login_password").value==""){
		alert( "Хэрэглэгчийн нууц үгийг оруулна уу" );
	}else {
		document.getElementById("updatepassbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="edit-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th>Хэрэглэгчийн нууц үгийг засварлах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн нэвтрэх нэр:</label>
              <div class="controls">
                <input type="text" name="login_name" id="login_name" value="<?php echo $row[$i]["login_name"]; ?>" disabled/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн овог:</label>
              <div class="controls">
                <input type="text" name="firstname" id="firstname" value="<?php echo $row[$i]["firstname"]; ?>" disabled/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн нэр:</label>
              <div class="controls">
                <input type="text" name="lastname" id="lastname" value="<?php echo $row[$i]["lastname"]; ?>" disabled/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн нууц үг:</label>
              <div class="controls">
                <input type="text" name="login_password" id="login_password"/>
              </div>
            </div>
            <input type="hidden" id="updatepassbttn" name="updatepassbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="updatesubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <button class="btn btn-danger"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</button>
            </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("warning", "", $notify);
}
?>
