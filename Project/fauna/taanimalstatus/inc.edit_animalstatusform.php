<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2))
{
							
	if (isset($_GET["status_id"]))
	{
		$status_id = (int) $_GET["status_id"];
	}else
	{
		$status_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "tapr.*,takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl,".$schemas.".taanimalstatus tapr";
	
	if($sess_profile==1)
		$whereQuery = "WHERE  tapl.species_code = tapr.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND tapr.status_id = ".$status_id;
	else
		$whereQuery = "WHERE  tapl.species_code = tapr.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND tapr.status_id = ".$status_id." AND tapr.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery; 
	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
if (document.getElementById("reference_code").value==""){
		alert( "Төлөв байдлын нэрийг оруулна уу" );
	}
	else {
		document.getElementById("updateanimalstatusbttn").value = "1";
		document.mainform.submit();}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 12); ?> засварлах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="status_id" id="status_id" value="<?php echo $row[$i]["status_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <input type="hidden" name="species_code" id="species_code" value="<?php echo $row[$i]["species_code"]; ?>">
            <div class="control-group">
              <label class="control-label">Аймгийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["kingdom_name"])) echo $row[$i]["kingdom_name"]; 
					if(!empty($row[$i]["kingdom_name_mn"])) echo " - ".$row[$i]["kingdom_name_mn"]; 
					if(!empty($row[$i]["kingdom_name_en"])) echo " - ".$row[$i]["kingdom_name_en"]; 
					if(!empty($row[$i]["kingdom_name_ru"])) echo " - ".$row[$i]["kingdom_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хүрээний нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["phylum_name"])) echo $row[$i]["phylum_name"]; 
					if(!empty($row[$i]["phylum_name_mn"])) echo " - ".$row[$i]["phylum_name_mn"]; 
					if(!empty($row[$i]["phylum_name_en"])) echo " - ".$row[$i]["phylum_name_en"]; 
					if(!empty($row[$i]["phylum_name_ru"])) echo " - ".$row[$i]["phylum_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["class_name"])) echo $row[$i]["class_name"]; 
					if(!empty($row[$i]["class_name_mn"])) echo " - ".$row[$i]["class_name_mn"]; 
					if(!empty($row[$i]["class_name_en"])) echo " - ".$row[$i]["class_name_en"]; 
					if(!empty($row[$i]["class_name_ru"])) echo " - ".$row[$i]["class_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["order_name"])) echo $row[$i]["order_name"]; 
					if(!empty($row[$i]["order_name_mn"])) echo " - ".$row[$i]["order_name_mn"]; 
					if(!empty($row[$i]["order_name_en"])) echo " - ".$row[$i]["order_name_en"]; 
					if(!empty($row[$i]["order_name_ru"])) echo " - ".$row[$i]["order_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["family_name"])) echo $row[$i]["family_name"]; 
					if(!empty($row[$i]["family_name_mn"])) echo " - ".$row[$i]["family_name_mn"]; 
					if(!empty($row[$i]["family_name_en"])) echo " - ".$row[$i]["family_name_en"]; 
					if(!empty($row[$i]["family_name_ru"])) echo " - ".$row[$i]["family_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Төрлийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["genus_name"])) echo $row[$i]["genus_name"]; 
					if(!empty($row[$i]["genus_name_mn"])) echo " - ".$row[$i]["genus_name_mn"]; 
					if(!empty($row[$i]["genus_name_en"])) echo " - ".$row[$i]["genus_name_en"]; 
					if(!empty($row[$i]["genus_name_ru"])) echo " - ".$row[$i]["genus_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["species_name"])) echo $row[$i]["species_name"]; 
					if(!empty($row[$i]["species_name_mn"])) echo " - ".$row[$i]["species_name_mn"]; 
					if(!empty($row[$i]["species_name_en"])) echo " - ".$row[$i]["species_name_en"]; 
					if(!empty($row[$i]["species_name_ru"])) echo " - ".$row[$i]["species_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Төлөв байдлын нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tcrn.reference_code, tcrn.reference_name FROM ".$schemas.".tcreferencestatus tcrn";
					$rows = $db->query($selQuery);
					echo seldatadb("reference_code", "span3", $rows, "reference_code", "reference_name",  $row[$i]["reference_code"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <input type="hidden" id="updateanimalstatusbttn" name="updateanimalstatusbttn" value="0"/>
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
