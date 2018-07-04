<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 2)) {
require("calendar/classes/tc_calendar.php");

if (isset($_GET["contagion_id"])) {
$contagion_id = (int) $_GET["contagion_id"];
} else {
$contagion_id = 0;
}

$i = 0;

$startQuery = "SELECT";

$valueQuery = "tgaco.*, tgaco.species_name as species_name_code, st_x(tgaco.geom) as geomx, st_y(tgaco.geom) as geomy,  takn.kingdom_code, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, 
takn.kingdom_name_ru, tapn.phylum_code, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_code, tacn.class_name, tacn.class_name_mn, 
tacn.class_name_en, tacn.class_name_ru, taon.order_code, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru,  tafn.family_code, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_code, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl," . $schemas . ".tganimalcontagion tgaco ";

	if ($sess_profile == 1) {
		$whereQuery = "WHERE tapl.species_code = tgaco.species_name AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code  AND tgaco.contagion_id = " . $contagion_id;
	} 
	else {
		$whereQuery = "WHERE  tapl.species_code = tgaco.species_name AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code  AND tgaco.contagion_id = " . $contagion_id . " AND tgaco.user_id = " . $sess_user_id;
		
	}
	
$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
//echo $selQuery;
$row = $db->query($selQuery);

if (!empty($row)) {

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
    if (document.getElementById("place_name").value == "") {
        alert("Газрын нэр оруулна уу");
    } else {
        document.getElementById("updatecontagionbttn").value = "1";
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
      <th><?php echo getdata($ITEM_TYPE, 110); ?> засварлах хэсэг</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
          <input type="hidden" name="contagion_id" id="contagion_id" value="<?php echo $row[$i]["contagion_id"]; ?>">
          <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
          <input type="hidden" name="species_code" id="species_code" value="<?php echo $row[$i]["species_name_code"]; ?>">
          <div class="control-group">
              <label   class="control-label">Аймгийн нэр:</label>
              <div class="controls" >
                <?php 
			if(!empty($row[$i]["kingdom_name"])) echo $row[$i]["kingdom_name"]; 
			if(!empty($row[$i]["kingdom_name_mn"])) echo " - ".$row[$i]["kingdom_name_mn"]; 
			if(!empty($row[$i]["kingdom_name_en"])) echo " - ".$row[$i]["kingdom_name_en"]; 
			if(!empty($row[$i]["kingdom_name_ru"])) echo " - ".$row[$i]["kingdom_name_ru"];
			?>
              </div>
            </div>
            <div class="control-group">
              <label   class="control-label">Хүрээний нэр:</label>
              <div class="controls" >
                <?php 
			if(!empty($row[$i]["phylum_name"])) echo $row[$i]["phylum_name"]; 
			if(!empty($row[$i]["phylum_name_mn"])) echo " - ".$row[$i]["phylum_name_mn"]; 
			if(!empty($row[$i]["phylum_name_en"])) echo " - ".$row[$i]["phylum_name_en"]; 
			if(!empty($row[$i]["phylum_name_ru"])) echo " - ".$row[$i]["phylum_name_ru"];
			?>
              </div>
            </div>
            <div class="control-group">
              <label   class="control-label">Ангийн нэр:</label>
              <div class="controls" >
                <?php 
			if(!empty($row[$i]["class_name"])) echo $row[$i]["class_name"]; 
			if(!empty($row[$i]["class_name_mn"])) echo " - ".$row[$i]["class_name_mn"]; 
			if(!empty($row[$i]["class_name_en"])) echo " - ".$row[$i]["class_name_en"]; 
			if(!empty($row[$i]["class_name_ru"])) echo " - ".$row[$i]["class_name_ru"];
			?>
              </div>
            </div>
            <div class="control-group">
              <label   class="control-label">Багийн нэр:</label>
              <div class="controls" >
                <?php 
			if(!empty($row[$i]["order_name"])) echo $row[$i]["order_name"]; 
			if(!empty($row[$i]["order_name_mn"])) echo " - ".$row[$i]["order_name_mn"]; 
			if(!empty($row[$i]["order_name_en"])) echo " - ".$row[$i]["order_name_en"]; 
			if(!empty($row[$i]["order_name_ru"])) echo " - ".$row[$i]["order_name_ru"];
			?>
              </div>
            </div>
            <div class="control-group">
              <label   class="control-label">Овгийн нэр:</label>
              <div class="controls" >
                <?php 
			if(!empty($row[$i]["family_name"])) echo $row[$i]["family_name"]; 
			if(!empty($row[$i]["family_name_mn"])) echo " - ".$row[$i]["family_name_mn"]; 
			if(!empty($row[$i]["family_name_en"])) echo " - ".$row[$i]["family_name_en"]; 
			if(!empty($row[$i]["family_name_ru"])) echo " - ".$row[$i]["family_name_ru"];
			?>
              </div>
            </div>
            <div class="control-group">
              <label   class="control-label">Төрлийн нэр:</label>
              <div class="controls" >
                <?php 
			if(!empty($row[$i]["genus_name"])) echo $row[$i]["genus_name"]; 
			if(!empty($row[$i]["genus_name_mn"])) echo " - ".$row[$i]["genus_name_mn"]; 
			if(!empty($row[$i]["genus_name_en"])) echo " - ".$row[$i]["genus_name_en"]; 
			if(!empty($row[$i]["genus_name_ru"])) echo " - ".$row[$i]["genus_name_ru"];
			?>
              </div>
            </div>
            <div class="control-group">
              <label   class="control-label">Зүйлийн нэр:</label>
              <div class="controls" >
                <?php 
			if(!empty($row[$i]["species_name"])) echo $row[$i]["species_name"]; 
			if(!empty($row[$i]["species_name_mn"])) echo " - ".$row[$i]["species_name_mn"]; 
			if(!empty($row[$i]["species_name_en"])) echo " - ".$row[$i]["species_name_en"]; 
			if(!empty($row[$i]["species_name_ru"])) echo " - ".$row[$i]["species_name_ru"];
			?>
              </div>
            </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Халдварт өвчин  гарсан огноо:</label>
            <div class="controls">
              <?php
                            $myCalendar1 = new tc_calendar("contagion_date", true);
                            $contagion_date = $row[$i]["contagion_date"];
                            $myCalendar1->setIcon("calendar/images/iconCalendar.gif");
                            $myCalendar1->setDate(date('d', strtotime($contagion_date)), date('m', strtotime($contagion_date)), date('Y', strtotime($contagion_date)));
                            $myCalendar1->setPath("calendar/");
                            $myCalendar1->setYearInterval(1990, 2014);
                            $myCalendar1->dateAllow('1990-01-01', '2014-12-31');
                            $myCalendar1->setDateFormat('Y-m-d');
                            $myCalendar1->setAlignment('left', 'bottom');
                            $myCalendar1->writeScript();
                            ?>
            </div>
          </div>
		  <div class="control-group">
            <label class="control-label">Аймгийн нэр:</label>
            <div class="controls">
              <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("aimag_name", "span3", $rows, "aimag_code", "aimag_name_mn", $row[$i]["aimag_name"]);
					$aimagcode = $rows[0]["aimag_code"];
					?>
            </div>
            </br>
            <label class="control-label">Сумын нэр:</label>
            <div class="controls">
              <?php
					$selQuery = "SELECT vs.soum_code, vs.soum_name_mn soum_name_mn FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";			
					$rows = $db->query($selQuery);
					echo seldatadb("soum_name", "span4", $rows, "soum_code", "soum_name_mn", $row[$i]["soum_name"]);
					?>
            </div>
          </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Халдварт өвчин  гарсан газрын нэр:</label>
            <div class="controls">
              <textarea name="place_name" id="place_name" rows="1" class="span4" > <?php echo $row[$i]["place_name"]; ?></textarea>
              <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй.</span> </div>
          </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Халдварт өвчний нэр:</label>
            <div class="controls">
			  <textarea name="contagion_name" id="contagion_name" rows="1" class="span4" > <?php echo $row[$i]["contagion_name"]; ?></textarea>
              <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span> </div>
          </div>
          
          <div class="control-group ">
            <label class="control-label" id="lbl">Халдварт өвчинд нэрвэгдсэн хүний тоо:</label>
            <div class="controls">
               <input type="text" name="sick_number" id="sick_number" class="span4"  value="<?php echo $row[$i]["sick_number"]; ?>"/>
              <span class="help-inline">Бүхэл тоо байна.</span> </div>
          </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Халдварт өвчний улмаас нас барсан тоо:</label>
            <div class="controls">
              <input type="text" name="dead_number" id="dead_number" class="span4"  value="<?php echo $row[$i]["dead_number"]; ?>"/>
              <span class="help-inline">Бүхэл тоо байна.</span> </div>
          </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Зарцуулсан зардлын хэмжээ, мян төг:</label>
            <div class="controls">
              <input type="text" name="total_expense" id="total_expense" class="span4"  value="<?php echo $row[$i]["total_expense"]; ?>"/>
              <span class="help-inline">Бутархай тоо байна. </span> </div>
          </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Нэмэлт мэдээлэл:</label>
            <div class="controls">
              <textarea name="additional_info" id="additional_info" rows="3" class="span4" > <?php echo $row[$i]["additional_info"]; ?></textarea>
              <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
          </div>      
           <div class="control-group">
              <label   class="control-label">Координатын проекцын нэр:</label>
              <div class="controls">
                <?php
					echo seldata("geom_srid", "span3", $GEOMETRY_SRID, 4326);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label   class="control-label" for="textarea">Координат оруулах хэлбэр:</label>
              <div class="controls">
                <select name="geom_type" id="geom_type" onchange="select_geom(this)" class="span5">
                  <option value="2" selected="selected">Цэгэн мэдээлэл DD форматаас</option>
                  <option value="3" >Цэгэн мэдээлэл DMS форматаас</option>
                </select>
              </div>
            </div>
            <div class="control-group" id="geom_2">
              <label   class="control-label"></label>
              <div class="controls">
                <table id="points">
                  <tr>
                    <td>Өргөрөг :
                      <input type="text" name="y_coord" id="y_coord" class="span2" value="<?php echo $row[$i]["geomy"]; ?>"/></td>
                    <td>Уртраг :
                      <input type="text" name="x_coord" id="x_coord" class="span2" value="<?php echo $row[$i]["geomx"]; ?>"/></td>
                  </tr>
                </table>
                <span class="help-inline">Газарзүйн мэдээллийг DD буюу Decimal Degree форматаар заавал оруулах ёстой.</span> </div>
            </div>
            <div class="control-group" id="geom_3" hidden="hidden">
              <label   class="control-label"></label>
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
                    <td><input type="text" name="y_coordinate_sec" id="y_coordinate_sec" value="<?php echo $y_coordinate_sec; ?>" /></td>
                  </tr>
                  <tr>
                    <td colspan="6">Уртраг:</td>
                  </tr>
                  <tr>
                    <td>Градус</td>
                    <td><input type="text" name="x_coordinate_deg" id="x_coordinate_deg" value="<?php echo $x_coordinate_deg; ?>" /></td>
                    <td>Минут</td>
                    <td><input type="text" name="x_coordinate_min" id="x_coordinate_min" value="<?php echo $x_coordinate_min; ?>" /></td>
                    <td>Секунд</td>
                    <td><input type="text" name="x_coordinate_sec" id="x_coordinate_sec" value="<?php echo $x_coordinate_sec; ?>" /></td>
                  </tr>
                </table>
                <span class="help-inline">Координатын проекцын нэрийг автоматаар WGS84 гэж тооцно. Газарзүйн мэдээллийг DMS буюу Degree Minute Second форматаар оруулна. Өргөрөгийн градусын хэмжээ 40 - 55 хооронд байна. 2 тэмдэгтээс хэтэрч болохгүй. Өргөрөгийн минутын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Өргөрөгийн секундын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Уртрагын градусын хэмжээ 85 - 125 хооронд байна. 3 тэмдэгтээс хэтэрч болохгүй. Уртрагын минутын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Уртрагын секундын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. </span> </div>
            </div>
          <input type="hidden" id="updatecontagionbttn" name="updatecontagionbttn" value="0"/>
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
