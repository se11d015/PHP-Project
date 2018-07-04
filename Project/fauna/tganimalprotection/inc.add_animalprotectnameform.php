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
		$valueQuery = "SELECT tgpp.*, tcpt.type_name, vas.aimag_name_mn, vas.soum_name_mn  FROM ".$schemas.".tganimalprotection tgpp, ".$schemas.".tcprotectiontype tcpt , scadministrative.vasoumname vas" ;
	
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
	if (document.getElementById("species_code").value==""){
		alert( "Зүйлийн нэрийг оруулна уу!" );
	}else {
		document.getElementById("insertanimalprotectbttn").value = "1";
		document.mainform.submit();
	}
}

</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 51); ?> бүртгэх хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="protect_id" id="protect_id" value="<?php echo $protect_id ?>">
            <div class="control-group" >
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
              <label class="control-label">Хүрээний нэр: </label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tapn.phylum_code, tapn.phylum_name_mn||' - '||tapn.phylum_name as phylum_name FROM ".$schemas.".taphylumname tapn";
					$sortQuery = "ORDER BY tapn.phylum_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("phylum_code_species", "span4", $rows, "phylum_code", "phylum_name", $rows[0]["phylum_code"]);
					$phylum_code =  $rows[0]["phylum_code"];
					?>  <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label">Багийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "taon.order_code, taon.order_name_mn||' - '||taon.order_name as order_name FROM ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.phylum_code = ".$phylum_code;
					$sortQuery = "ORDER BY taon.order_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("order_code_species", "span4", $rows, "order_code", "order_name", $rows[0]["order_code"]); 
					$order_code =  $rows[0]["order_code"];
					?> <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label">Овгийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tafn.family_code, tafn.family_name_mn||' - '||tafn.family_name as family_name FROM ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon WHERE tafn.order_code = taon.order_code AND taon.order_code = ".$order_code;
					$sortQuery = "ORDER BY tafn.family_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;
					$rows = $db->query($selQuery);
					echo seldatadb("family_code_species", "span4", $rows, "family_code", "family_name", $rows[0]["family_code"]);
					$family_code =  $rows[0]["family_code"];
					?> <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label">Төрлийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tagn.genus_code, tagn.genus_name_mn||' - '||tagn.genus_name as genus_name FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn WHERE tagn.family_code = tafn.family_code AND tafn.family_code = ".$family_code;
					$sortQuery = "ORDER BY tagn.genus_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("genus_code", "span4", $rows, "genus_code", "genus_name", $rows[0]["genus_code"]);
					$genus_code =  $rows[0]["genus_code"];
					?> <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label">Зүйлийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tapl.species_code, tapl.species_name_mn||' - '||tapl.species_name as species_name FROM ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn WHERE tagn.genus_code = tapl.genus_code AND tagn.genus_code = ".$genus_code;
					$sortQuery = "ORDER BY tapl.species_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;
					$rows = $db->query($selQuery);
					if(!empty($rows))
						echo seldatadb("species_code", "span4", $rows, "species_code", "species_name", $rows[0]["species_code"]);
					else 
						echo seldatadb("species_code", "span4", $rows, "species_code", "species_name", NULL);			
					?>  <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span>
              </div>
            </div>
            <input type="hidden" id="insertanimalprotectbttn" name="insertanimalprotectbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="addsubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a> </div>
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
