<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) {
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
	if (document.getElementById("gyear").value == "") {
        alert("Газрын зургийг хийсэн оноо оруулна уу");
  	}else if (document.getElementById("phylum_code_species").value==""){
		alert( "Хүрээний латин нэрийг оруулна уу" );
	}else if (document.getElementById("order_code_species").value==""){
		alert( "Багийн латин нэрийг оруулна уу" );
	}else if (document.getElementById("family_code_species").value==""){
		alert( "Овгийн латин нэрийг оруулна уу" );
	}else if (document.getElementById("genus_code").value==""){
		alert( "Төрлийн кодыг оруулна уу" );
	}else if (document.getElementById("species_code").value==""){
		alert( "Зүйлийн кодыг оруулна уу" );
	}
    else {
        document.getElementById("insertanimalhabitatbttn").value = "1";
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
            <th><?php echo getdata($ITEM_TYPE, 13); ?> бүртгэх хэсэг</th>
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
					echo seldatadb("phylum_code_species", "span4", $rows, "phylum_code", "phylum_name", $rows[0]["phylum_code"]);
					$phylum_code =  $rows[0]["phylum_code"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн нэр:</label>
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
              <label class="control-label">Овгийн нэр:</label>
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
              <label class="control-label">Төрлийн нэр:</label>
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
              <label class="control-label">Зүйлийн нэр:</label>
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
						echo seldatadb("species_code", "span4", $rows, "species_code", "species_name", NULL);			
					?>
              </div>
            </div>
                    <div class="control-group">
                    <label class="control-label">Тархацын зургийг хийсэн он:</label>
                    <div class="controls">
                       <input type="text" class="span2"name="gyear" id="gyear"/> 
					    <span class="help-inline">Бүхэл тоо байна.</span> </div>
                       </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Тархацын зургийн хийсэн байгууллагын нэр:</label>
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
           

                    <input type="hidden" id="insertanimalhabitatbttn" name="insertanimalhabitatbttn" value="0"/>
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
