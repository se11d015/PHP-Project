<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) {
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
	if (document.getElementById("species_names").value == "") {
    alert("Зүйлсийн нэрс оруулна уу");
} else if (document.getElementById("zone_name").value == "") {
    alert("Бүсийн нэр оруулна уу");
} else if (document.getElementById("zone_year").value==""){
		alert( "Бүсийн  зургийг хийсэн оноо оруулна уу" );
	}else {
        document.getElementById("insertanimalzonebttn").value = "1";
        document.mainform.submit();
    }
}
function select_geom(selectobj)
{
	if (selectobj[selectobj.selectedIndex].value=="2")
	{
		document.getElementById("geom_2").hidden = false;
		document.getElementById("geom_3").hidden= true;
		document.getElementById("geom_4").hidden= true;
	}
	if (selectobj[selectobj.selectedIndex].value=="3")
	{
		document.getElementById("geom_2").hidden= true;
		document.getElementById("geom_3").hidden = false;
		document.getElementById("geom_4").hidden= true;
	}
	if (selectobj[selectobj.selectedIndex].value=="4")
	{
		document.getElementById("geom_2").hidden= true;
		document.getElementById("geom_3").hidden= true;
		document.getElementById("geom_4").hidden = false;
	}
}

</script>

<div class="add-table">
<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th><?php echo getdata($ITEM_TYPE, 19); ?> бүртгэх хэсэг</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
        
            <div class="control-group">
              <label class="control-label">Хүрээний нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tapn.phylum_code, tapn.phylum_name_mn||' - '||tapn.phylum_name as phylum_name FROM ".$schemas.".taphylumname tapn";
					$sortQuery = "ORDER BY tapn.phylum_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("phylum_code", "span4", $rows, "phylum_code", "phylum_name", $rows[0]["phylum_code"]);
					$phylum_code =  $rows[0]["phylum_code"];
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tacn.class_code, tacn.class_name_mn||' - '||tacn.class_name as class_name FROM ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE tacn.phylum_code = tapn.phylum_code AND tapn.phylum_code = ".$phylum_code;
					$sortQuery = "ORDER BY tacn.class_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					if(!empty($rows))
						echo seldatadb("class_code", "span4", $rows, "class_code", "class_name", $rows[0]["class_code"]);
					else
						echo seldatadb("class_code", "span4", $rows, "class_code", "class_name", NULL);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
			<div class="control-group">
                    <label class="control-label">Зүйлийн нэрc:</label>
                    <div class="controls">
                         <textarea name="species_names" id="species_names" rows="1" class="span5"></textarea>					   
					   <span class="help-inline"> 250 Тэмдэгтэд багтаана.</span> </div>
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
			   <div class="control-group">
                    <label class="control-label">Бүсийн нэр:</label>
                    <div class="controls">
                         <textarea name="zone_name" id="zone_name" rows="1" class="span5"></textarea>					   
					   <span class="help-inline"> 150 Тэмдэгтэд багтаана.</span> </div>
                 </div>
			    <div class="control-group">
                    <label class="control-label">Бүсийн зургийг хийсэн он:</label>
                    <div class="controls">
                       <input type="text" class="span2"name="zone_year" id="zone_year"/> 
					   <span class="help-inline">   Бүхэл тоо байна.</span> </div>					
                       </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Бүсийн зургийн хийсэн байгууллагын нэр:</label>
                    <div class="controls">
                        <textarea name="org_name" id="org_name" rows="3" class="span5"></textarea>
                        <span class="help-inline"> 250 Тэмдэгтэд багтаана.</span> </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Тархсан байршлын нэр:</label>
                    <div class="controls">
                        <textarea name="place_name" id="place_name" rows="3" class="span5"></textarea>
                        <span class="help-inline"> 250 Тэмдэгтэд багтаана.</span> </div>
                </div>                
                <div class="control-group">
                    <label class="control-label">Нэмэлт мэдээлэл:</label>
                    <div class="controls">
                        <textarea name="additional_info" id="additional_info" rows="3" class="span5"></textarea>
                        <span class="help-inline"> Тэмдэгтийн тоо хязгааргүй</span> </div>
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
                  <option value="2" selected="selected">Полигон мэдээлэл DD форматаар оруулах</option>
                  <option value="3">Полигон мэдээлэл текст файлаар оруулах</option>
                  <option value="4">Geom форматаар оруулах</option>
                </select>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group" id="geom_2">
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

                    <input type="hidden" id="insertanimalzonebttn" name="insertanimalzonebttn" value="0"/>
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
$notify = "Таны хандалт буруу байна.";
show_notification("error", "", $notify);
}
?>
