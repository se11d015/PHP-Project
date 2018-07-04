<?php
if (isset($_GET["species_code"])) 
{
	$species_code = (int) $_GET["species_code"];
} else {
	$species_code = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tapi.* FROM  " . $schemas . ".taanimalinfo tapi";
$whereQuery = "WHERE  tapi.species_code=" . $species_code;

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
$row = $db->query($selQuery);

if (!empty($row)) 
{
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2">Дэлгэрэнгүй мэдээлэл</th>
      </tr>
    </thead>
  </table>
  <div class="accordion" id="accordion">
    <?php
		$i = 0;
		$startQuery = "SELECT";
		$valueQuery = "tapi.*, takn.kingdom_name, takn.kingdom_name_mn, takn.kingdom_name_en, takn.kingdom_name_ru, tapn.phylum_name, tapn.phylum_name_mn, tapn.phylum_name_en, tapn.phylum_name_ru, tacn.class_name, tacn.class_name_mn, tacn.class_name_en, tacn.class_name_ru, taon.order_name, taon.order_name_mn, taon.order_name_en, taon.order_name_ru, tafn.family_name, tafn.family_name_mn, tafn.family_name_en, tafn.family_name_ru, tagn.genus_name, tagn.genus_name_mn, tagn.genus_name_en, tagn.genus_name_ru, tapl.species_name, tapl.species_name_mn,  tapl.species_name_en, tapl.species_name_ru FROM  " . $schemas . ".taanimalinfo tapi ," . $schemas . ".taanimalname tapl, " . $schemas . ".tagenusname tagn, " . $schemas . ".tafamilyname tafn, " . $schemas . ".taordername taon, " . $schemas . ".taclassname tacn, " . $schemas . ".taphylumname tapn, " . $schemas . ".takingdomname takn";
		$whereQuery = "WHERE tapi.species_code = tapl.species_code AND tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code  AND tapi.species_code=" . $species_code;
		
		$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
		
		$row = $db->query($selQuery);
		if (!empty($row)) 
		{
    	?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 10); ?></a></div>
      <div id="collapse1" class="accordion-body collapse in">
        <div class="accordion-inner">
          <?php
            require("includes/taanimalinfo/inc.query_animalinfo.php");
            ?>
        </div>
      </div>
    </div>
    <?php
		}
	
		$i = 0;
		$startQuery = "SELECT";
	
		$valueQuery = "taar.* FROM  " . $schemas . ".taanimalresource taar ";
		$whereQuery = "WHERE  taar.species_code = " . $species_code." ORDER BY evaluated_date DESC";
	
		$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
	
		$row = $db->query($selQuery);
	
		if (!empty($row)) 
		{
		?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 11); ?></a></div>
      <div id="collapse2" class="accordion-body collapse">
        <div class="accordion-inner">
          <?php
            for ($i=0; $i < sizeof($row); $i++) 
				require("includes/taanimalinfo/inc.query_animalresource.php");
            ?>
        </div>
      </div>
    </div>
    <?php
		}
		
		$i = 0;
		$startQuery = "SELECT";
		$valueQuery = "taps.*, tcrn.reference_name  FROM  " . $schemas . ".taanimalstatus taps," . $schemas . ".tcreferencestatus tcrn ";
		$whereQuery = "WHERE taps.reference_code=tcrn.reference_code AND taps.species_code = " . $species_code;
	
		$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;
		$row = $db->query($selQuery);
	
		if (!empty($row)) 
		{
		?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 12); ?></a></div>
      <div id="collapse3" class="accordion-body collapse ">
        <div class="accordion-inner">
          <div class="more-table">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th colspan="2"><?php echo getdata($ITEM_TYPE, 12); ?> дэлгэрэнгүй харах</th>
                </tr>
              </thead>
              <tbody>
                <?php
					for ($i=0; $i < sizeof($row); $i++) 
						require("includes/taanimalinfo/inc.query_animalstatus.php");
					?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php
		}
		
		$i = 0;
		$startQuery = "SELECT";

		$valueQuery = "tganp.*, taaim.aimag_name_mn, tasou.soum_name_mn  FROM  " . $schemas . ".tganimalpicture tganp, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou";
		$whereQuery = "WHERE taaim.aimag_code=tganp.aimag_name  AND tasou.soum_code=tganp.soum_name AND tganp.species_code = " . $species_code;
		$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;

		$row = $db->query($selQuery);

		if (!empty($row)) 
		{
		?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse5"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 14); ?></a></div>
      <div id="collapse5" class="accordion-body collapse ">
        <div class="accordion-inner">
          <div class="more-table">
            <?php
				for ($i=0; $i < sizeof($row); $i++) 
					require("includes/taanimalinfo/inc.query_animalpicture.php");
				?>
          </div>
        </div>
      </div>
    </div>
    <?php
		}
		
		$i = 0;
		$startQuery = "SELECT";

		$valueQuery = "tgph.*, vas.aimag_name_mn, vas.soum_name_mn  FROM  " . $schemas . ".tganimalherbarium tgph, scadministrative.vasoumname vas ";
		$whereQuery = "WHERE tgph.soum_name = vas.soum_code AND tgph.species_code = " . $species_code;

		$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery;

		$row = $db->query($selQuery);

		if (!empty($row)) 
		{
		?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse6"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 15); ?></a></div>
      <div id="collapse6" class="accordion-body collapse ">
        <div class="accordion-inner">
          <?php
            for ($i=0; $i < sizeof($row); $i++) 
				require("includes/taanimalinfo/inc.query_animalherbarium.php");
            ?>
        </div>
      </div>
    </div>
    <?php 
		}
		?>
  </div>
</div>
<div><a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url .$list_url. $sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
<?php
} else {
	$notify = "Таны хайсан мэдээлэл байхгүй байна. <a href=\"" . $my_url . $my_page . $search_url .$list_url. $sort_url . "\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
