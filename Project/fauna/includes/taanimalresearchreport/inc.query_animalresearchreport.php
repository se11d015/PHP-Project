
<table class="table table-bordered table-striped table-hover">
  <thead>
    <tr>
      <th colspan="2"><?php echo getdata($ITEM_TYPE, 30); ?> дэлгэрэнгүй харах</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($row[$i]["approved_org"])) { ?>
    <tr>
      <td class="span4"><strong>Судалгааны зөвшөөрөл баталсан байгууллагын нэр:</strong></td>
      <td><?php echo $row[$i]["approved_org"]; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["approved_date"])) { ?>
    <tr>
      <td><strong>Судалгааны зөвшөөрөл баталсан огноо:</strong></td>
      <td><?php echo $row[$i]["approved_date"];?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["approved_statement"])) { ?>
    <tr>
      <td><strong>Судалгааны зөвшөөрөл баталсан шийдвэрийн нэр, дугаар:</strong></td>
      <td><?php echo $row[$i]["approved_statement"]; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["customer_name"])) { ?>
    <tr>
      <td class="span4"><strong>Захиалагч байгууллагын нэр:</strong></td>
      <td><?php echo $row[$i]["customer_name"]; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["type_name"])) { ?>
    <tr>
      <td class="span4"><strong>Судалгааны төрөл:</strong></td>
      <td><?php echo $row[$i]["type_name"];?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["research_name"])) { ?>
    <tr>
      <td class="span4"><strong>Судалгааны нэр:</strong></td>
      <td><?php echo $row[$i]["research_name"]; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["research_time"])) { ?>
    <tr>
      <td><strong>Судалгаа хийсэн хугацаа:</strong></td>
      <td><?php echo $row[$i]["research_time"]; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["place_name"])) { ?>
    <tr>
      <td><strong>Судалгаа хамрах нутаг дэвсгэр:</strong></td>
      <td><?php echo $row[$i]["place_name"]; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["executive_name"])) { ?>
    <tr>
      <td class="span4"><strong>Судалгааны ажил гүйцэтгэгч байгууллагын нэр:</strong></td>
      <td><?php echo $row[$i]["executive_name"]; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["researcher_name"])) { ?>
    <tr>
      <td><strong>Судалгаа хийсэн судлаачид:</strong></td>
      <td><?php echo $row[$i]["researcher_name"]; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["research_purpose"])) { ?>
    <tr>
      <td><strong>Судалгааны ажлын зорилго:</strong></td>
      <td><?php echo $row[$i]["research_purpose"]; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["research_abstract"])) { ?>
    <tr>
      <td><strong>Судалгааны ажлын тайлангийн хураангуй:</strong></td>
      <td><?php echo $row[$i]["research_abstract"]; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($row[$i]["research_filename"])) { ?>
    <tr>
      <td><strong>Судалгааны ажлын тайлан:</strong></td>
      <td><a href="<?php echo $row[$i]["research_pathname"]."/".$row[$i]["research_filename"]; ?>" target="_blank">Тайлан харах</a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
