<?php
if (isset($_GET["class_id"]))
{
	$class_id = (int)$_GET["class_id"];
}else
{
	$class_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tacn.*, takn.kingdom_code, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, takn.citation_author kingdom_citation_author, takn.citation_year kingdom_citation_year, takn.alternative_name kingdom_alternative_name, tapn.phylum_code, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tapn.citation_author phylum_citation_author, tapn.citation_year phylum_citation_year, tapn.alternative_name phylum_alternative_name FROM ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
$whereQuery = "WHERE tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code AND tacn.class_id = ".$class_id;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 3); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="span5"><strong>Аймгийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["kingdom_name"])) echo $row[$i]["kingdom_name"]; 
			if(!empty($row[$i]["kingdom_name_mn"])) echo " - ".$row[$i]["kingdom_name_mn"]; 
			if(!empty($row[$i]["kingdom_name_en"])) echo " - ".$row[$i]["kingdom_name_en"]; 
			if(!empty($row[$i]["kingdom_name_ru"])) echo " - ".$row[$i]["kingdom_name_ru"];
			?></td>
      </tr>
      <?php if(!empty($row[$i]["kingdom_citation_author"]) && !empty($row[$i]["kingdom_citation_year"])) { ?>
      <tr>
        <td><strong>Аймгийн зохиогчийн нэр, ишлэгдсэн он:</strong></td>
        <td><?php 
			if(!empty($row[$i]["kingdom_citation_author"])) echo $row[$i]["kingdom_citation_author"];
			if(!empty($row[$i]["kingdom_citation_year"])) echo ", ".$row[$i]["kingdom_citation_year"];
		 ?></td>
      </tr>       
      <?php } ?>
      <?php if(!empty($row[$i]["kingdom_alternative_name"])) { ?>
      <tr>
        <td><strong>Аймгийн алтернатив нэр:</strong></td>
        <td><?php echo $row[$i]["kingdom_alternative_name"]; ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td><strong>Хүрээний нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["phylum_name"])) echo $row[$i]["phylum_name"]; 
			if(!empty($row[$i]["phylum_name_mn"])) echo " - ".$row[$i]["phylum_name_mn"]; 
			if(!empty($row[$i]["phylum_name_en"])) echo " - ".$row[$i]["phylum_name_en"]; 
			if(!empty($row[$i]["phylum_name_ru"])) echo " - ".$row[$i]["phylum_name_ru"];
			?></td>
      </tr>
      <?php if(!empty($row[$i]["phylum_citation_author"]) && !empty($row[$i]["phylum_citation_author"])) { ?>
      <tr>
        <td><strong>Хүрээний зохиогчийн нэр, ишлэгдсэн он:</strong></td>
        <td><?php 
			if(!empty($row[$i]["phylum_citation_author"])) echo $row[$i]["phylum_citation_author"];
			if(!empty($row[$i]["phylum_citation_year"])) echo ", ".$row[$i]["phylum_citation_year"];
		 ?></td>
      </tr>       
      <?php } ?>
      <?php if(!empty($row[$i]["phylum_alternative_name"])) { ?>
      <tr>
        <td><strong>Хүрээний алтернатив нэр:</strong></td>
        <td><?php echo $row[$i]["phylum_alternative_name"]; ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td><strong>Ангийн нэр:</strong></td>
        <td><?php 
			if(!empty($row[$i]["class_name"])) echo $row[$i]["class_name"]; 
			if(!empty($row[$i]["class_name_mn"])) echo " - ".$row[$i]["class_name_mn"]; 
			if(!empty($row[$i]["class_name_en"])) echo " - ".$row[$i]["class_name_en"]; 
			if(!empty($row[$i]["class_name_ru"])) echo " - ".$row[$i]["class_name_ru"];
			?></td>
      </tr> 
      <?php if(!empty($row[$i]["citation_author"]) && !empty($row[$i]["citation_year"])) { ?>
      <tr>
        <td><strong>Ангийн зохиогчийн нэр, ишлэгдсэн он:</strong></td>
        <td><?php 
			if(!empty($row[$i]["citation_author"])) echo $row[$i]["citation_author"];
			if(!empty($row[$i]["citation_year"])) echo ", ".$row[$i]["citation_year"];
		 ?></td>
      </tr>       
      <?php } ?>
      <?php if(!empty($row[$i]["alternative_name"])) { ?>
      <tr>
        <td><strong>Ангийн алтернатив нэр:</strong></td>
        <td><?php echo $row[$i]["alternative_name"]; ?></td>
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
