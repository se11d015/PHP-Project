<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 2)) 
{
	require("calendar/classes/tc_calendar.php");
	
	if (isset($_GET["entity_id"]))
	{
		$entity_id = (int)$_GET["entity_id"];
	}else
	{
		$entity_id = 0;
	}
	
	$i = 0;

?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
	if (document.getElementById("permission_number").value == "") {
    	alert("Зөвшөөрлийн дугаарыг оруулна уу");
    } else {
		document.getElementById("insertanimalcustompermissionbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 61); ?> бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <div class="control-group">
              <input type="hidden" name="entity_id" id="entity_id" value="<?php echo $entity_id ?>">
              <label class="control-label">Экспортлогч, импортлогчийн нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tacen.* FROM ".$schemas.".tganimalcustomentity tacen ORDER BY tacen.entity_name ASC";
					$rows = $db->query($selQuery);
					echo getdatadb($rows, "entity_id", "entity_name", $entity_id);
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрлийн төрөл:</label>
              <div class="controls">
                <?php
					echo seldata("permission_type", "span2", $CUSTOM_PERMISSION_TYPE, 1);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрөл олгосон байгууллагын нэр:</label>
              <div class="controls">
                <textarea name="approved_org" id="approved_org" rows="1" class="span5"></textarea>
                <span class="help-inline">200 Тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрөл олгосон шийдвэрийн нэр, дугаар:</label>
              <div class="controls">
                <textarea name="approved_statement" id="approved_statement" rows="1" class="span5"></textarea>
                <span class="help-inline">200 Тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрлийн дугаар:</label>
              <div class="controls">
                <input type="text" name="permission_number" id="permission_number" class="span4"/>
                <span class="help-inline"> 50 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div  class="control-group">
              <label class="control-label">Зөвшөөрөл олгосон огноо: </label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("approved_date", true);
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime("now")), date('m', strtotime("now")), date('Y', strtotime("now")));
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
              <label class="control-label">Зөвшөөрөл дуусах огноо: </label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("end_date", true);
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime("now")), date('m', strtotime("now")), date('Y', strtotime("now")));
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
              <label class="control-label">Нэвтрүүлэх боомтын нэр:</label>
              <div class="controls">
                <input type="text" name="port_name" id="port_name" class="span5"/>
                <span class="help-inline">150 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Гадаад улсын нэр:</label>
              <div class="controls">
                <input type="text" name="importer_country" id="importer_country" class="span5"/>
                <span class="help-inline"> 150 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Гадаад улсын экспортлогч, импортлогчийн нэр:</label>
              <div class="controls">
                <textarea name="importer_name" id="importer_name" rows="2" class="span5"></textarea>
                <span class="help-inline"> 250 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Гарал үүслийн улсын нэр:</label>
              <div class="controls">
                <input type="text" name="origin_name" id="origin_name" class="span5"/>
                <span class="help-inline"> 150 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Нэмэлт мэдээлэл:</label>
              <div class="controls">
                <textarea name="additional_info" id="additional_info" rows="3" class="span5"></textarea>
                <span class="help-inline"> Тэмдэгтийн тоо хязгааргүй</span> </div>
            </div>
            <input type="hidden" id="insertanimalcustompermissionbttn" name="insertanimalcustompermissionbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger"" onclick="addsubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
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
