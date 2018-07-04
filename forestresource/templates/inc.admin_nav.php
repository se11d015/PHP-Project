<?php
	$my_url = "admin.php";
	if (isset($_GET["menuitem"]))
	{
		$menuitem = (int)$_GET["menuitem"];
	}else
	{
		$menuitem = 1;
	}
?>
<!-- Navigation-->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav"> <a class="navbar-brand" href="#"><?php echo _p("SITE_NAME"); ?></a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav navbar-sidenav" id="menuAccordion">
      <li class="nav-item"> <a class="nav-link" href="<?php echo $my_url."?menuitem=1"; ?>"> <i class="fa fa-dashboard"></i> <span class="nav-link-text"><?php echo _p("Dashboard"); ?></span> </a> </li>
      <li class="nav-item">
      <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseUser" data-parent="#menuAccordion"> <i class="fa fa-user"></i> <span class="nav-link-text"><?php echo _p("User"); ?></span> </a>
      <ul class="sidenav-second-level collapse" id="collapseUser">
        <li> <a href="<?php echo $my_url."?menuitem=3"; ?>"><?php echo _p("UsersTitle"); ?></a> </li>
        <?php if($sess_profile==1) { ?>
        <li> <a href="<?php echo $my_url."?menuitem=2"; ?>"><?php echo _p("GroupsTitle"); ?></a> </li>
        <li> <a href="<?php echo $my_url."?menuitem=5"; ?>"><?php echo _p("GroupRolesTitle"); ?></a> </li>
        <li> <a href="<?php echo $my_url."?menuitem=4"; ?>"><?php echo _p("UserGroupsTitle"); ?></a></li>
        <li> <a href="<?php echo $my_url."?menuitem=6"; ?>"><?php echo _p("UserAimagsTitle"); ?></a> </li>
        <?php } ?>
      </ul>
      </li>
      <li class="nav-item">
      <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseReference" data-parent="#menuAccordion"> <i class="fa fa-table"></i> <span class="nav-link-text"><?php echo _p("Reference"); ?></span> </a>
      <ul class="sidenav-second-level collapse" id="collapseReference">
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 10, 1)) { ?>	
        <li> <a href="<?php echo $my_url."?menuitem=11"; ?>"><?php echo _p("ReferenceSubTitle2"); ?></a> </li>
        <li> <a href="<?php echo $my_url."?menuitem=12"; ?>"><?php echo _p("ReferenceSubTitle3"); ?></a> </li>
        <li> <a href="<?php echo $my_url."?menuitem=13"; ?>"><?php echo _p("ReferenceSubTitle4"); ?></a></li>
        <?php } ?>
      </ul>
      </li>	  
      <li class="nav-item">
      <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseForest" data-parent="#menuAccordion"> <i class="fa fa-tree"></i> <span class="nav-link-text"><?php echo _p("OMReport"); ?></span> </a>
      <ul class="sidenav-second-level collapse" id="collapseForest">
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=21"; ?>"><?php echo _p("ResourceSubTitle1"); ?></a> </li>
        <?php } ?>
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=22"; ?>"><?php echo _p("ResourceSubTitle2"); ?></a> </li>
        <?php } ?>
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=23"; ?>"><?php echo _p("ResourceSubTitle3"); ?></a> </li>
        <?php } ?>
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 4, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=24"; ?>"><?php echo _p("ResourceSubTitle4"); ?></a> </li>
        <?php } ?>	
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=25"; ?>"><?php echo _p("ResourceSubTitle5"); ?></a> </li>
        <?php } ?>
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=26"; ?>"><?php echo _p("ResourceSubTitle6"); ?></a> </li>
        <?php } ?>	
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=27"; ?>"><?php echo _p("ResourceSubTitle7"); ?></a> </li>
        <?php } ?>
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=28"; ?>"><?php echo _p("ResourceSubTitle8"); ?></a> </li>
        <?php } ?>
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=29"; ?>"><?php echo _p("ResourceSubTitle9"); ?></a> </li>
        <?php } ?>		
      </ul>
      </li>	  
      <li class="nav-item">
      <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseGis" data-parent="#menuAccordion"> <i class="fa fa-globe"></i> <span class="nav-link-text"><?php echo _p("OMGisReport"); ?></span> </a>
      <ul class="sidenav-second-level collapse" id="collapseGis">
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=31"; ?>"><?php echo _p("GisSubTitle1"); ?></a> </li>
        <?php } ?>	
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=32"; ?>"><?php echo _p("GisSubTitle2"); ?></a> </li>
        <?php } ?>	
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 13, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=33"; ?>"><?php echo _p("GisSubTitle3"); ?></a> </li>
        <?php } ?>	
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 14, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=34"; ?>"><?php echo _p("GisSubTitle4"); ?></a> </li>
        <?php } ?>	
        <?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 15, 1)) { ?>		
        <li> <a href="<?php echo $my_url."?menuitem=35"; ?>"><?php echo _p("GisSubTitle5"); ?></a> </li>
        <?php } ?>			
      </ul>
      </li>		  
      <li class="nav-item"> <a class="nav-link" href="<?php echo $my_url."?menuitem=9"; ?>"> <i class="fa fa-bar-chart"></i> <span class="nav-link-text"><?php echo _p("DataEntryReport"); ?></span> </a> </li>
      <li class="nav-item"> <a class="nav-link" href="files/user_manual.pdf" target="_blank"> <i class="fa fa-file-pdf-o"></i> <span class="nav-link-text"><?php echo _p("UserManual"); ?></span> </a> </li>
    </ul>
    <ul class="navbar-nav sidenav-toggler">
      <li class="nav-item"> <a class="nav-link text-center" id="sidenavToggler"> <i class="fa fa-angle-left"></i> </a> </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"> <a href="get_language.php?lang=1" class="nav-link"> <img src="images/mn.png" alt="Mongolian page"/></a> </li>
      <li class="nav-item"> <a href="get_language.php?lang=2" class="nav-link"> <img src="images/en.png" alt="English page"/></a> </li>	  
      <li class="nav-item"> <a href="login.php?login=logout" class="nav-link"> <i class="fa fa-sign-out"></i><?php echo _p("Logout"); ?></a> </li>
    </ul>
  </div>
</nav>
