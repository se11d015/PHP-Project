<?php
	$my_url = "?id=120";
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

$doc_date = (isset($_GET["doc_date"])) ? (int) $_GET["doc_date"] : 0;
$aimag_name_mn = (isset($_GET["aimag_name_mn"])) ? $_GET["aimag_name_mn"] : "";
$zone_name = (isset($_GET["zone_name"])) ? $_GET["zone_name"] : "";
$type_id = (isset($_GET["type_id"])) ? $_GET["type_id"] : 0;

if(empty($type_id))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND taamn.doc_type=".$type_id;
		$search_url .= "&doc_type=".$type_id;
	}

	if($doc_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',taamn.doc_date) = ".$doc_date;
		$search_url .= "&doc_date=".$doc_date;
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
	
	if(empty($zone_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
	
		$searchQuery .= " AND lower(tganz.zone_name) LIKE lower('%".$zone_name."%')";
		$search_url .= "&zone_name=".$zone_name;
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

if ($action == "more") {
    require("includes/taanimalmng/inc.more_animalmngform.php");
}  else {
    require("includes/taanimalmng/inc.list_animalmngform.php");
}

?>
