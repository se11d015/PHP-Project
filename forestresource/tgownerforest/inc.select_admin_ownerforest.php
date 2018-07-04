
<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 7, 1)) 
{
	$my_url_old = $my_url;
	$my_url .= "&action=".$action;
	
	$count = (isset($_POST["count"]) && (int) $_POST["count"] > 0) ? (int) $_POST["count"] : ((isset($_GET["count"]) && (int) $_GET["count"] > 0) ? (int) $_GET["count"] : 10);
	$my_count = $my_url;
	$my_url .= "&count=".$count;

	$page_new = (isset($_GET["page_new"]) && (int) $_GET["page_new"] > 0) ? (int) $_GET["page_new"] : 1;
	$my_page = "&page_new=".$page_new;
				
	$searchQuery = "";
	$search_url_new = "";
	
	$slowner_year = (isset($_GET["slowner_year"])) ? (int) $_GET["slowner_year"] : 0;		
	$slaimag_code = (isset($_GET["slaimag_code"])) ? (int) $_GET["slaimag_code"] : 0;
	
	if($slaimag_code==0)
	{
		$searchQuery .= "";
		$search_url_new .= "";
	} else
	{
		$searchQuery .= " AND vs.aimag_code = ".$slaimag_code;
		$search_url_new .= "&slaimag_code=".$slaimag_code;
	}
		
	if($slowner_year==0)
	{
		$searchQuery .= "";
		$search_url_new .= "";
		
	} else
	{
		$searchQuery .= " AND taf.owner_year = ".$slowner_year;
		$search_url_new .= "&slowner_year=".$slowner_year;
	}
					
	$sort_url_new = "";
	$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
	$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;

	if ($sort == 0)
		$sort_url_new .= "";
	else
		$sort_url_new .= "&sort=".$sort;

	if ($sort_type == 0)
		$sort_url_new .= "";
	else
		$sort_url_new .= "&sorttype=".$sort_type;

	require("tgownerforest/inc.select_list_ownerforest.php");
} else {
	show_notification("error", _p("NotAccessText"), "");
}
?>
