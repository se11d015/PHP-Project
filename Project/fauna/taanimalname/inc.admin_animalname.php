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
		if (isset($_POST["insertspeciesbttn"]) && (int) $_POST["insertspeciesbttn"]==1)
		{
		
			if (isset($_POST["genus_code"]) && isset($_POST["species_code"]) && isset($_POST["species_name"]))
			{	
				$fields = array("genus_code", "species_code", "species_name", "citation_author", "citation_year", "species_name_mn", "species_name_en", " species_name_ru", "synonyms_name", "basionum_name", "taxonid", "barcode", "user_id");
				
				$checkvalues = array((int)$_POST["genus_code"], (int)$_POST["species_code"], $_POST["species_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["species_name_mn"], $_POST["species_name_en"], $_POST["species_name_ru"],$_POST[ "synonyms_name"], $_POST["basionum_name"], $_POST["taxonid"], $_POST["barcode"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taanimalname", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");	
			}
		}
		
		if (isset($_POST["updatespeciesbttn"]) && (int) $_POST["updatespeciesbttn"]==1)
		{
			if (isset($_POST["genus_code"]) && isset($_POST["species_code"]) && isset($_POST["species_name"]) && isset($_POST["species_id"]))
			{	
				$wherevalues = "species_id=".(int) $_POST["species_id"];
				
				$fields = array("genus_code", "species_code", "species_name", "citation_author", "citation_year", "species_name_mn", "species_name_en", " species_name_ru", "synonyms_name", "basionum_name", "taxonid", "barcode", "user_id");
				
				$checkvalues = array((int)$_POST["genus_code"], (int)$_POST["species_code"], $_POST["species_name"], $_POST["citation_author"], (int) $_POST["citation_year"], $_POST["species_name_mn"], $_POST["species_name_en"], $_POST["species_name_ru"],$_POST[ "synonyms_name"], $_POST["basionum_name"], $_POST["taxonid"], $_POST["barcode"], (int) $_POST["user_id"]);	

	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taanimalname", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}
						
		if (($action=="delete") && isset($_GET["species_id"]))
		{
			$species_id = (int) $_GET["species_id"];
			
			if($sess_profile==1)
				$wherevalues = "species_id = ".$species_id;
			else
				$wherevalues = "species_id = ".$species_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".taanimalname",$wherevalues);
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
		
	$species_name = (isset($_GET["species_name"])) ?  $_GET["species_name"] : "";
	$species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
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
	
	if(empty($genus_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tagn.genus_name_mn) LIKE lower('%".$genus_name_mn."%') OR lower(tagn.synonyms_name) LIKE lower('%".$genus_name_mn."%') OR lower(tagn.basionum_name) LIKE lower('%".$genus_name_mn."%') )";
		$search_url .= "&genus_name_mn=".$genus_name_mn;
	}
	
	if(empty($species_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name) LIKE lower('%".$species_name."%') OR lower(tapl.synonyms_name) LIKE lower('%".$species_name."%') OR lower(tapl.basionum_name) LIKE lower('%".$species_name."%') )";
		$search_url .= "&species_name=".$species_name;
	}
	
	if(empty($species_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name_mn) LIKE lower('%".$species_name_mn."%') OR lower(tapl.synonyms_name) LIKE lower('%".$species_name_mn."%') OR lower(tapl.basionum_name) LIKE lower('%".$species_name_mn."%'))";
		$search_url .= "&species_name_mn=".$species_name_mn;
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
		require("taanimalname/inc.edit_animalnameform.php");
	}elseif ($action=="add")
	{
		require("taanimalname/inc.add_animalnameform.php");
	}elseif ($action=="more")
	{
		require("taanimalname/inc.more_animalnameform.php");
	}else
	{
		require("taanimalname/inc.list_animalnameform.php");
	}
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}	
?>
