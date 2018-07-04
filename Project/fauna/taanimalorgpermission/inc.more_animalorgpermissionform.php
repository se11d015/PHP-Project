<?php

if (isset($_GET["permission_id"]))
{
	$permission_id = (int)$_GET["permission_id"];
}else
{
	$permission_id = 0;
}
$i = 0;

$startQuery = "SELECT";
$valueQuery = "tapp.*, tgpo.org_name as orgname FROM ".$schemas.".taanimalorgpermission tapp, ".$schemas.".tganimalorg tgpo";
$whereQuery = "WHERE tapp.org_name = tgpo.org_id AND tapp.permission_id = ".$permission_id;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);
	
if (!empty($row))
{
	
?>

<div class="more-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 41); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="span4"><strong>Мэргэжлийн байгууллагын нэр :</strong></td>
        <td><?php echo $row[$i]["orgname"]; ?></td>
      </tr>
      <tr>
        <td><strong>Эрхийн гэрчилгээний дугаар:</strong></td>
        <td><?php echo $row[$i]["permission_number"]; ?></td>
      </tr>
      <tr>
        <td><strong>Эрх олгосон байгууллагын нэр :</strong></td>
        <td><?php echo $row[$i]["approved_org"]; ?></td>
      </tr>
      <tr>
        <td><strong>Эрх авсан чиглэл:</strong></td>
        <td><?php
			$activity_name = "";
			$fldCode = explode(', ', $row[$i]["activity_name"]);

			if(is_array($fldCode)){
				for($j=0; $j<sizeof($fldCode); $j++){
					if(!empty($fldCode[$j])){
						$values = $db->query("SELECT tct.type_name FROM ".$schemas.".tcactivitytype tct WHERE tct.type_id = ".$fldCode[$j]."");	
						$activity_name .= (empty($values[0]) ? " ": $values[0]["type_name"].", ");
					}
				}
			}		
			echo $activity_name; 
			?>
        </td>
      </tr>
      <tr>
        <td><strong>Эрх олгосон огноо:</strong></td>
        <td><?php echo $row[$i]["approved_date"];?></td>
      </tr>
      <tr>
        <td><strong>Эрх олгосон шийдвэрийн нэр, дугаар:</strong></td>
        <td><?php echo $row[$i]["approved_statement"]; ?></td>
      </tr>
      <tr>
        <td><strong>Эрх хүчингүй болгосон байгууллагын нэр :</strong></td>
        <td><?php echo $row[$i]["canceled_org"]; ?></td>
      </tr>
      <tr>
        <td><strong>Эрх хүчингүй болгосон огноо:</strong></td>
        <td><?php echo $row[$i]["canceled_date"]; ?></td>
      </tr>
      <tr>
        <td><strong>Эрх хүчингүй болгосон шийдвэрийн нэр, дугаар :</strong></td>
        <td><?php echo $row[$i]["canceled_statement"]; ?></td>
      </tr>
      <tr>
        <td><strong>Эрх сунгасан байгууллагын нэр:</strong></td>
        <td><?php echo $row[$i]["extended_org"]; ?></td>
      </tr>
      <tr>
        <td><strong>Эрх сунгасан огноо:</strong></td>
        <td><?php echo $row[$i]["extended_date"]; ?></td>
      </tr>
      <tr>
        <td><strong>Эрх олгосон шийдвэрийн нэр, дугаар:</strong></td>
        <td><?php echo $row[$i]["extended_statement"]; ?></td>
      </tr>
      <tr>
        <td><strong>Эрх дуусах огноо:</strong></td>
        <td><?php echo $row[$i]["end_date"]; ?></td>
      </tr>
      <tr>
        <td><strong>Нэмэлт мэдээлэл:</strong></td>
        <td><?php echo $row[$i]["additional_info"]; ?></td>
      </tr>
    </tbody>
  </table>
</div>
<div>
  <?php
	if($sess_profile==1)
	{
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&permission_id=".$row[$i]["permission_id"]; ?>" title="Засварлах"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a> &nbsp;
  <?php 
	} else if($row[$i]["user_id"]==$sess_user_id) {
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&permission_id=".$row[$i]["permission_id"]; ?>" title="Засварлах"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a> &nbsp;
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
