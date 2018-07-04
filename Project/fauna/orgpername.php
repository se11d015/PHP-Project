<?php
require("config/inc.cfg_orgper.php");
require("config/inc.db_orgper.php");

$my_url = "?id=60";
$schemas = "scorgstaff";

if (isset($_GET["action"])) {
	$action = pg_prep($_GET["action"]);
} else {
	$action = "";
}

$count = (isset($_POST["count"]) && (int) $_POST["count"] > 0) ? (int) $_POST["count"] : ((isset($_GET["count"]) && (int) $_GET["count"] > 0) ? (int) $_GET["count"] : 10);
$my_count = $my_url."?page=1";
$my_url .= "&count=".$count;

$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
$my_page = "&page=".$page;	

$searchQuery = "";
$search_url = "";

$aimag_name = (isset($_GET["aimag_name"])) ? (int) $_GET["aimag_name"] : 0;
$org_name = (isset($_GET["org_name"])) ? pg_prep($_GET["org_name"]) : "";
$permission_number = (isset($_GET["permission_number"])) ? pg_prep($_GET["permission_number"]) : "";
$approved_date = (isset($_GET["approved_date"])) ? (int) $_GET["approved_date"]: 0;
$permission_type = (isset($_GET["permission_type"])) ? (int) $_GET["permission_type"]: 0;
$permission_valid = (isset($_GET["permission_valid"])) ? (int) $_GET["permission_valid"]: 1;

if ($aimag_name == 0) 
{
	$searchQuery .= "";
	$search_url .= "";
} else 
{
	$searchQuery .= " AND tgo.aimag_name = ".$aimag_name;
	$search_url .= "&aimag_name=".$aimag_name;
}

if (empty($org_name)) 
{
	$searchQuery .= "";
	$search_url .= "";
} else 
{
	$searchQuery .= " AND lower(tgo.org_name) LIKE lower('%".$org_name."%')";
	$search_url .= "&org_name=".$org_name;
}

if (empty($permission_number)) 
{
	$searchQuery .= "";
	$search_url .= "";
} else 
{
	$searchQuery .= " AND lower(tao.permission_number) LIKE lower('%".$permission_number."%')";
	$search_url .= "&permission_number=".$permission_number;
}		

if (empty($permission_valid)) 
{
	$searchQuery .= "";
	$search_url .= "";
} else if ($permission_valid == 1) 
{
	$searchQuery .= " AND (tao.end_date >= now() AND tao.canceled_date IS NULL)";
	$search_url .= "&permission_valid=".$permission_valid;
} else if ($permission_valid == 2) 
{
	$searchQuery .= " AND (tao.end_date < now() AND tao.canceled_date IS NULL)";
	$search_url .= "&permission_valid=".$permission_valid;
} else if ($permission_valid == 3) 
{
	$searchQuery .= " AND tao.canceled_date IS NOT NULL";
	$search_url .= "&permission_valid=".$permission_valid;
}

if($approved_date==0)
{
	$searchQuery .= "";
	$search_url .= "";
} else
{
	$searchQuery .= " AND date_part('year', tao.approved_date) = ".$approved_date;
	$search_url .= "&approved_date=".$approved_date;
}

if(empty($permission_type))
{
	$searchQuery .= "";
	$search_url .= "";
}else
{
	$searchQuery .= " AND lower(tao.permission_type) LIKE lower('%".$permission_type.", %')";
	$search_url .= "&permission_type=".$permission_type;
}	

$sort_url = "";
$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;

if ($sort == 0)
	$sort_url .= "";
else
	$sort_url .= "&sort=".$sort;

if ($sort_type == 0)
	$sort_url .= "";
else
	$sort_url .= "&sorttype=".$sort_type;

if ($action == "more")
{
	require("includes/orgpername/inc.more_orgpername.php");
} else
{
	require("includes/orgpername/inc.list_orgpername.php");
}
?>
  