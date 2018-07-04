<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2))
{
							
	if (isset($_GET["species_id"]))
	{
		$species_id = (int) $_GET["species_id"];
	}else
	{
		$species_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "tapl.* FROM ".$schemas.".taanimalname tapl";
	
	if($sess_profile==1)
		$whereQuery = "WHERE tapl.species_id = ".$species_id;
	else
		$whereQuery = "WHERE tapl.species_id = ".$species_id." AND tapl.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("genus_code").value==""){
		alert( "Төрлийн кодыг оруулна уу" );
	}else if (document.getElementById("species_code").value==""){
		alert( "Зүйлийн кодыг оруулна уу" );
	}else if (document.getElementById("species_name").value==""){
		alert( "Зүйлийн латин нэрийг оруулна уу" );
	}
	else {
		document.getElementById("updatespeciesbttn").value = "1";
		document.mainform.submit();}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 7); ?> засварлах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="species_id" id="species_id" value="<?php echo $row[$i]["species_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="control-group">
              <label class="control-label">Хүрээний нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tapn.phylum_code, tapn.phylum_name_mn||' - '||tapn.phylum_name as phylum_name FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tagn.genus_code = ".$row[$i]["genus_code"];
					$sortQuery = "ORDER BY tapn.phylum_code";
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;
					$rows = $db->query($selQuery);
					$phylum_code =  $rows[0]["phylum_code"];
					
					$startQuery = "SELECT";
					$valueQuery = "tapn.phylum_code, tapn.phylum_name_mn||' - '||tapn.phylum_name as phylum_name FROM ".$schemas.".taphylumname tapn";
					$sortQuery = "ORDER BY tapn.phylum_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("phylum_code_genus", "span4", $rows, "phylum_code", "phylum_name", $phylum_code);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "taon.order_code, taon.order_name_mn||' - '||taon.order_name as order_name FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tagn.genus_code = ".$row[$i]["genus_code"]." AND tapn.phylum_code = ".$phylum_code;
					$sortQuery = "ORDER BY taon.order_code";
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;
					$rows = $db->query($selQuery);
					$order_code =  $rows[0]["order_code"];
									
					$startQuery = "SELECT";
					$valueQuery = "taon.order_code, taon.order_name_mn||' - '||taon.order_name as order_name FROM ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.phylum_code = ".$phylum_code;
					$sortQuery = "ORDER BY taon.order_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("order_code_genus", "span4", $rows, "order_code", "order_name", $order_code);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tafn.family_code, tafn.family_name_mn||' - '||tafn.family_name as family_name FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tagn.genus_code = ".$row[$i]["genus_code"]." AND taon.order_code = ".$order_code;
					$sortQuery = "ORDER BY tafn.family_code";
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;
					$rows = $db->query($selQuery);
					$family_code =  $rows[0]["family_code"];
									
					$startQuery = "SELECT";
					$valueQuery = "tafn.family_code, tafn.family_name_mn||' - '||tafn.family_name as family_name FROM ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon WHERE tafn.order_code = taon.order_code AND taon.order_code = ".$order_code;
					$sortQuery = "ORDER BY tafn.family_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("family_code", "span4", $rows, "family_code", "family_name", $family_code);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Төрлийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tagn.genus_code, tagn.genus_name_mn||' - '||tagn.genus_name as genus_name FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn WHERE tagn.family_code = tafn.family_code AND tafn.family_code = ".$family_code;
					$sortQuery = "ORDER BY tagn.genus_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					if(!empty($rows))
						echo seldatadb("genus_code", "span4", $rows, "genus_code", "genus_name", $row[$i]["genus_code"]);
					else
						echo seldatadb("genus_code", "span4", $rows, "genus_code", "genus_name", NULL);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн код:</label>
              <div class="controls">
                <input type="text" class="span2" name="species_code" id="species_code" value="<?php echo $row[$i]["species_code"]; ?>"/>
                <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн латин нэр:</label>
              <div class="controls">
                <input type="text" class="span5" name="species_name" id="species_name" value="<?php echo $row[$i]["species_name"]; ?>"/>
                <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зохиогчийн нэр:</label>
              <div class="controls">
                <input type="text" class="span5" name="citation_author" id="citation_author" value="<?php echo $row[$i]["citation_author"]; ?>"/>
                <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ишлэгдсэн он:</label>
              <div class="controls">
                <input type="text" class="span1" name="citation_year" id="citation_year" value="<?php echo $row[$i]["citation_year"]; ?>"/>
                <span class="help-inline">Бүхэл тоо байна. 4 оронтой тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн монгол нэр:</label>
              <div class="controls">
                <input type="text" class="span5" name="species_name_mn" id="species_name_mn" value="<?php echo $row[$i]["species_name_mn"]; ?>"/>
                <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн англи нэр:</label>
              <div class="controls">
                <input type="text" class="span5" name="species_name_en" id="species_name_en" value="<?php echo $row[$i]["species_name_en"]; ?>"/>
                <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн орос нэр:</label>
              <div class="controls">
                <input type="text" class="span5" name="species_name_ru" id="species_name_ru" value="<?php echo $row[$i]["species_name_ru"]; ?>"/>
                <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн синоним нэр:</label>
              <div class="controls">
                <textarea name="synonyms_name" id="synonyms_name" rows="3" class="span5"><?php echo $row[$i]["synonyms_name"]; ?></textarea>
                <span class="help-inline">255 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн базионим нэр:</label>
              <div class="controls">
                <textarea name="basionum_name" id="basionum_name" rows="3" class="span5"><?php echo $row[$i]["basionum_name"]; ?></textarea>
                <span class="help-inline">255 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Олон улсын TAXONID дугаар:</label>
              <div class="controls">
                <input type="text" class="span3" name="taxonid" id="taxonid" value="<?php echo $row[$i]["taxonid"]; ?>"/>
                <span class="help-inline">25 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Олон улсын BARCODE дугаар:</label>
              <div class="controls">
                <input type="text" class="span3" name="barcode" id="barcode" value="<?php echo $row[$i]["barcode"]; ?>"/>
                <span class="help-inline">25 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <input type="hidden" id="updatespeciesbttn" name="updatespeciesbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="updatesubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a> </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php 
	} else {
		$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
		show_notification("error", "", $notify);
	}
} else {
		$notify ="Таны хандалт буруу байна.";
		show_notification("error", "", $notify);
}		
?>
