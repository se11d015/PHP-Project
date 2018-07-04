<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 2))
{
	if (isset($_GET["protect_id"]))
	{
		$protect_id = (int)$_GET["protect_id"];
	}else
	{
		$protect_id = 0;
	}
	$i = 0;
	$valueQuery = "SELECT tgpp.*, tcpt.type_name, vas.aimag_name_mn, vas.soum_name_mn FROM ".$schemas.".tganimalprotection tgpp, ".$schemas.".tcprotectiontype tcpt, scadministrative.vasoumname vas" ;
	
	if($sess_profile==1)
		$whereQuery = "WHERE tgpp.protect_type = tcpt.type_id AND  tgpp.protect_id = ".$protect_id;
	else
		$whereQuery = "WHERE tgpp.protect_type = tcpt.type_id AND tgpp.protect_id = ".$protect_id." AND tgpp.user_id = ".$sess_user_id;
	
	$selQuery = $valueQuery." ".$whereQuery;
//echo $selQuery;
	$row = $db->query($selQuery);

	if (!empty($row))
	{		
		
?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
	if (document.getElementById("expense_resource").value==""){
		alert( "Зардлын  эх үүсвэрийн нэрийг оруулна уу!" );
	}else {
		document.getElementById("insertresearchexpensebttn").value = "1";
		document.mainform.submit();
	}
}

</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 52); ?> бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
			<input type="hidden" name="protect_id" id="protect_id" value="<?php echo $protect_id ?>">           
		   <div class="control-group">
              <label  class="control-label">Хамгаалах арга хэмжээний төрөл:</label>
              <div class="controls">
                <?php
					echo $row[$i]["type_name"];
					?>
              </div>
            </div>
			<div class="control-group">
              <label  class="control-label">Хамгаалах арга хэмжээний авсан огноо:</label>
              <div class="controls">
                <?php
					echo $row[$i]["protect_date"];
					?>
              </div>
            </div>
			<div class="control-group">
              <label  class="control-label">Хамгаалах арга хэмжээ авсан байгууллагын нэр:</label>
              <div class="controls">
                <?php
					echo $row[$i]["protect_org"];
					?>
              </div>
            </div>
			<div class="control-group">
              <label  class="control-label">Аймгийн нэр:</label>
              <div class="controls">
                <?php
					echo $row[$i]["aimag_name_mn"];
					?>
              </div>
            </div>
			<div class="control-group">
              <label  class="control-label">Сумын нэр:</label>
              <div class="controls">
                <?php
					echo $row[$i]["soum_name_mn"];
					?>
              </div>
            </div>
			<div class="control-group">
              <label  class="control-label">Хамгаалах арга хэмжээний авсан газрын нэр:</label>
              <div class="controls">
                <?php
					echo $row[$i]["place_name"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label">Зардлын эх үүсвэр:</label>
              <div class="controls">
                <?php $selQuery = "SELECT tct.* FROM ".$schemas.".tcexpensetype tct ORDER BY tct.type_name ASC";
					$rows = $db->query($selQuery);
					
					
					if(!empty($rows))
					echo seldatadb("expense_resource", "span4", $rows, "type_id", "type_name", $rows[0]["type_id"]);
					else 
					echo seldatadb("expense_resource", "span4", $rows, "type_id", "type_name", null);
				
					
					?> <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label">Зардлын хэмжээ, мян төг:</label>
              <div class="controls">
                <input type="text" class="span2" name="expense_amount" id="expense_amount"/>
                <span class="help-inline">Бутархай тоо байна. 15 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <input type="hidden" id="insertresearchexpensebttn" name="insertresearchexpensebttn" value="0"/>
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
