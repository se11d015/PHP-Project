<?php
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 2))
{
	$my_url_old = $my_url;
	$my_url .= "&action=".$action;
	
	$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"]: 1;
	$my_page = "&page=".$page;
	
	$searchQuery = "";
	$search_url_new = "";
	
	$org_name = (isset($_GET["org_name"])) ? $_GET["org_name"] : "";
    $aimag_code = (isset($_GET["aimag_code"])) ? (int) $_GET["aimag_code"] : 0;

    if (empty($org_name)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tgpo.org_name) LIKE lower('%" . $org_name . "%')";
        $search_url .= "&org_name=" . $org_name;
    }
    if ($aimag_code == 0) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND tgpo.aimag_name = " . $aimag_code;
        $search_url .= "&aimag_name=" . $aimag_code;
    }
	
	$sort_url_new = "";
	$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"]: 0;
	$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"]: 0;
	
	if($sort==0)
		$sort_url_new .= "";
	else
		$sort_url_new .= "&sort=".$sort;
	
	if($sort_type==0)
		$sort_url_new .= "";
	else
		$sort_url_new .= "&sorttype=".$sort_type; 
	
	require("taanimalorgpermission/inc.select_list_animalorgform.php");
	
} else {
	$notify ="Таны хандалт буруу байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}	
?>
