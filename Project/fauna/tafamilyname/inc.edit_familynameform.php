<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2))
{
						
	if (isset($_GET["family_id"]))
	{
		$family_id = (int) $_GET["family_id"];
	}else
	{
		$family_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "tafn.* FROM ".$schemas.".tafamilyname tafn";
	
	if($sess_profile==1)
		$whereQuery = "WHERE tafn.family_id = ".$family_id;
	else
		$whereQuery = "WHERE tafn.family_id = ".$family_id." AND tafn.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("order_code").value==""){
		alert( "Багийн латин нэрийг оруулна уу" );
	}else if (document.getElementById("family_code").value==""){
		alert( "Овгийн кодыг оруулна уу" );
	}else if (document.getElementById("family_name").value==""){
		alert( "Овгийн латин нэрийг оруулна уу" );
	}else {
		document.getElementById("updatefamilybttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 5); ?> засварлах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="family_id" id="family_id" value="<?php echo $row[$i]["family_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="control-group">
              <label class="control-label">Хүрээний нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tapn.phylum_code, tapn.phylum_name_mn||' - '||tapn.phylum_name as phylum_name FROM ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND taon.order_code = ".$row[$i]["order_code"];
					$sortQuery = " ORDER BY tapn.phylum_code";
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;
					$rows = $db->query($selQuery);
					$phylum_code =  $rows[0]["phylum_code"];
				
					$startQuery = "SELECT";
					$valueQuery = "tapn.phylum_code, tapn.phylum_name_mn||' - '||tapn.phylum_name as phylum_name FROM ".$schemas.".taphylumname tapn";
					$sortQuery = "ORDER BY tapn.phylum_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("phylum_code", "span4", $rows, "phylum_code", "phylum_name", $phylum_code);
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
					if(!empty($rows))
						echo seldatadb("order_code", "span4", $rows, "order_code", "order_name", $row[$i]["order_code"]);
					else
						echo seldatadb("order_code", "span4", $rows, "order_code", "order_name", NULL);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн код:</label>
              <div class="controls">
                <input type="text" class="span2" name="family_code" id="family_code" value="<?php echo $row[$i]["family_code"]; ?>"/>
                <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн латин нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="family_name" id="family_name" value="<?php echo $row[$i]["family_name"]; ?>"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зохиогчийн нэр:</label>
              <div class="controls">
                <input type="text" class="span5" name="citation_author" id="citation_author" value="<?php echo $row[$i]["citation_author"]; ?>"/>
                <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ишлэгдсэн он:</label>
              <div class="controls">
                <input type="text" class="span1" name="citation_year" id="citation_year" value="<?php echo $row[$i]["citation_year"]; ?>"/>
                <span class="help-inline">Бүхэл тоо байна. 4 оронтой тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн монгол нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="family_name_mn" id="family_name_mn" value="<?php echo $row[$i]["family_name_mn"]; ?>"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн англи нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="family_name_en" id="family_name_en" value="<?php echo $row[$i]["family_name_en"]; ?>"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн орос нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="family_name_ru" id="family_name_ru" value="<?php echo $row[$i]["family_name_ru"]; ?>"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн алтернатив нэр:</label>
              <div class="controls">
                <textarea name="alternative_name" id="alternative_name" rows="3" class="span5"><?php echo $row[$i]["alternative_name"]; ?></textarea>
                <span class="help-inline">255 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <input type="hidden" id="updatefamilybttn" name="updatefamilybttn" value="0"/>
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
