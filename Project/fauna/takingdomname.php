<?php	
	$my_url = "?id=2";
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
	
	$kingdom_name = (isset($_GET["kingdom_name"])) ?  $_GET["kingdom_name"] : "";
	$kingdom_name_mn = (isset($_GET["kingdom_name_mn"])) ? $_GET["kingdom_name_mn"] : "";
		
	if(empty($kingdom_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(takn.kingdom_name) LIKE lower('%".$kingdom_name."%')";
		$search_url .= "&kingdom_name=".$kingdom_name;
	}
	
	if(empty($kingdom_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(takn.kingdom_name_mn) LIKE lower('%".$kingdom_name_mn."%')";
		$search_url .= "&kingdom_name_mn=".$kingdom_name_mn;
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
		require("includes/takingdomname/inc.more_kingdomname.php");
	} else {
		require("includes/takingdomname/inc.list_kingdomname.php");
	}
?>
