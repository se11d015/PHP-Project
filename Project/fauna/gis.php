<?php
require("config/inc.cfg.php");
require("templates/inc.main_head.php");

require("config/inc.db.php");
require("config/inc.functions.php");
require("notification/inc.alerts.php");
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
      <iframe src="/faunainfo/" style="margin-left:0px; width:100%; height:600px; border:0px;">
      <p>Your browser does not support iframes.</p>
      </iframe>
    </div>
  </div>
  <div class="row">
    <div class="span12">
      <?php	require("templates/inc.footer.php"); ?>
    </div>
  </div>
</div>
</body>
</html>
