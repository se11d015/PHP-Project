<div class="content-wrapper">
  <div class="container-fluid"> 
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a href="#"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><?php echo _p("Home"); ?></li>
    </ol>
	<div class="row">
		<div class="col-md-5">
			<div class="card">
			  <img class="card-img-top" src="images/back1.jpg" alt="images">
			  <div class="card-body text-white bg-success">
				<h5 class="card-title"><?php echo _p("OMReport"); ?></h5>
			  </div>
			  <ul class="list-group">
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 1)) { ?><li class="list-group-item"><img src="images/taforestarea.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=21"; ?>" class="card-link"><?php echo _p("ResourceSubTitle1"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1)) { ?><li class="list-group-item"><img src="images/taforestvolume.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=22"; ?>" class="card-link"><?php echo _p("ResourceSubTitle2"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 1)) { ?><li class="list-group-item"><img src="images/taforestfire.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=23"; ?>" class="card-link"><?php echo _p("ResourceSubTitle3"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 4, 1)) { ?><li class="list-group-item"><img src="images/taforestinsect.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=24"; ?>" class="card-link"><?php echo _p("ResourceSubTitle4"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 1)) { ?><li class="list-group-item"><img src="images/tareforestation.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=25"; ?>" class="card-link"><?php echo _p("ResourceSubTitle5"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 1)) { ?><li class="list-group-item"><img src="images/taforestutilization.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=26"; ?>" class="card-link"><?php echo _p("ResourceSubTitle6"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 1)) { ?><li class="list-group-item"><img src="images/taforestowner.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=27"; ?>" class="card-link"><?php echo _p("ResourceSubTitle7"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 1)) { ?><li class="list-group-item"><img src="images/taviolation.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=28"; ?>" class="card-link"><?php echo _p("ResourceSubTitle8"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 1)) { ?><li class="list-group-item"><img src="images/tacostreport.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=29"; ?>" class="card-link"><?php echo _p("ResourceSubTitle9"); ?></a></li><?php } ?>	
 			  </ul>
			</div>
		</div>
		<div class="col-md-5">
			<div class="card">
			  <img class="card-img-top" src="images/back2.jpg" alt="images">
			  <div class="card-body text-white bg-info">
				<h5 class="card-title"><?php echo _p("OMGisReport"); ?></h5>
			  </div>
			  <ul class="list-group">
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 1)) { ?><li class="list-group-item"><img src="images/tgforestinsect.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=31"; ?>" class="card-link"><?php echo _p("GisSubTitle1"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 1)) { ?><li class="list-group-item"><img src="images/tgreforestation.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=32"; ?>" class="card-link"><?php echo _p("GisSubTitle2"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 13, 1)) { ?><li class="list-group-item"><img src="images/tgplantedforest.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=33"; ?>" class="card-link"><?php echo _p("GisSubTitle3"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 14, 1)) { ?><li class="list-group-item"><img src="images/tgforestlogging.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=34"; ?>" class="card-link"><?php echo _p("GisSubTitle4"); ?></a></li><?php } ?>	
				<?php if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 15, 1)) { ?><li class="list-group-item"><img src="images/tgownerforest.png" alt="images"> 
				<a href="<?php echo $my_url."?menuitem=35"; ?>" class="card-link"><?php echo _p("GisSubTitle5"); ?></a></li><?php } ?>	
 			  </ul>
			</div>
		</div>
	</div>
  </div>
  <!-- /.container-fluid--> 
