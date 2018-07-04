<?php

if (isset($_GET["report_id"]))
{
	$report_id = (int)$_GET["report_id"];
}else
{
	$report_id = 0;
}
$i = 0;

$startQuery = "SELECT";
$valueQuery = "tapr.*, tct.type_name as type_name, tgpo.org_name as orgname FROM ".$schemas.".taanimalorgreport tapr, ".$schemas.".tganimalorg tgp, ".$schemas . ".tganimalorg tgpo, ".$schemas.".tcreporttype tct";
$whereQuery = "WHERE tapr.org_name = tgpo.org_id AND tapr.report_type = tct.type_id AND  tapr.report_id = ".$report_id;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);
	
if (!empty($row))
{
	
?>

<div class="more-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 42); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="span4"><strong>Мэргэжлийн байгууллагын нэр:</strong></td>
        <td><?php echo $row[$i]["orgname"]; ?></td>
      </tr>
      <tr>
        <td><strong>Тайлангийн төрөл:</strong></td>
        <td><?php echo $row[$i]["type_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Тайлангийн нэр:</strong></td>
        <td><?php echo $row[$i]["report_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Тайлан хамрах хугацаа:</strong></td>
        <td><?php echo $row[$i]["report_duration"];?></td>
      </tr>
      <tr>
        <td><strong>Тайлангийн хураангуй:</strong></td>
        <td><?php echo $row[$i]["report_summary"]; ?></td>
      </tr>
      <tr>
        <td><strong>Ажлын тайлангийн файл:</strong></td>
        <td><?php if(!empty($row[$i]["report_file"])) { ?>
          <a href="<?php echo $row[$i]["report_path"].$row[$i]["report_file"]; ?>" target="_blank">Файл татах</a>
          <?php } ?></td>
      </tr>
    </tbody>
  </table>
</div>
<div>
  <?php
	if($sess_profile==1)
	{
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&report_id=".$row[$i]["report_id"]; ?>" title="Засварлах"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a> &nbsp;
  <?php 
	} else if($row[$i]["user_id"]==$sess_user_id) {
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&report_id=".$row[$i]["report_id"]; ?>" title="Засварлах"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a> &nbsp;
  <?php
	}
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
