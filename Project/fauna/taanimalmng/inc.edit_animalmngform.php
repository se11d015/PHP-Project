<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 12, 2)) {
require("calendar/classes/tc_calendar.php");

if (isset($_GET["doc_id"])) {
$doc_id = (int) $_GET["doc_id"];
} else {
$doc_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "taamn.*, tganz.zone_name as zone_name_mn, taaim.aimag_name_mn, tasou.soum_name_mn, tcfty.type_name  FROM scfauna.tganimalzone tganz, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas . ".tcfiletype tcfty, ".$schemas . ".taanimalmng taamn ";

	if ($sess_profile == 1) {
		$whereQuery = "WHERE taaim.aimag_code=tganz.aimag_name AND tasou.soum_code=tganz.soum_name AND taamn.zone_name=tganz.gid AND taamn.doc_type=tcfty.type_id AND taamn.doc_id = " . $doc_id;
	} 
	else {
		$whereQuery = "WHERE taaim.aimag_code=tganz.aimag_name AND tasou.soum_code=tganz.soum_name AND taamn.zone_name=tganz.gid AND taamn.doc_type=tcfty.type_id AND taamn.doc_id = " . $doc_id ." AND taamn.user_id = " . $sess_user_id;
		
	}
	
$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
//echo $selQuery;
$row = $db->query($selQuery);

if (!empty($row)) {

?>

<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
    if (document.getElementById("zone_name").value == "") {
            alert("Бүсийн нэр оруулна уу");
    } else {
        document.getElementById("updatemngbttn").value = "1";
        document.mainform.submit();

    }
}

</script>

<div class="add-table">
<table class="table table-bordered table-condensed">
  <thead>
    <tr>
      <th><?php echo getdata($ITEM_TYPE, 120); ?> засварлах хэсэг</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
          <input type="hidden" name="doc_id" id="doc_id" value="<?php echo $row[$i]["doc_id"]; ?>">
          <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">

			<div class="control-group">
              <label class="control-label">Бүсийн нэр</label>
              <div class="controls">
                <?php 
					$selQuery = "SELECT tganz.* FROM ".$schemas.".tganimalzone tganz ORDER BY tganz.zone_name ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("zone_name", "span4", $rows, "gid", "zone_name", $row[$i]["zone_name"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
		  <div class="control-group">
              <label class="control-label">Баримт бичгийн төрөл:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tcrn.type_id, tcrn.type_name FROM ".$schemas.".tcfiletype tcrn";
					$rows = $db->query($selQuery);
					echo seldatadb("type_id", "span3", $rows, "type_id", "type_name",  $row[$i]["doc_type"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
          <div class="control-group ">
            <label class="control-label" id="lbl">Баримт бичгийн боловсруулсан огноо:</label>
            <div class="controls">
              <?php
                            $myCalendar1 = new tc_calendar("doc_date", true);
                            $doc_date = $row[$i]["doc_date"];
                            $myCalendar1->setIcon("calendar/images/iconCalendar.gif");
                            $myCalendar1->setDate(date('d', strtotime($doc_date)), date('m', strtotime($doc_date)), date('Y', strtotime($doc_date)));
                            $myCalendar1->setPath("calendar/");
                            $myCalendar1->setYearInterval(1990, 2020);
                            $myCalendar1->dateAllow('1990-01-01', '2020-12-31');
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
                <?php if(strlen($row[$i]["doc_pathname"])>0 && strlen($row[$i]["doc_filename"])>0) { ?>
                <p class="help-block"><a href="<?php echo $row[$i]["doc_pathname"]."/".$row[$i]["doc_filename"]; ?>" target="_blank"><?php echo $row[$i]["doc_filename"]; ?></a> файлыг мэдээллийн санд оруулсан байна.</p>
                <?php } ?>
              </div>
            </div>
		   <input type="hidden" id="doc_pathname" name="doc_pathname" value="<?php echo $row[$i]["doc_pathname"];?>"/>	
		   <input type="hidden" id="doc_filename" name="doc_filename" value="<?php echo $row[$i]["doc_filename"];?>"/>	
          <input type="hidden" id="updatemngbttn" name="updatemngbttn" value="0"/>
          <div class="form-actions">
            <button type="button" class="btn btn-danger" onclick="updatesubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
            <button class="btn btn-danger"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</button>
          </div>
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
$notify = "Таны хандалт буруу байна. <a href=\"" . $my_url . $my_page . $search_url . $sort_url . "\">Буцах</a>";
show_notification("error", "", $notify);
}
?>
