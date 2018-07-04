<?php
if (isset($_GET["redbook_id"]))
{
	$redbook_id = (int)$_GET["redbook_id"];
}else
{
	$redbook_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tareb.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM  ".$schemas.".taredbook tareb,".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
$whereQuery = "WHERE tareb.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code AND tareb.redbook_id = ".$redbook_id;
	
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
//echo $selQuery;
$row = $db->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 21); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
  </table>
  <?php if (!empty($row[$i]["fauna_filename"]) || !empty($row[$i]["dist_filename"])) { ?>
  <div class="img-button"> <a href="#" data-toggle="lightbox" data-target="#lightbox1"> <img  class="thumbnail" src="<?php echo$row[$i]["picture_pathname"].$row[$i]["fauna_filename"];?>" width="200px" title="Амьтны зураг"/></a> </div>
  <!-- Modal -->
  <div class="lightbox hide fade" id="lightbox1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class='lightbox-content'>
      <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
      <img  src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename"];?>" /> </div>
  </div>
  <div class="img-button"> <a href="#" data-toggle="lightbox" data-target="#lightbox2"> <img  class="thumbnail" src="<?php echo $row[$i]["picture_pathname"].$row[$i]["dist_filename"];?>" width="200px" title="Тархалтын зураг"/></a> </div>
  <div class="lightbox hide fade" id="lightbox2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class='lightbox-content'>
      <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
      <img  src="<?php echo $row[$i]["picture_pathname"].$row[$i]["dist_filename"];?>" /> </div>
  </div>
  <?php } ?>
  <table class="table table-bordered table-striped table-hover">
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
      <?php if(!empty($row[$i]["approved_year"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан номонд орсон он:</strong></td>
        <td><?php echo $row[$i]["approved_year"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["species_status"])) { ?>
      <tr>
        <td class="span4"><strong>Амьтны статус:</strong></td>
        <td><?php echo getdata($RB_SPECIES_STATUS, $row[$i]["species_status"]);?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["status_endemic"])) { ?>
      <tr>
        <td class="span4"><strong>Унаган амьтан:</strong></td>
        <td><?php echo getdata($RB_STATUS_ENDEMIC, $row[$i]["status_endemic"]); ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["status_relict"])) { ?>
      <tr>
        <td class="span4"><strong>Үлдвэр амьтан:</strong></td>
        <td><?php   echo getdata($RB_STATUS_RELICT, $row[$i]["status_relict"]);?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["status_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Статусын мэдээлэл, монголоор:</strong></td>
        <td><?php echo $row[$i]["status_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["status_en"])) { ?>
      <tr>
        <td class="span4"><strong>Статусын мэдээлэл, англиар:</strong></td>
        <td><?php echo $row[$i]["status_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["description_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Таних шинж, монголоор:</strong></td>
        <td><?php echo $row[$i]["description_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["description_en"])) { ?>
      <tr>
        <td class="span4"><strong>Таних шинж, англиар:</strong></td>
        <td><?php echo $row[$i]["description_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["habitat_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Тархац, байршил нутаг, монголоор:</strong></td>
        <td><?php echo $row[$i]["habitat_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["habitat_en"])) { ?>
      <tr>
        <td class="span4"><strong>Тархац, байршил нутаг, англиар:</strong></td>
        <td><?php echo $row[$i]["habitat_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["growth_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Амьдралын онцлог, монголоор:</strong></td>
        <td><?php echo $row[$i]["growth_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["growth_en"])) { ?>
      <tr>
        <td class="span4"><strong>Амьдралын онцлог, англиар:</strong></td>
        <td><?php echo $row[$i]["growth_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["population_threats_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Тоо толгой хомсдох шалтгаан, монголоор:</strong></td>
        <td><?php echo $row[$i]["population_threats_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["population_threats_en"])) { ?>
      <tr>
        <td class="span4"><strong>Тоо толгой хомсдох шалтгаан, англиар:</strong></td>
        <td><?php echo $row[$i]["population_threats_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["convervation_measures_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Хамгаалсан байдал, монголоор:</strong></td>
        <td><?php echo $row[$i]["convervation_measures_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["convervation_measures_en"])) { ?>
      <tr>
        <td class="span4"><strong>Хамгаалсан байдал, англиар:</strong></td>
        <td><?php echo $row[$i]["convervation_measures_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["further_action_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Хамгаалах арга хэмжээ, монголоор :</strong></td>
        <td><?php echo $row[$i]["further_action_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["further_action_en"])) { ?>
      <tr>
        <td class="span4"><strong>Хамгаалах арга хэмжээ, англиар:</strong></td>
        <td><?php echo $row[$i]["further_action_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["source_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Эх зохиол, мэдээ, монголоор:</strong></td>
        <td><?php echo $row[$i]["source_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["source_en"])) { ?>
      <tr>
        <td class="span4"><strong>Эх зохиол, мэдээ, англиар:</strong></td>
        <td><?php echo $row[$i]["source_en"]; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<div><a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$list_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
