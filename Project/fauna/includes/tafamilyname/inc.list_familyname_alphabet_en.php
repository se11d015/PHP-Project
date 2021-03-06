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
	require("includes/tafamilyname/inc.title_list_familyname.php");
	
	$startQuery = "SELECT";
	$valueQuery = "tafn.*, tacn.class_name, tacn.class_name_mn, tapn.phylum_name, tapn.phylum_name_mn, taon.order_name, taon.order_name_mn, takn.kingdom_name, takn.kingdom_name_mn FROM ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
	$whereQuery = "WHERE tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	
	$rows = $db->query($selQuery);
	
	$sum = sizeof($rows);
	$count = 10;
	$maxpage = ceil($sum / $count);
	
	$notify = "<strong>Нийт $sum бичлэг байна.</strong>";
	show_notification("info", "", $notify);
	
	$letter = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	$letter_small = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");

	$startQuery = "SELECT";
	$valueQuery = "tafn.*, tacn.class_name, tacn.class_name_mn, tapn.phylum_name, tapn.phylum_name_mn, taon.order_name, taon.order_name_mn, takn.kingdom_name, takn.kingdom_name_mn FROM ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn, ".$schemas.".takingdomname takn";
	$whereQuery = "WHERE tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tapn.kingdom_code=takn.kingdom_code";

	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$rows = $db->query($selQuery);

	$checklist = array();
	for ($int = 0; $int < sizeof($letter); $int++)
			$checklist[$int] = 0;
					
	for ($int = 0; $int < sizeof($letter); $int++)
	{
		for ($i = 0; $i < sizeof($rows); $i++)
		{
			$fauna = $rows[$i]["family_name"];
			$rest = substr($fauna, 0, 1);

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
				$fauna = $rows[$i]["family_name"];
				$rest = substr($fauna, 0, 1);
	
				if ($letter[$int] == $rest || $letter_small[$int]==$rest)
				{
		?>
    <a href="<?php echo $my_url.$my_page."&action=more&family_id=".$rows[$i]["family_id"]."&family_code=".$rows[$i]["family_code"]; ?>" title="Дэлгэрэнгүй харах"><?php echo $rows[$i]["family_name"]; ?></a><br>
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
