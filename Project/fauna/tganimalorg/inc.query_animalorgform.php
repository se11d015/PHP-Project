<table class="table table-bordered table-striped table-hover">
  <thead>
    <tr>
      <th colspan="2"><?php echo getdata($ITEM_TYPE, 40); ?> дэлгэрэнгүй харах</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="span5"><strong>Аймаг, хотын нэр:</strong></td>
      <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
    </tr>
    <tr>
      <td><strong>Сум, дүүргийн нэр:</strong></td>
      <td><?php echo $row[$i]["soum_name_mn"];?></td>
    </tr>
    <tr>
      <td><strong>Мэргэжлийн байгууллагын нэр:</strong></td>
      <td><?php echo $row[$i]["org_name"]; ?></td>
    </tr>
    <tr>
      <td><strong>Регистрийн дугаар:</strong></td>
      <td><?php echo $row[$i]["register_number"]; ?></td>
    </tr>
    <tr>
      <td><strong>Байршлын хаяг:</strong></td>
      <td><?php echo $row[$i]["location_address"];?></td>
    </tr>
    <tr>
      <td><strong>Утасны дугаар:</strong></td>
      <td><?php echo $row[$i]["tel_number"]; ?></td>
    </tr>
    <tr>
      <td><strong>Факсын дугаар:</strong></td>
      <td><?php echo $row[$i]["fax_number"]; ?></td>
    </tr>
    <tr>
      <td><strong>Имэйл:</strong></td>
      <td><?php echo $row[$i]["email_address"]; ?></td>
    </tr>
    <tr>
      <td><strong>Вэб хаяг:</strong></td>
      <td><?php echo $row[$i]["web_address"]; ?></td>
    </tr>
    <tr>
      <td><strong>Шуудангийн хаяг:</strong></td>
      <td><?php echo $row[$i]["postal_address"]; ?></td>
    </tr>
    <?php if (!empty($row[$i]["geom"])) { ?>
    <tr>
      <td><strong>Газарзүйн солбицол:</strong></td>
      <td><?php
    echo "| <a  href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=2&org_id=".$row[$i]["org_id"]."\">Координатаар харах</a> ";
    echo "| <a href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=3&org_id=".$row[$i]["org_id"]."\">Google KML-аар харах</a> |";
    ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
