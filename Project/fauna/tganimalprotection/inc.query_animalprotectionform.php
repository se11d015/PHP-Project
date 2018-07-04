<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th colspan="2"><?php echo getdata($ITEM_TYPE, 50); ?> дэлгэрэнгүй харах</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="span5"><strong>Хамгаалах арга хэмжээний төрөл:</strong></td>
      <td><?php echo $row[$i]["type_name"]; ?></td>
    </tr>
    <tr>
      <td><strong>Хамгаалах арга хэмжээний авсан огноо:</strong></td>
      <td><?php echo $row[$i]["protect_date"];?></td>
    </tr>
    <tr>
      <td><strong>Хамгаалах арга хэмжээ авсан байгууллагын нэр:</strong></td>
      <td><?php echo $row[$i]["protect_org"]; ?></td>
    </tr>
    <tr>
      <td><strong>Хамгаалах арга хэмжээ авсан байгууллагын регистрийн дугаар:</strong></td>
      <td><?php echo $row[$i]["register_number"]; ?></td>
    </tr>
    <tr>
      <td><strong>Мэргэжлийн эрхийн гэрчилгээний дугаар:</strong></td>
      <td><?php echo $row[$i]["certificate_number"];?></td>
    </tr>
    <tr>
      <td><strong>Аймгийн нэр:</strong></td>
      <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
    </tr>
    <tr>
      <td><strong>Сумын нэр:</strong></td>
      <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
    </tr>
    <tr>
      <td><strong>Хамгаалах арга хэмжээний авсан газрын нэр:</strong></td>
      <td><?php echo $row[$i]["place_name"]; ?></td>
    </tr>
    <tr>
      <td><strong>Хамгаалах арга хэмжээний авсан талбайн хэмжээ, га:</strong></td>
      <td><?php echo $row[$i]["protect_area"]; ?></td>
    </tr>
    <tr>
      <td><strong>Хамгаалах арга хэмжээний авсан ажлын хураангуй:</strong></td>
      <td><?php echo $row[$i]["protect_abstract"]; ?></td>
    </tr>
    <tr>
      <td><strong>Хамгаалах арга хэмжээний авсан ажлын тайлангийн файл:</strong></td>
      <td><?php if(!empty($row[$i]["protect_filename"])) { ?>
        <a href="<?php echo $row[$i]["protect_pathname"].$row[$i]["protect_filename"]; ?>" target="_blank">Тайлан харах</a>
        <?php } ?></td>
    </tr>
    <?php if (!empty($row[$i]["geom"])) { ?>
    <tr>
      <td><strong>Газарзүйн солбицол:</strong></td>
      <td><?php
    echo "| <a  href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=2&protect_id=".$row[$i]["protect_id"]."\">Координатаар харах</a> ";
    echo "| <a href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=3&protect_id=".$row[$i]["protect_id"]."\">Google KML-аар харах</a> |";
    ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
