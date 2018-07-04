<?php
require("config/inc.cfg.php");
require("config/inc.db.php");

$schemas = "scfauna";

if (isset($_POST["genuscode"]))
{
	$genuscode = (int) $_POST["genuscode"];
}else
{
	$genuscode= 0;
}

$selQuery="SELECT tapl.species_code, tapl.species_name_mn||' - '||tapl.species_name as species_name FROM ".$schemas.".taanimalname tapl, ".$schemas.".tagenusname tafn WHERE tapl.genus_code = tafn.genus_code AND tafn.genus_code = ".$genuscode." ORDER BY tapl.species_code";

$rows = $db->query($selQuery);

if(!empty($rows))
{
	for ($i=0; $i < sizeof($rows); $i++)
	{
		echo "<option value='".$rows[$i]["species_code"]."'>".$rows[$i]["species_name"]."</option>"; 
	}
}
?>