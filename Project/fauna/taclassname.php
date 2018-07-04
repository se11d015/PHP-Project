<?php
	$my_url = "?id=4";
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
	
	$class_name = (isset($_GET["class_name"])) ?  $_GET["class_name"] : "";
	$class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
	$phylum_name_mn = (isset($_GET["phylum_name_mn"])) ?  $_GET["phylum_name_mn"] : "";
	
	if(empty($phylum_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapn.phylum_name_mn) LIKE lower('%".$phylum_name_mn."%')";
		$search_url .= "&phylum_name_mn=".$phylum_name_mn;
	}
	
	if(empty($class_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tacn.class_name) LIKE lower('%".$class_name."%')";
		$search_url .= "&class_name=".$class_name;
	}
	
	if(empty($class_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%".$class_name_mn."%')";
		$search_url .= "&class_name_mn=".$class_name_mn;
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

	$list_url = "";
	$ltype = (isset($_GET["ltype"])) ? (int) $_GET["ltype"] : 1;
	
	if($ltype==1)
		$list_url .= "";
	else
		$list_url .= "&ltype=".$ltype;

	if ($action=="more")
	{
		require("includes/taclassname/inc.more_classname.php");
	} else {
		require("includes/taclassname/inc.list_classname.php");
	}
?>
