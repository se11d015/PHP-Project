<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id,1, 2))
{	
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
	if (document.getElementById("phylum_code").value==""){
		alert( "Хүрээний латин нэрийг оруулна уу" );
	}else if (document.getElementById("class_code").value==""){
		alert( "Ангийн кодыг оруулна уу" );
	}else if (document.getElementById("class_name").value==""){
		alert( "Ангийн латин нэрийг оруулна уу" );
	}else {
		document.getElementById("insertclassbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 3); ?> бүртгэх хэсэг</th>
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
					$valueQuery = "phylum_code, phylum_name_mn||' - '||phylum_name as phylum_name FROM ".$schemas.".taphylumname";
					$sortQuery = "ORDER BY phylum_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					if(!empty($rows))
						echo seldatadb("phylum_code", "span4", $rows, "phylum_code", "phylum_name", $rows[0]["phylum_code"]);
					else
						echo seldatadb("phylum_code", "span4", $rows, "phylum_code", "phylum_name", NULL);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангийн код:</label>
              <div class="controls">
                <input type="text" class="span2" name="class_code" id="class_code"/>
                <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангийн латин нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="class_name" id="class_name"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
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
              <label class="control-label">Ангийн монгол нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="class_name_mn" id="class_name_mn"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангийн англи нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="class_name_en" id="class_name_en"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангийн орос нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="class_name_ru" id="class_name_ru"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангийн алтернатив нэр:</label>
              <div class="controls">
                <textarea name="alternative_name" id="alternative_name" rows="3" class="span5"></textarea>
                <span class="help-inline">255 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <input type="hidden" id="insertclassbttn" name="insertclassbttn" value="0"/>
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
