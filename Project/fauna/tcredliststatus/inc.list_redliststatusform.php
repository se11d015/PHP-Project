<?php 
$selQuery = "SELECT tcrls.* FROM ".$schemas.".tcredliststatus tcrls";
$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 20;
$maxpage = ceil( $sum / $count);

$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"]: 1;
$my_page = "&page=".$page;

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<div class="list-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="9"><span class="title"><?php echo getdata($ITEM_TYPE, 22); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
		<th class="span1">№</th>
          <th class="span2">Ангиллын код</th>
          <th class="span2">Ангиллын монгол нэр</th>
          <th class="span2">Ангиллын англи нэр</th>
        <th class="span2">Үйлдэл</th>
      </tr>
    </thead>
    <tbody>
      <?php

				$limit = $count." OFFSET ".($page-1)*$count;
				$selQuery = "SELECT tcrls.* FROM ".$schemas.".tcredliststatus tcrls ORDER BY tcrls.status_id ASC LIMIT ".$limit;
				$rows = $db->query($selQuery);
				
		for ($i=0; $i < sizeof($rows); $i++) 
			{
			?>
      <tr>
       <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
          <td><?php echo $rows[$i]["status_code"]; ?></td>
          <td><?php echo $rows[$i]["name_mn"]; ?></td>
          <td><?php echo $rows[$i]["name_en"]; ?></td>
	<td align="center"><a href="<?php echo $my_url.$my_page."&action=more&status_id=".$rows[$i]["status_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a>
   
          <a href="<?php echo $my_url.$my_page."&action=edit&status_id=".$rows[$i]["status_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url."&action=delete&status_id=".$rows[$i]["status_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a>
        </td>
      </tr>
      <?php
			}
			
			?>
      <tr>
        <td colspan="9"><a class="btn btn-danger" href="<?php echo $my_url.$my_page."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a> </td>
      </tr>
    </tbody>
  </table>
<?php
		require("pagination/inc.pagination.php");
		pagelink($count, $maxpage, $my_url, $page);
		?>
</div>
