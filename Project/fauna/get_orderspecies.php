<?php
require("config/inc.cfg.php");
require("config/inc.db.php");

$schemas = "scfauna";

if (isset($_POST["ordercode"]))
{
	$ordercode = (int) $_POST["ordercode"];
}else
{
	$ordercode= 0;
}

$selQuery="SELECT tafn.family_code, tafn.family_name_mn||' - '||tafn.family_name as family_name FROM ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon WHERE tafn.order_code = taon.order_code AND taon.order_code = ".$ordercode." ORDER BY tafn.family_code";

$rows = $db->query($selQuery);

if(!empty($rows))
{
	$familycode = $rows[0]["family_code"];
	
	$selQuery1="SELECT tagn.genus_code, tagn.genus_name_mn||' - '||tagn.genus_name as genus_name FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon WHERE tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND tafn.family_code = ".$familycode." AND taon.order_code = ".$ordercode." ORDER BY tagn.genus_code";
		
	$rows1 = $db->query($selQuery1);
		
	if(!empty($rows1))
	{	
		$genuscode = $rows1[0]["genus_code"];
	
		$selQuery2="SELECT tapl.species_code, tapl.species_name_mn||' - '||tapl.species_name as species_name FROM ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon WHERE tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND tagn.genus_code = ".$genuscode." AND tafn.family_code = ".$familycode." AND taon.order_code = ".$ordercode." ORDER BY tapl.species_code";
		
		$rows2 = $db->query($selQuery2);
		
		if(!empty($rows2))
		{	
			for ($i=0; $i < sizeof($rows2); $i++)
			{
				echo "<option value='".$rows2[$i]["species_code"]."'>".$rows2[$i]["species_name"]."</option>"; 
			}
		}
	}	
}
?>