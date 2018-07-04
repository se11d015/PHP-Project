<?php
if (isset($_GET["basic_id"]))
{
	$basic_id = (int)$_GET["basic_id"];
}else
{
	$basic_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "tapi.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl," . $schemas . ".taanimalinfo tapi ";
$whereQuery = "WHERE tapi.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND  tapi.basic_id = ".$basic_id;
	
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 10); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="2"><?php if (!empty($row[$i]["fauna_filename1"])) { ?>
          <div class="span2">
            <div class="thumbnail"><a href="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename1"]; ?>" class="thumbnail" target="_blank" data-toggle="tooltip" data-placement="bottom" ><img src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename1"]; ?>" /> </a>
              <p align="center">Амьтны зураг 1</p>
            </div>
          </div>
          <?php } ?>
          <?php if (!empty($row[$i]["fauna_filename2"])) { ?>
          <div class="span2">
            <div class="thumbnail"><a href="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename2"]; ?>" class="thumbnail" target="_blank" data-toggle="tooltip" data-placement="bottom" ><img src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename2"]; ?>" /> </a>
              <p align="center">Амьтны зураг 2</p>
            </div>
          </div>
          <?php } ?>
          <?php if (!empty($row[$i]["fauna_filename3"])) { ?>
          <div class="span2">
            <div class="thumbnail"><a href="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename3"]; ?>" class="thumbnail" target="_blank" data-toggle="tooltip" data-placement="bottom" ><img src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename3"]; ?>" /> </a>
              <p align="center">Амьтны зураг 3</p>
            </div>
          </div>
          <?php } ?>
          <?php if (!empty($row[$i]["dist_filename"])) { ?>
          <div class="span2">
            <div class="thumbnail"><a href="<?php echo $row[$i]["picture_pathname"].$row[$i]["dist_filename"]; ?>" class="thumbnail" target="_blank" data-toggle="tooltip" data-placement="bottom" ><img src="<?php echo $row[$i]["picture_pathname"].$row[$i]["dist_filename"]; ?>" /> </a>
              <p align="center">Тархалтын зураг</p>
            </div>
          </div>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Аймгийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["kingdom_name"])) echo $row[$i]["kingdom_name"]; 
			if(!empty($row[$i]["kingdom_name_mn"])) echo " - ".$row[$i]["kingdom_name_mn"]; 
			if(!empty($row[$i]["kingdom_name_en"])) echo " - ".$row[$i]["kingdom_name_en"]; 
			if(!empty($row[$i]["kingdom_name_ru"])) echo " - ".$row[$i]["kingdom_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Хүрээний нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["phylum_name"])) echo $row[$i]["phylum_name"]; 
			if(!empty($row[$i]["phylum_name_mn"])) echo " - ".$row[$i]["phylum_name_mn"]; 
			if(!empty($row[$i]["phylum_name_en"])) echo " - ".$row[$i]["phylum_name_en"]; 
			if(!empty($row[$i]["phylum_name_ru"])) echo " - ".$row[$i]["phylum_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Ангийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["class_name"])) echo $row[$i]["class_name"]; 
			if(!empty($row[$i]["class_name_mn"])) echo " - ".$row[$i]["class_name_mn"]; 
			if(!empty($row[$i]["class_name_en"])) echo " - ".$row[$i]["class_name_en"]; 
			if(!empty($row[$i]["class_name_ru"])) echo " - ".$row[$i]["class_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Багийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["order_name"])) echo $row[$i]["order_name"]; 
			if(!empty($row[$i]["order_name_mn"])) echo " - ".$row[$i]["order_name_mn"]; 
			if(!empty($row[$i]["order_name_en"])) echo " - ".$row[$i]["order_name_en"]; 
			if(!empty($row[$i]["order_name_ru"])) echo " - ".$row[$i]["order_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Овгийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["family_name"])) echo $row[$i]["family_name"]; 
			if(!empty($row[$i]["family_name_mn"])) echo " - ".$row[$i]["family_name_mn"]; 
			if(!empty($row[$i]["family_name_en"])) echo " - ".$row[$i]["family_name_en"]; 
			if(!empty($row[$i]["family_name_ru"])) echo " - ".$row[$i]["family_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Төрлийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["genus_name"])) echo $row[$i]["genus_name"]; 
			if(!empty($row[$i]["genus_name_mn"])) echo " - ".$row[$i]["genus_name_mn"]; 
			if(!empty($row[$i]["genus_name_en"])) echo " - ".$row[$i]["genus_name_en"]; 
			if(!empty($row[$i]["genus_name_ru"])) echo " - ".$row[$i]["genus_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Зүйлийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["species_name"])) echo $row[$i]["species_name"]; 
			if(!empty($row[$i]["species_name_mn"])) echo " - ".$row[$i]["species_name_mn"]; 
			if(!empty($row[$i]["species_name_en"])) echo " - ".$row[$i]["species_name_en"]; 
			if(!empty($row[$i]["species_name_ru"])) echo " - ".$row[$i]["species_name_ru"];
			?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Таних шинж, монголоор:</strong></td>
        <td><?php echo $row[$i]["description_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Таних шинж, англиар:</strong></td>
        <td><?php echo $row[$i]["description_en"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Тархац, монголоор:</strong></td>
        <td><?php echo $row[$i]["distribution_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Тархац, англиар:</strong></td>
        <td><?php echo $row[$i]["distribution_en"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Амьдрах орчин, монголоор:</strong></td>
        <td><?php echo $row[$i]["habitat_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Амьдрах орчин, англиар:</strong></td>
        <td><?php echo $row[$i]["habitat_en"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Ач холбогдол, монголоор:</strong></td>
        <td><?php echo $row[$i]["benefit_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Ач холбогдол, англиар:</strong></td>
        <td><?php echo $row[$i]["benefit_en"]; ?></td>
      </tr>
    </tbody>
  </table>
</div>
<div>
  <?php
	if($sess_profile==1)
	{
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&basic_id=".$row[$i]["basic_id"]; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp;
  <?php 
	} else if($row[$i]["user_id"]==$sess_user_id) {
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&basic_id=".$row[$i]["basic_id"]; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp;
  <?php
	}
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a> </div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
