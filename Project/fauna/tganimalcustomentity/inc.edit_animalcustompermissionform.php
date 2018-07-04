<?php //
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 6, 2)) 
{
	require("calendar/classes/tc_calendar.php");


if (isset($_GET["permission_id"])) {
	$permission_id = (int) $_GET["permission_id"];
} else {
	$permission_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "tgcpe.*, tgcen.entity_name as entity FROM ".$schemas.".tganimalcustomentity tgcen, ".$schemas.".taanimalcustompermission tgcpe";

if ($sess_profile == 1)
	$whereQuery = "WHERE tgcpe.permission_id = tgcpe.permission_id AND tgcpe.entity_name=tgcen.entity_id AND tgcpe.permission_id = " . $permission_id;
else
	$whereQuery = "WHERE tgcpe.permission_id = " . $permission_id . " AND tgcpe.permission_id = tgcpe.permission_id AND tgcpe.entity_name=tgcen.entity_id AND tgcpe.user_id = " . $sess_user_id;

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
//echo $selQuery;
$row = $db->query($selQuery);

if (!empty($row)) 
{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("permission_number").value == "") {
    	alert("Зөвшөөрлийн дугаарыг оруулна уу");
    } else {
		document.getElementById("updateanimalcustompermissionbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 61); ?> засах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="permission_id" id="permission_id" value="<?php echo $row[$i]["permission_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="control-group">
              <input type="hidden" name="entity_name" id="entity_name" value="<?php echo $row[$i]["entity_name"]; ?>">
              <label class="control-label">Экспортлогч, импортлогчийн нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tacen.* FROM ".$schemas.".tganimalcustomentity tacen ORDER BY tacen.entity_name ASC";
					$rows = $db->query($selQuery);
					echo getdatadb($rows, "entity_id", "entity_name", $row[$i]["entity_name"]);
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрлийн төрөл:</label>
              <div class="controls">
                <?php
					echo seldata("permission_type", "span2", $CUSTOM_PERMISSION_TYPE, $row[$i]["permission_type"]);
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрөл олгосон байгууллагын нэр:</label>
              <div class="controls">
                <textarea name="approved_org" id="approved_org" rows="1" class="span5"><?php echo $row[$i]["approved_org"]; ?></textarea>
                <span class="help-inline">200 Тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрөл олгосон шийдвэрийн нэр, дугаар:</label>
              <div class="controls">
                <textarea name="approved_statement" id="approved_statement" rows="1" class="span5"><?php echo $row[$i]["approved_statement"]; ?></textarea>
                <span class="help-inline">200 Тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрлийн дугаар:</label>
              <div class="controls">
                <input type="text" name="permission_number" id="permission_number" class="span4" value="<?php echo $row[$i]["permission_number"]; ?>"/>
                <span class="help-inline">50 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрөл олгосон огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("approved_date", true);
					$approved_date = $row[$i]["approved_date"];
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime($approved_date)), date('m', strtotime($approved_date)), date('Y', strtotime($approved_date)));
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
              <label class="control-label">Зөвшөөрөл дуусах огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("end_date", true);
					$end_date = $row[$i]["end_date"];
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime($end_date)), date('m', strtotime($end_date)), date('Y', strtotime($end_date)));
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
                <input type="text" name="port_name" id="port_name" class="span5" value="<?php echo $row[$i]["port_name"]; ?>"/>
                <span class="help-inline"> 150 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Гадаад улсын нэр:</label>
              <div class="controls">
                <input type="text" name="importer_country" id="importer_country" class="span5" value="<?php echo $row[$i]["importer_country"]; ?>"/>
                <span class="help-inline"> 150 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Гадаад улсын экспортлогч, импортлогчийн нэр:</label>
              <div class="controls">
                <textarea name="importer_name" id="importer_name" rows="3" class="span5"><?php echo $row[$i]["importer_name"]; ?></textarea>
                <span class="help-inline"> 250 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Гарал үүслийн улсын нэр:</label>
              <div class="controls">
               <input type="text" name="origin_name" id="origin_name" class="span5" value="<?php echo $row[$i]["origin_name"]; ?>"/>
                <span class="help-inline"> 150 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Нэмэлт мэдээлэл:</label>
              <div class="controls">
                <textarea name="additional_info" id="additional_info" rows="3" class="span5"><?php echo $row[$i]["additional_info"]; ?></textarea>
                <span class="help-inline"> Тэмдэгтийн тоо хязгааргүй</span> </div>
            </div>
            <input type="hidden" id="updateanimalcustompermissionbttn" name="updateanimalcustompermissionbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger"" onclick="updatesubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
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
