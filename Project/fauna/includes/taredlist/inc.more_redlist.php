<?php
if (isset($_GET["redlist_id"]))
{
	$redlist_id = (int)$_GET["redlist_id"];
}else
{
	$redlist_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tarl.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru, tcrs.name_mn global_name_mn, tcrs1.name_mn regional_name_mn FROM  ".$schemas.".taredlist tarl,".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn, ".$schemas.".tcredliststatus tcrs , ".$schemas.".tcredliststatus tcrs1";

$whereQuery = "WHERE tarl.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code AND tarl.global_code = tcrs.status_code AND tarl.regional_code = tcrs1.status_code AND tarl.redlist_id = ".$redlist_id;
	
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 20); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
  </table>
  <?php if (!empty($row[$i]["fauna_filename"])){  ?>
  <div class="img-button"> <a href="#" data-toggle="lightbox" data-target="#lightbox1"> <img  class="thumbnail" src="<?php echo $row[$i]["fauna_filename"];?>" width="200px" title="Амьтны зураг"/></a> </div>
  <!-- Modal -->
  <div class="lightbox hide fade" id="lightbox1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class='lightbox-content'>
      <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
      <img  src="<?php echo $row[$i]["fauna_filename"];?>" /> </div>
  </div>
  <?php } ?>
  <?php if (!empty($row[$i]["dist_filename"])){  ?>
  <div class="img-button"> <a href="#" data-toggle="lightbox" data-target="#lightbox2"> <img  class="thumbnail" src="<?php echo $row[$i]["dist_filename"];?>" width="200px" title="Тархалтын зураг"/></a> </div>
  <div class="lightbox hide fade" id="lightbox2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class='lightbox-content'>
      <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
      <img  src="<?php echo $row[$i]["dist_filename"];?>" /> </div>
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
      <?php if(!empty($row[$i]["evaluated_year"])) { ?>
      <tr>
        <td class="span4"><strong>Үнэлгээ хийсэн он:</strong></td>
        <td><?php echo $row[$i]["evaluated_year"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["global_name_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны олон улсын үнэлгээ:</strong></td>
        <td><?php 
				echo $row[$i]["global_name_mn"]; 
				if(!empty($row[$i]["sub_global_status"])) 
					echo ", ".$row[$i]["sub_global_status"];?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["regional_name_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны бүс нутгийн үнэлгээ:</strong></td>
        <td><?php 
				echo $row[$i]["regional_name_mn"];
				if(!empty($row[$i]["sub_regional_status"])) 
					echo ", ".$row[$i]["sub_regional_status"];?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["assessment_rationale_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны үнэлгээний үндэслэл, монголоор:</strong></td>
        <td><?php echo $row[$i]["assessment_rationale_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["assessment_rationale_en"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны үнэлгээний үндэслэл, англиар:</strong></td>
        <td><?php echo $row[$i]["assessment_rationale_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["global_distribution_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны дэлхийн тархалт, монголоор:</strong></td>
        <td><?php echo $row[$i]["global_distribution_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["global_distribution_en"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны дэлхийн тархалт, англиар:</strong></td>
        <td><?php echo $row[$i]["global_distribution_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["regional_distribution_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны бүс нутгийн тархалт, монголоор:</strong></td>
        <td><?php echo $row[$i]["regional_distribution_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["regional_distribution_en"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны бүс нутгийн тархалт, англиар:</strong></td>
        <td><?php echo $row[$i]["regional_distribution_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["dominant_threats_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны ховордолын шалтгаан, монголоор:</strong></td>
        <td><?php echo $row[$i]["dominant_threats_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["dominant_threats_en"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны ховордолын шалтгаан, англиар:</strong></td>
        <td><?php echo $row[$i]["dominant_threats_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["measures_place_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны хамгаалсан байдал, монголоор:</strong></td>
        <td><?php echo $row[$i]["measures_place_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["measures_place_en"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны хамгаалсан байдал, англиар:</strong></td>
        <td><?php echo $row[$i]["measures_place_en"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["measures_required_mn"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны хамгаалах арга хэмжээ, монголоор:</strong></td>
        <td><?php echo $row[$i]["measures_required_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["measures_required_en"])) { ?>
      <tr>
        <td class="span4"><strong>Улаан дансны хамгаалах арга хэмжээ, англиар:</strong></td>
        <td><?php echo $row[$i]["measures_required_en"]; ?></td>
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
