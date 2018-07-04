
<?php if (isset($_GET["id"]))
{
	$id = (int) $_GET["id"];
}else
{
	$id = 1;
}

switch ($id)
{
	case 1 : require("home.php"); break;
	case 2 : require("takingdomname.php"); break;
    case 3 : require("taphylumname.php"); break;
    case 4 : require("taclassname.php"); break;
	case 5 : require("taordername.php"); break;
    case 6 : require("tafamilyname.php"); break;
	case 7 : require("tagenusname.php"); break;
	case 8 : require("taanimalname.php"); break;
	
	case 20 : require("taanimalinfo.php"); break;
	case 21 : require("taanimalresource.php"); break;
	case 22 : require("taanimalstatus.php"); break;

	case 24 : require("tganimalpicture.php"); break;
	case 25 : require("tganimalherbarium.php"); break;

	case 28 : require("tganimalhabitat.php"); break;
	case 29 : require("tganimalzone.php"); break;	
		
	case 30 : require("taredlist.php"); break;
	case 31 : require("taredbook.php"); break;
	
	case 40 : require("taanimalresearchreport.php"); break;
	
	case 50 : require("taanimalcustompermission.php"); break;
	
	case 60 : require("orgpername.php"); break;
	
	case 70 : require("taanimalusepermission.php"); break;
	
	case 80 : require("tganimalprotection.php"); break;
	//case 100 : require("tganimaloffence.php"); break;
	case 110 : require("tganimalcontagion.php"); break;
	case 120 : require("taanimalmng.php"); break;	
	default : echo "Тийм хуудас байхгүй байна."; break;
	
}

?>