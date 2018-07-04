<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 11, 2)) {
require("calendar/classes/tc_calendar.php");
?>
<script language="JavaScript" type="text/javascript">
    function addsubmitform()
    {
        if (document.getElementById("contagion_date").value == "") {
            alert("Зураг авсан огноог оруулна уу");
        } else {
            document.getElementById("insertcontagionbttn").value = "1";
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
      
    }
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 110); ?> бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
        <div class="control-group">
              <label  class="control-label">Хүрээний нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tapn.phylum_code, tapn.phylum_name_mn||' - '||tapn.phylum_name as phylum_name FROM ".$schemas.".taphylumname tapn";
					$sortQuery = "ORDER BY tapn.phylum_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("phylum_code_species", "span4", $rows, "phylum_code", "phylum_name", $rows[0]["phylum_code"]);
					$phylum_code =  $rows[0]["phylum_code"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label">Багийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "taon.order_code, taon.order_name_mn||' - '||taon.order_name as order_name FROM ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.phylum_code = ".$phylum_code;
					$sortQuery = "ORDER BY taon.order_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("order_code_species", "span4", $rows, "order_code", "order_name", $rows[0]["order_code"]);
					$order_code =  $rows[0]["order_code"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label">Овгийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tafn.family_code, tafn.family_name_mn||' - '||tafn.family_name as family_name FROM ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon WHERE tafn.order_code = taon.order_code AND taon.order_code = ".$order_code;
					$sortQuery = "ORDER BY tafn.family_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;
					$rows = $db->query($selQuery);
					echo seldatadb("family_code_species", "span4", $rows, "family_code", "family_name", $rows[0]["family_code"]);
					$family_code =  $rows[0]["family_code"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label">Төрлийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tagn.genus_code, tagn.genus_name_mn||' - '||tagn.genus_name as genus_name FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn WHERE tagn.family_code = tafn.family_code AND tafn.family_code = ".$family_code;
					$sortQuery = "ORDER BY tagn.genus_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("genus_code", "span4", $rows, "genus_code", "genus_name", $rows[0]["genus_code"]);
					$genus_code =  $rows[0]["genus_code"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label">Зүйлийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tapl.species_code, tapl.species_name_mn||' - '||tapl.species_name as species_name FROM ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn WHERE tagn.genus_code = tapl.genus_code AND tagn.genus_code = ".$genus_code;
					$sortQuery = "ORDER BY tapl.species_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;
					$rows = $db->query($selQuery);
					if(!empty($rows))
					echo seldatadb("species_code", "span4", $rows, "species_code", "species_name", $rows[0]["species_code"]);
					else 
					echo seldatadb("species_code", "span4", $rows, "species_code", "species_name", null);
				
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" id="lbl">Халдварт өвчин  гарсан огноо:</label>
              <div class="controls">
                <?php
				$myCalendar1 = new tc_calendar("contagion_date", true);
				$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
				$myCalendar1->setDate(date('d', strtotime("now")), date('m', strtotime("now")), date('Y', strtotime("now")));
				$myCalendar1->setPath("calendar/");
				$calendarendyear = date('Y', strtotime("now"));
				$calendarstartyear = $calendarendyear - 70;
				$calendarstartdate = $calendarstartyear."-01-01";
				$calendarenddate = $calendarendyear."-12-31";
				$myCalendar1->setYearInterval($calendarstartyear, $calendarendyear);
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
					echo seldatadb("aimag_name", "span3", $rows, "aimag_code", "aimag_name_mn", $rows[0]["aimag_code"]);
					$aimagcode = $rows[0]["aimag_code"];
					?>
              </div>
              </br>
              <label class="control-label">Сумын нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT vs.soum_code, vs.soum_name_mn soum_name_mn FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";			
					$rows = $db->query($selQuery);
					echo seldatadb("soum_name", "span4", $rows, "soum_code", "soum_name_mn", $rows[0]["soum_code"]);
					?>
              </div>
            </div>
           <div class="control-group ">
            <label class="control-label" id="lbl">Халдварт өвчин  гарсан газрын нэр:</label>
            <div class="controls">
              <textarea name="place_name" id="place_name" rows="1" class="span4" ></textarea>
               <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй. </span> </div>
          </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Халдварт өвчний нэр:</label>
            <div class="controls">
			  <textarea name="contagion_name" id="contagion_name" rows="1" class="span4" ></textarea>
               <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span>  </div>
          </div>
          
          <div class="control-group ">
            <label class="control-label" id="lbl">Халдварт өвчинд нэрвэгдсэн хүний тоо:</label>
            <div class="controls">
               <input type="text" name="sick_number" id="sick_number" class="span4"/>
               <span class="help-inline">Бүхэл тоо байна.</span> </div>
          </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Халдварт өвчний улмаас нас барсан тоо:</label>
            <div class="controls">
              <input type="text" name="dead_number" id="dead_number" class="span4"/>
               <span class="help-inline">Бүхэл тоо байна.</span>  </div>
          </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Зарцуулсан зардлын хэмжээ, мян төг:</label>
            <div class="controls">
              <input type="text" name="total_expense" id="total_expense" class="span4"/>
               <span class="help-inline">Бутархай тоо байна.</span>  </div>
          </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Нэмэлт мэдээлэл:</label>
            <div class="controls">
              <textarea name="additional_info" id="additional_info" rows="3" class="span4" ></textarea>
               <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span>  </div>
          </div>      
            <div class="control-group">
              <label  class="control-label">Координатын проекцын нэр:</label>
              <div class="controls">
                <?php
                echo seldata("geom_srid", "span3", $GEOMETRY_SRID, 4326);
                ?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label  class="control-label" for="textarea">Координат оруулах хэлбэр:</label>
              <div class="controls">
                <select name="geom_type" id="geom_type" onchange="select_geom(this)" class="span5">
                  <option value="2" selected="selected">Цэгэн мэдээлэл DD форматаас</option>
                  <option value="3" >Цэгэн мэдээлэл DMS форматаас</option>
                </select></div>
            </div>
            <div class="control-group" id="geom_2">
              <label  class="control-label"></label>
              <div class="controls">
                <table id="points">
                  <tr>
                    <td>Өргөрөг :
                      <input type="text" name="y_coord" id="y_coord" class="span2"/></td>
                    <td>Уртраг :
                      <input type="text" name="x_coord" id="x_coord" class="span2"/></td>
                  </tr>
                </table>
                <span class="help-inline">Газарзүйн мэдээллийг DD буюу Decimal Degree форматаар заавал оруулах ёстой.</span> </div>
            </div>
            <div class="control-group" id="geom_3" hidden="hidden">
              <label  class="control-label"></label>
              <div class="controls">
                <table id="points">
                  <tr>
                    <td colspan="6">Өргөрөг:</td>
                  </tr>
                  <tr>
                    <td>Градус</td>
                    <td><input type="text" name="y_coordinate_deg" id="y_coordinate_deg" /></td>
                    <td>Минут</td>
                    <td><input type="text" name="y_coordinate_min" id="y_coordinate_min" /></td>
                    <td>Секунд</td>
                    <td><input type="text" name="y_coordinate_sec" id="y_coordinate_sec" /></td>
                  </tr>
                  <tr>
                    <td colspan="6">Уртраг:</td>
                  </tr>
                  <tr>
                    <td>Градус</td>
                    <td><input type="text" name="x_coordinate_deg" id="x_coordinate_deg" /></td>
                    <td>Минут</td>
                    <td><input type="text" name="x_coordinate_min" id="x_coordinate_min" /></td>
                    <td>Секунд</td>
                    <td><input type="text" name="x_coordinate_sec" id="x_coordinate_sec" /></td>
                  </tr>
                </table>
                <span class="help-inline">Координатын проекцын нэрийг автоматаар WGS84 гэж тооцно. Газарзүйн мэдээллийг DMS буюу Degree Minute Second форматаар оруулна. Өргөрөгийн градусын хэмжээ 40 - 55 хооронд байна. 2 тэмдэгтээс хэтэрч болохгүй. Өргөрөгийн минутын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Өргөрөгийн секундын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Уртрагын градусын хэмжээ 85 - 125 хооронд байна. 3 тэмдэгтээс хэтэрч болохгүй. Уртрагын минутын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Уртрагын секундын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. </span> </div>
            </div>
            <input type="hidden" id="insertcontagionbttn" name="insertcontagionbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="addsubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a> </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
} else {
$notify = "Таны хандалт буруу байна. <a href=\"" . $my_url . $my_page . $search_url . $sort_url . "\">Буцах</a>";
show_notification("error", "", $notify);
}
?>
