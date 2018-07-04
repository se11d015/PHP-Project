<?php //
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) 
{
	require("calendar/classes/tc_calendar.php");
	
	if (isset($_GET["resource_id"])) {
		$resource_id = (int) $_GET["resource_id"];
	} else {
		$resource_id = 0;
	}
	
	$i = 0;
	
	$startQuery = "SELECT";
	$valueQuery = "tapnr.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl, ".$schemas.".taanimalresource tapnr";
	
	if ($sess_profile == 1)
		$whereQuery = "WHERE tapnr.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND tapnr.resource_id = " . $resource_id;
	else
		$whereQuery = "WHERE tapnr.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND tapnr.resource_id = " . $resource_id . " AND  tapnr.user_id = " . $sess_user_id;
	$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
	$row = $db->query($selQuery);
	
	if (!empty($row)) {
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("evaluated_date").value == "") {
		alert("Судалгаа хийсэн огноог оруулна уу");
	} else {
		document.getElementById("updateanimalresourcebttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 11); ?> засах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="resource_id" id="resource_id" value="<?php echo $row[$i]["resource_id"]; ?>">
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
              <label class="control-label">Судалгаа хийсэн огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("evaluated_date", true);
					$evaluated_date = $row[$i]["evaluated_date"];
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime($evaluated_date)), date('m', strtotime($evaluated_date)), date('Y', strtotime($evaluated_date)));
					$myCalendar1->setPath("calendar/");
					$calendarendyear = date('Y', strtotime("now"));
					$calendarstartyear = $calendarendyear - 20;
					$calendarstartdate = $calendarstartyear."-01-01";
					$calendarenddate = $calendarendyear."-12-31";
					$myCalendar1->setYearInterval($calendarstartyear, $calendarendyear);
					$myCalendar1->dateAllow($calendarstartdate, $calendarenddate);
					$myCalendar1->setDateFormat('Y-m-d');
					$myCalendar1->setAlignment('left', 'bottom');
					$myCalendar1->writeScript();
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгаа хийсэн байгууллагын нэр:</label>
              <div class="controls">
                <textarea name="evaluated_org" id="evaluated_org" rows="3" class="span5"><?php echo $row[$i]["evaluated_org"]; ?></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тархсан газрын нэр:</label>
              <div class="controls">
                <textarea name="dist_place" id="dist_place" rows="3" class="span5"><?php echo $row[$i]["dist_place"]; ?></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Талбайн хэмжээ, га:</label>
              <div class="controls">
                <input type="text" class="span2"name="dist_area" id="dist_area" value="<?php echo $row[$i]["dist_area"]; ?>"/>
                <span class="help-inline">Бутархай тоо байна. 11 оронгоос хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">1км2 дах амьтны нягтшил:</label>
              <div class="controls">
                <input type="text" class="span2"name="dist_density" id="dist_density" value="<?php echo $row[$i]["dist_density"]; ?>"/>
                <span class="help-inline">Бутархай тоо байна. 11 оронгоос хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Амьтны тоо толгой:</label>
              <div class="controls">
                <input type="text" class="span2"name="total_head" id="total_head" value="<?php echo $row[$i]["total_head"]; ?>"/>
               <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Сүргийн бүтэц, Бие гүйцсэн эр:</label>
              <div class="controls">
                <input type="text" class="span2"name="male_head" id="male_head" value="<?php echo $row[$i]["male_head"]; ?>"/>
               <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Сүргийн бүтэц, Бие гүйцсэн эм:</label>
              <div class="controls">
                <input type="text" class="span2"name="female_head" id="female_head" value="<?php echo $row[$i]["female_head"]; ?>"/>
               <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Сүргийн бүтэц, Залуу:</label>
              <div class="controls">
                <input type="text" class="span2"name="yearling_head" id="yearling_head" value="<?php echo $row[$i]["yearling_head"]; ?>"/>
               <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Сүргийн бүтэц, Төл:</label>
              <div class="controls">
                <input type="text" class="span2"name="young_head" id="young_head" value="<?php echo $row[$i]["young_head"]; ?>"/>
               <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Сүргийн нөхөн төлжилт, хувиар:</label>
              <div class="controls">
                <input type="text" class="span2"name="head_density" id="head_density" value="<?php echo $row[$i]["head_density"]; ?>"/>
               <span class="help-inline">Бутархай тоо байна. 5 оронгоос хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Нэмэлт мэдээлэл:</label>
              <div class="controls">
                <textarea name="additional_info" id="additional_info" rows="3" class="span5"><?php echo $row[$i]["additional_info"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <input type="hidden" id="updateanimalresourcebttn" name="updateanimalresourcebttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="updatesubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a> </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
	} else {
		$notify = "Таны хайсан мэдээлэл байхгүй байна. <a href=\"" . $my_url . $my_page . $search_url . $sort_url . "\">Буцах</a>";
		show_notification("error", "", $notify);
	}
} else {
	$notify = "Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}
?>
