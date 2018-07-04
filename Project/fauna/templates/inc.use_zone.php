
<div class="main-content">
  <p><?php echo getdata($GROUP_ITEM_TYPE, 12); ?></p>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=29"; ?>"><img src="images/tganimalzone.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 19); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=120"; ?>"><img src="images/taanimalmng.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 120); ?></a> </div>
  <?php
	}
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=1"; ?>"><img src="images/return.png" alt="image" width="48" height="48"></br>
    Буцах</a> </div>
  <p></p>
</div>
