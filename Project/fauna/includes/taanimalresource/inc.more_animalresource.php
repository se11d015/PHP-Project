<?php
if (isset($_GET["resource_id"]))
{
	$resource_id = (int)$_GET["resource_id"];
}else
{
	$resource_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tapnr.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn, ".$schemas.".taanimalresource tapnr";
$whereQuery = "WHERE tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code AND tapnr.resource_id = ".$resource_id." AND tapnr.species_code = tapl.species_code";


$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 11); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
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
      <?php if(!empty($row[$i]["evaluated_date"])) { ?>
      <tr>
        <td class="span4"><strong>Судалгаа хийсэн огноо:</strong></td>
        <td><?php echo $row[$i]["evaluated_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["evaluated_org"])) { ?>
      <tr>
        <td class="span4"><strong>Судалгаа хийсэн байгууллагын нэр:</strong></td>
        <td><?php echo $row[$i]["evaluated_org"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["dist_place"])) { ?>
      <tr>
        <td class="span4"><strong>Тархсан газрын нэр:</strong></td>
        <td><?php echo $row[$i]["dist_place"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["dist_area"])) { ?>
      <tr>
        <td class="span4"><strong>Талбайн хэмжээ, га:</strong></td>
        <td><?php echo $row[$i]["dist_area"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["dist_density"])) { ?>
      <tr>
        <td class="span4"><strong>1км2 дах амьтны нягтшил:</strong></td>
        <td><?php echo $row[$i]["dist_density"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["total_head"])) { ?>
      <tr>
        <td class="span4"><strong>Амьтны тоо толгой:</strong></td>
        <td><?php echo $row[$i]["total_head"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["male_head"])) { ?>
      <tr>
        <td class="span4"><strong>Сүргийн бүтэц, Бие гүйцсэн эр:</strong></td>
        <td><?php echo $row[$i]["male_head"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["female_head"])) { ?>
      <tr>
        <td class="span4"><strong>Сүргийн бүтэц, Бие гүйцсэн эм:</strong></td>
        <td><?php echo $row[$i]["female_head"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["yearling_head"])) { ?>
      <tr>
        <td class="span4"><strong>Сүргийн бүтэц, Залуу:</strong></td>
        <td><?php echo $row[$i]["yearling_head"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["young_head"])) { ?>
      <tr>
        <td class="span4"><strong>Сүргийн бүтэц, Төл:</strong></td>
        <td><?php echo $row[$i]["young_head"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["head_density"])) { ?>
      <tr>
        <td class="span4"><strong>Сүргийн нөхөн төлжилт, хувиар:</strong></td>
        <td><?php echo $row[$i]["head_density"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["additional_info"])) { ?>
      <tr>
        <td class="span4"><strong>Нэмэлт мэдээлэл:</strong></td>
        <td><?php echo $row[$i]["additional_info"]; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<div> <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a> </div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$list_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
} 
?>
