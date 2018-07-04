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
	require("includes/taredbook/inc.title_list_redbook.php");
	
	$startQuery = "SELECT";
	$valueQuery = "tarb.species_code, tarb.redbook_id, tapl.species_id, tapl.species_name animal_name FROM  ".$schemas.".taredbook tarb, ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn";
	$whereQuery = "WHERE tarb.species_code = tapl.species_code AND  tapl.genus_code = tagn.genus_code ORDER BY animal_name";
	
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
	$valueQuery = "tarb.species_code, tarb.redbook_id, tapl.species_id, tapl.species_name animal_name FROM ".$schemas.".taredbook tarb, ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn";
	$whereQuery = "WHERE tarb.species_code = tapl.species_code AND  tapl.genus_code = tagn.genus_code ORDER BY animal_name";
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$rows = $db->query($selQuery);

	$checklist = array();
	for ($int = 0; $int < sizeof($letter); $int++)
			$checklist[$int] = 0;
					
	for ($int = 0; $int < sizeof($letter); $int++)
	{
		for ($i = 0; $i < sizeof($rows); $i++)
		{
			$fauna = $rows[$i]["animal_name"];
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
				$fauna = $rows[$i]["animal_name"];
				$rest = substr($fauna, 0, 1);
	
				if ($letter[$int] == $rest || $letter_small[$int]==$rest)
				{
		?>
    <a href="<?php echo $my_url.$my_page."&action=more&redbook_id=".$rows[$i]["redbook_id"]."&species_code=".$rows[$i]["species_code"]; ?>" title="Дэлгэрэнгүй харах"><?php echo $rows[$i]["animal_name"]; ?></a><br>
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
