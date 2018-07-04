<?php
require("config/inc.functions.php");
require("config/inc.session.php");
require("config/inc.language.php");
require("config/inc.cfg.php");
require("config/inc.db.php");

$language_name = "mn";
if($session->get("forestresource_lang") == 1){
	$language_name = "mn";	
} else if($session->get("forestresource_lang") == 2){
	$language_name = "en";
}

$schemas = "scadministrative";

if (isset($_POST["aimagcode"]))
{
	$aimagcode = (int) $_POST["aimagcode"];
}else
{
	$aimagcode = 0;
}

$selQuery = "SELECT	vs.* FROM ".$schemas.".vasoumname vs WHERE	vs.aimag_code = ".$aimagcode." ORDER BY vs.soum_name_$language_name";

$rows = $db->query($selQuery);
if(!empty($rows))
{
	for ($i=0; $i < sizeof($rows); $i++) 
	{
		echo "<option value='".$rows[$i]["soum_code"]."'>".$rows[$i]["soum_name_$language_name"]."</option>"; 
	}
}		
?>
