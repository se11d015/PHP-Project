
<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 15); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($row[$i]["herbarium_type"])) { ?>
      <tr>
        <td class="span4"><strong>Цуглуулгын төрөл:</strong></td>
        <td><?php echo getdata($HERBARIUM_TYPE, $row[$i]["herbarium_type"]); ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["collected_date"])) { ?>
      <tr>
        <td class="span4"><strong>Цуглуулга хийсэн огноо:</strong></td>
        <td><?php echo $row[$i]["collected_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["herbarium_name"])) { ?>
      <tr>
        <td class="span4"><strong>Цуглуулгын нэр:</strong></td>
        <td><?php echo $row[$i]["herbarium_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["collecting_number"])) { ?>
      <tr>
        <td><strong>Цуглуулгын дугаар:</strong></td>
        <td><?php echo $row[$i]["collecting_number"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["aimag_name_mn"])) { ?>
      <tr>
        <td><strong>Аймаг, хотын нэр:</strong></td>
        <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["soum_name_mn"])) { ?>
      <tr>
        <td><strong>Сум, дүүргийн нэр:</strong></td>
        <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["place_name"])) { ?>
      <tr>
        <td><strong>Цуглуулга хийсэн газрын нэр:</strong></td>
        <td><?php echo $row[$i]["place_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["collector_name"])) { ?>
      <tr>
        <td><strong>Цуглуулга хийсэн судлаачийн нэр:</strong></td>
        <td><?php echo $row[$i]["collector_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["determiner_name"])) { ?>
      <tr>
        <td><strong>Цуглуулгыг тодорхойлсон судлаачийн нэр:</strong></td>
        <td><?php echo $row[$i]["determiner_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["herbarium_description"])) { ?>
      <tr>
        <td><strong>Цуглуулгын тайлбар:</strong></td>
        <td><?php echo $row[$i]["herbarium_description"]; ?></td>
      </tr>
      <?php } ?>
      <?php if (!empty($row[$i]["geom"])) {?>
      <tr>
        <td><strong>Газарзүйн солбицол:</strong></td>
        <td><?php
			echo "| <a  href=\"".$my_url.$my_page.$search_url.$sort_url."&action=outputanimalherbarium&outputtype=2&herbarium_id=".$row[$i]["herbarium_id"]."\">Координатаар харах</a> ";
			echo "| <a href=\"".$my_url.$my_page.$search_url.$sort_url."&action=outputanimalherbarium&outputtype=3&herbarium_id=".$row[$i]["herbarium_id"]."\">Google KML-аар харах</a> |";
		    ?>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
