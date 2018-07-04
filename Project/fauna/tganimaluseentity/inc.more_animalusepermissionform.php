<?php
if (isset($_GET["permission_id"]))
{
	$permission_id = (int)$_GET["permission_id"];
} else {
	$permission_id = 0;
}

	
$i = 0;

$startQuery = "SELECT";
$valueQuery = "tgcpe.*, tgcen.entity_name as entity,  taaim.aimag_name_mn, tasou.soum_name_mn FROM ".$schemas.".taanimalusepermission tgcpe, ".$schemas.".tganimaluseentity tgcen, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou";
$whereQuery = "WHERE tgcpe.entity_name = tgcen.entity_id AND taaim.aimag_code=tgcpe.aimag_name  AND tasou.soum_code=tgcpe.soum_name AND tgcpe.permission_id =".$permission_id;

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
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 71); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="span4"><strong>Нөөц ашиглагчийн нэр:</strong></td>
        <td><?php echo $row[$i]["entity"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зөвшөөрлийн төрөл :</strong></td>
        <td><?php echo getdata($USE_PERMISSION_TYPE, $row[$i]["permission_type"]); ?></td>
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
        <td class="span4"><strong>Ашиглах зориулалт:</strong></td>
        <td><?php echo getdata($USE_PURPOSE_TYPE, $row[$i]["use_purpose"]); ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Ашиглах аймгийн нэр:</strong></td>
        <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Ашиглах сумын нэр :</strong></td>
        <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Ашиглах газрын нэр:</strong></td>
        <td><?php echo $row[$i]["place_name"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Ашиглах хугацаа:</strong></td>
        <td><?php echo $row[$i]["use_duration"]; ?></td>
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
    <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a> </div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url;"\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
