<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th colspan="2"><?php echo getdata($ITEM_TYPE, 50); ?> дэлгэрэнгүй харах</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($row[$i]["type_name"])) { ?>
    <tr>
      <td class="span5"><strong>Хамгаалах арга хэмжээний төрөл:</strong></td>
      <td><?php echo $row[$i]["type_name"]; ?></td>
    </tr>
    <?php }?>
    <?php if(!empty($row[$i]["protect_date"])) { ?>
    <tr>
      <td><strong>Хамгаалах арга хэмжээний авсан огноо:</strong></td>
      <td><?php echo $row[$i]["protect_date"];?></td>
    </tr>
    <?php }?>
    <?php if(!empty($row[$i]["protect_org"])) { ?>
    <tr>
      <td><strong>Хамгаалах арга хэмжээ авсан байгууллагын нэр:</strong></td>
      <td><?php echo $row[$i]["protect_org"]; ?></td>
    </tr>
    <?php }?>
    <?php if(!empty($row[$i]["register_number"])) { ?>
    <tr>
      <td><strong>Хамгаалах арга хэмжээ авсан байгууллагын регистрийн дугаар:</strong></td>
      <td><?php echo $row[$i]["register_number"]; ?></td>
    </tr>
    <?php }?>
    <?php if(!empty($row[$i]["certificate_number"])) { ?>
    <tr>
      <td><strong>Мэргэжлийн эрхийн гэрчилгээний дугаар:</strong></td>
      <td><?php echo $row[$i]["certificate_number"];?></td>
    </tr>
    <?php }?>
    <?php if(!empty($row[$i]["aimag_name_mn"])) { ?>
    <tr>
      <td><strong>Аймгийн нэр:</strong></td>
      <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
    </tr>
    <?php }?>
    <?php if(!empty($row[$i]["soum_name_mn"])) { ?>
    <tr>
      <td><strong>Сумын нэр:</strong></td>
      <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
    </tr>
    <?php }?>
    <?php if(!empty($row[$i]["place_name"])) { ?>
    <tr>
      <td><strong>Хамгаалах арга хэмжээний авсан газрын нэр:</strong></td>
      <td><?php echo $row[$i]["place_name"]; ?></td>
    </tr>
    <?php }?>
    <?php if(!empty($row[$i]["protect_area"])) { ?>
    <tr>
      <td><strong>Хамгаалах арга хэмжээний авсан талбайн хэмжээ, га:</strong></td>
      <td><?php echo $row[$i]["protect_area"]; ?></td>
    </tr>
    <?php }?>
    <?php if(!empty($row[$i]["protect_abstract"])) { ?>
    <tr>
      <td><strong>Хамгаалах арга хэмжээний авсан ажлын хураангуй:</strong></td>
      <td><?php echo $row[$i]["protect_abstract"]; ?></td>
    </tr>
    <?php }?>
    <?php if(!empty($row[$i]["protect_pathname"])) { ?>
    <tr>
      <td><strong>Хамгаалах арга хэмжээний авсан ажлын тайлангийн файл:</strong></td>
      <td><?php if(!empty($row[$i]["protect_filename"])) { ?>
        <a href="<?php echo $row[$i]["protect_pathname"].$row[$i]["protect_filename"]; ?>" target="_blank">Тайлан харах</a>&nbsp;
        <?php } ?></td>
    </tr>
    <?php }?>
    <?php if (!empty($row[$i]["geom"])) { ?>
    <tr>
      <td><strong>Газарзүйн солбицол:</strong></td>
      <td><?php
    echo "| <a  href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=2&protect_id=".$row[$i]["protect_id"]."\">Координатаар харах</a> ";
    echo "| <a href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=3&protect_id=".$row[$i]["protect_id"]."\">Google KML-аар харах</a> |";
    ?></td>
    </tr>
    <?php }?>
  </tbody>
</table>
