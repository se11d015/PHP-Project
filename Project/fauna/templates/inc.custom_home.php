
<div class="main-content">
  <p><?php echo getdata($GROUP_ITEM_TYPE, 6); ?></p>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=51"; ?>"><img src="images/tganimalcustomentity.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 60); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=52"; ?>"><img src="images/taanimalcustompermission.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 61); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=53"; ?>"><img src="images/taanimalcustomname.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 62); ?></a> </div>
  <?php
	}
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=1"; ?>"><img src="images/return.png" alt="image" width="48" height="48"></br>
    Буцах</a> </div>
  <p></p>
</div>
