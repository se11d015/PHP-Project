<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2)) 
{

?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
    if (document.getElementById("org_name").value == "") {
        alert("Байгууллагын нэрийг оруулна уу");
    } else {
        document.getElementById("insertanimalorgbttn").value = "1";
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
        <th><?php echo getdata($ITEM_TYPE, 40); ?> бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <div class="control-group">
              <label class="control-label">Аймгийн нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("aimag_name", "span3", $rows, "aimag_code", "aimag_name_mn", $rows[0]["aimag_code"]);
					$aimagcode = $rows[0]["aimag_code"];
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
              </br>
              <label class="control-label">Сумын нэр:</label>
              <div class="controls">
                <?php
                        $selQuery = "SELECT vs.soum_code, vs.soum_name_mn soum_name_mn FROM scadministrative.vasoumname vs WHERE vs.aimag_code = " . $aimagcode . " ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";
                        $rows = $db->query($selQuery);
                        echo seldatadb("soum_name", "span4", $rows, "soum_code", "soum_name_mn", $rows[0]["soum_code"]);
                        ?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Мэргэжлийн байгууллагын нэр:</label>
              <div class="controls">
                <textarea name="org_name" id="org_name" rows="2" class="span4"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Регистрийн дугаар:</label>
              <div class="controls">
                <input type="text" name="register_number" id="register_number" class="span4"/>
                <span class="help-inline">20 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Байршлын хаяг :</label>
              <div class="controls">
                <textarea name="location_address" id="location_address" rows="2" class="span5"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Утасны дугаар :</label>
              <div class="controls">
                <input type="text" name="tel_number" id="tel_number" class="span4"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Факсын дугаар :</label>
              <div class="controls">
                <input type="text" name="fax_number" id="fax_number" class="span4"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Имэйл:</label>
              <div class="controls">
                <textarea name="email_address" id="email_address" rows="3" class="span5"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Вэб хаяг:</label>
              <div class="controls">
                <textarea name="web_address" id="web_address" rows="3" class="span5"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Шуудангийн хаяг:</label>
              <div class="controls">
                <textarea name="postal_address" id="postal_address" rows="3" class="span5"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
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
                <select name="geom_type" id="geom_type" onchange="select_geom(this)" class="span5">
                  <option value="2" selected="selected">Цэгэн мэдээлэл DD форматаар оруулах</option>
                  <option value="3">Цэгэн мэдээлэл DMS форматаар оруулах </option>
                </select>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group" id="geom_2">
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
                <span class="help-inline">Газарзүйн солбицлыг DD буюу Decimal Degree форматаар заавал оруулах ёстой. </span> </div>
            </div>
            <div class="control-group" id="geom_3" hidden="hidden">
              <div class="controls">
                <label class="control-label"></label>
                <table>
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
                <span class="help-inline">Газарзүйн солбицлыг DMS буюу Degree Minute Second форматаар оруулна. Өргөрөгийн градусын хэмжээ 40 - 55 хооронд байна. 2 тэмдэгтээс хэтэрч болохгүй. Өргөрөгийн минутын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Өргөрөгийн секундын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Уртрагын градусын хэмжээ 85 - 125 хооронд байна. 3 тэмдэгтээс хэтэрч болохгүй. Уртрагын минутын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. Уртрагын секундын бүхэл утга нь 60-аас бага байна. 5 тэмдэгтээс хэтэрч болохгүй. </span> </div>
            </div>
            <input type="hidden" id="insertanimalorgbttn" name="insertanimalorgbttn" value="0"/>
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
