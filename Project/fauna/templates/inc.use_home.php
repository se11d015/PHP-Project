
<div class="main-content">
  <p><?php echo getdata($GROUP_ITEM_TYPE, 8); ?></p>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=71"; ?>"><img src="images/tganimaluseentity.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 70); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=72"; ?>"><img src="images/taanimalusepermission.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 71); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=73"; ?>"><img src="images/taanimalusename.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 72); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=74"; ?>"><img src="images/taanimalusepayment.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 73); ?></a> </div>
  <?php
	}
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=1"; ?>"><img src="images/return.png" alt="image" width="48" height="48"></br>
    Буцах</a> </div>
  <p></p>
</div>
