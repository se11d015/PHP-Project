<?php
if (isset($_GET["species_id"]))
{
	$species_id = (int)$_GET["species_id"];
}else
{
	$species_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tapl.*, takn.kingdom_code, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, takn.citation_author kingdom_citation_author, takn.citation_year kingdom_citation_year, takn.alternative_name kingdom_alternative_name, tapn.phylum_code, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tapn.citation_author phylum_citation_author, tapn.citation_year phylum_citation_year, tapn.alternative_name phylum_alternative_name, tacn.class_code, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, tacn.citation_author class_citation_author, tacn.citation_year class_citation_year, tacn.alternative_name class_alternative_name, taon.order_code, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, taon.citation_author order_citation_author, taon.citation_year order_citation_year, taon.alternative_name order_alternative_name, tafn.family_code, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tafn.citation_author family_citation_author, tafn.citation_year family_citation_year, tafn.alternative_name family_alternative_name, tagn.genus_code, tagn.genus_name, tagn.citation_author genus_citation_author, tagn.citation_year genus_citation_year, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tagn.synonyms_name genus_synonyms_name, tagn.basionum_name genus_basionum_name FROM ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
$whereQuery = "WHERE tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code AND tapl.species_id = ".$species_id;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 7); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="span5"><strong>Аймгийн код:</strong></td>
        <td><?php echo $row[$i]["kingdom_code"]; ?></td>
      </tr>
      <tr>
        <td class="span5"><strong>Аймгийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["kingdom_name"])) echo $row[$i]["kingdom_name"]; 
			if(!empty($row[$i]["kingdom_name_mn"])) echo " - ".$row[$i]["kingdom_name_mn"]; 
			if(!empty($row[$i]["kingdom_name_en"])) echo " - ".$row[$i]["kingdom_name_en"]; 
			if(!empty($row[$i]["kingdom_name_ru"])) echo " - ".$row[$i]["kingdom_name_ru"];
			?></td>
      </tr>
      <tr>
        <td><strong>Аймгийн зохиогчийн нэр, ишлэгдсэн он:</strong></td>
        <td><?php 
			if(!empty($row[$i]["kingdom_citation_author"])) echo $row[$i]["kingdom_citation_author"];
			if(!empty($row[$i]["kingdom_citation_year"])) echo ", ".$row[$i]["kingdom_citation_year"];
		 ?></td>
      </tr>
      <tr>
        <td><strong>Аймгийн алтернатив нэр:</strong></td>
        <td><?php echo $row[$i]["kingdom_alternative_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Хүрээний код:</strong></td>
        <td><?php echo $row[$i]["phylum_code"]; ?></td>
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
        <td><strong>Хүрээний зохиогчийн нэр, ишлэгдсэн он:</strong></td>
        <td><?php 
			if(!empty($row[$i]["phylum_citation_author"])) echo $row[$i]["phylum_citation_author"];
			if(!empty($row[$i]["phylum_citation_year"])) echo ", ".$row[$i]["phylum_citation_year"];
		 ?></td>
      </tr>
      <tr>
        <td><strong>Хүрээний алтернатив нэр:</strong></td>
        <td><?php echo $row[$i]["phylum_alternative_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Ангийн код:</strong></td>
        <td><?php echo $row[$i]["class_code"]; ?></td>
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
        <td><strong>Ангийн зохиогчийн нэр, ишлэгдсэн он:</strong></td>
        <td><?php 
			if(!empty($row[$i]["class_citation_author"])) echo $row[$i]["class_citation_author"];
			if(!empty($row[$i]["class_citation_year"])) echo ", ".$row[$i]["class_citation_year"];
		 ?></td>
      </tr>
      <tr>
        <td><strong>Ангийн алтернатив нэр:</strong></td>
        <td><?php echo $row[$i]["class_alternative_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Багийн код:</strong></td>
        <td><?php echo $row[$i]["order_code"]; ?></td>
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
        <td><strong>Багийн зохиогчийн нэр, ишлэгдсэн он:</strong></td>
        <td><?php 
			if(!empty($row[$i]["order_citation_author"])) echo $row[$i]["order_citation_author"];
			if(!empty($row[$i]["order_citation_year"])) echo ", ".$row[$i]["order_citation_year"];
		 ?></td>
      </tr>
      <tr>
        <td><strong>Багийн алтернатив нэр:</strong></td>
        <td><?php echo $row[$i]["order_alternative_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Овгийн код:</strong></td>
        <td><?php echo $row[$i]["family_code"]; ?></td>
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
        <td><strong>Овгийн зохиогчийн нэр, ишлэгдсэн он:</strong></td>
        <td><?php 
			if(!empty($row[$i]["family_citation_author"])) echo $row[$i]["family_citation_author"];
			if(!empty($row[$i]["family_citation_year"])) echo ", ".$row[$i]["family_citation_year"];
		 ?></td>
      </tr>
      <tr>
        <td><strong>Овгийн алтернатив нэр:</strong></td>
        <td><?php echo $row[$i]["family_alternative_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Төрлийн код:</strong></td>
        <td><?php echo $row[$i]["genus_code"]; ?></td>
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
        <td><strong>Төрлийн зохиогчийн нэр, ишлэгдсэн он:</strong></td>
        <td><?php 
			if(!empty($row[$i]["genus_citation_author"])) echo $row[$i]["genus_citation_author"];
			if(!empty($row[$i]["genus_citation_year"])) echo ", ".$row[$i]["genus_citation_year"];
		 ?></td>
      </tr>      
      <tr>
        <td><strong>Төрлийн синоним нэр:</strong></td>
        <td><?php echo $row[$i]["genus_synonyms_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Төрлийн базионим нэр:</strong></td>
        <td><?php echo $row[$i]["genus_basionum_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Зүйлийн код:</strong></td>
        <td><?php echo $row[$i]["species_code"]; ?></td>
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
        <td><strong>Зүйлийн зохиогчийн нэр, ишлэгдсэн он:</strong></td>
        <td><?php 
			if(!empty($row[$i]["citation_author"])) echo $row[$i]["citation_author"];
			if(!empty($row[$i]["citation_year"])) echo ", ".$row[$i]["citation_year"];
		 ?></td>
      </tr>
      <tr>
        <td><strong>Зүйлийн синоним нэр:</strong></td>
        <td><?php echo $row[$i]["synonyms_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Зүйлийн базионим нэр:</strong></td>
        <td><?php echo $row[$i]["basionum_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>Олон улсын TAXONID дугаар:</strong></td>
        <td><?php echo $row[$i]["taxonid"]; ?></td>
      </tr>
      <tr>
        <td><strong>Олон улсын BARCODE дугаар:</strong></td>
        <td><?php echo $row[$i]["barcode"]; ?></td>
      </tr>                  
    </tbody>
  </table>
</div>
<div><a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
