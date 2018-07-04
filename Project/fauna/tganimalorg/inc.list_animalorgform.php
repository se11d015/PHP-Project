<?php
if (isset($_POST["searchanimalorgbttn"])) {
    $searchQuery = "";
    $search_url = "";

    $org_name = (isset($_POST["org_name"])) ? $_POST["org_name"] : "";
    $aimag_code = (isset($_POST["aimag_code"])) ? (int) $_POST["aimag_code"] : 0;

    if (empty($org_name)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tapr.org_name) LIKE lower('%" . $org_name . "%')";
        $search_url .= "&org_name=" . $org_name;
    }
	
    if ($aimag_code == 0) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND tapr.aimag_name = " . $aimag_code;
        $search_url .= "&aimag_name=" . $aimag_code;
    }
}

$sortQuery = " ORDER BY ";


if (isset($_GET["sort"])) {
    if ($_GET["sort"] == 1) {
        $sortQuery .= " vas.aimag_name_mn";
    } elseif ($_GET["sort"] == 2) {
        $sortQuery .= " vas.soum_name_mn";
    }  elseif ($_GET["sort"] == 3) {
        $sortQuery .= " tapr.org_name";
    } else {
        $sortQuery .= " tapr.org_id";
    }
} else {
    $sortQuery .= " tapr.org_id";
}

if (isset($_GET["sorttype"])) {
    if ($_GET["sorttype"] == 2) {
        $sorttype = 1;
        $sortQuery .= " ASC";
    } else {
        $sorttype = 2;
        $sortQuery .= " DESC";
    }
} else {
    $sorttype = 2;
    $sortQuery .= " DESC";
}

if (isset($_GET["sort"]) && isset($_GET["sorttype"])) {
    $sort_url = "";
    $sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
    $sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;

    if ($sort == 0)
        $sort_url .= "";
    else
        $sort_url .= "&sort=" . $sort;

    if ($sort_type == 0)
        $sort_url .= "";
    else
        $sort_url .= "&sorttype=" . $sort_type;
}


$startQuery = "SELECT";
$valueQuery = "COUNT(*) AS num_count FROM " . $schemas . ".tganimalorg tapr ";
$whereQuery = "WHERE tapr.org_id = tapr.org_id";

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery . " " . $searchQuery;
////echo $selQuery;
$rows = $db->query($selQuery);
$sum = 0;
if (sizeof($rows) > 0)
    $sum = $rows[0]["num_count"];

$count = 10;
$maxpage = ceil($sum / $count);


require("inc.search_animalorgform.php");

$notify = "<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="7"><span class="title"><?php echo getdata($ITEM_TYPE, 40); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th class="span1">№</th>
        <th class="span5"><a href="<?php echo $my_url . "&sort=1&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Аймаг, хотын нэр </a></th>
        <th class="span5"><a href="<?php echo $my_url . "&sort=2&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Сум, дүүргийн нэр </a></th>
        <th class="span4"><a href="<?php echo $my_url . "&sort=3&sorttype=" . $sorttype . $search_url; ?>" style="color:#FFFFFF"><i class="icon-tag icon-white"></i> Мэргэжлийн байгууллагын нэр</a></th>
        <th class="span3">Утасны дугаар</th>
        <th class="span4">Имэйл</th>
        <th class="span2">Үйлдэл</th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count . " OFFSET " . ($page - 1) * $count;
		$startQuery = "SELECT";
		$valueQuery = "tapr.*, vas.aimag_name_mn, vas.soum_name_mn  FROM " . $schemas . ".tganimalorg tapr , scadministrative.vasoumname vas ";
		$whereQuery = "WHERE tapr.soum_name = vas.soum_code AND tapr.org_id = tapr.org_id ";
		
		
		$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery . " " . $searchQuery . " " . $sortQuery . " LIMIT " . $limit;
		////echo $selQuery;
		
		$rows = $db->query($selQuery);
		
		for ($i = 0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page - 1) * $count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["aimag_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_mn"]; ?></td>
        <td><?php echo $rows[$i]["org_name"]; ?></td>
        <td><?php echo $rows[$i]["tel_number"]; ?></td>
        <td><?php echo $rows[$i]["email_address"]; ?></td>
        <td align="center"><a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=more&org_id=" . $rows[$i]["org_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>
          <?php
                if ($sess_profile == 1) 
				{
                    ?>
          <a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=edit&org_id=" . $rows[$i]["org_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url . $search_url . $sort_url . "&action=delete&org_id=" . $rows[$i]["org_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a> <a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=reportadd&org_id=" . $rows[$i]["org_id"]; ?>" title="Ажлын тайлан нэмэх"><i class="icon-plus-sign"></i></a> <a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=permissionadd&org_id=" . $rows[$i]["org_id"]; ?>" title="Эрхийн бүртгэл нэмэх"><i class="icon-plus"></i></a>
          <?php
                } else if ($rows[$i]["user_id"] == $sess_user_id) {
                    ?>
          <a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=edit&org_id=" . $rows[$i]["org_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url . $search_url . $sort_url . "&action=delete&org_id=" . $rows[$i]["org_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a> <a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=reportadd&org_id=" . $rows[$i]["org_id"]; ?>" title="Ажлын тайлан нэмэх"><i class="icon-plus-sign"></i></a> <a href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=permissionadd&org_id=" . $rows[$i]["org_id"]; ?>" title="Эрхийн бүртгэл нэмэх"><i class="icon-plus"></i></a>
          <?php
                }
                ?></td>
      </tr>
      <?php
            }

            if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2)) {
            ?>
      <tr>
        <td colspan="7"><a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a></td>
      </tr>
      <?php
			}
			?>
    </tbody>
  </table>
  <?php
	require("pagination/inc.pagination1.php");
	pagelink1($count, $maxpage, $my_url, $page, $search_url . $sort_url);
	?>
</div>
