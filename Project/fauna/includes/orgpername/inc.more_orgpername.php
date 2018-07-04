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
$valueQuery = "tgo.* FROM ".$schemas.".tgorgpername tgo,".$schemas.".taorgpermission tao";
$whereQuery = "WHERE tgo.gid = tao.org_id AND tgo.sector_status = 3 AND tao.permission_id = ".$permission_id;
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db1->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
<table class="table table-bordered table-striped table-hover">
  <thead>
    <tr>
      <th colspan="2">Дэлгэрэнгүй мэдээлэл</th>
    </tr>
  </thead>
</table>
<div class="accordion" id="accordion">
  <?php
	$i = 0;

$startQuery = "SELECT";
$valueQuery = "tgo.* FROM ".$schemas.".tgorgpername tgo,".$schemas.".taorgpermission tao";
$whereQuery = "WHERE tgo.gid = tao.org_id AND tgo.sector_status = 3 AND tao.permission_id = ".$permission_id;
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db1->query($selQuery);

	if (!empty($row)) 
	{
	?>
  <div class="accordion-group">
    <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="icon-folder-open"></i>&nbsp;Мэргэжлийн байгууллагын мэдээлэл</a></div>
    <div id="collapse2" class="accordion-body collapse">
      <div class="accordion-inner">
       <table class="table table-bordered table-hover">
			<thead>
			  <tr>
				<th colspan="2">Мэргэжлийн байгууллагын мэдээлэл дэлгэрэнгүй харах хэсэг</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<th style="width: 30%">Мэргэжлийн байгууллагын нэр:</th>
				<td><?php echo $row[$i]["org_name"]; ?></td>
			  </tr>
			 
			  <?php  if(!empty($row[$i]["soum_name"])){ ?>
			  <tr>
				<th>Аймаг, хотын нэр:</th>
				<td><?php 
					$values = $db1->query("SELECT vs.soum_name_mn, vs.soum_name_en FROM scadministrative.vasoumname vs WHERE vs.soum_code = ".$row[$i]["soum_name"]."");
					echo $values[0]["soum_name_$language_name"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["register_num"])){ ?>
			  <tr>
				<th>Регистрийн дугаар:</th>
				<td><?php echo $row[$i]["register_num"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["found_date"])){ ?>
			  <tr>
				<th>Байгуулагдсан огноо:</th>
				<td><?php echo $row[$i]["found_date"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["suborgname_list"])){ ?>
			  <tr>
				<th>Харьяа дээд байгууллагын нэр:</th>
				<td><?php echo $row[$i]["suborgname_list"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["main_activity"])){ ?>
			  <tr>
				<th>Үйл ажиллагааны үндсэн чиглэл>:</th>
				<td><?php echo $row[$i]["main_activity"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["main_structure"])){ ?>
			  <tr>
				<th>Байгууллагын бүтэц зохион байгуулалт:</th>
				<td><?php echo $row[$i]["main_structure"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["leader_name"])){ ?>
			  <tr>
				<th>Удирдлагын нэр:</th>
				<td><?php echo $row[$i]["leader_name"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["tel_number"])){ ?>
			  <tr>
				<th>Утасны дугаар:</th>
				<td><?php echo $row[$i]["tel_number"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["fax_number"])){ ?>
			  <tr>
				<th>Факсын дугаар:</th>
				<td><?php echo $row[$i]["fax_number"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["email_address"])){ ?>
			  <tr>
				<th>И-мэйл:</th>
				<td><?php echo $row[$i]["email_address"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["web_address"])){ ?>
			  <tr>
				<th>Вэб хаяг:</th>
				<td><?php echo $row[$i]["web_address"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["postal_address"])){ ?>
			  <tr>
				<th>Шуудангийн хаяг:</th>
				<td><?php echo $row[$i]["postal_address"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["location_address"])){ ?>
			  <tr>
				<th>Байршлын хаяг:</th>
				<td><?php echo $row[$i]["location_address"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row[$i]["extract_date"])){ ?>
			  <tr>
				<th>Татан буугдсан огноо:</th>
				<td><?php echo $row[$i]["extract_date"]; ?></td>
			  </tr>
			  <?php } ?>
			</tbody>
		  </table>
      </div>
    </div>
  </div>
  <?php
	}

        $startQuery1 = "SELECT";
		$valueQuery1 = "tao.*, tgo.org_name tgo_org_name FROM ".$schemas.".tgorgpername tgo,".$schemas.".taorgpermission tao";
		$whereQuery1 = "WHERE tgo.gid = tao.org_id AND tao.permission_id = ".$permission_id;

        $selQuery1 = $startQuery1." ".$valueQuery1." ".$whereQuery1;
        $row1 = $db1->query($selQuery1);
        
        if (!empty($row1)) 
        {
		?>
  <div class="accordion-group">
    <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="icon-folder-open"></i>&nbsp;Мэргэжлийн байгууллагын эрхийн бүртгэл</a></div>
    <div id="collapse3" class="accordion-body collapse in">
      <div class="accordion-inner">
         <table class="table table-bordered table-hover">
			<thead>
			  <tr>
				<th colspan="2">Мэргэжлийн байгууллагын эрхийн бүртгэл дэлгэрэнгүй харах хэсэг</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<th style="width: 30%">Мэргэжлийн байгууллагын нэр:</th>
				<td><?php echo $row1[$i]["tgo_org_name"]; ?></td>
			  </tr>
			  <tr>
				<th>Эрхийн дугаар:</th>
				<td><?php echo $row1[$i]["permission_number"]; ?></td>
			  </tr>
			  <tr>
				<th>Эрх авсан чиглэл:</th>
				<td><?php 
					$permission_type = "";
					$fldCode = explode(', ', $row1[$i]["permission_type"]);

					if(is_array($fldCode)){
						for($j=0; $j<sizeof($fldCode); $j++){
							if(!empty($fldCode[$j])){
								$values = $db1->query("SELECT tcp.permissiontype_name FROM ".$schemas.".tcpermissiontype tcp WHERE tcp.permissiontype_id = ".$fldCode[$j]."");	
								$permission_type .= (empty($values[0]) ? " ": $values[0]["permissiontype_name"].", ");
							}
						}
					}		
					echo $permission_type; 
					?></td>
			  </tr>
			  <tr>
				<th>Эрх олгосон байгууллагын нэр:</th>
				<td><?php echo $row1[$i]["approved_org"]; ?></td>
			  </tr>
			  <tr>
				<th>Эрх олгосон огноо:</th>
				<td><?php echo $row1[$i]["approved_date"]; ?></td>
			  </tr>
			  <tr>
				<th>Эрх олгосон шийдвэрийн нэр, дугаар:</th>
				<td><?php echo $row1[$i]["approved_statement"]; ?></td>
			  </tr>
			  <tr>
				<th>Эрх дуусах огноо:</th>
				<td><?php echo $row1[$i]["end_date"]; ?></td>
			  <tr>
			  <?php  if(!empty($row1[$i]["extended_org"])){ ?>
			  <tr>
				<th>Эрх сунгасан байгууллагын нэр:</th>
				<td><?php echo $row1[$i]["extended_org"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row1[$i]["extended_date"])){ ?>
			  <tr>
				<th>Эрх сунгасан огноо:</th>
				<td><?php echo $row1[$i]["extended_date"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row1[$i]["extended_statement"])){ ?>
			  <tr>
				<th>Эрх сунгасан шийдвэрийн нэр, дугаар:</th>
				<td><?php echo $row1[$i]["extended_statement"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row1[$i]["canceled_org"])){ ?>
			  <tr>
				<th>Эрх хүчингүй болгосон байгууллагын нэр:</th>
				<td><?php echo $row1[$i]["canceled_org"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row1[$i]["canceled_date"])){ ?>
			  <tr>
				<th>Эрх хүчингүй болгосон огноо:</th>
				<td><?php echo $row1[$i]["canceled_date"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row1[$i]["canceled_statement"])){ ?>
			  <tr>
				<th>Эрх хүчингүй болгосон шийдвэрийн нэр, дугаар:</th>
				<td><?php echo $row1[$i]["canceled_statement"]; ?></td>
			  </tr>
			  <?php } ?>
			  <?php  if(!empty($row1[$i]["additional_info"])){ ?>
			  <tr>
				<th>Нэмэлт мэдээлэл:</th>
				<td><?php echo $row1[$i]["additional_info"]; ?></td>
			  </tr>
			  <?php } ?>
			</tbody>
		  </table>
      </div>
    </div>
  </div>
  <?php
	} else {
			$notify = "Мэргэжлийн байгууллагын эрхийн бүртгэлийн мэдээлэл байхгүй байна.";
			show_notification("warning", "", $notify);
		}
?>
</div>
<a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a>
</div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
