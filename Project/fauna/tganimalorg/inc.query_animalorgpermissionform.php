
<tr>
  <td><?php echo $i+1; ?></td>
  <td><?php echo $row[$i]["permission_number"]; ?></td>
  <td><?php echo $row[$i]["approved_statement"]; ?></td>
  <td><?php echo $row[$i]["approved_date"];?></td>
  <td><?php echo $row[$i]["end_date"]; ?></td>
  <td><?php
			$activity_name = "";
			$fldCode = explode(', ', $row[$i]["activity_name"]);

			if(is_array($fldCode)){
				for($j=0; $j<sizeof($fldCode); $j++){
					if(!empty($fldCode[$j])){
						$values = $db->query("SELECT tct.type_name FROM ".$schemas.".tcactivitytype tct WHERE tct.type_id = ".$fldCode[$j]."");	
						$activity_name .= (empty($values[0]) ? " ": $values[0]["type_name"].", ");
					}
				}
			}		
			echo $activity_name; 
			?></td>
  <td><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=permissionmore&permission_id=".$row[$i]["permission_id"]; ?>" title="Дэлгэрэнгүй харах"><i class="icon-list"></i></a> <a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=permissionedit&permission_id=".$row[$i]["permission_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=permissiondelete&permission_id=".$row[$i]["permission_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i> </a></td>
</tr>
