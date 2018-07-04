<?php

    $my_url = "?id=100";
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

$offence_date = (isset($_GET["offence_date"])) ? (int) $_GET["offence_date"] : 0;
$species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
$species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";

$family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";

$aimag_name_mn = (isset($_GET["aimag_name_mn"])) ? $_GET["aimag_name_mn"] : "";
$soum_name_mn = (isset($_GET["soum_name_mn"])) ? $_GET["soum_name_mn"] : "";

	
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
	if(empty($species_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name) LIKE lower('%".$species_name."%') OR lower(tagn.genus_name) LIKE lower('%".$species_name."%') )";
		$search_url .= "&species_name=".$species_name;
	}
	
	if($offence_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgaof.offence_date) = ".$offence_date;
		$search_url .= "&offence_date=".$offence_date;
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
    require("includes/tganimaloffence/inc.output_animaloffenceform.php");
} elseif ($action == "more") {
    require("includes/tganimaloffence/inc.more_animaloffenceform.php");
} else {
    require("includes/tganimaloffence/inc.list_animaloffenceform.php");
}
?>
