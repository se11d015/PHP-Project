<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2))
{
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
	if (document.getElementById("report_name").value==""){
		alert( "Тайлангийн нэрийг оруулна уу!" );
	}else {
		document.getElementById("insertanimalorgreportbttn").value = "1";
		document.mainform.submit();
	}
}

</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 42); ?> бүртгэх хэсэг</th>
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
              <label class="control-label">Тайлангийн төрөл:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tct.* FROM ".$schemas.".tcreporttype tct ORDER BY tct.type_name ASC";
					$rows = $db->query($selQuery);
					if(!empty($rows))
						echo seldatadb("report_type", "span4", $rows, "type_id", "type_name", $rows[0]["type_id"]);
					else 
						echo seldatadb("report_type", "span4", $rows, "type_id", "type_name", NULL);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тайлангийн нэр:</label>
              <div class="controls">
                <textarea  class="span4" rows="3"  name="report_name" id="report_name" ></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тайлан хамрах хугацаа:</label>
              <div class="controls">
                <textarea  class="span4" rows="1"  name="report_duration" id="report_duration" ></textarea>
                <span class="help-inline">150 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тайлангийн хураангуй:</label>
              <div class="controls">
                <textarea  class="span4" rows="5"  name="report_summary" id="report_summary" ></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ажлын тайлангийн файл:</label>
              <div class="controls">
                <input type="file" name="report_file" id="report_file" />
                <span class="help-inline">Файлын өргөтгөл нь .doc, .docx, .pdf байна.</span> </div>
            </div>
            <input type="hidden" id="insertanimalorgreportbttn" name="insertanimalorgreportbttn" value="0"/>
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
