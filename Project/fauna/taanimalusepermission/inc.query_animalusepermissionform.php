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
        <td class="span4"><strong>Зөвшөөрөл олгосон огноо:</strong></td>
        <td><?php echo $row[$i]["approved_date"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зөвшөөрөл дуусах огноо:</strong></td>
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
        <td class="span4"><strong>Ашиглах сумын нэр:</strong></td>
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
