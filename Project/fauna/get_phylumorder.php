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
	for ($i=0; $i < sizeof($rows); $i++)
	{
		echo "<option value='".$rows[$i]["order_code"]."'>".$rows[$i]["order_name"]."</option>"; 
	}
}
?>