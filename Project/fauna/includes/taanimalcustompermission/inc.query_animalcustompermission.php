<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 61); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($row[$i]["entity_name"])) { ?>
      <tr>
        <td class="span4"><strong>Экспортлогч, импортлогчийн нэр:</strong></td>
        <td><?php echo $row[$i]["entity_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["permission_type"])) { ?>
      <tr>
        <td class="span4"><strong>Зөвшөөрлийн төрөл :</strong></td>
        <td><?php echo getdata($CUSTOM_PERMISSION_TYPE, $row[$i]["permission_type"]); ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["approved_org"])) { ?>
      <tr>
        <td class="span4"><strong>Зөвшөөрөл олгосон байгууллагын нэр:</strong></td>
        <td><?php echo $row[$i]["approved_org"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["approved_statement"])) { ?>
      <tr>
        <td class="span4"><strong>Зөвшөөрөл олгосон шийдвэрийн нэр, дугаар:</strong></td>
        <td><?php echo $row[$i]["approved_statement"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["permission_number"])) { ?>
      <tr>
        <td class="span4"><strong>Зөвшөөрлийн дугаар:</strong></td>
        <td><?php echo $row[$i]["permission_number"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["approved_date"])) { ?>
      <tr>
        <td class="span4"><strong>Зөвшөөрөл олгосон огноо :</strong></td>
        <td><?php echo $row[$i]["approved_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["end_date"])) { ?>
      <tr>
        <td class="span4"><strong>Зөвшөөрөл дуусах огноо :</strong></td>
        <td><?php echo $row[$i]["end_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["port_name"])) { ?>
      <tr>
        <td class="span4"><strong>Нэвтрүүлэх боомтын нэр:</strong></td>
        <td><?php echo $row[$i]["port_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["importer_country"])) { ?>
      <tr>
        <td class="span4"><strong>Гадаад улсын нэр:</strong></td>
        <td><?php echo $row[$i]["importer_country"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["importer_name"])) { ?>
      <tr>
        <td class="span4"><strong>Гадаад улсын экспортлогч, импортлогчийн нэр:</strong></td>
        <td><?php echo $row[$i]["importer_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["origin_name"])) { ?>
      <tr>
        <td class="span4"><strong>Гарал үүслийн улсын нэр:</strong></td>
        <td><?php echo $row[$i]["origin_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["origin_name"])) { ?>
      <tr>
        <td class="span4"><strong>Нэмэлт мэдээлэл:</strong></td>
        <td><?php echo $row[$i]["origin_name"]; ?></td>
        <?php } ?>
      </tr>
  </table>
</div>
