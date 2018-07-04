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
	for ($i=0; $i < sizeof($rows); $i++)
	{
		echo "<option value='".$rows[$i]["family_code"]."'>".$rows[$i]["family_name"]."</option>"; 
	}
}
?>