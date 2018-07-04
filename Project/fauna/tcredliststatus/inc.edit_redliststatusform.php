<?php				
	if (isset($_GET["status_id"]))
	{
		$status_id = (int) $_GET["status_id"];
	}else
	{
		$status_id = 0;
	}
	
	$i = 0;	
	
	$selQuery = "SELECT tcrls.* FROM ".$schemas.".tcredliststatus tcrls WHERE tcrls.status_id  = ".$status_id;
	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
 if (document.getElementById("status_code").value == "") {
            alert("Ангиллын кодыг оруулна уу");
	}
	else {
		document.getElementById("updateredliststatusbttn").value = "1";
		document.mainform.submit();}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 22); ?> засах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="status_id" id="status_id" value="<?php echo $row[$i]["status_id"]; ?>">
            <div class="control-group">
              <label class="control-label">Ангиллын код:</label>
              <div class="controls">
                <input type="text" name="status_code" id="status_code" value="<?php echo $row[$i]["status_code"]; ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангиллын монгол нэр:</label>
              <div class="controls">
                <input type="text" name="name_mn" id="name_mn"  class="span4" value="<?php echo $row[$i]["name_mn"]; ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангиллын англи нэр:</label>
              <div class="controls">
                <input type="text" name="name_en" id="name_en" class="span4" value="<?php echo $row[$i]["name_en"]; ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангиллын монгол тайлбар:</label>
              <div class="controls">
                <textarea name="desc_mn" id="desc_mn" class="span4" rows=5><?php echo $row[$i]["desc_mn"]; ?></textarea>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангиллын англи тайлбар:</label>
              <div class="controls">
                <textarea name="desc_en" id="desc_en" class="span4" rows=5><?php echo $row[$i]["desc_en"]; ?></textarea>
              </div>
            </div>
            <input type="hidden" id="updateredliststatusbttn" name="updateredliststatusbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="updatesubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <a class="btn btn-danger" href="<?php echo $my_url.$my_page; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a> </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php 
	} else {
		$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page."\">Буцах</a>";
		show_notification("error", "", $notify);
	}
		
?>
