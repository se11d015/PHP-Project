<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2))
{						
	if (isset($_GET["kingdom_id"]))
	{
		$kingdom_id = (int) $_GET["kingdom_id"];
	}else
	{
		$kingdom_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";
	$valueQuery = "takn.* FROM ".$schemas.".takingdomname takn";
	
	if($sess_profile==1)
		$whereQuery = "WHERE takn.kingdom_id = ".$kingdom_id;
	else
		$whereQuery = "WHERE takn.kingdom_id = ".$kingdom_id." AND takn.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("kingdom_code").value==""){
		alert( "Аймгийн кодыг оруулна уу" );
	}else if (document.getElementById("kingdom_name").value==""){
		alert( "Аймгийн латин нэрийг оруулна уу" );
	}else {
		document.getElementById("updatekingdombttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 1); ?> засварлах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="kingdom_id" id="kingdom_id" value="<?php echo $row[$i]["kingdom_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <div class="control-group">
              <label class="control-label">Аймгийн код:</label>
              <div class="controls">
                <input type="text" class="span2" name="kingdom_code" id="kingdom_code" value="<?php echo $row[$i]["kingdom_code"]; ?>"/>
                <span class="help-inline">Бүхэл тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Аймгийн латин нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="kingdom_name" id="kingdom_name" value="<?php echo $row[$i]["kingdom_name"]; ?>"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
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
              <label class="control-label">Аймгийн монгол нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="kingdom_name_mn" id="kingdom_name_mn" value="<?php echo $row[$i]["kingdom_name_mn"]; ?>"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Аймгийн англи нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="kingdom_name_en" id="kingdom_name_en" value="<?php echo $row[$i]["kingdom_name_en"]; ?>"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Аймгийн орос нэр:</label>
              <div class="controls">
                <input type="text" class="span4" name="kingdom_name_ru" id="kingdom_name_ru" value="<?php echo $row[$i]["kingdom_name_ru"]; ?>"/>
                <span class="help-inline">50 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Аймгийн алтернатив нэр:</label>
              <div class="controls">
                <textarea name="alternative_name" id="alternative_name" rows="3" class="span5"><?php echo $row[$i]["alternative_name"]; ?></textarea>
                <span class="help-inline">255 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <input type="hidden" id="updatekingdombttn" name="updatekingdombttn" value="0"/>
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
