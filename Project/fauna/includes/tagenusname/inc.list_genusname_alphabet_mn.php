<div class="list-table">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th><span class="title"><?php echo getdata($ITEM_TYPE, 21); ?></span></th>
      </tr>
    </thead>
    <thead>
  </table>
  <?php
	require("includes/tagenusname/inc.title_list_genusname.php");
	
	$startQuery = "SELECT";
	$valueQuery = "tagn.*, tafn.family_name_mn, tafn.family_name, taon.order_name_mn, taon.order_name, tacn.class_name, tacn.class_name_mn, tapn.phylum_name, tapn.phylum_name_mn, takn.kingdom_name, takn.kingdom_name_mn FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
	$whereQuery = "WHERE tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	//echo $selQuery;
	$rows = $db->query($selQuery);
	
	$sum = sizeof($rows);
	$count = 10;
	$maxpage = ceil($sum / $count);
	
	$notify = "<strong>Нийт $sum бичлэг байна.</strong>";
	show_notification("info", "", $notify);
	
	$letter = array("А","Б","В","Г","Д","Е","Ё","Ж","З","И","Й","К","Л","М","Н","О","Ө","П","Р","С","Т","У","Ү","Ф","Х","Ц","Ч","Ш","Щ","Э","Ю","Я");
	$letter_small = array("а","б","в","г","д","е","ё","ж","з","и","й","к","л","м","н","о","ө","п","р","с","т","у","ү","ф","х","ц","ч","ш","щ","э","ю","я");

	$startQuery = "SELECT";
	$valueQuery = "tagn.*, tafn.family_name_mn, tafn.family_name, taon.order_name_mn, taon.order_name, tacn.class_name, tacn.class_name_mn, tapn.phylum_name, tapn.phylum_name_mn, takn.kingdom_name, takn.kingdom_name_mn FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
	$whereQuery = "WHERE tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
//echo $selQuery ;
	$rows = $db->query($selQuery);
	
	$checklist = array();
	for ($int = 0; $int < sizeof($letter); $int++)
			$checklist[$int] = 0;
	
	for ($int = 0; $int < sizeof($letter); $int++)
	{
		for ($i = 0; $i < sizeof($rows); $i++)
		{
			$flora = $rows[$i]["genus_name_mn"];
			$rest = substr($flora, 0, 2);

			if ($letter[$int] == $rest || $letter_small[$int]==$rest)
			{
				$checklist[$int] = 1;
			}
		}
	}	
	
	for ($int = 0; $int < sizeof($letter); $int++)
	{	
		if($checklist[$int]==1)
		{		
	?>
  <div class="home-button">
    <h5><?php echo $letter[$int] . "<br>"; ?></h5>
    <?php		
			for ($i = 0; $i < sizeof($rows); $i++)
			{           
				$flora = $rows[$i]["genus_name_mn"];
				$rest = substr($flora, 0, 2);

				if ($letter[$int] == $rest || $letter_small[$int] == $rest)
				{
			?>
    <a href="<?php echo $my_url.$my_page."&action=more&genus_id=".$rows[$i]["genus_id"]; ?>" title="Дэлгэрэнгүй харах"><?php echo $rows[$i]["genus_name_mn"]; ?></a><br>
    <?php
				}
			}
		?>
  </div>
  <?php
		}
	}
	?>
</div>
