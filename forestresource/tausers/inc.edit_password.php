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
$valueQuery = "tau.* FROM ".$schemas.".tausers tau";
$whereQuery = "";

if($sess_profile==1) 
	$whereQuery .= "WHERE tau.user_id = ".$user_id;
else
	$whereQuery .= "WHERE tau.user_id = ".$sess_user_id;


$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform(){
	if (document.getElementById("login_passwd").value==""){
		alert( "<?php echo _p("UsersColumn9"); ?>ийг оруулна уу" );
	}else {
		document.getElementById("updatepassbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("EditText3")." "._p("UsersColumn9")." "._p("EditText4"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" role="form" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("UsersColumn1"); ?>:</label>
              <div class="col-md-4">
                <input type="text" readonly class="form-control-plaintext" value="<?php echo $row[$i]["login_name"]; ?>"/>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("UsersColumn3"); ?>:</label>
              <div class="col-md-4">
                <input type="text" readonly class="form-control-plaintext" value="<?php echo $row[$i]["firstname"]; ?>"/>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("UsersColumn4"); ?>:</label>
              <div class="col-md-4">
                <input type="text" readonly class="form-control-plaintext" value="<?php echo $row[$i]["lastname"]; ?>"/>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("UsersColumn9"); ?> *:</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="login_passwd" id="login_passwd" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar35"); ?></span> </div>
            <input type="hidden" id="updatepassbttn" name="updatepassbttn" value="0"/>
            <div class="form-group row col-md-10 justify-content-center">
              <div>
                <button type="button" class="btn btn-primary" onclick="updatesubmitform()"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
                <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></a></div>
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
?>
