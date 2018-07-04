<?php 
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3,2))
{
							
	if (isset($_GET["redlist_id"]))
	{
		$redlist_id = (int) $_GET["redlist_id"];
	}else
	{
		$redlist_id = 0;
	}
	
	$i = 0;	
	
	$startQuery = "SELECT";

	$valueQuery = "tarl.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru, tcrs.name_mn global_name_mn, tcrs1.name_mn regional_name_mn FROM  ".$schemas.".taredlist tarl,".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn, ".$schemas.".tcredliststatus tcrs , ".$schemas.".tcredliststatus tcrs1";
	
	if($sess_profile==1)
		$whereQuery = "WHERE tarl.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code AND tarl.global_code = tcrs.status_code AND tarl.regional_code = tcrs1.status_code AND tarl.redlist_id = ".$redlist_id;
	else	
		$whereQuery = "WHERE tarl.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code AND tarl.global_code = tcrs.status_code AND tarl.regional_code = tcrs1.status_code AND tarl.redlist_id = ".$redlist_id."  AND tarl.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("species_code").value==""){
		alert( "Зүйлийн кодыг оруулна уу" );
	}else if (document.getElementById("evaluated_year").value==""){
		alert( "Үнэлгээ хийсэн оныг оруулна уу" );
	}else {
		document.getElementById("updateredlistbttn").value = "1";
		document.mainform.submit();}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 20); ?> засах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="redlist_id" id="redlist_id" value="<?php echo $row[$i]["redlist_id"]; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row[$i]["user_id"]; ?>">
            <input type="hidden" name="species_code" id="species_code" value="<?php echo $row[$i]["species_code"]; ?>">
            <div class="control-group">
              <label class="control-label">Аймгийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["kingdom_name"])) echo $row[$i]["kingdom_name"]; 
					if(!empty($row[$i]["kingdom_name_mn"])) echo " - ".$row[$i]["kingdom_name_mn"]; 
					if(!empty($row[$i]["kingdom_name_en"])) echo " - ".$row[$i]["kingdom_name_en"]; 
					if(!empty($row[$i]["kingdom_name_ru"])) echo " - ".$row[$i]["kingdom_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хүрээний нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["phylum_name"])) echo $row[$i]["phylum_name"]; 
					if(!empty($row[$i]["phylum_name_mn"])) echo " - ".$row[$i]["phylum_name_mn"]; 
					if(!empty($row[$i]["phylum_name_en"])) echo " - ".$row[$i]["phylum_name_en"]; 
					if(!empty($row[$i]["phylum_name_ru"])) echo " - ".$row[$i]["phylum_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ангийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["class_name"])) echo $row[$i]["class_name"]; 
					if(!empty($row[$i]["class_name_mn"])) echo " - ".$row[$i]["class_name_mn"]; 
					if(!empty($row[$i]["class_name_en"])) echo " - ".$row[$i]["class_name_en"]; 
					if(!empty($row[$i]["class_name_ru"])) echo " - ".$row[$i]["class_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Багийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["order_name"])) echo $row[$i]["order_name"]; 
					if(!empty($row[$i]["order_name_mn"])) echo " - ".$row[$i]["order_name_mn"]; 
					if(!empty($row[$i]["order_name_en"])) echo " - ".$row[$i]["order_name_en"]; 
					if(!empty($row[$i]["order_name_ru"])) echo " - ".$row[$i]["order_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Овгийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["family_name"])) echo $row[$i]["family_name"]; 
					if(!empty($row[$i]["family_name_mn"])) echo " - ".$row[$i]["family_name_mn"]; 
					if(!empty($row[$i]["family_name_en"])) echo " - ".$row[$i]["family_name_en"]; 
					if(!empty($row[$i]["family_name_ru"])) echo " - ".$row[$i]["family_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Төрлийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["genus_name"])) echo $row[$i]["genus_name"]; 
					if(!empty($row[$i]["genus_name_mn"])) echo " - ".$row[$i]["genus_name_mn"]; 
					if(!empty($row[$i]["genus_name_en"])) echo " - ".$row[$i]["genus_name_en"]; 
					if(!empty($row[$i]["genus_name_ru"])) echo " - ".$row[$i]["genus_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Зүйлийн нэр:</label>
              <div class="controls">
                <?php 
					if(!empty($row[$i]["species_name"])) echo $row[$i]["species_name"]; 
					if(!empty($row[$i]["species_name_mn"])) echo " - ".$row[$i]["species_name_mn"]; 
					if(!empty($row[$i]["species_name_en"])) echo " - ".$row[$i]["species_name_en"]; 
					if(!empty($row[$i]["species_name_ru"])) echo " - ".$row[$i]["species_name_ru"];
					?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Үнэлгээ хийсэн он:</label>
              <div class="controls">
                <input type="text" class="span2" name="evaluated_year" id="evaluated_year" value="<?php echo $row[$i]["evaluated_year"]; ?>"/>
                <span class="help-inline">Бүхэл тоо байна. 4 тэмдэгтээс хэтэрч болохгүй </span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны олон улсын үнэлгээний ангилал:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tcrs.status_code, tcrs.name_mn FROM ".$schemas.".tcredliststatus tcrs";
					$rows = $db->query($selQuery);
					echo seldatadb("global_code", "span2", $rows, "status_code", "name_mn", $row[$i]["global_code"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны олон улсын үнэлгээний нэмэлт:</label>
              <div class="controls">
                <input type="text" class="span3" name="sub_global_status" id="sub_global_status" value="<?php echo $row[$i]["sub_global_status"]; ?>"/>
                <span class="help-inline">25 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны бүс нутгийн үнэлгээний ангилал:</label>
              <div class="controls">
                <?php
					$selQuery = "SELECT tcrs.status_code, tcrs.name_mn FROM ".$schemas.".tcredliststatus tcrs";
					$rows = $db->query($selQuery);
					echo seldatadb("regional_code", "span2", $rows, "status_code", "name_mn", $row[$i]["regional_code"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны бүс нутгийн үнэлгээний нэмэлт:</label>
              <div class="controls">
                <input type="text" class="span3" name="sub_regional_status" id="sub_regional_status" value="<?php echo $row[$i]["sub_regional_status"]; ?>"/>
                <span class="help-inline">25 тэмдэгтээс хэтэрч болохгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны үнэлгээний үндэслэл, монголоор:</label>
              <div class="controls">
                <textarea name="assessment_rationale_mn" id="assessment_rationale_mn" rows="3" class="span5"><?php echo $row[$i]["assessment_rationale_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны үнэлгээний үндэслэл, англиар:</label>
              <div class="controls">
                <textarea name="assessment_rationale_en" id="assessment_rationale_en" rows="3" class="span5"><?php echo $row[$i]["assessment_rationale_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны дэлхийн тархалт, монголоор:</label>
              <div class="controls">
                <textarea name="global_distribution_mn" id="global_distribution_mn" rows="3" class="span5"><?php echo $row[$i]["global_distribution_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны дэлхийн тархалт, англиар:</label>
              <div class="controls">
                <textarea name="global_distribution_en" id="global_distribution_en" rows="3" class="span5"><?php echo $row[$i]["global_distribution_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны бүс нутгийн тархалт, монголоор:</label>
              <div class="controls">
                <textarea name="regional_distribution_mn" id="regional_distribution_mn" rows="3" class="span5"><?php echo $row[$i]["regional_distribution_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны бүс нутгийн тархалт, англиар:</label>
              <div class="controls">
                <textarea name="regional_distribution_en" id="regional_distribution_en" rows="3" class="span5"><?php echo $row[$i]["regional_distribution_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны ховордолын шалтгаан, монголоор:</label>
              <div class="controls">
                <textarea name="dominant_threats_mn" id="dominant_threats_mn" rows="3" class="span5"><?php echo $row[$i]["dominant_threats_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны ховордолын шалтгаан, англиар:</label>
              <div class="controls">
                <textarea name="dominant_threats_en" id="dominant_threats_en" rows="3" class="span5"><?php echo $row[$i]["dominant_threats_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны хамгаалсан байдал, монголоор:</label>
              <div class="controls">
                <textarea name="measures_place_mn" id="measures_place_mn" rows="3" class="span5"><?php echo $row[$i]["measures_place_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны хамгаалсан байдал, англиар:</label>
              <div class="controls">
                <textarea name="measures_place_en" id="measures_place_en" rows="3" class="span5"><?php echo $row[$i]["measures_place_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны хамгаалах арга хэмжээ, монголоор:</label>
              <div class="controls">
                <textarea name="measures_required_mn" id="measures_required_mn" rows="3" class="span5"><?php echo $row[$i]["measures_required_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Улаан дансны хамгаалах арга хэмжээ, англиар:</label>
              <div class="controls">
                <textarea name="measures_required_en" id="measures_required_en" rows="3" class="span5"><?php echo $row[$i]["measures_required_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Амьтны зураг:</label>
              <div class="controls">
                <input type="file" name="fauna_filename" id="fauna_filename"/>
                <span class="help-inline">Файлын өргөтгөл нь .jpeg, .jpg, .png байна.</span>
                <?php if(!empty($row[$i]["fauna_filename"])) { ?>
                <p class="help-block">Зургийн <a href="<?php $row[$i]["fauna_filename"]; ?>" target="_blank"><img src="<?php echo $row[$i]["fauna_filename"]; ?>" width="100"/></a> файл байна. </p>
                <?php } ?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тархалтын зураг:</label>
              <div class="controls">
                <input type="file" name="dist_filename" id="dist_filename"/>
                <span class="help-inline">Файлын өргөтгөл нь .jpeg, .jpg, .png байна.</span>
                <?php if(!empty($row[$i]["dist_filename"])) { ?>
                <p class="help-block">Зургийн <a href="<?php $row[$i]["dist_filename"]; ?>" target="_blank"><img src="<?php echo $row[$i]["dist_filename"]; ?>" width="100"/></a> файл байна. </p>
                <?php } ?>
              </div>
            </div>
            <input type="hidden" id="fauna_filename" name="fauna_filename" value="<?php echo $row[$i]["fauna_filename"]; ?>"/>
            <input type="hidden" id="dist_filename" name="dist_filename" value="<?php echo $row[$i]["dist_filename"]; ?>"/>
            <input type="hidden" id="updateredlistbttn" name="updateredlistbttn" value="0"/>
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
