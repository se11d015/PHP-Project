<?php
if (isset($_GET["status_id"]))
{
	$status_id = (int)$_GET["status_id"];
}else
{
	$status_id = 0;
}

$i = 0;

$selQuery = "SELECT tcrls.* FROM ".$schemas.".tcredliststatus tcrls WHERE tcrls.status_id  = ".$status_id;
$row = $db->query($selQuery);
			
if (!empty($row))
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 22); ?> дэлгэрэнгүй мэдээлэл</th>
      </tr>
    </thead>
    <tbody>
     
      <tr>
        <td class="span4"><strong>Ангиллын код:</strong></td>
        <td><?php echo $row[$i]["status_code"]; ?></td>
      </tr>
	   <tr>
        <td class="span4"><strong>Ангиллын монгол нэр:</strong></td>
        <td><?php echo $row[$i]["name_mn"]; ?></td>
      </tr>
	   <tr>
        <td class="span4"><strong>Ангиллын англи нэр:</strong></td>
        <td><?php echo $row[$i]["name_en"]; ?></td>
      </tr>
	   <tr>
        <td class="span4"><strong>Ангиллын монгол тайлбар:</strong></td>
        <td><?php echo $row[$i]["desc_mn"]; ?></td>
      </tr>
	   <tr>
        <td class="span4"><strong>Ангиллын англи тайлбар:</strong></td>
        <td><?php echo $row[$i]["desc_en"]; ?></td>
      </tr>
    </tbody>
  </table>
</div><div>
          <a class="btn btn-danger" href="<?php echo $my_url.$my_page."&action=edit&status_id=".$row[$i]["status_id"]; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp; 
          <a class="btn btn-danger" href="<?php echo $my_url.$my_page; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a>
    
</div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
