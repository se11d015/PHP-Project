<?php
if (isset($_GET["id"]))
{
	$id = (int) $_GET["id"];
}else
{
	$id = 1;
}

$my_url .= "?id=".$id;

switch ($id)
{
	case 1 : require("statistics/taforestarea/inc.admin_forestarea.php"); break;
	case 2 : require("statistics/taforestvolume/inc.admin_forestvolume.php"); break;
	case 3 : require("statistics/taforestfire/inc.admin_forestfire.php"); break;
	case 4 : require("statistics/taforestinsect/inc.admin_forestinsect.php"); break;
	case 5 : require("statistics/tareforestation/inc.admin_reforestation.php"); break;
	case 6 : require("statistics/taforestutilization/inc.admin_forestutilization.php"); break;
	case 7 : require("statistics/taownerforest/inc.admin_ownerforest.php"); break;
	case 8 : require("statistics/taviolation/inc.admin_violation.php"); break;
	case 9 : require("statistics/tacostreport/inc.admin_costreport.php"); break;
}
?>
