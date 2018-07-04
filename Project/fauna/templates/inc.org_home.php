
<div class="main-content">
  <p><?php echo getdata($GROUP_ITEM_TYPE, 7); ?></p>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=61"; ?>"><img src="images/tganimalorg.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 40); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=64"; ?>"><img src="images/taanimalorgpermission.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 41); ?></a> </div>
    <div class="home-button"> <a href="<?php echo $my_url."?menuitem=65"; ?>"><img src="images/taanimalorgreport.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 42); ?></a> </div>
	
  <?php
	}
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=1"; ?>"><img src="images/return.png" alt="image" width="48" height="48"></br>
    Буцах</a> </div>
</div>
