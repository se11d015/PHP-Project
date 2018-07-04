<?php //
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) {
require("calendar/classes/tc_calendar.php");
if (isset($_GET["gid"])) {
$gid = (int) $_GET["gid"];
} else {
$gid = 0;
}

$i = 0;

$startQuery = "SELECT";

$valueQuery = "tgazo.*,  takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taaim.aimag_name_mn, tasou.soum_name_mn  FROM ".$schemas.".tganimalzone tgazo, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas.".takingdomname takn,".$schemas.".taphylumname tapn,".$schemas.".taclassname tacn";

if ($sess_profile == 1)
$whereQuery = "WHERE tgazo.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taaim.aimag_code=tgazo.aimag_name AND tasou.soum_code=tgazo.soum_name AND tgazo.gid = " . $gid;
else
$whereQuery = "WHERE tgazo.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taaim.aimag_code=tgazo.aimag_name AND tasou.soum_code=tgazo.soum_name AND tgazo.gid = " . $gid . " AND  tgazo.user_id = " . $sess_user_id;

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
$row = $db->query($selQuery);

if (!empty($row)) {

?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
if (document.getElementById("species_names").value == "") {
    alert("Зүйлсийн нэрс оруулна уу");
} else if (document.getElementById("zone_name").value == "") {
    alert("Бүсийн нэр оруулна уу");
} else if (document.getElementById("zone_year").value==""){
		alert( "Бүсийн  зургийг хийсэн оноо оруулна уу" );
	}else {
    document.getElementById("updateanimalzonebttn").value = "1";
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
        }
        if (selectobj[selectobj.selectedIndex].value == "3")
        {
            document.getElementById("geom_2").hidden = true;
            document.getElementById("geom_3").hidden = false;
            document.getElementById("geom_4").hidden = true;
        }
        if (selectobj[selectobj.selectedIndex].value == "4")
        {
            document.getElementById("geom_2").hidden = true;
            document.getElementById("geom_3").hidden = true;
            document.getElementById("geom_4").hidden = false;
        }
		if (selectobj[selectobj.selectedIndex].value=="5")
		{
			document.getElementById("geom_2").hidden= true;
			document.getElementById("geom_3").hidden= true;
			document.getElementById("geom_4").hidden = true;
		}	
}
</script>

<div class="add-table">


<table class="table table-bordered table-condensed">
<thead>
    <tr>
        <th><?php echo getdata($ITEM_TYPE, 19); ?> засах хэсэг</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
                <input type="hidden" name="gid" id="gid" value="<?php echo $row[$i]["gid"]; ?>">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">	
                <input type="hidden" name="class_code" id="class_code" value="<?php echo $row[$i]["class_code"]; ?>">	
                <div class="control-group">
              <label class="control-label">Аймгийн нэр:</label>
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
              <label class="control-label">Хүрээний нэр:</label>
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
              <label class="control-label">Ангийн нэр:</label>
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
                    <label class="control-label">Зүйлийн нэрc:</label>
                    <div class="controls">
                         <textarea name="species_names" id="species_names" rows="1" class="span5"><?php echo $row[$i]["species_names"]; ?></textarea>					   
					   <span class="help-inline"> 250 Тэмдэгтэд багтаана.</span> </div>
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
                    <label class="control-label">Бүсийн нэр:</label>
                    <div class="controls">
                         <textarea name="zone_name" id="zone_name" rows="1" class="span5"><?php echo $row[$i]["zone_name"]; ?></textarea>					   
					   <span class="help-inline"> 150 Тэмдэгтэд багтаана.</span> </div>
                 </div>
			    <div class="control-group">
                    <label class="control-label">Бүсийн зургийг хийсэн он:</label>
                    <div class="controls">
                       <input type="text" class="span2"name="zone_year" id="zone_year" value="<?php echo $row[$i]["zone_year"]; ?>"/> 
					   <span class="help-inline">   Бүхэл тоо байна.</span> </div>					
                       </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Бүсийн зургийн хийсэн байгууллагын нэр:</label>
                    <div class="controls">
                        <textarea name="org_name" id="org_name" rows="3" class="span5"><?php echo $row[$i]["org_name"]; ?></textarea>
                        <span class="help-inline"> 250 Тэмдэгтэд багтаана.</span> </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Тархсан байршлын нэр:</label>
                    <div class="controls">
                        <textarea name="place_name" id="place_name" rows="3" class="span5"><?php echo $row[$i]["place_name"]; ?></textarea>
                        <span class="help-inline"> 250 Тэмдэгтэд багтаана.</span> </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Нэмэлт мэдээлэл:</label>
                    <div class="controls">
					    <textarea name="additional_info" id="additional_info" rows="3" class="span5"><?php echo $row[$i]["additional_info"]; ?></textarea>
                        <span class="help-inline"> Тэмдэгтийн тоо хязгааргүй.</span> </div>
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
                  <option value="5" selected="selected">Координатын мэдээлэлд өөрчлөлт орохгүй</option>
                  <option value="2">Полигон мэдээлэл DD форматаар оруулах</option>
                  <option value="3">Полигон мэдээлэл текст файлаар оруулах</option>
                  <option value="4">Geom форматаар оруулах</option>
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
                <input type="hidden" id="updateanimalzonebttn" name="updateanimalzonebttn" value="0"/>
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
