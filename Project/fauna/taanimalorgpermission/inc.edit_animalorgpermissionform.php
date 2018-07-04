<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2))
{
	require("calendar/classes/tc_calendar.php");
	
	if (isset($_GET["permission_id"]))
	{
		$permission_id = (int)$_GET["permission_id"];
	}else
	{
		$permission_id = 0;
	}
	$i = 0;
	$valueQuery = "SELECT tapop.* FROM ".$schemas.".taanimalorgpermission tapop";
	
	if($sess_profile==1)
		$whereQuery = "WHERE tapop.permission_id = ".$permission_id;
	else
		$whereQuery = "WHERE tapop.permission_id = ".$permission_id." AND tapop.user_id = ".$sess_user_id;
	
	$selQuery = $valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);

	if (!empty($row))
	{	
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (validateChecked(document.getElementsByName("activity_name[]"))==false){
		alert("Эрх авсан чиглэлээс нэгийг сонгоно уу.");
	}else if (document.getElementById("permission_number").value==""){
		alert("Эрхийн гэрчилгээний дугаарыг оруулна уу!" );
	}else {
		document.getElementById("updateanimalorgpermissionbttn").value = "1";
		document.mainform.submit();
	}
}

function validateChecked(chks) {

	var hasChecked = false;	
	for (var i = 0; i < chks.length; i++)
	{
		if (chks[i].checked)
		{
			hasChecked = true;
			break;
		}
	}
	if (hasChecked == false)
		return false;
	else
		return true;
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 41); ?> засах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="permission_id" id="permission_id" value="<?php echo $row[$i]["permission_id"]; ?>">
            <input type="hidden" name="org_name" id="org_name" value="<?php echo $row[$i]["org_name"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="control-group">
              <input type="hidden" name="org_name" id="org_name" value="<?php echo $row[$i]["org_name"];  ?>">
              <label class="control-label">Мэргэжлийн байгууллагын нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tapr.* FROM ".$schemas.".tganimalorg tapr WHERE tapr.org_id=".$row[$i]["org_name"]."";
					$rows = $db->query($selQuery);
					echo $rows[$i]['org_name'] ;
					?>
              </div>
            </div>
           <div class="control-group">
              <label class="control-label">Эрх авсан чиглэл:</label>
              <div class="controls">
                <?php
					$fldCode = explode(', ', $row[$i]["activity_name"]);

					$selQuery = "SELECT tca.* FROM ".$schemas.".tcactivitytype tca ORDER BY tca.type_id ASC";
					$rows = $db->query($selQuery);

					if(is_array($rows) && is_array($fldCode)) {
						for($j=0; $j<sizeof($rows); $j++){
							$kcount = 0;
							
							for($k=0; $k<sizeof($fldCode); $k++){
								if(!empty($rows[$j]["type_id"]) && !empty($fldCode[$k])){
									if($rows[$j]["type_id"] == $fldCode[$k]){
										echo "<label class=\"checkbox inline\">";
										echo "<input name=\"activity_name[]\" type=\"checkbox\" id=\"activity_name\" value=\"".$rows[$j]["type_id"]."\" checked=\"true\"/> ".$rows[$j]["type_name"]." </label></br>";
										$kcount = 1;
									}
								}
							}
							
							if($kcount == 0){
								echo "<label class=\"checkbox inline\">";
								echo "<input name=\"activity_name[]\" type=\"checkbox\" id=\"activity_name\" value=\"".$rows[$j]["type_id"]."\"/> ".$rows[$j]["type_name"]." </label></br>";
							}
						}
					}
					
					?>
                <span class="help-inline">Хамгийн багадаа нэг эрх авсан чиглэл заавал сонгох ёстой.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрхийн гэрчилгээний дугаар:</label>
              <div class="controls">
                <input type="text" class="span4" name="permission_number" id="permission_number" value="<?php echo $row[$i]["permission_number"]; ?>"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх олгосон байгууллагын нэр :</label>
              <div class="controls">
                <textarea class="span4" rows="3"  name="approved_org" id="approved_org"><?php echo $row[$i]["approved_org"]; ?></textarea>
                <span class="help-inline"> 200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх олгосон огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("approved_date", true);
					$approved_date=$row[$i]["approved_date"];
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
              <label class="control-label">Эрх олгосон шийдвэрийн нэр, дугаар:</label>
              <div class="controls">
                <textarea class="span4" rows="3"  name="approved_statement" id="approved_statement"><?php echo $row[$i]["approved_statement"]; ?></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх хүчингүй болгосон байгууллагын нэр :</label>
              <div class="controls">
                <textarea class="span4" rows="3" name="canceled_org" id="canceled_org"><?php echo $row[$i]["canceled_org"]; ?></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх хүчингүй болгосон огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("canceled_date", true);
					$canceled_date=$row[$i]["canceled_date"];
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime($canceled_date)), date('m', strtotime($canceled_date)), date('Y', strtotime($canceled_date)));
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
              <label class="control-label">Эрх хүчингүй болгосон шийдвэрийн нэр, дугаар:</label>
              <div class="controls">
                <textarea class="span4" rows="3" name="canceled_statement" id="canceled_statement"><?php echo $row[$i]["canceled_statement"]; ?></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх сунгасан байгууллагын нэр:</label>
              <div class="controls">
                <textarea class="span4" rows="3" name="extended_org" id="extended_org"><?php echo $row[$i]["extended_org"]; ?></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх сунгасан огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("extended_date", true);
					$extended_date=$row[$i]["extended_date"];
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime($extended_date)), date('m', strtotime($extended_date)), date('Y', strtotime($extended_date)));
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
              <label class="control-label">Эрх олгосон шийдвэрийн нэр, дугаар:</label>
              <div class="controls">
                <textarea class="span4" rows="4" name="extended_statement" id="extended_statement"><?php echo $row[$i]["extended_statement"]; ?></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх дуусах огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("end_date", true);
					$end_date=$row[$i]["end_date"];
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
              <label class="control-label">Нэмэлт мэдээлэл:</label>
              <div class="controls">
                <textarea class="span4" rows="4" name="additional_info" id="additional_info"><?php echo $row[$i]["additional_info"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <input type="hidden" id="updateanimalorgpermissionbttn" name="updateanimalorgpermissionbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="updatesubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a> </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php 
	} else {
		$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
		show_notification("error", "", $notify);
	}	
} else {
	$notify ="Таны хандалт буруу байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
