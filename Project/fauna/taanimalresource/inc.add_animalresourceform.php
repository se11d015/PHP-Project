<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2)) 
{
	require("calendar/classes/tc_calendar.php");
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
    if (document.getElementById("evaluated_date").value == "") {
        alert("Судалгаа хийсэн огноог оруулна уу");
    }
    else {
        document.getElementById("insertanimalresourcebttn").value = "1";
        document.mainform.submit();
    }
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 11); ?> бүртгэх хэсэг</th>
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
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
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
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
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
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
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
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
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
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Судалгаа хийсэн огноо:</label>
              <div class="controls">
                <?php
                $myCalendar1 = new tc_calendar("evaluated_date", true);
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
              <label class="control-label">Судалгаа хийсэн байгууллагын нэр:</label>
              <div class="controls">
                <textarea name="evaluated_org" id="evaluated_org" rows="3" class="span5"></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тархсан газрын нэр:</label>
              <div class="controls">
                <textarea name="dist_place" id="dist_place" rows="3" class="span5"></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Талбайн хэмжээ, га:</label>
              <div class="controls">
                <input type="text" class="span2"name="dist_area" id="dist_area"/>
                <span class="help-inline">Бутархай тоо байна.  11 оронгоос хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">1км2 дах амьтны нягтшил:</label>
              <div class="controls">
                <input type="text" class="span2"name="dist_density" id="dist_density"/>
                <span class="help-inline">Бутархай тоо байна. 11 оронгоос хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Амьтны тоо толгой:</label>
              <div class="controls">
                <input type="text" class="span2"name="total_head" id="total_head"/>
                <span class="help-inline"> Бүхэл тоо байна. </span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Сүргийн бүтэц, Бие гүйцсэн эр:</label>
              <div class="controls">
                <input type="text" class="span2"name="male_head" id="male_head"/>
                <span class="help-inline"> Бүхэл тоо байна. </span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Сүргийн бүтэц, Бие гүйцсэн эм:</label>
              <div class="controls">
                <input type="text" class="span2"name="female_head" id="female_head"/>
                <span class="help-inline"> Бүхэл тоо байна. </span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Сүргийн бүтэц, Залуу:</label>
              <div class="controls">
                <input type="text" class="span2"name="yearling_head" id="yearling_head"/>
                <span class="help-inline"> Бүхэл тоо байна. </span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Сүргийн бүтэц, Төл:</label>
              <div class="controls">
                <input type="text" class="span2"name="young_head" id="young_head"/>
                <span class="help-inline"> Бүхэл тоо байна. </span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Сүргийн нөхөн төлжилт, хувиар:</label>
              <div class="controls">
                <input type="text" class="span2"name="head_density" id="head_density"/>
                <span class="help-inline"> Бутархай тоо байна. 5 оронгоос хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Нэмэлт мэдээлэл:</label>
              <div class="controls">
                <textarea name="additional_info" id="additional_info" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <input type="hidden" id="insertanimalresourcebttn" name="insertanimalresourcebttn" value="0"/>
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
