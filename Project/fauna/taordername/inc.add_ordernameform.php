<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2))
{	
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
	if (document.getElementById("class_code").value==""){
		alert( "Ангийн латин нэрийг оруулна уу" );
	}else if (document.getElementById("order_code").value==""){
		alert( "Багийн кодыг оруулна уу" );
	}else if (document.getElementById("order_name").value==""){
		alert( "Багийн латин нэрийг оруулна уу" );
	}else {
		document.getElementById("insertorderbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 4); ?> бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <div class="control-group">
              <label class="control-label">Хүрээний нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tapn.phylum_code, tapn.phylum_name_mn||' - '||tapn.phylum_name as phylum_name FROM ".$schemas.".taphylumname tapn";
					$sortQuery = "ORDER BY tapn.phylum_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("phylum_code", "span4", $rows, "phylum_code", "phylum_name", $rows[0]["phylum_code"]);
					$phylum_code =  $rows[0]["phylum_code"];
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
						echo seldatadb("class_code", "span4", $rows, "class_code", "class_name", $rows[0]["class_code"]);
					else
						echo seldatadb("class_code", "span4", $rows, "class_code", "class_name", NULL);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн код:</label>
              <div class="controls">
                <input type="text" class="span2" name="order_code" id="order_code"/>
                <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн латин нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="order_name" id="order_name"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зохиогчийн нэр:</label>
              <div class="controls">
                <input type="text" class="span5" name="citation_author" id="citation_author"/>
                <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ишлэгдсэн он:</label>
              <div class="controls">
                <input type="text" class="span1" name="citation_year" id="citation_year"/>
                <span class="help-inline">Бүхэл тоо байна. 4 оронтой тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн монгол нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="order_name_mn" id="order_name_mn"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн англи нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="order_name_en" id="order_name_en"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн орос нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="order_name_ru" id="order_name_ru"/>
                <span class="help-inline">100 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн алтернатив нэр:</label>
              <div class="controls">
                <textarea name="alternative_name" id="alternative_name" rows="3" class="span5"></textarea>
                <span class="help-inline">255 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <input type="hidden" id="insertorderbttn" name="insertorderbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="addsubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <a class="btn btn-danger" href="<?php echo $my_url.$search_url.$sort_url; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a> </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php 
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}		
?>
