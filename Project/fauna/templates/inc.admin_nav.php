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

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="brand" href="#"><?php echo $_MY_CONF["SITE_NAME"]; ?></a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li><a href="<?php echo $my_url."?menuitem=1"; ?>">Нүүр хуудас</a></li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Амьтны мэдээлэл<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <?php
              	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 1))
				{
				?>
              <li><a href="<?php echo $my_url."?menuitem=10"; ?>"> <?php echo getdata($GROUP_ITEM_TYPE, 1); ?></a></li>
              <?php
              	}
				?>
              <?php
              	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1))
				{
				?>
              <li><a href="<?php echo $my_url."?menuitem=20"; ?>"> <?php echo getdata($GROUP_ITEM_TYPE, 2); ?></a></li>
              <?php
              	}
				?>
              <?php
              	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 1))
				{
				?>
              <li><a href="<?php echo $my_url."?menuitem=30"; ?>"> <?php echo getdata($GROUP_ITEM_TYPE, 3); ?></a></li>
              <?php
              	}
				?>
              <?php
              	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 4, 1))
				{
				?>
              <li><a href="<?php echo $my_url."?menuitem=31"; ?>"> <?php echo getdata($GROUP_ITEM_TYPE, 4); ?></a></li>
              <?php
              	}
				?>
              <?php
              	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 1))
				{
				?>
              <li><a href="<?php echo $my_url."?menuitem=40"; ?>"> <?php echo getdata($GROUP_ITEM_TYPE, 5); ?></a></li>
              <?php
              	}
				?>
              <?php
              	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 1))
				{
				?>
              <li><a href="<?php echo $my_url."?menuitem=50"; ?>"> <?php echo getdata($GROUP_ITEM_TYPE, 6); ?></a></li>
              <?php
              	}
				?>
              <?php
              	//if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 1))
				//{
				?>
              <!-- <li><a href="<?php //echo $my_url."?menuitem=60"; ?>"> <?php //echo getdata($GROUP_ITEM_TYPE, 7); ?></a></li> -->
              <?php
              	//}
				?>
              <?php
              	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 1))
				{
				?>
              <li><a href="<?php echo $my_url."?menuitem=70"; ?>"> <?php echo getdata($GROUP_ITEM_TYPE, 8); ?></a></li>
              <?php
              	}
				?>
              <?php
              	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 1))
				{
				?>
              <li><a href="<?php echo $my_url."?menuitem=80"; ?>"> <?php echo getdata($GROUP_ITEM_TYPE, 9); ?></a></li>
              <?php
              	}
				?>
              <?php
              	//if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 10, 1))
				//{
				?>
              <!-- <li><a href="<?php //echo $my_url."?menuitem=100"; ?>"> <?php //echo getdata($GROUP_ITEM_TYPE, 10); ?></a></li> -->
              <?php
              	//}
				?>
              <?php
              	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 1))
				{
				?>
              <li><a href="<?php echo $my_url."?menuitem=110"; ?>"> <?php echo getdata($GROUP_ITEM_TYPE, 11); ?></a></li>
              <?php
              	}
				?>
              <?php
              	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 1))
				{
				?>
              <li><a href="<?php echo $my_url."?menuitem=122"; ?>"> <?php echo getdata($GROUP_ITEM_TYPE, 12); ?></a></li>
              <?php
              	}
				?>
            </ul>
          </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Хэрэглэгч <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo $my_url."?menuitem=3"; ?>">Хэрэглэгчийн мэдээлэл</a></li>
              <?php 
				if($sess_profile==1) 
				{
				?>
              <li class="divider"></li>
              <li><a href="<?php echo $my_url."?menuitem=2"; ?>">Бүлгийн мэдээлэл</a></li>
              <li><a href="<?php echo $my_url."?menuitem=7"; ?>">Бүлгийн эрх, үүрэг</a></li>
              <li><a href="<?php echo $my_url."?menuitem=5"; ?>">Бүлгийн хэрэглэгч</a></li>
              <?php 
				} 
				?>
            </ul>
          </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Лавлах мэдээлэл<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo $my_url."?menuitem=27"; ?>"><?php echo getdata($ITEM_TYPE, 16); ?></a></li>
              <li class="divider"></li>
              <li><a href="<?php echo $my_url."?menuitem=32"; ?>"><?php echo getdata($ITEM_TYPE, 22); ?></a></li>
              <li class="divider"></li>
              <li><a href="<?php echo $my_url."?menuitem=41"; ?>"><?php echo getdata($ITEM_TYPE, 32); ?></a></li>
              <li><a href="<?php echo $my_url."?menuitem=42"; ?>"><?php echo getdata($ITEM_TYPE, 33); ?></a></li>
              <li class="divider"></li>
              <li><a href="<?php echo $my_url."?menuitem=62"; ?>"><?php echo getdata($ITEM_TYPE, 44); ?></a></li>
              <li><a href="<?php echo $my_url."?menuitem=63"; ?>"><?php echo getdata($ITEM_TYPE, 43); ?></a></li>
              <li class="divider"></li>
              <li><a href="<?php echo $my_url."?menuitem=81"; ?>"><?php echo getdata($ITEM_TYPE, 53); ?></a></li>
              <li><a href="<?php echo $my_url."?menuitem=82"; ?>"><?php echo getdata($ITEM_TYPE, 52); ?></a></li>
			  <li class="divider"></li>
              <li><a href="<?php echo $my_url."?menuitem=121"; ?>"><?php echo getdata($ITEM_TYPE, 121); ?></a></li>
            </ul>
          </li>
          <li><a href="login.php?login=logout">Гарах</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
