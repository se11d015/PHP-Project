<?php
if (isset($_GET["permission_id"]))
{
	$permission_id = (int)$_GET["permission_id"];
} else {
	$permission_id = 0;
}

	
$i = 0;

$startQuery = "SELECT";
$valueQuery = "tgcpe.*, tgcen.entity_name as entity FROM ".$schemas.".taanimalcustompermission tgcpe, ".$schemas.".tganimalcustomentity tgcen";
$whereQuery = "WHERE tgcpe.entity_name = tgcen.entity_id AND tgcpe.permission_id =".$permission_id;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
//echo $selQuery;
$row = $db->query($selQuery);
$permission=0;

if (!empty($row)) 
{
	$userid  = $row[$i]["user_id"];
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 61); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="span4"><strong>Экспортлогч, импортлогчийн нэр:</strong></td>
        <td><?php echo $row[$i]["entity"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зөвшөөрлийн төрөл :</strong></td>
        <td><?php echo getdata($CUSTOM_PERMISSION_TYPE, $row[$i]["permission_type"]); ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зөвшөөрөл олгосон байгууллагын нэр:</strong></td>
        <td><?php echo $row[$i]["approved_org"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зөвшөөрөл олгосон шийдвэрийн нэр, дугаар:</strong></td>
        <td><?php echo $row[$i]["approved_statement"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зөвшөөрлийн дугаар:</strong></td>
        <td><?php echo $row[$i]["permission_number"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зөвшөөрөл олгосон огноо :</strong></td>
        <td><?php echo $row[$i]["approved_date"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зөвшөөрөл дуусах огноо :</strong></td>
        <td><?php echo $row[$i]["end_date"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Нэвтрүүлэх боомтын нэр:</strong></td>
        <td><?php echo $row[$i]["port_name"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Гадаад улсын нэр:</strong></td>
        <td><?php echo $row[$i]["importer_country"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Гадаад улсын экспортлогч, импортлогчийн нэр:</strong></td>
        <td><?php echo $row[$i]["importer_name"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Гарал үүслийн улсын нэр:</strong></td>
        <td><?php echo $row[$i]["origin_name"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Нэмэлт мэдээлэл:</strong></td>
        <td><?php echo $row[$i]["additional_info"]; ?></td>
      </tr>
  </table>
</div>
<div>
  <?php
	if($sess_profile==1)
	{
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=permissionedit&permission_id=".$row[$i]["permission_id"]; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>
  <?php 
	} else if($userid==$sess_user_id) {
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=permissionedit&permission_id=".$row[$i]["permission_id"]; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>
  <?php
	}
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&entity_id=".$row[$i]["entity_name"]; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a> </div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url;"\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
