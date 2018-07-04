<div class="more-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 41); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($row[$i]["activity_name"])) { ?>
      <tr>
        <td class="span3"><strong>Эрх авсан чиглэл:</strong></td>
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
			?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["permission_number"])) { ?>
      <tr>
        <td><strong>Эрхийн гэрчилгээний дугаар:</strong></td>
        <td><?php echo $row[$i]["permission_number"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["approved_org"])) { ?>
      <tr>
        <td><strong>Эрх олгосон байгууллагын нэр :</strong></td>
        <td><?php echo $row[$i]["approved_org"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["approved_date"])) { ?>
      <tr>
        <td><strong>Эрх олгосон огноо:</strong></td>
        <td><?php echo $row[$i]["approved_date"];?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["approved_statement"])) { ?>
      <tr>
        <td><strong>Эрх олгосон шийдвэрийн нэр, дугаар:</strong></td>
        <td><?php echo $row[$i]["approved_statement"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["canceled_org"])) { ?>
      <tr>
        <td><strong>Эрх хүчингүй болгосон байгууллагын нэр :</strong></td>
        <td><?php echo $row[$i]["canceled_org"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["canceled_date"])) { ?>
      <tr>
        <td><strong>Эрх хүчингүй болгосон огноо:</strong></td>
        <td><?php echo $row[$i]["canceled_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["canceled_statement"])) { ?>
      <tr>
        <td><strong>Эрх хүчингүй болгосон шийдвэрийн нэр, дугаар :</strong></td>
        <td><?php echo $row[$i]["canceled_statement"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["extended_org"])) { ?>
      <tr>
        <td><strong>Эрх сунгасан байгууллагын нэр:</strong></td>
        <td><?php echo $row[$i]["extended_org"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["extended_date"])) { ?>
      <tr>
        <td><strong>Эрх сунгасан огноо:</strong></td>
        <td><?php echo $row[$i]["extended_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["extended_statement"])) { ?>
      <tr>
        <td><strong>Эрх олгосон шийдвэрийн нэр, дугаар:</strong></td>
        <td><?php echo $row[$i]["extended_statement"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["end_date"])) { ?>
      <tr>
        <td><strong>Эрх дуусах огноо:</strong></td>
        <td><?php echo $row[$i]["end_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["additional_info"])) { ?>
      <tr>
        <td><strong>Нэмэлт мэдээлэл:</strong></td>
        <td><?php echo $row[$i]["additional_info"]; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
