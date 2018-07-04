<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 2))
{
	if (isset($_GET["research_id"]))
	{
		$research_id = (int)$_GET["research_id"];
	}else
	{
		$research_id = 0;
	}
	
	$i = 0;
	$valueQuery = "SELECT tapr.* FROM ".$schemas.".taanimalresearchreport tapr";
	
	if($sess_profile==1)
		$whereQuery = "WHERE tapr.research_id = ".$research_id;
	else
		$whereQuery = "WHERE tapr.research_id = ".$research_id." AND tapr.user_id = ".$sess_user_id;
	
	$selQuery = $valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);

	if (!empty($row))
	{		
		
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
	if (document.getElementById("budget_resource").value==""){
		alert( "Санхүүжилтийн эх үүсвэрийн нэрийг оруулна уу!" );
	}else {
		document.getElementById("insertresearchbudgetbttn").value = "1";
		document.mainform.submit();
	}
}

</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 31); ?> бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <div class="control-group">
              <input type="hidden" name="research_id" id="research_id" value="<?php echo $research_id ?>">
              <label class="control-label">Судалгааны нэр:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tapr.* FROM ".$schemas.".taanimalresearchreport tapr ORDER BY tapr.research_name ASC";
					$rows = $db->query($selQuery);
					echo getdatadb($rows, "research_id", "research_name", $research_id);
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Санхүүжилтийн эх үүсвэр:</label>
              <div class="controls">
                <?php $selQuery = "SELECT tct.* FROM ".$schemas.".tcbudgettype tct ORDER BY tct.type_name ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("budget_resource", "span4", $rows, "type_id", "type_name", $rows[0]["type_id"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Санхүүжилтийн хэмжээ, мян төг:</label>
              <div class="controls">
                <input type="text" class="span2" name="budget_amount" id="budget_amount"/>
                <span class="help-inline">Бутархай тоо байна. 15 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <input type="hidden" id="insertresearchbudgetbttn" name="insertresearchbudgetbttn" value="0"/>
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
