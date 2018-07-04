<?php //
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 8, 2)) 
{
	require("calendar/classes/tc_calendar.php");
	
	if (isset($_GET["payment_id"])) {
		$payment_id = (int) $_GET["payment_id"];
	} else {
		$payment_id = 0;
	}
	
	$i = 0;
	
	$startQuery = "SELECT";
	$valueQuery = "tgcpe.*, taupa.*, tapl.species_code, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl, " . $schemas . ".taanimalusepayment taupa, ".$schemas.".taanimalusepermission tgcpe";
	
	
	if ($sess_profile == 1)
		$whereQuery = "WHERE tgcpe.permission_id = taupa.permission_id  AND taupa.species_name = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taupa.payment_id = " . $payment_id;
	else
		$whereQuery = "WHERE tgcpe.permission_id = taupa.permission_id  AND taupa.species_name = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND taupa.payment_id = " . $payment_id . " AND taupa.user_id = " . $sess_user_id;

	$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
	//echo $selQuery;
	
	$row = $db->query($selQuery);
	
	if (!empty($row)) 
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("used_amount").value == "") {
		alert("Ашигласан амьтны тоо толгойг оруулна уу");
	} else {
		document.getElementById("updateanimalusepaymentbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 73); ?> засах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="payment_id" id="payment_id" value="<?php echo $row[$i]["payment_id"]; ?>">
            <input type="hidden" name="permission_id" id="permission_id" value="<?php echo $row[$i]["permission_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <input type="hidden" name="species_name" id="species_name" value="<?php echo $row[$i]["species_code"]; ?>">
            <div class="control-group">
              <label class="control-label">Аймгийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["kingdom_name"])) echo $row[$i]["kingdom_name"]; 
					if(!empty($row[$i]["kingdom_name_mn"])) echo " - ".$row[$i]["kingdom_name_mn"]; 
					if(!empty($row[$i]["kingdom_name_en"])) echo " - ".$row[$i]["kingdom_name_en"]; 
					if(!empty($row[$i]["kingdom_name_ru"])) echo " - ".$row[$i]["kingdom_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хүрээний нэр:</label>

              <div class="controls">
                <?php 
					if(!empty($row[$i]["phylum_name"])) echo $row[$i]["phylum_name"]; 
					if(!empty($row[$i]["phylum_name_mn"])) echo " - ".$row[$i]["phylum_name_mn"]; 
					if(!empty($row[$i]["phylum_name_en"])) echo " - ".$row[$i]["phylum_name_en"]; 
					if(!empty($row[$i]["phylum_name_ru"])) echo " - ".$row[$i]["phylum_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["class_name"])) echo $row[$i]["class_name"]; 
					if(!empty($row[$i]["class_name_mn"])) echo " - ".$row[$i]["class_name_mn"]; 
					if(!empty($row[$i]["class_name_en"])) echo " - ".$row[$i]["class_name_en"]; 
					if(!empty($row[$i]["class_name_ru"])) echo " - ".$row[$i]["class_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["order_name"])) echo $row[$i]["order_name"]; 
					if(!empty($row[$i]["order_name_mn"])) echo " - ".$row[$i]["order_name_mn"]; 
					if(!empty($row[$i]["order_name_en"])) echo " - ".$row[$i]["order_name_en"]; 
					if(!empty($row[$i]["order_name_ru"])) echo " - ".$row[$i]["order_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["family_name"])) echo $row[$i]["family_name"]; 
					if(!empty($row[$i]["family_name_mn"])) echo " - ".$row[$i]["family_name_mn"]; 
					if(!empty($row[$i]["family_name_en"])) echo " - ".$row[$i]["family_name_en"]; 
					if(!empty($row[$i]["family_name_ru"])) echo " - ".$row[$i]["family_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Төрлийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["genus_name"])) echo $row[$i]["genus_name"]; 
					if(!empty($row[$i]["genus_name_mn"])) echo " - ".$row[$i]["genus_name_mn"]; 
					if(!empty($row[$i]["genus_name_en"])) echo " - ".$row[$i]["genus_name_en"]; 
					if(!empty($row[$i]["genus_name_ru"])) echo " - ".$row[$i]["genus_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["species_name"])) echo $row[$i]["species_name"]; 
					if(!empty($row[$i]["species_name_mn"])) echo " - ".$row[$i]["species_name_mn"]; 
					if(!empty($row[$i]["species_name_en"])) echo " - ".$row[$i]["species_name_en"]; 
					if(!empty($row[$i]["species_name_ru"])) echo " - ".$row[$i]["species_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зөвшөөрлийн дугаар:</label>
              <div class="controls"> <?php echo $row[$i]["permission_number"]; ?> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тайлант огноо:</label>
              <div class="controls">
                <?php
					$myCalendar1 = new tc_calendar("report_date", true);
					$report_date = $row[$i]["report_date"];
					$myCalendar1->setIcon("calendar/images/iconCalendar.gif");
					$myCalendar1->setDate(date('d', strtotime($report_date)), date('m', strtotime($report_date)), date('Y', strtotime($report_date)));
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
              <label class="control-label">Ашигласан амьтны тоо толгой:</label>
              <div class="controls">
                <input type="text" class="span3" name="used_amount" id="used_amount" value="<?php echo $row[$i]["used_amount"]; ?>"/>
                <span class="help-inline">Бодит тоо байна. 10 тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хэмжих нэгж:</label>
              <div class="controls">
                <input type="text" class="span3" name="amount_unit" id="amount_unit" value="<?php echo $row[$i]["amount_unit"]; ?>"/>
                <span class="help-inline">20 Тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Экологи-эдийн засгийн үнэлгээ, төг:</label>
              <div class="controls">
                <input type="text" class="span3" name="ecology_rate" id="ecology_rate" value="<?php echo $row[$i]["ecology_rate"]; ?>"/>
                <span class="help-inline">Бодит тоо байна. 15 тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ногдуулсан төлбөрийн хэмжээ, төг:</label>
              <div class="controls">
                <input type="text" class="span3" name="payment_value" id="payment_value" value="<?php echo $row[$i]["payment_value"]; ?>"/>
                <span class="help-inline">Бодит тоо байна. 15 тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хөнгөлөлт чөлөөлөлтийн хэмжээ, төг:</label>
              <div class="controls">
                <input type="text" class="span3" name="discount_value" id="discount_value" value="<?php echo $row[$i]["discount_value"]; ?>"/>
                <span class="help-inline">Бодит тоо байна. 15 тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Нийт ногдуулсан төлбөрийн хэмжээ, төг:</label>
              <div class="controls">
                <input type="text" class="span3" name="total_payment" id="total_payment" value="<?php echo $row[$i]["total_payment"]; ?>"/>
                <span class="help-inline">Бодит тоо байна. 15 тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Нэмэлт мэдээлэл:</label>
              <div class="controls">
                <textarea name="additional_info" id="additional_info" rows="3" class="span5"><?php echo $row[$i]["additional_info"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <input type="hidden" id="updateanimalusepaymentbttn" name="updateanimalusepaymentbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="updatesubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
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
