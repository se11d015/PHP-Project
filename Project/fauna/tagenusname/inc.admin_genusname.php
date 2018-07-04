<?php
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 1))
{				
	$my_url .= "?menuitem=".$menuitem;
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}else
	{
		$action = "";
	}

	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 1, 2))
	{	
		if (isset($_POST["insertgenusbttn"]) && (int) $_POST["insertgenusbttn"]==1)
		{
			if (isset($_POST["family_code"]) && isset($_POST["genus_code"]) && isset($_POST["genus_name"]))
			{				
				$fields = array("family_code", "genus_code", "genus_name", "citation_author", "citation_year", "genus_name_mn", "genus_name_en", "genus_name_ru", "synonyms_name","basionum_name", "user_id");

				$checkvalues = array((int)$_POST["family_code"], (int)$_POST["genus_code"], $_POST["genus_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["genus_name_mn"], $_POST["genus_name_en"], $_POST["genus_name_ru"], $_POST["synonyms_name"], $_POST["basionum_name"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".tagenusname", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		

			}
		}
		
		if (isset($_POST["updategenusbttn"]) && (int) $_POST["updategenusbttn"]==1)
		{
			if (isset($_POST["family_code"]) && isset($_POST["genus_code"]) && isset($_POST["genus_name"]) && isset($_POST["genus_id"]))
			{	
				$wherevalues = "genus_id=".(int) $_POST["genus_id"];
				
				$fields = array("family_code", "genus_code", "genus_name", "citation_author", "citation_year", "genus_name_mn", "genus_name_en", "genus_name_ru", "synonyms_name","basionum_name", "user_id");

				$checkvalues = array((int)$_POST["family_code"], (int)$_POST["genus_code"], $_POST["genus_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["genus_name_mn"], $_POST["genus_name_en"], $_POST["genus_name_ru"], $_POST["synonyms_name"], $_POST["basionum_name"], (int) $_POST["user_id"]);	

	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".tagenusname", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}
						
		if (($action=="delete") && isset($_GET["genus_id"]))
		{
			$genus_id = (int) $_GET["genus_id"];
			
			if($sess_profile==1)
				$wherevalues = "genus_id = ".$genus_id;
			else
				$wherevalues = "genus_id = ".$genus_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".tagenusname",$wherevalues);
			if(! $result)
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
		
		}
	}
	
	$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
	$my_page = "&page=".$page;
	
	$searchQuery = "";
	$search_url = "";
	
	$genus_name = (isset($_GET["genus_name"])) ?  $_GET["genus_name"] : "";
	$genus_name_mn = (isset($_GET["genus_name_mn"])) ? $_GET["genus_name_mn"] : "";
	$family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
	$order_name_mn = (isset($_GET["order_name_mn"])) ? $_GET["order_name_mn"] : "";
	$phylum_name_mn = (isset($_GET["phylum_name_mn"])) ? $_GET["phylum_name_mn"] : "";

	if(empty($phylum_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapn.phylum_name_mn) LIKE lower('%".$phylum_name_mn."%')";
		$search_url .= "&phylum_name_mn=".$phylum_name_mn;
	}
	
	if(empty($order_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(taon.order_name_mn) LIKE lower('%".$order_name_mn."%') OR lower(taon.alternative_name) LIKE lower('%".$order_name_mn."%'))";
		$search_url .= "&order_name_mn=".$order_name_mn;
	}

	if(empty($family_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tafn.family_name_mn) LIKE lower('%".$family_name_mn."%') OR lower(tafn.alternative_name) LIKE lower('%".$family_name_mn."%'))";
		$search_url .= "&family_name_mn=".$family_name_mn;
	}
		
	if(empty($genus_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%".$genus_name."%') OR lower(tagn.synonyms_name) LIKE lower('%".$genus_name."%') OR lower(tagn.basionum_name) LIKE lower('%".$genus_name."%') )";
		$search_url .= "&genus_name=".$genus_name;
	}
	
	if(empty($genus_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%".$genus_name_mn."%') OR lower(tagn.synonyms_name) LIKE lower('%".$genus_name_mn."%') OR lower(tagn.basionum_name) LIKE lower('%".$genus_name_mn."%') )";
		$search_url .= "&genus_name_mn=".$genus_name_mn;
	}
		
	$sort_url = "";
	$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
	$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;
	
	if($sort==0)
		$sort_url .= "";
	else
		$sort_url .= "&sort=".$sort;
	
	if($sort_type==0)
		$sort_url .= "";
	else
		$sort_url .= "&sorttype=".$sort_type; 
	
	if ($action=="edit")
	{
		require("tagenusname/inc.edit_genusnameform.php");
	}elseif ($action=="add")
	{
		require("tagenusname/inc.add_genusnameform.php");
	}elseif ($action=="more")
	{
		require("tagenusname/inc.more_genusnameform.php");
	}else
	{
		require("tagenusname/inc.list_genusnameform.php");
	}
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}	
?>
