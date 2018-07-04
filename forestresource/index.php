<?php
require("config/inc.functions.php");
require("config/inc.session.php");
require("config/inc.language.php");
require("config/inc.cfg.php");

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
    <div class="row justify-content-center">
      <div class="col-md-11"><?php echo _p("HomeText"); ?> </div>
    </div>
    <div class="row">
      <div class="col">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active"> <img class="d-block w-100" src="images/oimod1.jpg" alt="First slide">
              <div class="carousel-caption d-none d-md-block">
                <h5><?php echo _p("HomeCarouselTitle1"); ?></h5>
                <p><?php echo _p("HomeCarouselText1"); ?></p>
              </div>
            </div>
            <div class="carousel-item"> <img class="d-block w-100" src="images/oimod2.jpg" alt="Second slide">
              <div class="carousel-caption d-none d-md-block">
                <h5><?php echo _p("HomeCarouselTitle2"); ?></h5>
                <p><?php echo _p("HomeCarouselText2"); ?></p>
              </div>
            </div>
            <div class="carousel-item"> <img class="d-block w-100" src="images/oimod3.jpg" alt="Third slide">
              <div class="carousel-caption d-none d-md-block">
                <h5><?php echo _p("HomeCarouselTitle3"); ?></h5>
                <p><?php echo _p("HomeCarouselText3"); ?></p>
              </div>
            </div>
            <div class="carousel-item"> <img class="d-block w-100" src="images/oimod4.jpg" alt="Fourth slide">
              <div class="carousel-caption d-none d-md-block">
                <h5><?php echo _p("HomeCarouselTitle4"); ?></h5>
                <p><?php echo _p("HomeCarouselText4"); ?></p>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
      </div>
    </div>
  </section>
  <?php require("templates/inc.main_footer.php"); ?>
</div>
</body>
</html>