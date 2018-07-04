<?php
require("config/inc.cfg.php");
require("config/inc.db.php");

if (isset($_POST["aimagcode"]))
{
	$aimagcode = (int) $_POST["aimagcode"];
}else
{
	$aimagcode = 0;
}

$selQuery = "SELECT	vs.* FROM scadministrative.vasoumname vs WHERE vs.aimag_code = ".$aimagcode." ORDER BY vs.soum_name_mn";

$rows = $db->query($selQuery);

if(!empty($rows))
{
	for ($i=0; $i < sizeof($rows); $i++) 
	{
		echo "<option value='".$rows[$i]["soum_code"]."'>".$rows[$i]["soum_name_mn"]."</option>"; 
	}
}		
?>
