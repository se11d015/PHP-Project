<?php
require("config/inc.cfg.php");
require("config/inc.db.php");

$schemas = "scfauna";

if (isset($_POST["familycode"]))
{
	$familycode = (int) $_POST["familycode"];
}else
{
	$familycode= 0;
}

$selQuery="SELECT tagn.genus_code, tagn.genus_name_mn||' - '||tagn.genus_name as genus_name FROM ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn WHERE tagn.family_code = tafn.family_code AND tafn.family_code = ".$familycode." ORDER BY tagn.genus_code";

$rows = $db->query($selQuery);

if(!empty($rows))
{
	$genuscode = $rows[0]["genus_code"];

	$selQuery1="SELECT tapl.species_code, tapl.species_name_mn||' - '||tapl.species_name as species_name FROM ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tagn, ".$schemas.".tafamilyname tafn WHERE tapl.genus_code = tagn.genus_code AND tagn.family_code = tafn.family_code AND tagn.genus_code = ".$genuscode." AND tafn.family_code = ".$familycode." ORDER BY tapl.species_code";
	
	$rows1 = $db->query($selQuery1);
	
	if(!empty($rows1))
	{	
		for ($i=0; $i < sizeof($rows1); $i++)
		{
			echo "<option value='".$rows1[$i]["species_code"]."'>".$rows1[$i]["species_name"]."</option>"; 
		}
	}
}
?>