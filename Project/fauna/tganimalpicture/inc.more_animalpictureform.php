<?php
if (isset($_GET["picture_id"]))
{
	$picture_id = (int)$_GET["picture_id"];
}else
{
	$picture_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tganp.*, taaim.aimag_name_mn, tasou.soum_name_mn, tapl.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM ".$schemas.".tganimalpicture tganp,".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn,".$schemas.".taordername taon,".$schemas.".tafamilyname tafn,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou ";
$whereQuery = "WHERE tganp.picture_id =".$picture_id." AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code 
AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code AND taaim.aimag_code=tganp.aimag_name  AND tasou.soum_code=tganp.soum_name AND tganp.species_code = tapl.species_code";
	
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
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 18); ?> дэлгэрэнгүй харах</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($row[$i]["photo_filename"])) {?>
      <tr>
        <td colspan="2"><div class="span3">
            <div class="thumbnail"><a href="<?php echo $row[$i]["photo_pathname"].$row[$i]["photo_filename"]; ?>" class="thumbnail" target="_blank" data-toggle="tooltip" data-placement="bottom" ><img src="<?php echo $row[$i]["photo_pathname"].$row[$i]["photo_filename"]; ?>" /> </a>
            </div>
          </div></td>
      </tr>
      <?php } ?>
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
        <td class="span4"><strong>Зураг авсан огноо:</strong></td>
        <td><?php echo $row[$i]["photo_date"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зургийн гарчиг:</strong></td>
        <td><?php echo $row[$i]["photo_title"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зураг авсан аймгийн нэр:</strong></td>
        <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зураг авсан сумын нэр:</strong></td>
        <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зургийг авсан газрын нэр:</strong></td>
        <td><?php echo $row[$i]["photo_place"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зургийг авсан хүний нэр:</strong></td>
        <td><?php echo $row[$i]["photo_auhtor"]; ?></td>
      </tr>
      <tr>
        <td class="span4"><strong>Зургийн тайлбар:</strong></td>
        <td><?php echo $row[$i]["photo_description"]; ?></td>
      </tr>
      <?php if (!empty($row[$i]["geom"])) { ?>
      <tr>
        <td><strong>Газарзүйн солбицол:</strong></td>
        <td><?php
			echo "| <a  href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=2&picture_id=".$row[$i]["picture_id"]."\">Координатаар харах</a> ";
			echo "| <a href=\"".$my_url.$my_page.$search_url.$sort_url."&action=output&outputtype=3&picture_id=".$row[$i]["picture_id"]."\">Google KML-аар харах</a> |";
			?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<div>
  <?php
	if($sess_profile==1)
	{
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&picture_id=".$row[$i]["picture_id"]; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp;
  <?php 
	} else if($row[$i]["user_id"]==$sess_user_id) {
	?>
  <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&picture_id=".$row[$i]["picture_id"]; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp;
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