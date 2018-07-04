<?php
if (isset($_GET["kingdom_id"]))
{
	$kingdom_id = (int)$_GET["kingdom_id"];
}else
{
	$kingdom_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "takn.* FROM ".$schemas.".takingdomname takn";
$whereQuery = "WHERE takn.kingdom_id = ".$kingdom_id;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 1); ?> дэлгэрэнгүй харах</th>
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
			if(!empty($row[$i]["citation_author"])) echo $row[$i]["citation_author"];
			if(!empty($row[$i]["citation_year"])) echo ", ".$row[$i]["citation_year"];
		 ?></td>
      </tr>       
      <tr>
        <td><strong>Аймгийн алтернатив нэр:</strong></td>
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
