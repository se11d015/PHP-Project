<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 2))
{	
	require("calendar/classes/tc_calendar.php");

?>
<script language="JavaScript" type="text/javascript">
function addsubmitform()
{
	if (document.getElementById("species_code").value==""){
		alert( "Зүйлийн кодыг оруулна уу" );
	}else if (document.getElementById("evaluated_year").value==""){
		alert( "Үнэлгээ хийсэн оныг оруулна уу" );
	}else {
		document.getElementById("insertredlistbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 20); ?> бүртгэх хэсэг</th>
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
					echo seldatadb("phylum_code_species", "span4", $rows, "phylum_code", "phylum_name", $rows[0]["phylum_code"]);
					$phylum_code =  $rows[0]["phylum_code"];
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
					echo seldatadb("order_code_species", "span4", $rows, "order_code", "order_name", $rows[0]["order_code"]);
					$order_code =  $rows[0]["order_code"];
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tafn.family_code, tafn.family_name_mn||' - '||tafn.family_name as family_name FROM ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon WHERE tafn.order_code = taon.order_code AND taon.order_code = ".$order_code;
					$sortQuery = "ORDER BY tafn.family_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;
					$rows = $db->query($selQuery);
					echo seldatadb("family_code_species", "span4", $rows, "family_code", "family_name", $rows[0]["family_code"]);
					$family_code =  $rows[0]["family_code"];
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Төрлийн нэр:</label>
              <div class="controls">
                <?php
					$startQuery = "SELECT";
					$valueQuery = "tagn.genus_code, tagn.genus_name_mn||' - '||tagn.genus_name as genus_name FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn WHERE tagn.family_code = tafn.family_code AND tafn.family_code = ".$family_code;
					$sortQuery = "ORDER BY tagn.genus_code";
				
					$selQuery = $startQuery." ".$valueQuery." ".$sortQuery;

					$rows = $db->query($selQuery);
					echo seldatadb("genus_code", "span4", $rows, "genus_code", "genus_name", $rows[0]["genus_code"]);
					$genus_code =  $rows[0]["genus_code"];
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн нэр:</label>
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
					echo seldatadb("species_code", "span4", $rows, "species_code", "species_name", null);
				
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Үнэлгээ хийсэн он:</label>
              <div class="controls">
                <input type="text" class="span2" name="evaluated_year" id="evaluated_year"/>
                <span class="help-inline">Бүхэл тоо байна. 4 тэмдэгтээс хэтэрч болохгүй </span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны олон улсын үнэлгээний ангилал:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tcrs.status_code, tcrs.name_mn FROM ".$schemas.".tcredliststatus tcrs";
					$rows = $db->query($selQuery);
					echo seldatadb("global_code", "span3", $rows, "status_code", "name_mn", "7", $rows[0]["status_code"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны олон улсын үнэлгээний нэмэлт:</label>
              <div class="controls">
                <input type="text" class="span3" name="sub_global_status" id="sub_global_status"/>
                <span class="help-inline">25 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны бүс нутгийн үнэлгээний ангилал:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tcrs.status_code, tcrs.name_mn FROM ".$schemas.".tcredliststatus tcrs";
					$rows = $db->query($selQuery);
					echo seldatadb("regional_code", "span3", $rows, "status_code", "name_mn", "7", $rows[0]["status_code"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны бүс нутгийн үнэлгээний нэмэлт:</label>
              <div class="controls">
                <input type="text" class="span3" name="sub_regional_status" id="sub_regional_status"/>
                <span class="help-inline">25 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны үнэлгээний үндэслэл, монголоор:</label>
              <div class="controls">
                <textarea name="assessment_rationale_mn" id="assessment_rationale_mn" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны үнэлгээний үндэслэл, англиар:</label>
              <div class="controls">
                <textarea name="assessment_rationale_en" id="assessment_rationale_en" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны дэлхийн тархалт, монголоор:</label>
              <div class="controls">
                <textarea name="global_distribution_mn" id="global_distribution_mn" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны дэлхийн тархалт, англиар:</label>
              <div class="controls">
                <textarea name="global_distribution_en" id="global_distribution_en" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны бүс нутгийн тархалт, монголоор:</label>
              <div class="controls">
                <textarea name="regional_distribution_mn" id="regional_distribution_mn" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны бүс нутгийн тархалт, англиар:</label>
              <div class="controls">
                <textarea name="regional_distribution_en" id="regional_distribution_en" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны ховордолын шалтгаан, монголоор:</label>
              <div class="controls">
                <textarea name="dominant_threats_mn" id="dominant_threats_mn" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны ховордолын шалтгаан, англиар:</label>
              <div class="controls">
                <textarea name="dominant_threats_en" id="dominant_threats_en" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны хамгаалсан байдал, монголоор:</label>
              <div class="controls">
                <textarea name="measures_place_mn" id="measures_place_mn" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны хамгаалсан байдал, англиар:</label>
              <div class="controls">
                <textarea name="measures_place_en" id="measures_place_en" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны хамгаалах арга хэмжээ, монголоор:</label>
              <div class="controls">
                <textarea name="measures_required_mn" id="measures_required_mn" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны хамгаалах арга хэмжээ, англиар:</label>
              <div class="controls">
                <textarea name="measures_required_en" id="measures_required_en" rows="3" class="span5"></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Амьтны зураг:</label>
              <div class="controls">
                <input type="file" name="fauna_filename" id="fauna_filename"/>
                <span class="help-inline">Файлын өргөтгөл нь .jpeg, .jpg, .png байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тархалтын зураг:</label>
              <div class="controls">
                <input type="file" name="dist_filename" id="dist_filename"/>
                <span class="help-inline">Файлын өргөтгөл нь .jpeg, .jpg, .png байна.</span> </div>
            </div>
            <input type="hidden" id="insertredlistbttn" name="insertredlistbttn" value="0"/>
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
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}		
?>
