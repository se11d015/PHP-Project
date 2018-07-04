<?php
require("config/inc.functions.php");
require("config/inc.session.php");
require("config/inc.language.php");
require("config/inc.cfg.php");
require("config/inc.db.php");
require("notification/inc.alerts.php");

require("templates/inc.main_head.php");

$language_name = "mn";
if($session->get("forestresource_lang") == 1){
	$language_name = "mn";	
} else if($session->get("forestresource_lang") == 2){
	$language_name = "en";
}	

require("config/inc.cfg_legal.php");
require("config/inc.db_legal.php");
		
$my_url = "legalinfo.php";
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
        <h2 class="page-header"><?php echo _p("LegalInfoTitle"); ?></h2>
		<hr>
        <?php

		
		$count = (isset($_POST["count"]) && (int) $_POST["count"] > 0) ? (int) $_POST["count"] : ((isset($_GET["count"]) && (int) $_GET["count"] > 0) ? (int) $_GET["count"] : 10);
		$my_count = $my_url."?page=1";
		$my_url .= "?count=".$count;
		
		if (isset($_GET["action"])) {
			$action = pg_prep($_GET["action"]);
		} else {
			$action = "";
		}
				
		$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
		$my_page = "&page=".$page;
		
		$searchQuery = "";
		$search_url = "";
		
		$legal_type = (isset($_GET["legal_type"])) ? (int) $_GET["legal_type"] : 0;
		$legal_name = (isset($_GET["legal_name"])) ? pg_prep($_GET["legal_name"]) : "";
		$issued_date = (isset($_GET["issued_date"])) ? (int) $_GET["issued_date"] : 0;
		$legal_status = (isset($_GET["legal_status"])) ? pg_prep($_GET["legal_status"]) : "t";
		
		if($legal_type == 0)
		{
			$searchQuery .= "";
			$search_url .= "";
		}else
		{
			$searchQuery .= " AND tli.legal_type = ".$legal_type;
			$search_url .= "&legal_type=".$legal_type;
		}
		
		if(empty($legal_name))
		{
			$searchQuery .= "";
			$search_url .= "";
		}else
		{
			$searchQuery .= " AND lower(tli.legal_name) LIKE lower('%".$legal_name."%')";
			$search_url .= "&legal_name=".$legal_name;
		}
		
		if($issued_date == 0)
		{
			$searchQuery .= "";
			$search_url .= "";
		}else
		{
			$searchQuery .= " AND date_part('year', tli.issued_date) = ".$issued_date;
			$search_url .= "&issued_date=".$issued_date;
		}
		
		if($legal_status == "t")
		{
			$searchQuery .= " AND tli.legal_status = 't'";
			$search_url .= "&legal_status=t";
		}else
		{
			$searchQuery .= " AND tli.legal_status = 'f'";
			$search_url .= "&legal_status=f";
		}
		
		$sort_url = "";
		$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
		$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;
	
		if ($sort == 0)
			$sort_url .= "";
		else
			$sort_url .= "&sort=".$sort;
	
		if ($sort_type == 0)
			$sort_url .= "";
		else
			$sort_url .= "&sorttype=".$sort_type;
		
		if ($action == "more")
		{
			require("includes/legalinfo/inc.more_legalinfo.php");
		}else
		{
			require("includes/legalinfo/inc.list_legalinfo.php");
		}
	?>
      </div>
    </div>
  </section>
  <?php require("templates/inc.main_footer.php"); ?>
</div>
</body>
</html>