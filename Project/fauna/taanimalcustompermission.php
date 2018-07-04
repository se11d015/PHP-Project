<?php
    $my_url = "?id=50";
	$schemas = "scfauna";
    
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "";
    }
	
    $page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
    $my_page = "&page=" . $page;

    $searchQuery = "";
    $search_url = "";

    $entity_name = (isset($_GET["entity_name"])) ? $_GET["entity_name"] : "";
    $permission_number = (isset($_GET["permission_number"])) ? $_GET["permission_number"] : "";
	$approved_date = (isset($_GET["approved_date"])) ? (int) $_GET["approved_date"] : 0;
	$end_date = (isset($_GET["end_date"])) ? (int) $_GET["end_date"] : 0;
	$permission_type = (isset($_GET["permission_type"])) ? (int) $_GET["permission_type"] : 0;
    $species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
	$species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";
	
	if($permission_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND tgcpe.permission_type = ".$permission_type;
	    $search_url .= "&permission_type=".$permission_type;
	}
	
	if($end_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgcpe.end_date) = ".$end_date;
		$search_url .= "&end_date=".$end_date;
	}
	
    if($approved_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgcpe.approved_date) = ".$approved_date;
		$search_url .= "&approved_date=".$approved_date;
	}	

	if(empty($entity_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgcen.entity_name) LIKE lower('%".$entity_name."%')";
		$search_url .= "&entity_name=".$entity_name;
	}

  	if(empty($permission_number))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgcpe.permission_number) LIKE lower('%".$permission_number."%')";
		$search_url .= "&permission_number=".$permission_number;
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

    if ($action == "output") {
        require("tganimalcustomentity/inc.output_animalcustomentityform.php");
    }  elseif ($action == "more") {
        require("includes/taanimalcustompermission/inc.more_animalcustompermission.php");
    } else {
        require("includes/taanimalcustompermission/inc.list_animalcustompermission.php");
    }
?>
