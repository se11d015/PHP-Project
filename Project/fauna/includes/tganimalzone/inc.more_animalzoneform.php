<?php
if (isset($_GET["gid"]))
{
	$gid = (int)$_GET["gid"];
}else
{
	$gid = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tgazo.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taaim.aimag_name_mn, tasou.soum_name_mn  FROM ".$schemas.".tganimalzone tgazo, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn";
$whereQuery = "WHERE  tgazo.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taaim.aimag_code=tgazo.aimag_name AND tasou.soum_code=tgazo.soum_name AND tgazo.gid = ".$gid;
	
	
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 19); ?> (дэлгэрэнгүй харах) </th>
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
        <td class="span4"><strong>Зүйлийн нэрc:</strong></td>
        <td><?php echo $row[$i]["species_names"]; ?></td>
      </tr>
     <tr>
        <td class="span4"><strong>Хэрэгжих аймаг, хотын нэр :</strong></td>
        <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
      </tr>
	  <tr>
        <td class="span4"><strong>Хэрэгжих сум, дүүргийн нэр :</strong></td>
        <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
      </tr>
	  <tr>
        <td class="span4"><strong>Агнуурын бүсийн нэр:</strong></td>
        <td><?php echo $row[$i]["zone_name"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Бүсийн зургийг хийсэн он:</strong></td>
        <td><?php echo $row[$i]["zone_year"]; ?></td>
      </tr>
	   <tr>
        <td class="span4"><strong>Бүсийн зургийг хийсэн байгууллагын нэр:</strong></td>
        <td><?php echo $row[$i]["org_name"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Тархсан байршлын нэр:</strong></td>
        <td><?php echo $row[$i]["place_name"]; ?></td>
      </tr>
	  <tr>
        <td class="span4"><strong>Нэмэлт мэдээлэл:</strong></td>
        <td><?php echo $row[$i]["additional_info"]; ?></td>
      </tr>
       <?php
     if (!empty($row[$i]["geom"])) {
    ?>
      <tr>
        <td><strong>Газарзүйн солбицол:</strong></td>
	 <td><?php
    echo "| <a href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=3&gid=".$row[$i]["gid"]."\">Google KML-аар харах</a> |";
    ?></td>
      </tr>
      <?php
                    }
                    ?>
    </tbody>
  </table>
</div>
<?php
$startQuery = "SELECT";

$valueQuery = "taamn.*, tganz.zone_name as zone_name_mn, taaim.aimag_name_mn, tasou.soum_name_mn, tcfty.type_name  FROM scfauna.tganimalzone tganz, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas . ".tcfiletype tcfty, ".$schemas . ".taanimalmng taamn ";
$whereQuery = "WHERE taaim.aimag_code=tganz.aimag_name AND tasou.soum_code=tganz.soum_name AND taamn.zone_name=tganz.gid AND taamn.doc_type=tcfty.type_id AND taamn.zone_name = ".$gid;

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery ;
$row2 = $db->query($selQuery);

if (!empty($row2)) {
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="3"><?php echo getdata($ITEM_TYPE, 120); ?> </th>
      </tr>
	  <th class="span4">Баримт бичгийн төрөл</th>
        <th class="span4">Баримт бичгийн боловсруулсан огноо</th>	
        <th class="span4">Төлөвлөгөөний файл</th>
    </thead>
    <tbody>
		
		<?php
	for ($i = 0; $i < sizeof($row2); $i++) {
?>		
	<tr>
	   <td><?php echo $row2[$i]["type_name"]; ?></td>
	   <td><?php echo $row2[$i]["doc_date"]; ?></td>
	   <td><?php if(strlen($row2[$i]["doc_filename"])>0) { ?>
        <a href="<?php echo $row2[$i]["doc_pathname"]."/".$row2[$i]["doc_filename"]; ?>" target="_blank">Файл харах</a>&nbsp;
	</tr>
	<?php }} ?>
    </tbody>
  </table>
</div>

<?php
                }
else "";				
?>
<div>
  <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$list_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
