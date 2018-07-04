
<div class="main-content">
  <p><?php echo getdata($GROUP_ITEM_TYPE, 2); ?></p>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=21"; ?>"><img src="images/taanimalinfo.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 10); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=22"; ?>"><img src="images/taanimalresource.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 11); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=23"; ?>"><img src="images/taanimalstatus.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 12); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=28"; ?>"><img src="images/tganimalhabitat.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 13); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=25"; ?>"><img src="images/tganimalpicture.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 18); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=26"; ?>"><img src="images/tganimalherbarium.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 15); ?></a> </div>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=29"; ?>"><img src="images/tganimalzone.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($ITEM_TYPE, 19); ?></a> </div>
  <?php
	}
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=1"; ?>"><img src="images/return.png" alt="image" width="48" height="48"></br>
    Буцах</a> </div>
  <p></p>
</div>
