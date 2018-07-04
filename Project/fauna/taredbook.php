<?php
	$my_url = "?id=31";
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
 
    $species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
	$species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";
    $class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
    $family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
    $order_name_mn = (isset($_GET["order_name_mn"])) ? $_GET["order_name_mn"] : "";
	$species_status = (isset($_GET["species_status"])) ? (int) $_GET["species_status"] : 0;	
	
	if($species_status==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND tareb.species_status = ".$species_status;
	    $search_url .= "&species_status=".$species_status;
	}

    if (empty($class_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%" . $class_name_mn . "%')";
        $search_url .= "&class_name_mn=" . $class_name_mn;
    }

    if (empty($family_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tafn.family_name_mn) LIKE lower('%" . $family_name_mn . "%')";
        $search_url .= "&family_name_mn=" . $family_name_mn;
    }

    if (empty($order_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
       $searchQuery .= " AND lower(taon.order_name_mn) LIKE lower('%" . $order_name_mn . "%')";
        $search_url .= "&order_name_mn=" . $order_name_mn;
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
    $list_url = "";
	$ltype = (isset($_GET["ltype"])) ? (int) $_GET["ltype"] : 1;
	
	if($ltype==1)
		$list_url .= "";
	else
		$list_url .= "&ltype=".$ltype;
	
	if ($action=="more")
	{
		require("includes/taredbook/inc.more_redbook.php");
	}elseif($action=="alphabet_mn")
	{
		require("includes/taredbook/inc.list_redbook_alphabet_mn.php");
		
	}elseif($action=="alphabet_en")
	{
		require("includes/taredbook/inc.list_redbook_alphabet_en.php");
		
	} else
	{
		require("includes/taredbook/inc.list_redbook.php");
	}
?>
