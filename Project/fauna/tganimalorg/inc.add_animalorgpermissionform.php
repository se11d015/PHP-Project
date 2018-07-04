<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2))
{
	require("calendar/classes/tc_calendar.php");
	
	if (isset($_GET["org_id"]))
	{
		$org_id = (int)$_GET["org_id"];
	}else
	{
		$org_id = 0;
	}
	$i = 0;
	$valueQuery = "SELECT tapr.* FROM ".$schemas.".tganimalorg tapr";
	
	if($sess_profile==1)
		$whereQuery = "WHERE tapr.org_id = ".$org_id;
	else
		$whereQuery = "WHERE tapr.org_id = ".$org_id." AND tapr.user_id = ".$sess_user_id;
	
	$selQuery = $valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);

	if (!empty($row))
	{		
		
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
	if (validateChecked(document.getElementsByName("activity_name[]"))==false){
		alert("Эрх авсан чиглэлээс нэгийг сонгоно уу.");
	}else if (document.getElementById("permission_number").value==""){
		alert("Эрхийн гэрчилгээний дугаарыг оруулна уу!" );
	}else {
		document.getElementById("insertanimalorgpermissionbttn").value = "1";
		document.mainform.submit();
	}
}

function validateChecked(chks) 
{

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
        <th><?php echo getdata($ITEM_TYPE, 41); ?> бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <div class="control-group">
              <input type="hidden" name="org_name" id="org_name" value="<?php echo $org_id ?>">
              <label class="control-label">Мэргэжлийн байгууллагын нэр:</label>
              <div class="controls">
                <?php
					echo $row[$i]['org_name'];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх авсан чиглэл:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tca.* FROM ".$schemas.".tcactivitytype tca ORDER BY tca.type_id ASC";
					$rows = $db->query($selQuery);

					if(is_array($rows))
					{
						for ($j=0; $j<sizeof($rows); $j++)
						{
							if(!empty($rows[$j]["type_id"])) 
							{
								echo "<label class=\"checkbox inline\">";
								echo "<input name=\"activity_name[]\" type=\"checkbox\" id=\"activity_name\" value=\"".$rows[$j]["type_id"]."\"/> ".$rows[$j]["type_name"]." </label></br>";
							}
						}
					}
					?>
                <span class="help-inline" align="left">Хамгийн багадаа нэг эрх авсан чиглэл заавал сонгох ёстой.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрхийн гэрчилгээний дугаар:</label>
              <div class="controls">
                <input type="text" class="span4" name="permission_number" id="permission_number"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх олгосон байгууллагын нэр :</label>
              <div class="controls">
                <textarea  class="span4" rows="3"  name="approved_org" id="approved_org"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх олгосон огноо:</label>
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
              <label class="control-label">Эрх олгосон шийдвэрийн нэр, дугаар:</label>
              <div class="controls">
                <textarea  class="span4" rows="3"  name="approved_statement" id="approved_statement"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх хүчингүй болгосон байгууллагын нэр :</label>
              <div class="controls">
                <textarea  class="span4" rows="3" name="canceled_org" id="canceled_org"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх хүчингүй болгосон огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("canceled_date", true);
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime("")), date('m', strtotime("")), date('Y', strtotime("")));
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
                <textarea  class="span4" rows="3" name="canceled_statement" id="canceled_statement"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх сунгасан байгууллагын нэр:</label>
              <div class="controls">
                <textarea  class="span4" rows="3" name="extended_org" id="extended_org"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх сунгасан огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("extended_date", true);
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime("")), date('m', strtotime("")), date('Y', strtotime("")));
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
                <textarea  class="span4" rows="4"" name="extended_statement" id="extended_statement"></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эрх дуусах огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("end_date", true);
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime("")), date('m', strtotime("")), date('Y', strtotime("")));
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
                <textarea  class="span4" name="additional_info" id="additional_info" rows="4"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <input type="hidden" id="insertanimalorgpermissionbttn" name="insertanimalorgpermissionbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="addsubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
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
