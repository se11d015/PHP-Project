<?php
if (isset($_GET["family_id"]))
{
	$family_id = (int)$_GET["family_id"];
}else
{
	$family_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tafn.*, takn.kingdom_code, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, takn.citation_author kingdom_citation_author, takn.citation_year kingdom_citation_year, takn.alternative_name kingdom_alternative_name, tapn.phylum_code, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tapn.citation_author phylum_citation_author, tapn.citation_year phylum_citation_year, tapn.alternative_name phylum_alternative_name, tacn.class_code, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, tacn.citation_author class_citation_author, tacn.citation_year class_citation_year, tacn.alternative_name class_alternative_name, taon.order_code, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, taon.citation_author order_citation_author, taon.citation_year order_citation_year, taon.alternative_name order_alternative_name FROM ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
$whereQuery = "WHERE tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code AND tafn.family_id = ".$family_id;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 5); ?> дэлгэрэнгүй харах</th>
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
			if(!empty($row[$i]["citation_author"])) echo $row[$i]["citation_author"];
			if(!empty($row[$i]["citation_year"])) echo ", ".$row[$i]["citation_year"];
		 ?></td>
      </tr>       
      <tr>
        <td><strong>Овгийн алтернатив нэр:</strong></td>
        <td><?php echo $row[$i]["alternative_name"]; ?></td>
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
