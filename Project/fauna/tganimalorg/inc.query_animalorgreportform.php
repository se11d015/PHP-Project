
<tr>
  <td><?php echo $i+1; ?></td>
  <td><?php echo $row[$i]["type_name"]; ?></td>
  <td><?php echo $row[$i]["report_name"]; ?></td>
  <td><?php echo $row[$i]["report_duration"]; ?></td>
  <td><?php echo $row[$i]["report_summary"]; ?></td>
  <td><?php if(!empty($row[$i]["report_file"])) { ?> <a href="<?php echo $row[$i]["report_path"].$row[$i]["report_file"]; ?>" target="_blank">Файл татах</a><?php } ?></td>
  <td><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=reportedit&report_id=".$row[$i]["report_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=reportdelete&report_id=".$row[$i]["report_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a></td>
</tr>
