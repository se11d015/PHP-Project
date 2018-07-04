<?php
if (isset($_GET["protect_id"]))
{
	$protect_id = (int)$_GET["protect_id"];
}else
{
	$protect_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tgpp.*  FROM ".$schemas.".tganimalprotection tgpp";
$whereQuery = "WHERE tgpp.protect_id = ".$protect_id."";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
	$userid  = $row[$i]["user_id"];
?>

<div class="more-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Дэлгэрэнгүй мэдээлэл</th>
      </tr>
    </thead>
  </table>
  <div class="accordion" id="accordion">
    <?php

	$i = 0;

	$startQuery = "SELECT";
	$valueQuery = "tgpp.*, tcpt.type_name, vas.aimag_name_mn, vas.soum_name_mn  FROM ".$schemas.".tganimalprotection tgpp, ".$schemas.".tcprotectiontype tcpt, scadministrative.vasoumname vas ";
	$whereQuery = "WHERE tgpp.protect_type = tcpt.type_id AND tgpp.soum_name = vas.soum_code AND tgpp.protect_id = ".$protect_id."";
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);

	if (!empty($row))
	{
	?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 50); ?></a></div>
      <div id="collapse1" class="accordion-body collapse in">
        <div class="accordion-inner">
          <?php
			require("tganimalprotection/inc.query_animalprotectionform.php");
			?>
        </div>
      </div>
    </div>
    <?php
	}
	
	$i = 0;
	
	$startQuery = "SELECT";
	$valueQuery = "tappn.*,  takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM ".$schemas.".taanimalprotectname tappn, " . $schemas . ".takingdomname takn," . $schemas . ".taphylumname tapn," . $schemas . ".taclassname tacn," . $schemas . ".tafamilyname tafn," . $schemas . ".taordername taon," . $schemas . ".tagenusname tagn," . $schemas . ".taanimalname tapl, ".$schemas.".tganimalprotection tgpp";
	$whereQuery = "WHERE  tappn.species_name = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code=tacn.class_code AND tacn.phylum_code=tapn.phylum_code  AND tapn.kingdom_code=takn.kingdom_code AND tappn.protect_id = ".$protect_id;
	$sortQuery = " ORDER BY tappn.species_name ASC";
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$sortQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row)) 
	{
	?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 51); ?></a></div>
      <div id="collapse2" class="accordion-body collapse">
        <div class="accordion-inner">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th colspan="6"><?php echo getdata($ITEM_TYPE, 51); ?> дэлгэрэнгүй харах</th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th class="span4">Хүрээний нэр</th>
                <th class="span4">Багийн нэр</th>
                <th class="span4">Овгийн нэр</th>
                <th class="span4">Төрлийн нэр</th>
                <th class="span4">Зүйлийн нэр</th>
                <th class="span2"></th>
              </tr>
            </thead>
            <tbody>
              <?php	 
				for ($i=0; $i < sizeof($row); $i++) 
				{
					require("tganimalprotection/inc.query_animalprotectnameform.php");
				}
				?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php 
	} 
	$i = 0;
	
	$startQuery = "SELECT";
	$valueQuery = "tapb.*, tcpt.type_name as expense_type_name FROM ".$schemas.".taanimalprotectexpense tapb, ".$schemas.".tcexpensetype tcpt";
	$whereQuery = "WHERE tapb.expense_resource = tcpt.type_id AND tapb.protect_id = ".$protect_id;
	$sortQuery = " ORDER BY tapb.expense_resource ASC";
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$sortQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row)) 
	{
	?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 52); ?></a></div>
      <div id="collapse3" class="accordion-body collapse">
        <div class="accordion-inner">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th colspan="3"><?php echo getdata($ITEM_TYPE, 52); ?> дэлгэрэнгүй харах</th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th class="span4">Зардлын эх үүсвэр</th>
                <th class="span4">Зардлын хэмжээ, мян төг</th>
                <th class="span2"></th>
              </tr>
            </thead>
            <tbody>
              <?php
				$sum = 0.0;
				
				for ($i=0; $i < sizeof($row); $i++) 
				{
					$sum = $sum + $row[$i]["expense_amount"];

					require("tganimalprotection/inc.query_animalprotectexpenseform.php");
				}
				?>
              <tr>
                <th>Нийт дүн</th>
                <th colspan="2"><?php echo $sum; ?></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
  <div>
    <?php
		if($sess_profile==1)
		{
		?>
    <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&protect_id=".$protect_id; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp;
    <?php 
        } else if($userid==$sess_user_id) {
		?>
    <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&protect_id=".$protect_id; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp;
    <?php
		}
		?>
    <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a> </div>
</div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
