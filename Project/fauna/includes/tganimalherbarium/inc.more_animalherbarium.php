<?php
if (isset($_GET["herbarium_id"])) {
	$herbarium_id = (int) $_GET["herbarium_id"];
} else {
	$herbarium_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "tgph.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru, vas.aimag_name_mn, vas.soum_name_mn FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl," . $schemas . ".tganimalherbarium tgph, scadministrative.vasoumname vas ";
$whereQuery = "WHERE tapl.species_code = tgph.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code  AND tgph.soum_name = vas.soum_code AND tgph.herbarium_id = " . $herbarium_id;

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery ;
$row = $db->query($selQuery);

if (!empty($row)) {
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 15); ?> дэлгэрэнгүй харах</th>
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
      <?php if(!empty($row[$i]["herbarium_type"])) { ?>
      <tr>
        <td><strong>Цуглуулгын төрөл:</strong></td>
        <td><?php echo getdata($HERBARIUM_TYPE, $row[$i]["herbarium_type"]); ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["collected_date"])) { ?>
      <tr>
        <td><strong>Цуглуулга хийсэн огноо:</strong></td>
        <td><?php echo $row[$i]["collected_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["herbarium_name"])) { ?>
      <tr>
        <td><strong>Цуглуулгын нэр:</strong></td>
        <td><?php echo $row[$i]["herbarium_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["collecting_number"])) { ?>
      <tr>
        <td><strong>Цуглуулгын дугаар:</strong></td>
        <td><?php echo $row[$i]["collecting_number"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["aimag_name_mn"])) { ?>
      <tr>
        <td><strong>Цуглуулга хийсэн аймгийн нэр:</strong></td>
        <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["soum_name_mn"])) { ?>
      <tr>
        <td><strong>Цуглуулга хийсэн сумын нэр:</strong></td>
        <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["place_name"])) { ?>
      <tr>
        <td><strong>Цуглуулга хийсэн газрын нэр:</strong></td>
        <td><?php echo $row[$i]["place_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["collector_name"])) { ?>
      <tr>
        <td><strong>Цуглуулга хийсэн судлаачийн нэр:</strong></td>
        <td><?php echo $row[$i]["collector_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["determiner_name"])) { ?>
      <tr>
        <td><strong>Цуглуулгыг тодорхойлсон судлаачийн нэр:</strong></td>
        <td><?php echo $row[$i]["determiner_name"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["herbarium_description"])) { ?>
      <tr>
        <td><strong>Цуглуулгын тайлбар:</strong></td>
        <td><?php echo $row[$i]["herbarium_description"]; ?></td>
      </tr>
      <?php } ?>
      <?php if (!empty($row[$i]["geom"])) { ?>
      <tr>
        <td><strong>Газарзүйн солбицол:</strong></td>
        <td><?php
    echo "| <a  href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=2&herbarium_id=".$row[$i]["herbarium_id"]."\">Координатаар харах</a> ";
    echo "| <a href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=3&herbarium_id=".$row[$i]["herbarium_id"]."\">Google KML-аар харах</a> |";
    ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<div><a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$list_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
<?php
} else {
	$notify = "Таны хайсан мэдээлэл байхгүй байна. <a href=\"" . $my_url . $my_page . $search_url.$list_url . $sort_url . "\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
