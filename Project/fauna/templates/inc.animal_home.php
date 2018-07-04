
<div class="main-content">
  <p><?php echo getdata($GROUP_ITEM_TYPE, 1); ?></p>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=11"; ?>"><img src="images/takingdomname.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 1); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=12"; ?>"><img src="images/taphylumname.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 2); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=13"; ?>"><img src="images/taclassname.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 3); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=14"; ?>"><img src="images/taordername.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 4); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=15"; ?>"><img src="images/tafamilyname.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 5); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=16"; ?>"><img src="images/tagenusname.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 6); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=17"; ?>"><img src="images/taanimalname.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 7); ?></a> </div>
  <?php
	}
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=1"; ?>"><img src="images/return.png" alt="image" width="48" height="48"></br>
    Буцах</a> </div>
</div>
