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
$whereQuery = " ";

if($sess_profile==1) 
	$whereQuery .= " WHERE tu.user_id = ".$user_id;
else
	$whereQuery .= " WHERE tu.user_id = ".$sess_user_id;


$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform(){
	if (document.getElementById("login_name").value==""){
		alert( "Хэрэглэгчийн нэвтрэх нэр оруулна уу" );
	}else if (document.getElementById("lastname").value==""){
		alert( "Хэрэглэгчийн нэр оруулна уу" );
	}else if (document.getElementById("firstname").value==""){
		alert( "Хэрэглэгчийн овог нэр оруулна уу" );
	}else if (document.getElementById("organization").value==""){
		alert( "Байгууллагын нэр оруулна уу" );
	}else {
		document.getElementById("updateuserbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="edit-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th>Хэрэглэгчийн мэдээлэл засварлах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <?php 
						if($sess_profile==1)
						{
						?>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн нэвтрэх нэр:</label>
              <div class="controls">
                <input type="text" name="login_name" id="login_name" value="<?php echo $row[$i]["login_name"]; ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн төрөл:</label>
              <div class="controls">
                <?php
								echo seldata("profile", "span3", $USER_PROFILE, $row[$i]["profile"]);
								?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн статус:</label>
              <div class="controls">
                <?php
								echo seldata("login_status", "span2", $USER_ACTIVE, $row[$i]["login_status"]);
								?>
              </div>
            </div>
            <?php
            } else
            {
            ?>
            <input type="hidden" name="login_name" id="login_name" value="<?php echo $row[$i]["login_name"]; ?>"/>
            <input type="hidden" name="profile" id="profile" value="<?php echo $row[$i]["profile"]; ?>">
            <input type="hidden" name="login_status" id="login_status" value="<?php echo $row[$i]["login_status"]; ?>">
            <?php
            }
            ?>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн овог:</label>
              <div class="controls">
                <input type="text" class="span4" name="firstname" id="firstname" value="<?php echo $row[$i]["firstname"]; ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэрэглэгчийн нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="lastname" id="lastname" value="<?php echo $row[$i]["lastname"]; ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Байгууллагын нэр:</label>
              <div class="controls">
                <input type="text" class="span5" name="organization" id="organization" value="<?php echo $row[$i]["organization"]; ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Утас:</label>
              <div class="controls">
                <input type="text" class="span5" name="phone" id="phone" value="<?php echo $row[$i]["phone"]; ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">И-мэйл хаяг:</label>
              <div class="controls">
                <input type="text" class="span5" name="email" id="email" value="<?php echo $row[$i]["email"]; ?>"/>
              </div>
            </div>
            <input type="hidden" id="updateuserbttn" name="updateuserbttn" value="0"/>
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
