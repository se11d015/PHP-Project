
<div class="main-content">
  <p><?php echo "Сайн байна уу ".$sess_user_name.", та системд нэвтэрлээ.";?></p>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=10"; ?>"><img src="images/1.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($GROUP_ITEM_TYPE, 1); ?></a> </div>
  <?php
	}
	?>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=20"; ?>"><img src="images/2.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($GROUP_ITEM_TYPE, 2); ?></a> </div>
  <?php
	}
	?>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=30"; ?>"><img src="images/taredlist.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($GROUP_ITEM_TYPE, 3); ?></a> </div>
  <?php
	}
	?>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 4, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=31"; ?>"><img src="images/taredbook.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($GROUP_ITEM_TYPE, 4); ?></a> </div>
  <?php
	}
	?>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=40"; ?>"><img src="images/taanimalresearchreport.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($GROUP_ITEM_TYPE, 5); ?></a> </div>
  <?php
	}
	?>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=50"; ?>"><img src="images/6.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($GROUP_ITEM_TYPE, 6); ?></a> </div>
  <?php
	}
	?>
  <?php
	//if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 1))
	//{
	?>
  <!-- <div class="home-button"> <a href="<?php //echo $my_url."?menuitem=60"; ?>"><img src="images/7.png" alt="image" width="48" height="48"></br>
    <?php //echo getdata($GROUP_ITEM_TYPE, 7); ?></a> </div> -->
  <?php
	//}
	?>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=70"; ?>"><img src="images/8.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($GROUP_ITEM_TYPE, 8); ?></a> </div>
  <?php
	}
	?>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=80"; ?>"><img src="images/tganimalprotection.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($GROUP_ITEM_TYPE, 9); ?></a> </div>
  <?php
	}
	?>
  <?php
	//if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 10, 1))
	//{
	?>
  <!-- <div class="home-button"> <a href="<?php// echo $my_url."?menuitem=100"; ?>"><img src="images/tganimaloffence.png" alt="image" width="48" height="48"></br>
    <?php //echo getdata($GROUP_ITEM_TYPE, 10); ?></a> </div> -->
  <?php
	//}
	?>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=110"; ?>"><img src="images/tganimalcontagion.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($GROUP_ITEM_TYPE, 11); ?></a> </div>
  <?php
	}
	?>
  <?php
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 1))
	{
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=122"; ?>"><img src="images/taanimalmng.png" alt="image" width="48" height="48"></br>
    <?php echo getdata($GROUP_ITEM_TYPE, 12); ?></a> </div>
  <?php
	}
	?>
  <div class="home-button"> <a href="<?php echo $my_url."?menuitem=3"; ?>"><img src="images/tausers.png" alt="image" width="48" height="48"></br>
    Хэрэглэгчийн мэдээлэл</a> </div>
  <div class="home-button"> <a href="login.php?login=logout"><img src="images/logout.png" alt="image" width="48" height="48"></br>
    Гарах</a> </div>
</div>
