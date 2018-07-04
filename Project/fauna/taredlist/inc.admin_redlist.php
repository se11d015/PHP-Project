<?php
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 1))
{				
	$my_url .= "?menuitem=".$menuitem;
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}else
	{
		$action = "";
	}
	
	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 3, 2))
	{	
		require("modules/upload_document.class.php");

		if (isset($_POST["insertredlistbttn"]) && (int) $_POST["insertredlistbttn"]==1)
		{
			if (isset($_POST["species_code"]) && isset($_POST["evaluated_year"]))
			{	
				$species_code  = (int) $_POST["species_code"];
				
				$fauna_filename = "";
				$dist_filename = "";
				$picture_pathname = "";

				$fauna_fullname = "";
				$dist_fullname = "";
	
				if (is_uploaded_file($_FILES['fauna_filename']['tmp_name'])) 
				{
					$today = date('Y-m-d');
	
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/" . $year;
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $_MY_CONF["REDLIST_PATH"];
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $species_code . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
	
					$uploader = new file_upload();
					$uploader->first_values('', '_' . $species_code, 'MB', '20');
					$uploader->uploader_set($_FILES['fauna_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);
	
					if ($uploader->uploaded) {
						$fauna_filename = $uploader->uploaded_files[0];			
						$fauna_fullname = $path.$fauna_filename;
					} else {
						show_notification("error", "", $uploader->error);
					}
				}
	
				if (is_uploaded_file($_FILES['dist_filename']['tmp_name'])) {
					$today = date('Y-m-d');
	
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/" . $year;
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $_MY_CONF["REDLIST_PATH"];
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $species_code . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
	
					$uploader = new file_upload();
					$uploader->first_values('', '_' . $species_code, 'MB', '20');
					$uploader->uploader_set($_FILES['dist_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);
	
					if ($uploader->uploaded) {
						$dist_filename = $uploader->uploaded_files[0];
						$dist_fullname = $path.$dist_filename;						
					} else {
						show_notification("error", "", $uploader->error);
					}
				}		
											
				$fields = array("species_code", "evaluated_year", "global_code", "sub_global_status", "regional_code", "sub_regional_status", "assessment_rationale_mn", 
				"assessment_rationale_en", "global_distribution_mn", "global_distribution_en", "regional_distribution_mn", "regional_distribution_en", "dominant_threats_mn", "dominant_threats_en", 
				"measures_place_mn", "measures_place_en", "measures_required_mn", "measures_required_en", "fauna_filename", "dist_filename", "picture_pathname", "user_id");

				$checkvalues = array((int)$_POST["species_code"], (int)$_POST["evaluated_year"], (int) $_POST["global_code"], $_POST["sub_global_status"], (int) $_POST["regional_code"], $_POST["sub_regional_status"], $_POST["assessment_rationale_mn"], 
				$_POST["assessment_rationale_en"], $_POST["global_distribution_mn"], $_POST["global_distribution_en"], $_POST["regional_distribution_mn"], $_POST["regional_distribution_en"], $_POST["dominant_threats_mn"], $_POST["dominant_threats_en"], 
				$_POST["measures_place_mn"], $_POST["measures_place_en"], $_POST["measures_required_mn"], $_POST["measures_required_en"], $fauna_fullname, $dist_fullname, $picture_pathname, $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taredlist", $fields, $values);
				if(! $result) {
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
					if(strlen($fauna_fullname)>0)
						unlink($fauna_fullname);	
					if(strlen($dist_fullname)>0)
						unlink($dist_fullname);					
				} else {
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		
				}
			}
			
		}
	
		if (isset($_POST["updateredlistbttn"]) && (int) $_POST["updateredlistbttn"]==1)
		{
			if (isset($_POST["species_code"]) && isset($_POST["evaluated_year"]) && isset($_POST["redlist_id"]))
			{	
				$wherevalues = "redlist_id=".(int) $_POST["redlist_id"];
				$species_code  = (int) $_POST["species_code"];
				
				$fauna_filename = "";
				$dist_filename = "";
				$picture_pathname = "";

				$fauna_fullname = "";
				$dist_fullname = "";

                if (is_uploaded_file($_FILES['fauna_filename']['tmp_name'])) 
				{
                    $today = date('Y-m-d');

                    $file = "files/index.php";
                    $year = date("Y", strtotime($today));
                    $path = "upload/" . $year;
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $_MY_CONF["REDLIST_PATH"];
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $species_code . "/";
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }

                    $uploader = new file_upload();
                    $uploader->first_values('', '_' . $species_code, 'MB', '20');
                    $uploader->uploader_set($_FILES['fauna_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);

					if ($uploader->uploaded) {

                        if (!empty($_POST["fauna_filename"]))
                            unlink($_POST["fauna_filename"]);
                        $fauna_filename = $uploader->uploaded_files[0];
 						$fauna_fullname = $path.$fauna_filename;
                    } else {
                        show_notification("error", "", $uploader->error);
                    }
                } else {
                    if (isset($_POST["fauna_filename"]) && !empty($_POST["fauna_filename"])) {
                        $fauna_filename = $_POST["fauna_filename"];
						$fauna_fullname = $_POST["fauna_filename"];
                    }
                }

                if (is_uploaded_file($_FILES['dist_filename']['tmp_name'])) 
				{
                    $today = date('Y-m-d');

                    $file = "files/index.php";
                    $year = date("Y", strtotime($today));
                    $path = "upload/" . $year;
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $_MY_CONF["REDLIST_PATH"];
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $species_code . "/";
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }

                    $uploader = new file_upload();
                    $uploader->first_values('', '_' . $species_code, 'MB', '20');
                    $uploader->uploader_set($_FILES['dist_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);

                    if ($uploader->uploaded) {
                        if (!empty($_POST["dist_filename"]))
                            unlink($_POST["dist_filename"]);
                        $dist_filename = $uploader->uploaded_files[0];
                        $dist_fullname = $path.$dist_filename;
                    } else {
                        show_notification("error", "", $uploader->error);
                    }
                } else {
                    if (isset($_POST["dist_filename"]) && !empty($_POST["dist_filename"])) {
                        $dist_filename = $_POST["dist_filename"];
                        $dist_fullname = $_POST["dist_filename"];
                    }
                }
				
				$fields = array("species_code", "evaluated_year", "global_code", "sub_global_status", "regional_code", "sub_regional_status", "assessment_rationale_mn", "assessment_rationale_en", 
				"global_distribution_mn", "global_distribution_en", "regional_distribution_mn", "regional_distribution_en", "dominant_threats_mn", "dominant_threats_en", 
				"measures_place_mn", "measures_place_en", "measures_required_mn", "measures_required_en", "fauna_filename", "dist_filename", "picture_pathname", "user_id");


				$checkvalues = array((int)$_POST["species_code"], (int)$_POST["evaluated_year"], (int) $_POST["global_code"], $_POST["sub_global_status"], (int) $_POST["regional_code"], $_POST["sub_regional_status"], $_POST["assessment_rationale_mn"], 
				$_POST["assessment_rationale_en"], $_POST["global_distribution_mn"], $_POST["global_distribution_en"], $_POST["regional_distribution_mn"], $_POST["regional_distribution_en"], $_POST["dominant_threats_mn"], $_POST["dominant_threats_en"], 
				$_POST["measures_place_mn"], $_POST["measures_place_en"], $_POST["measures_required_mn"], $_POST["measures_required_en"], $fauna_fullname, $dist_fullname, $picture_pathname, (int) $_POST["user_id"]);	

	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taredlist", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}
						
		if (($action=="delete") && isset($_GET["redlist_id"]))
		{
			$redlist_id = (int) $_GET["redlist_id"];
			
			
			if($sess_profile==1)
				$wherevalues = "redlist_id = ".$redlist_id;
			else
				$wherevalues = "redlist_id = ".$redlist_id." AND user_id = ".$sess_user_id;
				
			$selQuery = "SELECT fauna_filename, dist_filename, picture_pathname FROM ".$schemas.".taredlist WHERE ".$wherevalues;	
			$rowfile = $db->query($selQuery);
			 
			$result = $db->delete("".$schemas.".taredlist", $wherevalues);
			if(! $result) {
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			} else {
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
				if (!empty($rowfile)) 
				{
/*
					if (!empty($rowfile[0]["picture_pathname"]) && !empty($rowfile[0]["fauna_filename"]))
                    	unlink($rowfile[0]["picture_pathname"] . $rowfile[0]["fauna_filename"]);
					if (!empty($rowfile[0]["picture_pathname"]) && !empty($rowfile[0]["dist_filename"]))
                    	unlink($rowfile[0]["picture_pathname"] . $rowfile[0]["dist_filename"]);
*/						
					if (!empty($rowfile[0]["fauna_filename"]))
                    	unlink($rowfile[0]["fauna_filename"]);
					if (!empty($rowfile[0]["dist_filename"]))
                    	unlink($rowfile[0]["dist_filename"]);
						
				}
				 
			}		
		
		}
	}
	
	$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
	$my_page = "&page=".$page;
	
	$searchQuery = "";
	$search_url = "";
	
	$species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
	$species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";
    $class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
    $family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
    $order_name_mn = (isset($_GET["order_name_mn"])) ? $_GET["order_name_mn"] : "";

	$global_code = (isset($_GET["global_code"])) ? (int) $_GET["global_code"] : 0;
	$regional_code = (isset($_GET["regional_code"])) ? (int) $_GET["regional_code"] : 0;
	
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
	
	if($global_code==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tarl.global_code = ".$global_code;
		$search_url .= "&global_code=".$global_code;
	}
	if($regional_code==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tarl.regional_code = ".$regional_code;
		$search_url .= "&regional_code=".$regional_code;
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
		require("taredlist/inc.edit_redlistform.php");
	}elseif ($action=="add")
	{
		require("taredlist/inc.add_redlistform.php");
	}elseif ($action=="more")
	{
		require("taredlist/inc.more_redlistform.php");
	}else
	{
		require("taredlist/inc.list_redlistform.php");
	}
	
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}	
?>
