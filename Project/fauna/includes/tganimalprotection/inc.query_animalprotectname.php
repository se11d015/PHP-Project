<tr>
  <td><?php 
		if(!empty($row[$i]["phylum_name"])) echo $row[$i]["phylum_name"]; 
		if(!empty($row[$i]["phylum_name_mn"])) echo " - ".$row[$i]["phylum_name_mn"]; 
		?></td>
  <td><?php 
		if(!empty($row[$i]["order_name"])) echo $row[$i]["order_name"]; 
		if(!empty($row[$i]["order_name_mn"])) echo " - ".$row[$i]["order_name_mn"];
		?></td>
  <td><?php 
		if(!empty($row[$i]["family_name"])) echo $row[$i]["family_name"]; 
		if(!empty($row[$i]["family_name_mn"])) echo " - ".$row[$i]["family_name_mn"]; 
		?></td>
  <td><?php 
		if(!empty($row[$i]["genus_name"])) echo $row[$i]["genus_name"]; 
		if(!empty($row[$i]["genus_name_mn"])) echo " - ".$row[$i]["genus_name_mn"]; 
		?></td>
  <td><?php 
		if(!empty($row[$i]["species_name"])) echo $row[$i]["species_name"]; 
		if(!empty($row[$i]["species_name_mn"])) echo " - ".$row[$i]["species_name_mn"]; 
		?></td>
</tr>
