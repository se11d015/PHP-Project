<?php

if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1)) 
{
    $my_url .= "?menuitem=" . $menuitem;
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "";
    }


    if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2))
	{
		if (isset($_POST["insertanimalresourcebttn"]) && (int) $_POST["insertanimalresourcebttn"] == 1) 
		{
			if (isset($_POST["species_code"]) && isset($_POST["evaluated_date"])) 
			{
				if ($_POST["evaluated_date"] != '0000-00-00')
					$evaluated_date = $_POST["evaluated_date"];
				else
					$evaluated_date = date('Y-m-d');
				
				$fields = array("species_code", "evaluated_date", "evaluated_org", "dist_place", "dist_area", "dist_density", "total_head", "male_head", "female_head", "yearling_head", "young_head", "head_density", "additional_info", "user_id");
				 
				$sum=$_POST["male_head"]+$_POST["female_head"]+$_POST["yearling_head"]+$_POST["young_head"];
				$total=$_POST["total_head"];
				if($total!=$sum)$total=$sum;	
				
				$checkvalues = array((int) $_POST["species_code"], $_POST["evaluated_date"], $_POST["evaluated_org"], $_POST["dist_place"], $_POST["dist_area"], $_POST["dist_density"], $total, (int) $_POST["male_head"], (int) $_POST["female_head"],(int) $_POST["yearling_head"], (int) $_POST["young_head"], $_POST["head_density"], $_POST["additional_info"],  $sess_user_id);
	
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'" . $checkvalues[$i] . "'");
				}
	
				$result = $db->insert("" . $schemas . ".taanimalresource", $fields, $values);
				if (!$result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
			}
		}

        if (isset($_POST["updateanimalresourcebttn"]) && (int) $_POST["updateanimalresourcebttn"] == 1) 
		{

            if (isset($_POST["species_code"]) && isset($_POST["evaluated_date"]) && isset($_POST["resource_id"])) 
			{
                $wherevalues = "resource_id=" . (int) $_POST["resource_id"];
				
				if ($_POST["evaluated_date"] != '0000-00-00')
					$evaluated_date = $_POST["evaluated_date"];
				else
					$evaluated_date = date('Y-m-d');

                $fields = array("species_code", "evaluated_date", "evaluated_org", "dist_place", "dist_area", 
				"dist_density", "total_head", "male_head", "female_head", "yearling_head", "young_head",
				"head_density", "additional_info", "user_id");
                
				$sum=$_POST["male_head"]+$_POST["female_head"]+$_POST["yearling_head"]+$_POST["young_head"];
				$total=$_POST["total_head"];
				if($total!=$sum)$total=$sum;				   
				
                $checkvalues = array((int) $_POST["species_code"], $_POST["evaluated_date"], $_POST["evaluated_org"], $_POST["dist_place"], $_POST["dist_area"], $_POST["dist_density"], $total, (int) $_POST["male_head"], (int) $_POST["female_head"],(int) $_POST["yearling_head"], (int) $_POST["young_head"], $_POST["head_density"], $_POST["additional_info"],  (int) $_POST["user_id"]);
                $values = array();
                for ($i = 0; $i < sizeof($checkvalues); $i++) {
                    $values[$i] = (empty($checkvalues[$i]) ? "NULL": "'" . $checkvalues[$i] . "'");
                }

                $result = $db->update("" . $schemas . ".taanimalresource", $fields, $values, $wherevalues);
                if (!$result)
                    show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
                else
                    show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
            }
        }

        if (($action == "delete") && isset($_GET["resource_id"])) 
		{
            $resource_id = (int) $_GET["resource_id"];

            if ($sess_profile == 1)
                $wherevalues = "resource_id = " . $resource_id;
            else
                $wherevalues = "resource_id = " . $resource_id . " AND user_id = " . $sess_user_id;
           

            $result = $db->delete("" . $schemas . ".taanimalresource", $wherevalues);
            if (!$result) {
                show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
            } else {
                show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");               
            }
        }
    }

    $page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"]: 1;
    $my_page = "&page=" . $page;

    $searchQuery = "";
    $search_url = "";

    $species_name = (isset($_POST["species_name"])) ? $_POST["species_name"]: "";
	$species_name_mn = (isset($_POST["species_name_mn"])) ? $_POST["species_name_mn"]: "";
    $class_name_mn = (isset($_POST["class_name_mn"])) ? $_POST["class_name_mn"]: "";
    $order_name_mn = (isset($_POST["order_name_mn"])) ? $_POST["order_name_mn"]: "";
    $family_name_mn = (isset($_POST["family_name_mn"])) ? $_POST["family_name_mn"]: "";
    $evaluated_date = (isset($_GET["evaluated_date"])) ? $_GET["evaluated_date"]: 0;

	if (empty($class_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%" . $class_name_mn . "%')";
        $search_url .= "&class_name_mn=" . $class_name_mn;
    }

    if (empty($order_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(taon.order_name_mn) LIKE lower('%" . $order_name_mn . "%')";
        $search_url .= "&order_name_mn=" . $order_name_mn;
    }

    if (empty($family_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tafn.family_name_mn) LIKE lower('%" . $family_name_mn . "%')";
        $search_url .= "&family_name_mn=" . $family_name_mn;
    }

    if (empty($species_name)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND (lower(tagn.genus_name) LIKE lower('%" . $species_name . "%') OR  lower(tapn.species_name) LIKE lower('%" . $species_name . "%'))";
        $search_url .= "&species_name=" . $species_name;
    }
	
	if (empty($species_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%" . $species_name_mn . "%') OR  lower(tapn.species_name_mn) LIKE lower('%" . $species_name_mn . "%'))";
        $search_url .= "&species_name_mn=" . $species_name_mn;
    }	
	
	if($evaluated_date==0) {
		$searchQuery .= "";
		$search_url .= "";
	} else {  
		$searchQuery .= " AND date_part('year',tapnr.evaluated_date) = ".$evaluated_date;
		$search_url .= "&evaluated_date=".$evaluated_date;
	}
	

    $sort_url = "";
    $sort = (isset($_GET["sort"])) ? (int) $_GET["sort"]: 0;
    $sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"]: 0;

    if ($sort == 0)
        $sort_url .= "";
    else
        $sort_url .= "&sort=" . $sort;

    if ($sort_type == 0)
        $sort_url .= "";
    else
        $sort_url .= "&sorttype=" . $sort_type;

    if ($action == "edit") {
        require("taanimalresource/inc.edit_animalresourceform.php");
    }  elseif ($action == "add") {
        require("taanimalresource/inc.add_animalresourceform.php");
    } elseif ($action == "more") {
        require("taanimalresource/inc.more_animalresourceform.php");
    } else {
        require("taanimalresource/inc.list_animalresourceform.php");
    }
} else {
    $notify = "Таны хандалт буруу байна.";
    show_notification("error", "", $notify);
}
?>
