<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th colspan="2"><?php echo getdata($ITEM_TYPE, 30); ?> дэлгэрэнгүй харах</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="span5"><strong>Судалгааны зөвшөөрөл баталсан байгууллагын нэр:</strong></td>
      <td><?php echo $row[$i]["approved_org"]; ?></td>
    </tr>
    <tr>
      <td><strong>Судалгааны зөвшөөрөл баталсан огноо:</strong></td>
      <td><?php echo $row[$i]["approved_date"];?></td>
    </tr>
    <tr>
      <td><strong>Судалгааны зөвшөөрөл баталсан шийдвэрийн нэр, дугаар:</strong></td>
      <td><?php echo $row[$i]["approved_statement"]; ?></td>
    </tr>
    <tr>
      <td><strong>Захиалагч байгууллагын нэр:</strong></td>
      <td><?php echo $row[$i]["customer_name"]; ?></td>
    </tr>
    <tr>
      <td><strong>Судалгааны төрөл:</strong></td>
      <td><?php echo $row[$i]["type_name"];?></td>
    </tr>
    <tr>
      <td><strong>Судалгааны нэр:</strong></td>
      <td><?php echo $row[$i]["research_name"]; ?></td>
    </tr>
    <tr>
      <td><strong>Судалгаа хийсэн хугацаа:</strong></td>
      <td><?php echo $row[$i]["research_time"]; ?></td>
    </tr>
    <tr>
      <td><strong>Судалгаа хамрах нутаг дэвсгэр:</strong></td>
      <td><?php echo $row[$i]["place_name"]; ?></td>
    </tr>
    <tr>
      <td><strong>Судалгааны ажил гүйцэтгэгч байгууллагын нэр:</strong></td>
      <td><?php echo $row[$i]["executive_name"]; ?></td>
    </tr>
    <tr>
      <td><strong>Судалгаа хийсэн судлаачид:</strong></td>
      <td><?php echo $row[$i]["researcher_name"]; ?></td>
    </tr>
    <tr>
      <td><strong>Судалгааны ажлын зорилго:</strong></td>
      <td><?php echo $row[$i]["research_purpose"]; ?></td>
    </tr>
    <tr>
      <td><strong>Судалгааны ажлын тайлангийн хураангуй:</strong></td>
      <td><?php echo $row[$i]["research_abstract"]; ?></td>
    </tr>
    <tr>
      <td><strong>Судалгааны ажлын тайлан:</strong></td>
      <td><?php if(!empty($row[$i]["research_filename"])) { ?>
        <a href="<?php echo $row[$i]["research_pathname"]."/".$row[$i]["research_filename"]; ?>" target="_blank">Тайлан харах</a>
        <?php } ?></td>
    </tr>
  </tbody>
</table>
