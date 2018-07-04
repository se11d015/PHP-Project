<?php	
	$my_url = "?id=80";
	$schemas = "scfauna";
	
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}else
	{
		$action = "";
	}

	$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
	$my_page = "&page=".$page;
	
	$searchQuery = "";
	$search_url = "";
	
	$protect_type = (isset($_GET["protect_type"])) ?  (int)$_GET["protect_type"] : 0;
	$protect_date = (isset($_GET["protect_date"])) ? (int) $_GET["protect_date"] : 0;
	$aimag_code = (isset($_GET["aimag_code"])) ? (int) $_GET["aimag_code"] : 0;
	
	if($protect_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tgpp.protect_type = ".$protect_type;
		$search_url .= "&protect_type=".$protect_type;
	}
	
	if($protect_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgpp.protect_date) = ".$protect_date;
		$search_url .= "&protect_date=".$protect_date;
	}	
		
    if ($aimag_code == 0) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND tgpp.aimag_name = " . $aimag_code;
        $search_url .= "&aimag_code=" . $aimag_code;
    }
	
	$sort_url = "";
	$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
	$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;
	
	if($sort==0)
		$sort_url .= "";
	else
		$sort_url .= "&sort=".$sort;
	
	if($sort_type==0)
		$sort_url .= "";
	else
		$sort_url .= "&sorttype=".$sort_type; 
	
	if ($action=="more")
	{
		require("includes/tganimalprotection/inc.more_animalprotection.php");
	}elseif ($action == "output") {
		require("tganimalprotection/inc.output_animalprotectionform.php");
	} else 
	{
		require("includes/tganimalprotection/inc.list_animalprotection.php");
	}
?>
