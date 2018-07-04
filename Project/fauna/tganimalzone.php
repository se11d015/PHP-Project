<?php
     $my_url = "?id=29";
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
	
	$zone_year = (isset($_GET["zone_year"])) ? $_GET["zone_year"] : 0;
	$species_names = (isset($_GET["species_names"])) ? $_GET["species_names"] : "";
	$aimag_name_mn = (isset($_GET["aimag_name_mn"])) ? $_GET["aimag_name_mn"] : "";
    $soum_name_mn = (isset($_GET["soum_name_mn"])) ? $_GET["soum_name_mn"] : "";
	$class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
	$zone_name = (isset($_GET["zone_name"])) ? $_GET["zone_name"] : "";
	
	if(empty($zone_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgazo.zone_name) LIKE lower('%".$zone_name."%')";
		$search_url .= "&zone_name=".$zone_name;
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

	if(empty($species_names))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tgazo.species_names) LIKE lower('%".$species_names."%') ";
		$search_url .= "&species_names=".$species_names;
	}

    if($zone_year==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{  
		$searchQuery .= " AND tgazo.zone_year = ".$zone_year;
		$search_url .= "&zone_year=".$zone_year;
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

    if ($action == "output") {
		require("includes/tganimalzone/inc.output_animalzoneform.php");
	}  elseif ($action == "more") {
        require("includes/tganimalzone/inc.more_animalzoneform.php");
    } else {
        require("includes/tganimalzone/inc.list_animalzoneform.php");
    }

?>
