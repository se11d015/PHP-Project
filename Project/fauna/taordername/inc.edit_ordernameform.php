<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2))
{						
	if (isset($_GET["order_id"]))
	{
		$order_id = (int) $_GET["order_id"];
	}else
	{
		$order_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "taon.* FROM ".$schemas.".taordername taon";
	
	if($sess_profile==1)
		$whereQuery = "WHERE taon.order_id = ".$order_id;
	else
		$whereQuery = "WHERE taon.order_id = ".$order_id." AND taon.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("class_code").value==""){
		alert( "Ангийн латин нэрийг оруулна уу" );
	}else if (document.getElementById("order_code").value==""){
		alert( "Багийн кодыг оруулна уу" );
	}else if (document.getElementById("order_name").value==""){
		alert( "Багийн латин нэрийг оруулна уу" );
	}else {
		document.getElementById("updateorderbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 4); ?> засварлах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="order_id" id="order_id" value="<?php echo $row[$i]["order_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="control-group">
              <label class="control-label">Хүрээний нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tapn.phylum_code, tapn.phylum_name_mn||' - '||tapn.phylum_name as phylum_name FROM ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE tacn.phylum_code = tapn.phylum_code AND tacn.class_code = ".$row[$i]["class_code"];
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
              <label class="control-label">Ангийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tacn.class_code, tacn.class_name_mn||' - '||tacn.class_name as class_name FROM ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE tacn.phylum_code = tapn.phylum_code AND tapn.phylum_code = ".$phylum_code;
					$sortQuery = "ORDER BY tacn.class_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					if(!empty($rows))
						echo seldatadb("class_code", "span4", $rows, "class_code", "class_name", $row[$i]["class_code"]);
					else
						echo seldatadb("class_code", "span4", $rows, "class_code", "class_name", NULL);					
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн код:</label>
              <div class="controls">
                <input type="text" class="span2"name="order_code" id="order_code" value="<?php echo $row[$i]["order_code"]; ?>"/>
                <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн латин нэр:</label>
              <div class="controls">
                <input type="text" class="span4"name="order_name" id="order_name" value="<?php echo $row[$i]["order_name"]; ?>"/>
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
              <label class="control-label">Багийн монгол нэр:</label>
              <div class="controls">
                <input type="text" class="span4"name="order_name_mn" id="order_name_mn" value="<?php echo $row[$i]["order_name_mn"]; ?>"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн англи нэр:</label>
              <div class="controls">
                <input type="text" class="span4"name="order_name_en" id="order_name_en" value="<?php echo $row[$i]["order_name_en"]; ?>"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн орос нэр:</label>
              <div class="controls">
                <input type="text" class="span4"name="order_name_ru" id="order_name_ru" value="<?php echo $row[$i]["order_name_ru"]; ?>"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн алтернатив нэр:</label>
              <div class="controls">
                <textarea name="alternative_name" id="alternative_name" rows="3" class="span5"><?php echo $row[$i]["alternative_name"]; ?></textarea>
                <span class="help-inline">255 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <input type="hidden" id="updateorderbttn" name="updateorderbttn" value="0"/>
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
