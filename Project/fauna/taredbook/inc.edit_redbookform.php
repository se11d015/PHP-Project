<?php 
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 4, 2)) 
{

if (isset($_GET["redbook_id"])) 
{
	$redbook_id = (int) $_GET["redbook_id"];
} else {
	$redbook_id = 0;
}

$i = 0;

$startQuery="SELECT";

$valueQuery = "tareb.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl," . $schemas . ".taredbook tareb ";

if ($sess_profile == 1)
	$whereQuery = "WHERE tareb.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND tareb.redbook_id = " . $redbook_id;
else
	$whereQuery = "WHERE tareb.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND tareb.redbook_id = " . $redbook_id . " AND  tareb.user_id = " . $sess_user_id;

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
$row = $db->query($selQuery);

if (!empty($row)) 
{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform()
{
	if (document.getElementById("species_code").value==""){
		alert( "Зүйлийн кодыг оруулна уу" );
	}else if (document.getElementById("approved_year").value == "") {
		alert("Улаан номонд орсон оныг оруулна уу");
	} else {
		document.getElementById("updateredbookbttn").value = "1";
		document.mainform.submit();
	}
}
</script>

<div class="add-table">
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><?php echo getdata($ITEM_TYPE, 21); ?> засах хэсэг</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form-horizontal" action="<?php echo $my_url . $search_url . $sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
            <input type="hidden" name="redbook_id" id="redbook_id" value="<?php echo $row[$i]["redbook_id"]; ?>">
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
              <label class="control-label">Улаан номонд орсон он:</label>
              <div class="controls">
                <input type="text" class="span2"name="approved_year" id="approved_year" value="<?php echo $row[$i]["approved_year"]; ?>"/>
                <span class="help-inline">Бүхэл тоо байна. 4 оронтой тоо байна.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Амьтны статус:</label>
              <div class="controls">
                <?php
					echo seldata("species_status", "span2", $RB_SPECIES_STATUS, $row[$i]["species_status"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Унаган амьтан:</label>
              <div class="controls">
                <?php
					echo seldata("status_endemic", "span2", $RB_STATUS_ENDEMIC, $row[$i]["status_endemic"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span></div>
            </div>
            <div class="control-group">
              <label class="control-label">Үлдвэр амьтан:</label>
              <div class="controls">
                <?php
					echo seldata("status_relict", "span2", $RB_STATUS_RELICT, $row[$i]["status_relict"]);
					?>
                <span class="help-inline">Жагсаалтаас аль нэгийг нь сонгоно.</span></div>
            </div>
            <div class="control-group">
              <label class="control-label">Статусын мэдээлэл, монголоор:</label>
              <div class="controls">
                <textarea name="status_mn" id="status_mn" rows="2" class="span5"><?php echo $row[$i]["status_mn"]; ?></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Статусын мэдээлэл, англиар:</label>
              <div class="controls">
                <textarea name="status_en" id="status_en" rows="2" class="span5"><?php echo $row[$i]["status_en"]; ?></textarea>
                <span class="help-inline">250 тэмдэгтээс хэтрэхгүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Таних шинж, монголоор:</label>
              <div class="controls">
                <textarea name="description_mn" id="description_mn" rows="3" class="span5"><?php echo $row[$i]["description_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Таних шинж, англиар:</label>
              <div class="controls">
                <textarea name="description_en" id="description_en" rows="3" class="span5"><?php echo $row[$i]["description_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тархац, байршил нутаг, монголоор:</label>
              <div class="controls">
                <textarea name="habitat_mn" id="habitat_mn" rows="3" class="span5"><?php echo $row[$i]["habitat_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тархац, байршил нутаг, англиар:</label>
              <div class="controls">
                <textarea name="habitat_en" id="habitat_en" rows="3" class="span5"><?php echo $row[$i]["habitat_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Амьдралын онцлог, монголоор:</label>
              <div class="controls">
                <textarea name="growth_mn" id="growth_mn" rows="3" class="span5"><?php echo $row[$i]["growth_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Амьдралын онцлог, англиар:</label>
              <div class="controls">
                <textarea name="growth_en" id="growth_en" rows="3" class="span5"><?php echo $row[$i]["growth_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тоо толгой хомсдох шалтгаан, монголоор:</label>
              <div class="controls">
                <textarea name="population_threats_mn" id="population_threats_mn" rows="3" class="span5"><?php echo $row[$i]["population_threats_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тоо толгой хомсдох шалтгаан, англиар:</label>
              <div class="controls">
                <textarea name="population_threats_en" id="population_threats_en" rows="3" class="span5"><?php echo $row[$i]["population_threats_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хамгаалсан байдал, монголоор:</label>
              <div class="controls">
                <textarea name="convervation_measures_mn" id="convervation_measures_mn" rows="3" class="span5"><?php echo $row[$i]["convervation_measures_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хамгаалсан байдал, англиар:</label>
              <div class="controls">
                <textarea name="convervation_measures_en" id="convervation_measures_en" rows="3" class="span5"><?php echo $row[$i]["convervation_measures_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хамгаалах арга хэмжээ, монголоор :</label>
              <div class="controls">
                <textarea name="further_action_mn" id="further_action_mn" rows="3" class="span5"><?php echo $row[$i]["further_action_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Хамгаалах арга хэмжээ, англиар:</label>
              <div class="controls">
                <textarea name="further_action_en" id="further_action_en" rows="3" class="span5"><?php echo $row[$i]["further_action_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эх зохиол, мэдээ, монголоор:</label>
              <div class="controls">
                <textarea name="source_mn" id="source_mn" rows="3" class="span5"><?php echo $row[$i]["source_mn"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Эх зохиол, мэдээ, англиар:</label>
              <div class="controls">
                <textarea name="source_en" id="source_en" rows="3" class="span5"><?php echo $row[$i]["source_en"]; ?></textarea>
                <span class="help-inline">Тэмдэгтийн тоо хязгааргүй.</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Амьтны зураг:</label>
              <div class="controls">
                <input type="file" name="fauna_filename" id="fauna_filename"/>
                <span class="help-inline">Файлын өргөтгөл нь .jpeg, .jpg, .png байна.</span>
                <?php if (!empty($row[$i]["fauna_filename"])) { ?>
                <p class="help-block">Зургийн <a href="<?php echo $row[$i]["picture_pathname"] . $row[$i]["fauna_filename"]; ?>" target="_blank"><img src="<?php echo $row[$i]["picture_pathname"] . $row[$i]["fauna_filename"]; ?>" width="90"/></a> файл байна. </p>
                <?php } ?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Тархалтын зураг:</label>
              <div class="controls">
                <input type="file" name="dist_filename" id="dist_filename"/>
                <span class="help-inline">Файлын өргөтгөл нь .jpeg, .jpg, .png байна.</span>
                <?php if (!empty($row[$i]["dist_filename"])) { ?>
                <p class="help-block">Зургийн <a href="<?php echo $row[$i]["picture_pathname"] . $row[$i]["dist_filename"]; ?>" target="_blank"><img src="<?php echo $row[$i]["picture_pathname"] . $row[$i]["dist_filename"]; ?>" width="90"/></a> файл байна. </p>
                <?php } ?>
              </div>
            </div>
            <input type="hidden" id="fauna_filename" name="fauna_filename" value="<?php echo $row[$i]["fauna_filename"]; ?>"/>
            <input type="hidden" id="dist_filename" name="dist_filename" value="<?php echo $row[$i]["dist_filename"]; ?>"/>
            <input type="hidden" id="picture_pathname" name="picture_pathname" value="<?php echo $row[$i]["picture_pathname"]; ?>"/>
            <input type="hidden" id="updateredbookbttn" name="updateredbookbttn" value="0"/>
            <div class="form-actions">
              <button type="button" class="btn btn-danger" onclick="updatesubmitform()"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
              <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a> </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
	} else {
	$notify = "Таны хайсан мэдээлэл байхгүй байна. <a href=\"" . $my_url . $my_page . $search_url . $sort_url . "\">Буцах</a>";
	show_notification("error", "", $notify);
	}
} else {
	$notify = "Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}
?>
