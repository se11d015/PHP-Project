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
		for ($i=0; $i < sizeof($rows1); $i++)
		{
			echo "<option value='".$rows1[$i]["family_code"]."'>".$rows1[$i]["family_name"]."</option>"; 
		}
	}	
}
?>