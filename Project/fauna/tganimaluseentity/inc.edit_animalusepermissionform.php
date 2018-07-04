<?php //
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 2)) 
{
	require("calendar/classes/tc_calendar.php");

	if (isset($_GET["permission_id"])) {
		$permission_id = (int) $_GET["permission_id"];
	} else {
		$permission_id = 0;
	}
	
	$i = 0;
	
	$startQuery = "SELECT";
	$valueQuery = "tgcpe.*, tgcen.entity_name as entity FROM ".$schemas.".tganimaluseentity tgcen, ".$schemas.".taanimalusepermission tgcpe";

	if ($sess_profile == 1)
		$whereQuery = "WHERE tgcpe.entity_name=tgcen.entity_id AND tgcpe.permission_id = " . $permission_id;
	else
		$whereQuery = "WHERE tgcpe.entity_name=tgcen.entity_id AND tgcpe.permission_id = " . $permission_id . " AND tgcpe.user_id = " . $sess_user_id;
	
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
    } else if (document.getElementById("place_name").value == "") {
    	alert("Ашиглах газрын нэрийг оруулна уу");
    } else {
		document.getElementById("updateanimalusepermissionbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 71); ?> засах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="permission_id" id="permission_id" value="<?php echo $row[$i]["permission_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <input type="hidden" name="entity_name" id="entity_name" value="<?php echo $row[$i]["entity_name"]; ?>">
            <div class="control-group">
              <label class="control-label">Нөөц ашиглагчийн нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tacen.* FROM ".$schemas.".tganimaluseentity tacen";
					$rows = $db->query($selQuery);
					echo getdatadb($rows, "entity_id", "entity_name", $row[$i]["entity_name"]);
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрлийн төрөл:</label>
              <div class="controls">
                <?php
					echo seldata("permission_type", "span2", $USE_PERMISSION_TYPE, $row[$i]["permission_type"]);
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
              <label class="control-label">Ашиглах зориулалт :</label>
              <div class="controls">
                <?php
					echo seldata("use_purpose", "span3", $USE_PURPOSE_TYPE, $row[$i]["use_purpose"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ашиглах аймгийн нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("aimag_name", "span3", $rows, "aimag_code", "aimag_name_mn", $row[$i]["aimag_name"]);
					$aimagcode = $row[$i]["aimag_name"];
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
              </br>
              <label class="control-label">Ашиглах сумын нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT vs.soum_code, vs.soum_name_mn soum_name_mn FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.aimag_name_mn ASC, vs.soum_name_mn ASC";			
					$rows = $db->query($selQuery);
					echo seldatadb("soum_name", "span4", $rows, "soum_code", "soum_name_mn", $row[$i]["soum_name"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ашиглах газрын нэр:</label>
              <div class="controls">
                <textarea name="place_name" id="place_name" rows="2" class="span5"><?php echo $row[$i]["place_name"]; ?></textarea>
                <span class="help-inline"> 250 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ашиглах хугацаа:</label>
              <div class="controls">
                <input type="text" name="use_duration" id="use_duration" class="span5" value="<?php echo $row[$i]["use_duration"]; ?>"/>
                <span class="help-inline">150 Тэмдэгтээс хэтрэхгүй</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Нэмэлт мэдээлэл:</label>
              <div class="controls">
                <textarea name="additional_info" id="additional_info" rows="3" class="span5"><?php echo $row[$i]["additional_info"]; ?></textarea>
                <span class="help-inline"> Тэмдэгтийн тоо хязгааргүй</span> </div>
            </div>
            <input type="hidden" id="updateanimalusepermissionbttn" name="updateanimalusepermissionbttn" value="0"/>
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
