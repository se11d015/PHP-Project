<?php
if (isset($_GET["offence_id"])) {
$offence_id = (int) $_GET["offence_id"];
} else {
$offence_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "tgaof.*, taaim.aimag_name_mn, tasou.soum_name_mn,  takn.kingdom_code, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, 
tapn.phylum_code, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_code, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, 
tacn.class_name_ru, taon.order_code, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_code, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, 
tafn.family_name_ru,  tagn.genus_code, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru,  tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru, vas.aimag_name_mn, vas.soum_name_mn FROM " . $schemas . ".takingdomname takn, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, " . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl," . $schemas . ".tganimaloffence tgaof, scadministrative.vasoumname vas ";
$whereQuery = "WHERE taaim.aimag_code=tgaof.aimag_name AND tasou.soum_code=tgaof.soum_name AND tapl.species_code = tgaof.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code  AND tgaof.soum_name = vas.soum_code AND tgaof.offence_id = " . $offence_id;

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery ;
$row = $db->query($selQuery);

if (!empty($row)) {
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 100); ?>  (дэлгэрэнгүй харах) </th>
      </tr>
    </thead>
    <tbody>
      <tr>
      
        <td class="span3"><strong>Аймгийн нэр:</strong></td>
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
        <td><strong>Зөрчил гарсан огноо:</strong></td>
        <td><?php echo $row[$i]["offence_date"]; ?></td>
      </tr>
      <tr>
        <td><strong>Зөрчил гарсан аймаг, хотын нэр :</strong></td>
        <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
      </tr>
      <tr>
        <td><strong>Зөрчил гарсан сум, дүүргийн нэр :</strong></td>
        <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
      </tr>
     
      <tr>
        <td><strong>Зөрчил гарсан газрын нэр:</strong></td>
        <td><?php echo $row[$i]["place_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Хууль бусаар агнасан, барьсан амьтны тоо:</strong></td>
        <td><?php echo $row[$i]["offense_amount"]; ?></td>
      </tr>
      <tr>
        <td><strong>Хэмжих нэгж:</strong></td>
        <td><?php echo getdata($OFFENCE_TYPE, $row[$i]["amount_unit"]); ?></td>
      </tr>
      <tr>
        <td><strong>Ногдуулсан торгуулийн хэмжээ, мян төг:</strong></td>
        <td><?php echo $row[$i]["penalty_payment"]; ?></td>
      </tr>
	  <tr>
        <td><strong>Нөхөн төлбөрийн хэмжээ, мян төг:</strong></td>
        <td><?php echo $row[$i]["recovery_payment"]; ?></td>
      </tr>
      <tr>
        <td><strong>Нэмэлт мэдээлэл:</strong></td>
        <td><?php echo $row[$i]["additional_info"]; ?></td>
      </tr>
      <?php
if (!empty($row[$i]["geom"])) {
    ?>
      <tr>
        <td><strong>Газарзүйн солбицол:</strong></td>
        <td><?php
    echo "| <a  href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=2&offence_id=".$row[$i]["offence_id"]."\">Координатаар харах</a> ";
    echo "| <a href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=3&offence_id=".$row[$i]["offence_id"]."\">Google KML-аар харах</a> |";
    ?></td>
      </tr>
      <?php
                    }
                    ?>
    </tbody>
  </table>
</div>
<div>

  <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div><br>
<?php
                } else {
                    $notify = "Таны хайсан мэдээлэл байхгүй байна. <a href=\"" . $my_url . $my_page . $search_url . $sort_url . "\">Буцах</a>";
                    show_notification("error", "", $notify);
                }
                ?>
