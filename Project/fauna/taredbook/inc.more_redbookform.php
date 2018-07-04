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
  <table class="table table-bordered table-striped table-hover">
    <tbody>
      <tr>
        <td colspan="2"><?php if (!empty($row[$i]["fauna_filename"])){  ?>
          <div class="span3">
            <div class="thumbnail"><a href="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename"]; ?>" class="thumbnail" target="_blank" data-toggle="tooltip" data-placement="bottom" ><img src="<?php echo $row[$i]["picture_pathname"].$row[$i]["fauna_filename"]; ?>" /> </a>
              <p align="center">Амьтны зураг</p>
            </div>
          </div>
          <?php } ?>
          <?php if (!empty($row[$i]["dist_filename"])){  ?>
          <div class="span3">
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
        <td class="span4"><strong>Улаан номонд орсон он:</strong></td>
        <td><?php echo $row[$i]["approved_year"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Амьтны статус:</strong></td>
        <td><?php echo getdata($RB_SPECIES_STATUS, $row[$i]["species_status"]);?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Унаган амьтан:</strong></td>
        <td><?php echo getdata($RB_STATUS_ENDEMIC, $row[$i]["status_endemic"]); ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Үлдвэр амьтан:</strong></td>
        <td><?php   echo getdata($RB_STATUS_RELICT, $row[$i]["status_relict"]);?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Статусын мэдээлэл, монголоор:</strong></td>
        <td><?php echo $row[$i]["status_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Статусын мэдээлэл, англиар:</strong></td>
        <td><?php echo $row[$i]["status_en"]; ?></td>
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
        <td class="span4"><strong>Тархац, байршил нутаг, монголоор:</strong></td>
        <td><?php echo $row[$i]["habitat_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Тархац, байршил нутаг, англиар:</strong></td>
        <td><?php echo $row[$i]["habitat_en"]; ?></td>
      </tr>
      <tr>
      <tr>
        <td class="span4"><strong>Амьдралын онцлог, монголоор:</strong></td>
        <td><?php echo $row[$i]["growth_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Амьдралын онцлог, англиар:</strong></td>
        <td><?php echo $row[$i]["growth_en"]; ?></td>
      </tr>
      <tr>
      <tr>
        <td class="span4"><strong>Тоо толгой хомсдох шалтгаан, монголоор:</strong></td>
        <td><?php echo $row[$i]["population_threats_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Тоо толгой хомсдох шалтгаан, англиар:</strong></td>
        <td><?php echo $row[$i]["population_threats_en"]; ?></td>
      </tr>
      <tr>
      <tr>
        <td class="span4"><strong>Хамгаалсан байдал, монголоор:</strong></td>
        <td><?php echo $row[$i]["convervation_measures_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Хамгаалсан байдал, англиар:</strong></td>
        <td><?php echo $row[$i]["convervation_measures_en"]; ?></td>
      </tr>
      <tr>
      <tr>
        <td class="span4"><strong>Хамгаалах арга хэмжээ, монголоор :</strong></td>
        <td><?php echo $row[$i]["further_action_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Хамгаалах арга хэмжээ, англиар:</strong></td>
        <td><?php echo $row[$i]["further_action_en"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Эх зохиол, мэдээ, монголоор:</strong></td>
        <td><?php echo $row[$i]["source_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Эх зохиол, мэдээ, англиар:</strong></td>
        <td><?php echo $row[$i]["source_en"]; ?></td>
      </tr>
    </tbody>
  </table>
</div>
<div>
  <?php
	if($sess_profile==1)
	{
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&redbook_id=".$row[$i]["redbook_id"]; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp;
  <?php 
	} else if($row[$i]["user_id"]==$sess_user_id) {
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&redbook_id=".$row[$i]["redbook_id"]; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp;
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
