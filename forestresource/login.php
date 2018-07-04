<?php
require("config/inc.functions.php");
require("config/inc.session.php");
require("config/inc.language.php");
require("config/inc.cfg.php");
require("config/inc.db.php");
require("notification/inc.alerts.php");

$username = "";
$password = "";

$error = "";
$my_url = "login.php";

if (isset($_POST["loginbttn"]))
{
	if (isset($_POST["username"]) && isset($_POST["password"]))
	{
		$username = pg_prep($_POST["username"]);
		$password = pg_prep($_POST["password"]);
		
		if (!is_null($username) && !is_null($password))
		{
			$schemas = "scforestresource";
			
			$selQuery = "SELECT tu.user_id, tu.profile, tu.login_name FROM ".$schemas.".tausers tu WHERE tu.login_name = '".$username."' AND tu.login_passwd = md5('".$password."') AND tu.login_status = true";
			$rows = $db->query($selQuery);
			
			if (!empty($rows)) 
			{
				$today = date("Y-m-d H:i:s");
				$login_session = generateSessionString(16); 
				
				$session->set('forestresource_session_id', $login_session);
				$session->set('forestresource_login_name', $rows[0]["login_name"]);
				$session->set('forestresource_profile', $rows[0]["profile"]);
				
				$wherevalues = "user_id=".$rows[0]["user_id"]; 
				$fields = array("login_date", "login_session");
				$values = array("'".$today."'", "'".$login_session."'");
				
				$db->update("".$schemas.".tausers", $fields, $values, $wherevalues);
				
				header("Location: admin.php");
			}else
			{
				$error = _p("LoginErrorText1");
			}
		}else
		{
			$error = _p("LoginErrorText2");
		}
	}
}
if (isset($_GET["login"]) && ($_GET["login"]=="logout"))
{
	$session->deleteset('forestresource_session_id');
	$session->deleteset('forestresource_login_name');
	$session->deleteset('forestresource_profile');
}

require("templates/inc.main_head.php");

$language_name = "mn";
if($session->get("forestresource_lang") == 1){
	$language_name = "mn";	
} else if($session->get("forestresource_lang") == 2){
	$language_name = "en";
}
?>
<body>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="headerlogo"> <a <?php if($language_name=="mn") echo "class=\"logo1\""; else  echo "class=\"logo2\""; ?> href="http://www.mne.mn/"></a> </div>
      <div class="headertitle">
        <h2><?php echo _p("SITE_NAME"); ?>
          <div class="pull-right"> <a href="get_language.php?lang=1"><img src="images/mn.png" alt="Mongolian page" /></a> <a href="get_language.php?lang=2"><img src="images/en.png" alt="English page" /></a> </div>
        </h2>
      </div>
      <?php require("templates/inc.main_nav.php"); ?>
    </div>
  </div>
  <section>
    <div class="row">
      <div class="col">
        <h2 class="page-header"><?php echo _p("Login"); ?></h2>
		<hr>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-7">
        <?php
			require("templates/inc.login.php");
			?>
      </div>
    </div>
  </section>
  <?php require("templates/inc.main_footer.php"); ?>
</div>
</body>
</html>