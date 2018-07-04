<?php
	$my_url = "?id=110";
	$schemas = "scfauna";
	
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}else
	{
		$action = "";
	}

$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
$my_page = "&page=" . $page;
$searchQuery = "";
$search_url = "";

$contagion_date = (isset($_GET["contagion_date"])) ? (int) $_GET["contagion_date"] : 0;
$species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
$species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";
$family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
$aimag_name_mn = (isset($_GET["aimag_name_mn"])) ? $_GET["aimag_name_mn"] : "";
$soum_name_mn = (isset($_GET["soum_name_mn"])) ? $_GET["soum_name_mn"] : "";
$contagion_name = (isset($_GET["contagion_name"])) ? $_GET["contagion_name"] : "";

if(empty($contagion_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgaco.contagion_name) LIKE lower('%".$contagion_name."%')";
		$search_url .= "&contagion_name=".$contagion_name;
	}
	
if(empty($aimag_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(taaim.aimag_name_mn) LIKE lower('%".$aimag_name_mn."%')";
		$search_url .= "&aimag_name_mn=".$aimag_name_mn;
	}
	
	if(empty($soum_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
	
		$searchQuery .= " AND lower(tasou.soum_name_mn) LIKE lower('%".$soum_name_mn."%')";
		$search_url .= "&soum_name_mn=".$soum_name_mn;
	}

	
	if(empty($family_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
	
		$searchQuery .= " AND lower(tafn.family_name_mn) LIKE lower('%".$family_name_mn."%')";
		$search_url .= "&family_name_mn=".$family_name_mn;
	}	
	if(empty($species_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name_mn) LIKE lower('%".$species_name_mn."%') OR lower(tagn.genus_name_mn) LIKE lower('%".$species_name_mn."%') )";
		$search_url .= "&species_name_mn=".$species_name_mn;
	}

	
	if($contagion_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgaco.contagion_date) = ".$contagion_date;
		$search_url .= "&contagion_date=".$contagion_date;
	}
	
$sort_url = "";
$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;

if ($sort == 0)
    $sort_url .= "";
else
    $sort_url .= "&sort=" . $sort;

if ($sort_type == 0)
    $sort_url .= "";
else
    $sort_url .= "&sorttype=" . $sort_type;

if ($action == "output") {
    require("includes/tganimalcontagion/inc.output_animalcontagionform.php");
} elseif ($action == "more") {
    require("includes/tganimalcontagion/inc.more_animalcontagionform.php");
}  else {
    require("includes/tganimalcontagion/inc.list_animalcontagionform.php");
}

?>
