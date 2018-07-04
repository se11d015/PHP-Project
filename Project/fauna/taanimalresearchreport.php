<?php
	$my_url = "?id=40";
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
	
	$research_name = (isset($_GET["research_name"])) ? $_GET["research_name"] : "";
	$research_type = (isset($_GET["research_type"])) ?  (int)$_GET["research_type"] : 0;
	$executive_name = (isset($_GET["executive_name"])) ? $_GET["executive_name"] : "";

	if(empty($research_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapr.research_name) LIKE lower('%".$research_name."%')";
		$search_url .= "&research_name=".$research_name;
	}	
	
	if($research_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tapr.research_type = ".$research_type;
		$search_url .= "&research_type=".$research_type;
	}
	
	if(empty($executive_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapr.executive_name) LIKE lower('%".$executive_name."%')";
		$search_url .= "&executive_name=".$executive_name;
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
		require("includes/taanimalresearchreport/inc.more_animalresearchreport.php");
	}else
	{
		require("includes/taanimalresearchreport/inc.list_animalresearchreport.php");
	}
	
?>
