<?php

if (isset($_POST["searchuserbttn"]))
{
	$searchQuery = "";
	$search_url = "";

	$lastname = (isset($_POST["lastname"])) ? $_POST["lastname"]: "";	
	$group_id = (isset($_POST["group_id"])) ? (int) $_POST["group_id"]: 0;	
	$login_name = (isset($_POST["login_name"])) ? $_POST["login_name"]: "";	
	$profile = (isset($_POST["profile"])) ? (int) $_POST["profile"]: 0;	
					
	if(empty($lastname))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tu.lastname) LIKE lower('%".$lastname."%')";
		$search_url .= "&lastname=".$lastname;
	}

	if($group_id==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tug.group_id = ".$group_id;
		$search_url .= "&group_id=".$group_id;
		
		$valueQuery1 = ", ".$schemas.".tausergroups tug";
		$whereQuery1 = " AND tu.user_id = tug.user_id";		
	}
	
	if(empty($login_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tu.login_name) LIKE lower('%".$login_name."%')";
		$search_url .= "&login_name=".$login_name;
	}

	if($profile==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tu.profile = ".$profile;
		$search_url .= "&profile=".$profile;
	}	
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"]))
{
	if ($_GET["sort"]==2)
	{
		$sortQuery .= "tu.lastname ";
	}else if ($_GET["sort"]==3)
	{
		$sortQuery .= "tu.profile ";
	}else if ($_GET["sort"]==4)
	{
		$sortQuery .= "tu.organization ";
	}else
	{
		$sortQuery .= "tu.login_name ";
	}
}else
{
	$sortQuery .= "tu.user_id ";
}

if (isset($_GET["sorttype"]))
{
	if ($_GET["sorttype"]==2)
	{
		$sorttype = 1;
		$sortQuery .= "ASC";
	}else
	{
		$sorttype = 2;
		$sortQuery .= "DESC";
	}
}else
{
	$sorttype = 1;
	$sortQuery .= "DESC";
}

if(isset($_GET["sort"]) && isset($_GET["sorttype"]))
{
	$sort_url = "";
	$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"]: 0;
	$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"]: 0;

	if($sort==0)
		$sort_url .= "";
	else
		$sort_url .= "&sort=".$sort;
	
	if($sort_type==0)
		$sort_url .= "";
	else
		$sort_url .= "&sorttype=".$sort_type; 
}

$title_name = "Хэрэглэгч";
if (isset($_GET["checkusergroups"]))
{
	$searchQuery .= "AND tu.user_id NOT IN (SELECT tug1.user_id FROM ".$schemas.".tausergroups tug1)";
	$search_url .= "&checkusergroups=1";
	$title_name = "Бүлэгт хамрагдаагүй хэрэглэгч";	
}

$startQuery = "SELECT";
$valueQuery = "tu.* FROM ".$schemas.".tausers tu";
$whereQuery = " WHERE tu.user_id = tu.user_id";

if($sess_profile==1) 
	$whereQuery .= "";
else
	$whereQuery .= " AND tu.user_id = ".$sess_user_id;

$selQuery = $startQuery." ".$valueQuery." ".$valueQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery;

$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 10;
$maxpage = ceil( $sum / $count);

if($sess_profile==1) 
{ 
	if (isset($_GET["checkusergroups"]))
		$sname = "tausers/inc.search_userform.php";			
	else
		require("tausers/inc.search_userform.php");	
}

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>
<div class="list-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="9"><span class="title"><?php echo $title_name;?>ийн мэдээлэл</span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Нэвтрэх нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хэрэглэгчийн төрөл</a></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Хэрэглэгчийн нэр</a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Байгууллагын нэр</a></th>
        <th>Утас</th>
        <th>И-мэйл хаяг</th>
        <th>Статус</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
			$limit = $count." OFFSET ".($page-1)*$count;
		
			$startQuery = "SELECT";
			$valueQuery = "tu.* FROM ".$schemas.".tausers tu";
			$whereQuery = "WHERE tu.user_id = tu.user_id";
			
			if($sess_profile==1) 
				$whereQuery .= "";
			else
				$whereQuery .= " AND tu.user_id = ".$sess_user_id;
			
			$selQuery = $startQuery." ".$valueQuery." ".$valueQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
		
			$rows = $db->query($selQuery);
		
			for ($i=0; $i < sizeof($rows); $i++) 
			{
			?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["login_name"]; ?></td>
        <td><?php echo getdata($USER_PROFILE, $rows[$i]["profile"]); ?></td>
        <td><?php echo $rows[$i]["lastname"]; ?></td>
        <td><?php echo $rows[$i]["organization"]; ?></td>
        <td><?php echo $rows[$i]["phone"]; ?></td>
        <td><?php echo $rows[$i]["email"]; ?></td>
        <td><?php echo getdata($USER_ACTIVE, $rows[$i]["login_status"]); ?></td>
        <td align="center"><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&user_id=".$rows[$i]["user_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a>
          <?php 
					if($sess_profile==1)
					{ 
					?>
          <a href="<?php echo $my_url.$search_url.$sort_url."&action=delete&user_id=".$rows[$i]["user_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=usergroups&user_id=".$rows[$i]["user_id"]; ?>" title="Хэрэглэгчийн бүлэг" ><i class="icon-user"></i></a>
          <?php  
					} 
					?>
          <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=password&user_id=".$rows[$i]["user_id"]; ?>" title="Хэрэглэгчийн нууц үг" ><i class="icon-wrench"></i></a></td>
      </tr>
      <?php
			}
			
			if($sess_profile==1) 
			{ 
			?>
      <tr>
        <td colspan="9"><a class="btn btn-danger" href="<?php echo $my_url.$search_url.$sort_url."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a>
		<?php if (isset($_GET["checkusergroups"])) { ?> <a class="btn btn-danger" href="<?php echo $my_url; ?>"><i class="icon-home icon-white"></i>&nbsp;Бүх хэрэглэгч</a> <?php } ?>
		<?php if (!isset($_GET["checkusergroups"])) { ?> <a class="btn btn-danger" href="<?php echo $my_url."&checkusergroups=1"; ?>"><i class="icon-user icon-white"></i>&nbsp;Бүлэгт хамрагдаагүй хэрэглэгч</a> <?php } ?></td>
      </tr>
      <?php
			}	
			?>
    </tbody>
  </table>
  <?php
	require("pagination/inc.pagination1.php");
	pagelink1($count, $maxpage, $my_url, $page, $search_url.$sort_url);
	?>
</div>
