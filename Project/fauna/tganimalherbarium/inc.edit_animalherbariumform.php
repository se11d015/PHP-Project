<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) 
{
	require("calendar/classes/tc_calendar.php");
	
	if (isset($_GET["herbarium_id"])) {
		$herbarium_id = (int) $_GET["herbarium_id"];
	} else {
		$herbarium_id = 0;
	}
	
	$i = 0;
	
	$startQuery = "SELECT";
	
	$valueQuery = "tgph.*,  st_x(tgph.geom) as geomx, st_y(tgph.geom) as geomy, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl," . $schemas . ".tganimalherbarium tgph ";
	
	if ($sess_profile == 1)
		$whereQuery = "WHERE tapl.species_code = tgph.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code  AND tgph.herbarium_id = " . $herbarium_id;
	else
		$whereQuery = "WHERE  tapl.species_code = tgph.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code  AND tgph.herbarium_id = " . $herbarium_id . " AND tgph.user_id = " . $sess_user_id;
		
	$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
	//echo $selQuery;
	$row = $db->query($selQuery);	
	
	if (!empty($row)) 
	{
		$x_coordinate_wgs = $row[$i]["geomx"];
		$y_coordinate_wgs = $row[$i]["geomy"];
		$x_coordinate_deg = floor($x_coordinate_wgs);
		$x_coordinate_min = floor(($x_coordinate_wgs-$x_coordinate_deg)*60);
		$x_coordinate_sec = (($x_coordinate_wgs-$x_coordinate_deg)*60-$x_coordinate_min)*60;
		$y_coordinate_deg = floor($y_coordinate_wgs);
		$y_coordinate_min = floor(($y_coordinate_wgs-$y_coordinate_deg)*60);
		$y_coordinate_sec = (($y_coordinate_wgs-$y_coordinate_deg)*60-$y_coordinate_min)*60;
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("species_code").value==""){
		alert( "Зүйлийн кодыг оруулна уу" );
	}else if (document.getElementById("collected_date").value == "") {
		alert("Цуглуулга хийсэн огноог оруулна уу");
	}else if (document.getElementById("herbarium_name").value == "") {
		alert("Цуглуулгын нэрийг оруулна уу");
    } else {
        document.getElementById("updateherbariumbttn").value = "1";
        document.mainform.submit();
    }
}
function select_geom(selectobj)
{
	if (selectobj[selectobj.selectedIndex].value == "2")
	{
		document.getElementById("geom_2").hidden = false;
		document.getElementById("geom_3").hidden = true;
	 
	}
	if (selectobj[selectobj.selectedIndex].value == "3")
	{
		document.getElementById("geom_2").hidden = true;
		document.getElementById("geom_3").hidden = false;
	}
	if (selectobj[selectobj.selectedIndex].value=="5")
	{
		document.getElementById("geom_2").hidden= true;
		document.getElementById("geom_3").hidden= true;
	}	
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 15); ?> засварлах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="herbarium_id" id="herbarium_id" value="<?php echo $row[$i]["herbarium_id"]; ?>">
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
              <label class="control-label">Цуглуулгын төрөл:</label>
              <div class="controls">
                <?php
					echo seldata("herbarium_type", "span2", $HERBARIUM_TYPE, $row[$i]["herbarium_type"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Цуглуулга хийсэн огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("collected_date", true);
					$collected_date = $row[$i]["collected_date"];
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime($collected_date)), date('m', strtotime($collected_date)), date('Y', strtotime($collected_date)));
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
              <label class="control-label">Цуглуулгын нэр:</label>
              <div class="controls">
                <textarea name="herbarium_name" id="herbarium_name" rows="2" class="span4"><?php echo $row[$i]["herbarium_name"]; ?></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span></div>
            </div>
            <div class="control-group">
              <label class="control-label">Цуглуулгын дугаар:</label>
              <div class="controls">
                <input type="text" name="collecting_number" id="collecting_number" class="span4"  value="<?php echo $row[$i]["collecting_number"]; ?>"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Цуглуулга хийсэн аймгийн нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("aimag_name", "span3", $rows, "aimag_code", "aimag_name_mn", $row[$i]["aimag_name"]);
					$aimagcode = $row[$i]["aimag_name"];
					?>
              </div>
              </br>
              <label class="control-label">Цуглуулга хийсэн сумын нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT vs.soum_code, vs.soum_name_mn soum_name_mn FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";			
					$rows = $db->query($selQuery);
					echo seldatadb("soum_name", "span4", $rows, "soum_code", "soum_name_mn", $row[$i]["soum_name"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Цуглуулга хийсэн газрын нэр:</label>
              <div class="controls">
                <textarea name="place_name" id="place_name" rows="3" class="span4"><?php echo $row[$i]["place_name"]; ?></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Цуглуулга хийсэн судлаачийн нэр:</label>
              <div class="controls">
                <input type="text" name="collector_name" id="collector_name" class="span4"  value="<?php echo $row[$i]["collector_name"]; ?>"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Цуглуулгыг тодорхойлсон судлаачийн нэр:</label>
              <div class="controls">
                <input type="text" name="determiner_name" id="determiner_name" class="span4"  value="<?php echo $row[$i]["determiner_name"]; ?>"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Цуглуулгын тайлбар:</label>
              <div class="controls">
                <textarea name="herbarium_description" id="herbarium_description" rows="3" class="span4"><?php echo $row[$i]["herbarium_description"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Цуглуулгын хадгалалтын байдал:</label>
              <div class="controls">
                <textarea name="save_condition" id="save_condition" rows="3" class="span4"><?php echo $row[$i]["save_condition"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <input type="hidden" id="herbarium_filename" name="herbarium_filename" value="<?php echo $row[$i]["herbarium_filename"]; ?>"/>
            <input type="hidden" id="herbarium_pathname" name="herbarium_pathname" value="<?php echo $row[$i]["herbarium_pathname"]; ?>"/>
            <div class="control-group">
              <label class="control-label">Цуглуулгын зургийн файл:</label>
              <div class="controls">
                <input type="file" name="herbarium_filename" id="herbarium_filename"/>
                <span class="help-inline">Файлын өргөтгөл нь .jpg, .jpeg, .png байна.</span>
                <?php if(!empty($row[$i]["herbarium_pathname"]) && !empty($row[$i]["herbarium_filename"])) { ?>
                <p class="help-block">Цуглуулгын <a href="<?php echo $row[$i]["herbarium_pathname"]."/".$row[$i]["herbarium_filename"];?>" target="_blank"><img src="<?php echo $row[$i]["herbarium_pathname"]."/".$row[$i]["herbarium_filename"];?>" width="100"/> </a>файл байна. </p>
                <?php } ?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Координатын проекцын нэр:</label>
              <div class="controls">
                <?php
					echo seldata("geom_srid", "span3", $GEOMETRY_SRID, 4326);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="textarea">Координат оруулах хэлбэр:</label>
              <div class="controls">
                <select name="geom_type" id="geom_type" onchange="select_geom(this)" class="span4">
                  <option value="2" selected="selected">Цэгэн мэдээлэл DD форматаас</option>
                  <option value="3">Цэгэн мэдээлэл DMS форматаас</option>
                </select>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group" id="geom_2">
              <label class="control-label"></label>
              <div class="controls">
                <table id="points">
                  <tr>
                    <td>Өргөрөг :
                      <input type="text" name="y_coord" id="y_coord" class="span2" value="<?php echo $row[$i]["geomy"]; ?>"/></td>
                    <td>Уртраг :
                      <input type="text" name="x_coord" id="x_coord" class="span2" value="<?php echo $row[$i]["geomx"]; ?>"/></td>
                  </tr>
                </table>
                <span class="help-inline">Газарзүйн солбицлыг DD буюу Decimal Degree форматаар заавал оруулах ёстой.</span> </div>
            </div>
            <div class="control-group" id="geom_3" hidden="hidden">
              <label class="control-label"></label>
              <div class="controls">
                <table>
                  <tr>
                    <td colspan="6">Өргөрөг:</td>
                  </tr>
                  <tr>
                    <td>Градус</td>
                    <td><input type="text" name="y_coordinate_deg" id="y_coordinate_deg" value="<?php echo $y_coordinate_deg; ?>"/></td>
                    <td>Минут</td>
                    <td><input type="text" name="y_coordinate_min" id="y_coordinate_min" value="<?php echo $y_coordinate_min; ?>"/></td>
                    <td>Секунд</td>
                    <td><input type="text" name="y_coordinate_sec" id="y_coordinate_sec" value="<?php echo $y_coordinate_sec; ?>"/></td>
                  </tr>
                  <tr>
                    <td colspan="6">Уртраг:</td>
                  </tr>
                  <tr>
                    <td>Градус</td>
                    <td><input type="text" name="x_coordinate_deg" id="x_coordinate_deg" value="<?php echo $x_coordinate_deg; ?>"/></td>
                    <td>Минут</td>
                    <td><input type="text" name="x_coordinate_min" id="x_coordinate_min" value="<?php echo $x_coordinate_min; ?>"/></td>
                    <td>Секунд</td>
                    <td><input type="text" name="x_coordinate_sec" id="x_coordinate_sec" value="<?php echo $x_coordinate_sec; ?>"/></td>
                  </tr>
                </table>
                <span class="help-inline">Координатын проекцын нэрийг автоматаар WGS84 гэж тооцно. Газарзүйн солбицлыг DMS буюу Degree Minute Second форматаар оруулна. Өргөрөгийн градусын хэмжээ 40 - 55 хооронд байна. 2 тэмдэгтээс хэтэрч болохгүй. Өргөрөгийн минутын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Өргөрөгийн секундын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Уртрагын градусын хэмжээ 85 - 125 хооронд байна. 3 тэмдэгтээс хэтэрч болохгүй. Уртрагын минутын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Уртрагын секундын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. </span> </div>
            </div>
            <input type="hidden" id="updateherbariumbttn" name="updateherbariumbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="updatesubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <button class="btn btn-danger"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</button>
            </div>
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
$notify = "Таны хандалт буруу байна. <a href=\"" . $my_url . $my_page . $search_url . $sort_url . "\">Буцах</a>";
show_notification("error", "", $notify);
}
?>
