
<tr>
  <td><?php echo $i+1; ?></td>
  <td><?php echo $row[$i]["type_name"]; ?></td>
  <td><?php echo $row[$i]["report_name"]; ?></td>
  <td><?php echo $row[$i]["report_duration"]; ?></td>
  <td><?php echo $row[$i]["report_summary"]; ?></td>
  <td><?php if(!empty($row[$i]["report_file"])) { ?> <a href="<?php echo $row[$i]["report_path"].$row[$i]["report_file"]; ?>" target="_blank">Файл татах</a><?php } ?></td>
</tr>
