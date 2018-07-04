<?php
	$my_url = "?id=60";
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

    $org_name = (isset($_GET["org_name"])) ? $_GET["org_name"] : "";	
	$aimag_code = (isset($_GET["aimag_code"])) ? (int) $_GET["aimag_code"]: 0;
	$permission_number = (isset($_GET["permission_number"])) ? $_GET["permission_number"] : "";
	$end_date = (isset($_POST["end_date"])) ? (int) $_POST["end_date"]: 0;	
	$approved_date = (isset($_GET["approved_date"])) ? (int) $_GET["approved_date"]: 0;	
	$type_name = (isset($_GET["type_name"])) ? $_GET["type_name"]: "";	
		
	if(empty($org_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgpo.org_name) LIKE lower('%".$org_name."%')";
		$search_url .= "&org_name=".$org_name;
	}
	
	if($aimag_code==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tgpo.aimag_name = ".$aimag_code;
		$search_url .= "&aimag_code=".$aimag_code;
	}
	
	if(empty($permission_number))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapp.permission_number) LIKE lower('%".$permission_number."%')";
		$search_url .= "&permission_number=".$permission_number;
	}
	
	if($end_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND date_part('year',tapp.end_date) = ".$end_date;
		$search_url .= "&end_date=".$end_date;
	}
	
	if($approved_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND date_part('year',tapp.approved_date) = ".$approved_date;
		$search_url .= "&approved_date=".$approved_date;
	}

	if(empty($type_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapp.activity_name) LIKE lower('%".$type_name."%')";
		$search_url .= "&type_name=".$type_name;
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
        require("includes/tganimalorg/inc.more_animalorg.php");
    }elseif ($action == "permissionmore") {
        require("includes/tganimalorg/inc.more_animalorgpermission.php");
    }elseif ($action == "output") {
		require("tganimalorg/inc.output_animalorgform.php");
	}else {
        require("includes/tganimalorg/inc.list_animalorg.php");
    }

?>
