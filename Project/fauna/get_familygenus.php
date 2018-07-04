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
	for ($i=0; $i < sizeof($rows); $i++)
	{
		echo "<option value='".$rows[$i]["genus_code"]."'>".$rows[$i]["genus_name"]."</option>"; 
	}
}
?>