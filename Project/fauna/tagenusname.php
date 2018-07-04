<?php
	$my_url = "?id=7";
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
	
	$genus_name = (isset($_GET["genus_name"])) ?  $_GET["genus_name"] : "";
	$genus_name_mn = (isset($_GET["genus_name_mn"])) ? $_GET["genus_name_mn"] : "";
	$family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
	$order_name_mn = (isset($_GET["order_name_mn"])) ? $_GET["order_name_mn"] : "";
	$class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";

	if(empty($class_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%".$class_name_mn."%')";
		$search_url .= "&class_name_mn=".$class_name_mn;
	}
	
	if(empty($order_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taon.order_name_mn) LIKE lower('%".$order_name_mn."%') OR lower(taon.alternative_name) LIKE lower('%".$order_name_mn."%'))";
		$search_url .= "&order_name_mn=".$order_name_mn;
	}

	if(empty($family_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tafn.family_name_mn) LIKE lower('%".$family_name_mn."%') OR lower(tafn.alternative_name) LIKE lower('%".$family_name_mn."%'))";
		$search_url .= "&family_name_mn=".$family_name_mn;
	}
		
	if(empty($genus_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%".$genus_name."%') OR lower(tagn.synonyms_name) LIKE lower('%".$genus_name."%') OR lower(tagn.basionum_name) LIKE lower('%".$genus_name."%') )";
		$search_url .= "&genus_name=".$genus_name;
	}
	
	if(empty($genus_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%".$genus_name_mn."%') OR lower(tagn.synonyms_name) LIKE lower('%".$genus_name_mn."%') OR lower(tagn.basionum_name) LIKE lower('%".$genus_name_mn."%') )";
		$search_url .= "&genus_name_mn=".$genus_name_mn;
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
		require("includes/tagenusname/inc.more_genusname.php");
	}elseif($action=="alphabet_mn")
	{
		require("includes/tagenusname/inc.list_genusname_alphabet_mn.php");
		
	}elseif($action=="alphabet_en")
	{
		require("includes/tagenusname/inc.list_genusname_alphabet_en.php");
		
	} else {
		require("includes/tagenusname/inc.list_genusname.php");
	}
?>
