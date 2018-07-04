<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 2))
{
	require("calendar/classes/tc_calendar.php");						
	
	if (isset($_GET["research_id"]))
	{
		$research_id = (int) $_GET["research_id"];
	}else
	{
		$research_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "tapr.* FROM ".$schemas.".taanimalresearchreport tapr";
	
	if($sess_profile==1)
		$whereQuery = "WHERE tapr.research_id = ".$research_id;
	else
		$whereQuery = "WHERE tapr.research_id = ".$research_id." AND tapr.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("research_name").value==""){
		alert( "Судалгааны нэрийг оруулна уу" );
	}else if (document.getElementById("executive_name").value==""){
		alert( "Судалгааны ажил гүйцэтгэгч байгууллагын нэрийг оруулна уу" );
	}else if (document.getElementById("customer_name").value==""){
		alert( "Захиалагч байгууллагын нэрийг оруулна уу" );
	}else {
		document.getElementById("updateresearchreportbttn").value = "1";
		document.mainform.submit();}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 30); ?> засах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="research_id" id="research_id" value="<?php echo $row[$i]["research_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="control-group">
              <label class="control-label">Судалгааны зөвшөөрөл баталсан байгууллагын нэр:</label>
              <div class="controls">
                <textarea name="approved_org" id="approved_org" rows="3" class="span5"><?php echo $row[$i]["approved_org"]; ?></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгааны зөвшөөрөл баталсан огноо:</label>
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
              <label class="control-label">Судалгааны зөвшөөрөл баталсан шийдвэрийн нэр, дугаар:</label>
              <div class="controls">
                <textarea name="approved_statement" id="approved_statement" rows="3" class="span5"><?php echo $row[$i]["approved_statement"]; ?></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Захиалагч байгууллагын нэр:</label>
              <div class="controls">
                <textarea name="customer_name" id="customer_name" rows="3" class="span5"><?php echo $row[$i]["customer_name"]; ?></textarea>
                <span class="help-inline">200 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгааны төрөл:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "type_id, type_name  FROM ".$schemas.".tcresearchtype";
					$sortQuery = "ORDER BY type_id";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("research_type", "span3", $rows, "type_id", "type_name", $row[$i]["research_type"]);
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгааны нэр:</label>
              <div class="controls">
                <textarea name="research_name" id="research_name" rows="3" class="span5"><?php echo $row[$i]["research_name"]; ?></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгаа хийсэн хугацаа:</label>
              <div class="controls">
                <textarea name="research_time" id="research_time" rows="3" class="span5"><?php echo $row[$i]["research_time"]; ?></textarea>
                <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгаа хамрах нутаг дэвсгэр:</label>
              <div class="controls">
                <textarea name="place_name" id="place_name" rows="3" class="span5"><?php echo $row[$i]["place_name"]; ?></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгааны ажил гүйцэтгэгч байгууллагын нэр:</label>
              <div class="controls">
                <textarea name="executive_name" id="executive_name" rows="3" class="span5"><?php echo $row[$i]["executive_name"]; ?></textarea>
                <span class="help-inline">255 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгаа хийсэн судлаачид:</label>
              <div class="controls">
                <textarea name="researcher_name" id="researcher_name" rows="3" class="span5"><?php echo $row[$i]["researcher_name"]; ?></textarea>
                <span class="help-inline">255 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгааны ажлын зорилго:</label>
              <div class="controls">
                <textarea name="research_purpose" id="research_purpose" rows="3" class="span5"><?php echo $row[$i]["research_purpose"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгааны ажлын тайлангийн хураангуй:</label>
              <div class="controls">
                <textarea name="research_abstract" id="research_abstract" rows="3" class="span5"><?php echo $row[$i]["research_abstract"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгааны ажлын тайлангийн файл:</label>
              <div class="controls">
                <input type="file" name="research_filename" id="research_filename"/>
                <?php if(!empty($row[$i]["research_pathname"]) && !empty($row[$i]["research_filename"])) { ?>
                <p class="help-block"><a href="<?php echo $row[$i]["research_pathname"]."/".$row[$i]["research_filename"]; ?>" target="_blank"><?php echo $row[$i]["research_filename"]; ?></a> файлыг мэдээллийн санд оруулсан байна.</p>
                <?php } ?>
              </div>
            </div>
            <input type="hidden" id="research_filename" name="research_filename" value="<?php echo $row[$i]["research_filename"]; ?>"/>
            <input type="hidden" id="research_pathname" name="research_pathname" value="<?php echo $row[$i]["research_pathname"]; ?>"/>
            <input type="hidden" id="updateresearchreportbttn" name="updateresearchreportbttn" value="0"/>
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
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}		
?>
