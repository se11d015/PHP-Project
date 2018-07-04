<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 2))
{
	require("calendar/classes/tc_calendar.php");						
	if (isset($_GET["protect_id"]))
	{
		$protect_id = (int) $_GET["protect_id"];
	}else
	{
		$protect_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "tgpp.*, tcpt.type_name, vas.aimag_name_mn, vas.soum_name_mn FROM ".$schemas.".tganimalprotection tgpp, ".$schemas.".tcprotectiontype tcpt, scadministrative.vasoumname vas ";
	
	if($sess_profile==1)
		$whereQuery = "WHERE tgpp.protect_type = tcpt.type_id AND tgpp.soum_name = vas.soum_code AND tgpp.protect_id = ".$protect_id."";
	else
		$whereQuery = "WHERE tgpp.protect_type = tcpt.type_id AND tgpp.soum_name = vas.soum_code AND tgpp.protect_id = ".$protect_id." AND tgpp.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{	if (document.getElementById("protect_type").value==""){
		alert( "Хамгаалах арга хэмжээний төрлийг оруулна уу" );
	}else if (document.getElementById("protect_date").value==""){
		alert( "Хамгаалах арга хэмжээний авсан огноог оруулна уу" );
	}else if (document.getElementById("protect_org").value==""){
		alert( "Хамгаалах арга хэмжээ авсан байгууллагын нэрийг оруулна уу" );
	}else if (document.getElementById("place_name").value==""){
		alert( "Хамгаалах арга хэмжээний авсан газрын нэрийг оруулна уу" );
	}else {
		document.getElementById("updateanimalprotectionbttn").value = "1";
		document.mainform.submit();
	}
}
function select_geom(selectobj)
    {
        if (selectobj[selectobj.selectedIndex].value == "2")
        {
            document.getElementById("geom_2").hidden = false;
            document.getElementById("geom_3").hidden = true;
            document.getElementById("geom_4").hidden = true;
            document.getElementById("geom_5").hidden = true;
            document.getElementById("geom_6").hidden = true;
        }
        if (selectobj[selectobj.selectedIndex].value == "3")
        {
            document.getElementById("geom_2").hidden = true;
            document.getElementById("geom_3").hidden = false;
            document.getElementById("geom_4").hidden = true;
            document.getElementById("geom_5").hidden = true;
            document.getElementById("geom_6").hidden = true;
        }
        if (selectobj[selectobj.selectedIndex].value == "4")
        {
            document.getElementById("geom_2").hidden = true;
            document.getElementById("geom_3").hidden = true;
            document.getElementById("geom_4").hidden = false;
            document.getElementById("geom_5").hidden = true;
            document.getElementById("geom_6").hidden = true;
        }
		if (selectobj[selectobj.selectedIndex].value == "5")
        {
            document.getElementById("geom_2").hidden = true;
            document.getElementById("geom_3").hidden = true;
            document.getElementById("geom_4").hidden = true;
            document.getElementById("geom_5").hidden = false;
            document.getElementById("geom_6").hidden = true;
        }
		if (selectobj[selectobj.selectedIndex].value == "6")
        {
            document.getElementById("geom_2").hidden = true;
            document.getElementById("geom_3").hidden = true;
            document.getElementById("geom_4").hidden = true;
            document.getElementById("geom_5").hidden = true;
            document.getElementById("geom_6").hidden = false;
        }
		if (selectobj[selectobj.selectedIndex].value == "7")
        {
            document.getElementById("geom_2").hidden = true;
            document.getElementById("geom_3").hidden = true;
            document.getElementById("geom_4").hidden = true;
            document.getElementById("geom_5").hidden = true;
            document.getElementById("geom_6").hidden = true;
        }
    }
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 50); ?> засах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="protect_id" id="protect_id" value="<?php echo $row[$i]["protect_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="control-group">
              <label class="control-label">Хамгаалах арга хэмжээний төрөл:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tcpt.* FROM ".$schemas.".tcprotectiontype  tcpt";
					$rows = $db->query($selQuery);
					echo seldatadb("protect_type", "span3", $rows, "type_id", "type_name", "7", $row[$i]["protect_type"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хамгаалах арга хэмжээний авсан огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("protect_date", true);
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$protect_date=$row[$i]["protect_date"];
					$myCalendar1->setDate(date('d', strtotime($protect_date)), date('m', strtotime($protect_date)), date('Y', strtotime($protect_date)));
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
              <label class="control-label">Хамгаалах арга хэмжээ авсан байгууллагын нэр:</label>
              <div class="controls">
                <textarea name="protect_org" id="protect_org" rows="3" class="span5"><?php echo $row[$i]["protect_org"]; ?></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хамгаалах арга хэмжээ авсан байгууллагын регистрийн дугаар :</label>
              <div class="controls">
                <input type="text" name="register_number" id="register_number"  class="span3" value="<?php echo $row[$i]["register_number"]; ?>"/>
                <span class="help-inline">20 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Мэргэжлийн эрхийн гэрчилгээний дугаар:</label>
              <div class="controls">
                <input type="text" name="certificate_number" id="certificate_number"  class="span3" value="<?php echo $row[$i]["certificate_number"]; ?>"/>
                <span class="help-inline">20 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Аймгийн нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("aimag_name", "span3", $rows, "aimag_code", "aimag_name_mn", $row[$i]["aimag_name"]);
					$aimagcode = $row[$i]["aimag_name"];
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
              </br>
              <label class="control-label">Сумын нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT vs.soum_code, vs.soum_name_mn soum_name_mn FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";			
					$rows = $db->query($selQuery);
					echo seldatadb("soum_name", "span3", $rows, "soum_code", "soum_name_mn", $row[$i]["soum_name"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хамгаалах арга хэмжээний авсан газрын нэр:</label>
              <div class="controls">
                <textarea name="place_name" id="place_name" rows="3" class="span4"><?php echo $row[$i]["place_name"]; ?></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хамгаалах арга хэмжээний авсан талбайн хэмжээ, га:</label>
              <div class="controls">
                <input type="text" name="protect_area" id="protect_area"  class="span3"  value="<?php echo $row[$i]["protect_area"]; ?>"/>
                <span class="help-inline">Бутархай тоо байна. 11 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хамгаалах арга хэмжээний авсан ажлын хураангуй:</label>
              <div class="controls">
                <textarea name="protect_abstract" id="protect_abstract" rows="3" class="span5"><?php echo $row[$i]["protect_abstract"]; ?></textarea>
                <span class="help-inline"> Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хамгаалах арга хэмжээний авсан ажлын тайлангийн файл:</label>
              <div class="controls">
                <input type="file" name="protect_filename" id="protect_filename"/>
                <span class="help-inline">Файлын өргөтгөл нь .doc, .docx, .pdf байна.</span> </div>
              <?php if(!empty($row[$i]["protect_pathname"]) && !empty($row[$i]["protect_filename"])) { ?>
              <span class="help-inline">Тайлангийн <a href="<?php echo $row[$i]["protect_pathname"].$row[$i]["protect_filename"];?>" target="_blank"><?php echo $row[$i]["protect_filename"];?> </a>файл байна. </span>
              <?php } ?>
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
                  <option value="7" selected="selected">Координатын мэдээлэлд өөрчлөлт орохгүй</option>
                  <option value="2">Полигон мэдээлэл DD форматаар оруулах</option>
                  <option value="3">Полигон мэдээлэл текст файлаар оруулах</option>
                  <option value="4">Geom форматаар оруулах</option>
                  <option value="5">Цэгэн мэдээлэл DD форматаар оруулах</option>
                  <option value="6">Цэгэн мэдээлэл DMS форматаар оруулах </option>
                </select>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group" id="geom_2" hidden="hidden">
              <label class="control-label"></label>
              <div class="controls">
                <table id="points">
                  <tr>
                    <td>Уртраг 1:
                      <input type="text" name="x1" id="x1" class="span3"/></td>
                    <td>Өргөрөг 1:
                      <input type="text" name="y1" id="y1" class="span3"/></td>
                  </tr>
                  <tr>
                    <td>Уртраг 2:
                      <input type="text" name="x2" id="x2" class="span3"/></td>
                    <td>Өргөрөг 2:
                      <input type="text" name="y2" id="y2" class="span3"/></td>
                  </tr>
                  <tr>
                    <td>Уртраг 3:
                      <input type="text" name="x3" id="x3" class="span3"/></td>
                    <td>Өргөрөг 3:
                      <input type="text" name="y3" id="y3" class="span3"/></td>
                  </tr>
                  <tr>
                    <td>Уртраг 4:
                      <input type="text" name="x4" id="x4" class="span3"/></td>
                    <td>Өргөрөг 4:
                      <input type="text" name="y4" id="y4" class="span3"/></td>
                  </tr>
                  <tr>
                    <td>Уртраг 5:
                      <input type="text" name="x5" id="x5" class="span3"/></td>
                    <td>Өргөрөг 5:
                      <input type="text" name="y5" id="y5" class="span3"/></td>
                  </tr>
                  <tr>
                    <td>Уртраг 6:
                      <input type="text" name="x6" id="x6" class="span3"/></td>
                    <td>Өргөрөг 6:
                      <input type="text" name="y6" id="y6" class="span3"/></td>
                  </tr>
                  <tr>
                    <td>Уртраг 7:
                      <input type="text" name="x7" id="x7" class="span3"/></td>
                    <td>Өргөрөг 7:
                      <input type="text" name="y7" id="y7" class="span3"/></td>
                  </tr>
                  <tr>
                    <td>Уртраг 8:
                      <input type="text" name="x8" id="x8" class="span3"/></td>
                    <td>Өргөрөг 8:
                      <input type="text" name="y8" id="y8" class="span3"/></td>
                  </tr>
                  <tr>
                    <td>Уртраг 9:
                      <input type="text" name="x9" id="x9" class="span3"/></td>
                    <td>Өргөрөг 9:
                      <input type="text" name="y9" id="y9" class="span3"/></td>
                  </tr>
                  <tr>
                    <td>Уртраг 10:
                      <input type="text" name="x10" id="x10" class="span3"/></td>
                    <td>Өргөрөг 10:
                      <input type="text" name="y10" id="y10" class="span3"/></td>
                  </tr>
                </table>
                <span class="help-inline">Газарзүйн солбицлыг DD буюу Decimal Degree форматаар заавал оруулах ёстой.</span> </div>
            </div>
            <div class="control-group" id="geom_3" hidden="hidden">
              <label class="control-label">Текст файл:</label>
              <div class="controls">
                <input type="file" name="geom_file" id="geom_file"/>
                <span class="help-inline">Газарзүйн солбицлыг DD буюу Decimal Degree форматаар заавал оруулах ёстой. Файлын өргөтгөл нь .txt байна. Файл нь цэгийн дугаар, уртраг, өргөрөг гэсэн мэдээллийг агуулсан tab delimeted бүхий текстэн файл байна. Browse товчийг ашиглан текстэн файлыг сонгоно.</span> </div>
            </div>
            <div class="control-group" id="geom_4" hidden="hidden">
              <label class="control-label">Geom формат:</label>
              <div class="controls">
                <textarea name="geom_value" id="geom_value" rows="6" class="span5"></textarea>
              </div>
            </div>
            <div class="control-group" id="geom_5" hidden="hidden">
              <label class="control-label"></label>
              <div class="controls">
                <table id="points">
                  <tr>
                    <td>Өргөрөг :
                      <input type="text" name="y_coord" id="y_coord" class="span2"/></td>
                    <td>Уртраг :
                      <input type="text" name="x_coord" id="x_coord" class="span2"/></td>
                  </tr>
                </table>
                <span class="help-inline">Газарзүйн солбицлыг DD буюу Decimal Degree форматаар заавал оруулах ёстой.</span> </div>
            </div>
            <div class="control-group" id="geom_6" hidden="hidden">
              <label class="control-label"></label>
              <div class="controls">
                <table id="points">
                  <tr>
                    <td colspan="6">Өргөрөг:</td>
                  </tr>
                  <tr>
                    <td>Градус</td>
                    <td><input type="text" name="y_coordinate_deg" id="y_coordinate_deg"/></td>
                    <td>Минут</td>
                    <td><input type="text" name="y_coordinate_min" id="y_coordinate_min"/></td>
                    <td>Секунд</td>
                    <td><input type="text" name="y_coordinate_sec" id="y_coordinate_sec"/></td>
                  </tr>
                  <tr>
                    <td colspan="6">Уртраг:</td>
                  </tr>
                  <tr>
                    <td>Градус</td>
                    <td><input type="text" name="x_coordinate_deg" id="x_coordinate_deg"/></td>
                    <td>Минут</td>
                    <td><input type="text" name="x_coordinate_min" id="x_coordinate_min"/></td>
                    <td>Секунд</td>
                    <td><input type="text" name="x_coordinate_sec" id="x_coordinate_sec"/></td>
                  </tr>
                </table>
                <span class="help-inline">Координатын проекцын нэрийг автоматаар WGS84 гэж тооцно. Газарзүйн солбицлыг DMS буюу Degree Minute Second форматаар оруулна. Өргөрөгийн градусын хэмжээ 40 - 55 хооронд байна. 2 тэмдэгтээс хэтэрч болохгүй. Өргөрөгийн минутын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Өргөрөгийн секундын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Уртрагын градусын хэмжээ 85 - 125 хооронд байна. 3 тэмдэгтээс хэтэрч болохгүй. Уртрагын минутын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Уртрагын секундын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. </span> </div>
            </div>
            <input type="hidden" id="protect_filename" name="protect_filename" value="<?php echo $row[$i]["protect_filename"]; ?>"/>
            <input type="hidden" id="protect_pathname" name="protect_pathname" value="<?php echo $row[$i]["protect_pathname"]; ?>"/>
            <input type="hidden" id="updateanimalprotectionbttn" name="updateanimalprotectionbttn" value="0"/>
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
