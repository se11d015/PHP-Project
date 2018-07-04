
<tr>
  <td><?php echo $row[$i]["budget_type_name"]; ?></td>
  <td><?php echo $row[$i]["budget_amount"]; ?></td>
  <td><a href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=budgetedit&budget_id=".$row[$i]["budget_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url.$search_url.$sort_url."&action=budgetdelete&budget_id=".$row[$i]["budget_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a></td>
</tr>
