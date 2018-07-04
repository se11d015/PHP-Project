<?php
$error = "";
$my_url = "login.php";

require("config/inc.cfg.php");
require("config/inc.session.php");
require("config/inc.functions.php");
require("config/inc.db.php");
require("notification/inc.alerts.php");

$username = "";
$password = "";

if (isset($_POST["loginbttn"]))
{
	if (isset($_POST["username"]) && isset($_POST["password"]))
	{
		$username = pg_prep($_POST["username"]);
		$password = pg_prep($_POST["password"]);
		if (!is_null($username) && !is_null($password))
		{
			$schemas = "scfauna";
			
			$selQuery = "SELECT tu.user_id, tu.profile, tu.login_name FROM ".$schemas.".tausers tu WHERE tu.login_name = '".$username."' AND tu.login_passwd = md5('".$password."') AND tu.login_status = true";
			$rows = $db->query($selQuery);
			
			if (!empty($rows)) 
			{
				$today = date("Y-m-d H:i:s");
				$login_session = generateSessionString(16); 
							
				$session->set('fauna_session_id', $login_session);
				$session->set('fauna_login_name', $rows[0]["login_name"]);
				$session->set('fauna_profile', $rows[0]["profile"]);				
				
				$wherevalues = "user_id=".$rows[0]["user_id"]; 
				$fields = array("login_date", "login_session");
				$values = array("'".$today."'", "'".$login_session."'");
				
				$db->update("".$schemas.".tausers", $fields, $values, $wherevalues);
				
				header("Location: admin.php");
			}else
			{
				$error = "Таны оруулсан нэр, нууц үг буруу байна.";
			}
		}else
		{
			$error = "Та нэр, нууц үгээ оруулна уу.";
		}
	}
}
if (isset($_GET["login"]) && ($_GET["login"]=="logout"))
{
	$session->deleteset('fauna_session_id');
	$session->deleteset('fauna_login_name');
	$session->deleteset('fauna_profile');
}

require("templates/inc.main_head.php");
?>
<body>
<div class="container">
  <div class="row">
    <div class="span12">
      <div class="headerlogo"> <a class="logo1" href="http://www.mne.mn/"></a> <a class="logo2" href="http://www.irimhe.namem.gov.mn"></a> </div>
      <div class="headertitle">
        <h2><?php echo $_MY_CONF["SITE_NAME"]; ?></h2>
      </div>
      <?php	require("templates/inc.main_nav.php"); ?>
    </div>
  </div>
  <div class="row">
    <div class="span12">
      <div class="main-content">
        <div class="row">
          <div class="span7 offset2">
            <?php require("templates/inc.login.php"); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="span12">
      <?php	require("templates/inc.footer_nav.php"); ?>
    </div>
  </div>
</div>
</body>
</html>