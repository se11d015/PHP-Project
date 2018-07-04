<?php
if (isset($_GET["payment_id"]))
{
	$payment_id = (int)$_GET["payment_id"];
}else
{
	$payment_id = 0;
}

	
	$i = 0;
	
	$startQuery = "SELECT";
	$valueQuery = "taupa.*, tgcpe.permission_number, tapl.species_code, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl, " . $schemas . ".taanimalusepayment taupa, ".$schemas.".taanimalusepermission tgcpe";
	$whereQuery = "WHERE tgcpe.permission_id = taupa.permission_id  AND taupa.species_name = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taupa.payment_id = " . $payment_id;

	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	//echo $selQuery;
	$row = $db->query($selQuery);

	if (!empty($row)) 
	{
	$userid  = $row[$i]["user_id"];
	?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 73); ?> дэлгэрэнгүй харах</th>
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
      <?php if(!empty($row[$i]["permission_number"])) { ?>
      <tr>
        <td class="span4"><strong>Зөвшөөрлийн дугаар:</strong></td>
        <td><?php echo $row[$i]["permission_number"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["report_date"])) { ?>
      <tr>
        <td class="span4"><strong>Тайлант огноо:</strong></td>
        <td><?php echo $row[$i]["report_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["used_amount"])) { ?>
      <tr>
        <td class="span4"><strong>Ашигласан амьтны тоо толгой:</strong></td>
        <td><?php echo $row[$i]["used_amount"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["amount_unit"])) { ?>
      <tr>
        <td class="span4"><strong>Хэмжих нэгж:</strong></td>
        <td><?php echo $row[$i]["amount_unit"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["ecology_rate"])) { ?>
      <tr>
        <td class="span4"><strong>Экологи-эдийн засгийн үнэлгээ, төг:</strong></td>
        <td><?php echo $row[$i]["ecology_rate"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["payment_value"])) { ?>
      <tr>
        <td class="span4"><strong>Ногдуулсан төлбөрийн хэмжээ, төг:</strong></td>
        <td><?php echo $row[$i]["payment_value"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["discount_value"])) { ?>
      <tr>
        <td class="span4"><strong>Хөнгөлөлт чөлөөлөлтийн хэмжээ, төг:</strong></td>
        <td><?php echo $row[$i]["discount_value"]; ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($row[$i]["total_payment"])) { ?>
      <tr>
        <td class="span4"><strong>Нийт ногдуулсан төлбөрийн хэмжээ, төг:</strong></td>
        <td><?php echo $row[$i]["total_payment"]; ?></td>
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
<div> <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a> </div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url;"\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
