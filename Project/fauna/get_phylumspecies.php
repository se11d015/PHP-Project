<?php
require("config/inc.cfg.php");
require("config/inc.db.php");

$schemas = "scfauna";

if (isset($_POST["phylumcode"]))
{
	$phylumcode = (int) $_POST["phylumcode"];
}else
{
	$phylumcode= 0;
}

$selQuery="SELECT taon.order_code, taon.order_name_mn||' - '||taon.order_name as order_name FROM ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tacn.phylum_code = ".$phylumcode." ORDER BY taon.order_code";

$rows = $db->query($selQuery);

if(!empty($rows))
{
	$ordercode = $rows[0]["order_code"];

	$selQuery1="SELECT tafn.family_code, tafn.family_name_mn||' - '||tafn.family_name as family_name FROM ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND taon.order_code = ".$ordercode." AND tacn.phylum_code = ".$phylumcode." ORDER BY tafn.family_code";
	
	$rows1 = $db->query($selQuery1);
	
	if(!empty($rows1))
	{
		$familycode = $rows1[0]["family_code"];
	
		$selQuery2="SELECT tagn.genus_code, tagn.genus_name_mn||' - '||tagn.genus_name as genus_name FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tafn.family_code = ".$familycode." AND taon.order_code = ".$ordercode." AND tacn.phylum_code = ".$phylumcode." ORDER BY tagn.genus_code";
		
		$rows2 = $db->query($selQuery2);
		
		if(!empty($rows2))
		{	
			$genuscode = $rows2[0]["genus_code"];
		
			$selQuery3="SELECT tapl.species_code, tapl.species_name_mn||' - '||tapl.species_name as species_name FROM ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn, ".$schemas.".taordername taon, ".$schemas.".taclassname tacn, ".$schemas.".taphylumname tapn WHERE tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tafn.order_code = taon.order_code AND taon.class_code = tacn.class_code AND tacn.phylum_code = tapn.phylum_code AND tagn.genus_code = ".$genuscode." AND tafn.family_code = ".$familycode." AND taon.order_code = ".$ordercode." AND tacn.phylum_code = ".$phylumcode." ORDER BY tapl.species_code";
			
			$rows3 = $db->query($selQuery3);
			
			if(!empty($rows3))
			{	
				for ($i=0; $i < sizeof($rows3); $i++)
				{
					echo "<option value='".$rows3[$i]["species_code"]."'>".$rows3[$i]["species_name"]."</option>"; 
				}
			}
		}
	}	
}
?>