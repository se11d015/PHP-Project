<?php
if (isset($_GET["id"]))
{
	$id = (int) $_GET["id"];
}else
{
	$id = 1;
}

switch ($id)
{
	case 1 : require("taforestarea.php"); break;
	case 2 : require("taforestvolume.php"); break;
	case 3 : require("taforestfire.php"); break;
	case 4 : require("taforestinsect.php"); break;
	case 5 : require("tareforestation.php"); break;
	case 6 : require("taforestutilization.php"); break;
	case 7 : require("taownerforest.php"); break;
	case 8 : require("taviolation.php"); break;
	case 9 : require("tacostreport.php"); break;
	case 10 : require("tctablesdata.php"); break;
}
?>
