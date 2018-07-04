<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 60); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="span4"><strong>Аймаг, хотын нэр:</strong></td>
        <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Сум, дүүргийн нэр:</strong></td>
        <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Хуулийн этгээдийн төрөл:</strong></td>
        <td><?php echo getdata($CUSTOM_ENTITY_TYPE, $row[$i]["entity_type"]); ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Экспортлогч, импортлогчийн нэр:</strong></td>
        <td><?php echo $row[$i]["entity_name"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Экспортлогч, импортлогчийн регистрийн дугаар:</strong></td>
        <td><?php echo $row[$i]["register_number"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Байршлын хаяг:</strong></td>
        <td><?php echo $row[$i]["location_address"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Утасны дугаар:</strong></td>
        <td><?php echo $row[$i]["tel_number"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Факсын дугаар:</strong></td>
        <td><?php echo $row[$i]["fax_number"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Имэйл:</strong></td>
        <td><?php echo $row[$i]["email_address"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Вэб хаяг:</strong></td>
        <td><?php echo $row[$i]["web_address"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Шуудангийн хаяг:</strong></td>
        <td><?php echo $row[$i]["postal_address"]; ?></td>
      </tr>
      <?php if (!empty($row[$i]["geom"])) { ?>
      <tr>
        <td><strong>Газарзүйн солбицол:</strong></td>
        <td><?php
			echo "| <a  href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=2&entity_id=".$row[$i]["entity_id"]."\">Координатаар харах</a> ";
			echo "| <a href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=3&entity_id=".$row[$i]["entity_id"]."\">Google KML-аар харах</a> |";
			?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>