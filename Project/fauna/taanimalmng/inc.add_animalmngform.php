<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 2)) {
require("calendar/classes/tc_calendar.php");
?>
<script language="JavaScript" type="text/javascript">
    function addsubmitform()
    {
        if (document.getElementById("zone_name").value == "") {
            alert("Бүсийн нэр оруулна уу");
        } else {
            document.getElementById("insertmngbttn").value = "1";
            document.mainform.submit();
        }
    }
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 120); ?> бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
			<div class="control-group">
              <label class="control-label">Бүсийн нэр</label>
              <div class="controls">
                <?php 
					$selQuery = "SELECT tganz.*, tasou.soum_name_mn||' - '||tganz.zone_name as zone_name_mn FROM ".$schemas.".tganimalzone tganz, scadministrative.tasoumname tasou 
					WHERE tasou.soum_code=tganz.soum_name ORDER BY tganz.zone_name ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("zone_name", "span4", $rows, "gid", "zone_name_mn", $row[0]["zone_name"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>

		  <div class="control-group">
              <label class="control-label">Баримт бичгийн төрөл:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tcrn.type_id, tcrn.type_name FROM ".$schemas.".tcfiletype tcrn";
					$rows = $db->query($selQuery);
					if(!empty($rows))
						echo seldatadb("type_id", "span3", $rows, "type_id", "type_name",  $rows[0]["type_id"]);
					else
						echo seldatadb("type_id", "span3", $rows, "type_id", "type_name", null);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label" id="lbl">Баримт бичгийн боловсруулсан огноо:</label>
              <div class="controls">
                <?php
				$myCalendar1 = new tc_calendar("doc_date", true);
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
              <label class="control-label">Mенежментийн төлөвлөгөө:</label>
              <div class="controls">
                <input type="file" name="doc_filename" id="doc_filename" />
                <span class="help-inline">Файлын өргөтгөл нь .doc, .docx, .pdf байна.</span> </div>
            </div>
            <input type="hidden" id="insertmngbttn" name="insertmngbttn" value="0"/>
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
