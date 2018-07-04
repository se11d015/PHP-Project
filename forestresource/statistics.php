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

$my_url = "statistics.php";
$schemas = "scforestresource";

?>

<script>
	<?php if($language_name=="mn") { ?>
	Highcharts.setOptions({
		lang: {
			downloadJPEG: ['JPEG хэлбэрээр татах'],
			downloadPDF: ['PDF хэлбэрээр татах'],
			downloadPNG: ['PNG хэлбэрээр татах'],
			downloadSVG: ['SVG хэлбэрээр татах'],
			printChart: ['Хэвлэх'],
		}
	});
	<?php } else { ?>
	Highcharts.setOptions({
		lang: {
			downloadJPEG: ['Download JPEG image'],
			downloadPDF: ['Download PDF document'],
			downloadPNG: ['Download PNG image'],
			downloadSVG: ['Download SVG vector image'],
			printChart: ['Print chart'],
		}
	});	
	<?php } ?>	
</script>
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
        <h2 class="page-header"><?php echo _p("StatisticsTitle"); ?></h2>
		<hr>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <?php
			require("templates/inc.front_statistic_left.php");
		?>
      </div>
      <div class="col-md-9">
        <?php		
			require("templates/inc.front_statistic_main.php");
		?>
      </div>
    </div>
  </section>
  <?php require("templates/inc.main_footer.php"); ?>
</div>
</body>
</html>