<?php
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 1))
{				
	$my_url .= "?menuitem=".$menuitem;
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}else
	{
		$action = "";
	}

	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 9, 2))
	{	
		require("modules/generategeom.class.php");
		require("modules/upload_document.class.php");
		
		if (isset($_POST["insertanimalprotectionbttn"]) && (int) $_POST["insertanimalprotectionbttn"]==1)
		{
					
			if ( isset($_POST["protect_type"]) && isset($_POST["protect_date"]) && isset($_POST["protect_org"]) && isset($_POST["aimag_name"]) && isset($_POST["soum_name"]) &&  isset($_POST["place_name"]))
			{
				$geom = new generategeom();
				$geomvalues = "";
	
				$geomsrid = (int) $_POST["geom_srid"];
				$geomtype = (int) $_POST["geom_type"];
	
				// polygon
				if ($geomtype == 2) {
					$points = array();
	
					$points[0][0] = $_POST["x1"];
					$points[0][1] = $_POST["y1"];
					$points[1][0] = $_POST["x2"];
					$points[1][1] = $_POST["y2"];
					$points[2][0] = $_POST["x3"];
					$points[2][1] = $_POST["y3"];
					$points[3][0] = $_POST["x4"];
					$points[3][1] = $_POST["y4"];
					$points[4][0] = $_POST["x5"];
					$points[4][1] = $_POST["y5"];
					$points[5][0] = $_POST["x6"];
					$points[5][1] = $_POST["y6"];
					$points[6][0] = $_POST["x7"];
					$points[6][1] = $_POST["y7"];
					$points[7][0] = $_POST["x8"];
					$points[7][1] = $_POST["y8"];
					$points[8][0] = $_POST["x9"];
					$points[8][1] = $_POST["y9"];
					$points[9][0] = $_POST["x10"];
					$points[9][1] = $_POST["y10"];
	
					if ($geomsrid == 4326)
						$geomvalues = $geom->generatePolygonGeom($points, 4326);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POLYGON");
				}
	
			  // file
					if($geomtype==3){
						$filename = $_FILES['geom_file']['name'];		
						if(!empty($filename)){
							$fullname = "upload/".$filename;
							echo $fullname;
							move_uploaded_file($_FILES['geom_file']['tmp_name'],$fullname);
							$handle = fopen($fullname, "r");
							if ($handle){					
								$i=0;
								$points = array();
								while ($buffer = fgets($handle, 4096)){					
									$elements = explode("\t", $buffer);
									$points[$i][0] = $elements[1];
									$points[$i][1] = $elements[2];
									$i++;
								}
							
								fclose($handle);
				
								if($geomsrid ==4326)
									$geomvalues = $geom->generatePolygonGeom($points, 4326);
								else
									$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POLYGON");			
							}
							unlink($fullname);
						}
					}
	
				// geom
				if ($geomtype == 4) {
					if ($geomsrid == 4326)
						$geomvalues = $geom->generateGeometryGeom($_POST["geom_value"]);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $_POST["geom_value"], "GEOM");
				}
				
				 // point
				if ($geomtype == 5) {
					$points = array();
	
					$points[0] = $_POST["x_coord"];
					$points[1] = $_POST["y_coord"];
				
					 $geomvalues = $geom->generatePointGeom($points, 4326);
				}
	
				// point
				if ($geomtype == 6) {
					$points = array();
					$points[0] = ($_POST["x_coordinate_sec"]/60 + $_POST["x_coordinate_min"])/60 + $_POST["x_coordinate_deg"];
					$points[1] = ($_POST["y_coordinate_sec"]/60 + $_POST["y_coordinate_min"])/60 + $_POST["y_coordinate_deg"];
						  
					$geomvalues = $geom->generatePointGeom($points, 4326);
	
				}
	
				if (empty($geomvalues))
					$geomvalues = "NULL";
	
				if ($_POST["protect_date"] != '0000-00-00')
					$protect_date = $_POST["protect_date"];
				else
					$protect_date = date('Y-m-d');
				
				$protect_type = $_POST["protect_type"];
				$protect_filename = "";
				$protect_pathname = "";		
				if (is_uploaded_file($_FILES['protect_filename']['tmp_name']))
				{
					$today = date('Y-m-d');
					
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/".$year;
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path."/".$_MY_CONF["ANIMALPROTECTION_PATH"];
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path . "/" . $protect_type . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
						
					$uploader = new file_upload();
					$uploader->first_values('','_' . $protect_type,'MB','20') ;
					$uploader->uploader_set($_FILES['protect_filename'], date("Y", strtotime($today)).date("m", strtotime($today)).date("d", strtotime ($today)), $path, $DOCUMENT_TYPES);
					
					if ($uploader->uploaded)
					{
						$protect_filename = $uploader->uploaded_files[0];
						$protect_pathname = $path;
					} else 
					{
						show_notification("error", "", $uploader->error);
					}	
				}	
				
				if($_POST["protect_date"]!='0000-00-00')
					$protect_date = $_POST["protect_date"];
				else
					$protect_date = NULL;					
				

				
				$fields = array("protect_type", "protect_date", "protect_org", "register_number", "certificate_number", "aimag_name", "soum_name", "place_name", "protect_area", "protect_abstract ", "protect_filename", "protect_pathname", "geom", "user_id");

				$checkvalues = array($_POST["protect_type"],  $protect_date,  $_POST["protect_org"],  $_POST["register_number"],  $_POST["certificate_number"],  $_POST["aimag_name"],  $_POST["soum_name"],  $_POST["place_name"],  $_POST["protect_area"],  $_POST["protect_abstract"],  $protect_filename,  $protect_pathname);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++) 
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				array_push($values, $geomvalues, $sess_user_id);
				$result = $db->insert("".$schemas.".tganimalprotection", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		
					
			}
		
		}
		if (isset($_POST["updateanimalprotectionbttn"]) && (int) $_POST["updateanimalprotectionbttn"]==1)
		{
			if ( isset($_POST["protect_type"]) && isset($_POST["protect_date"]) && isset($_POST["protect_org"]) && isset($_POST["aimag_name"]) && isset($_POST["soum_name"]) &&  isset($_POST["place_name"]))
			{	
				$wherevalues = "protect_id=".(int) $_POST["protect_id"];
				$protect_id = (int) $_POST["protect_id"];
								
				$protect_filename = "";
				$protect_pathname = "";	
								
				if (is_uploaded_file($_FILES['protect_filename']['tmp_name']))
				{
					$today = date('Y-m-d');
					
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/".$year;
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path."/".$_MY_CONF["ANIMALPROTECTION_PATH"];
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path . "/" . $protect_type . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
						
					$uploader = new file_upload();
					$uploader->first_values('','_' . $protect_type,'MB','20') ;
					$uploader->uploader_set($_FILES['protect_filename'], date("Y", strtotime($today)).date("m", strtotime($today)).date("d", strtotime ($today)), $path, $DOCUMENT_TYPES);
					
					if ($uploader->uploaded)
					{
								
						if(!empty($_POST["protect_pathname"]) && !empty($_POST["protect_filename"]))
							unlink($_POST["protect_pathname"].$_POST["protect_filename"]);	
						$protect_filename = $uploader->uploaded_files[0];
						$protect_pathname = $path;
												
					} else 
					{
						show_notification("error", "", $uploader->error);
					}	
				}else{
					if(isset($_POST["protect_pathname"]) && !empty($_POST["protect_pathname"])&& isset($_POST["protect_filename"]) && !empty($_POST["protect_filename"]))
					{
						$protect_pathname = $_POST["protect_pathname"];				
						$protect_filename = $_POST["protect_filename"];				
					}					
				}
						
				if($_POST["protect_date"]!='0000-00-00')
					$protect_date = $_POST["protect_date"];
				else
					$protect_date = 'NULL';
	
				$geom = new generategeom();
				$geomvalues = "";
	
				$geomsrid = (int) $_POST["geom_srid"];
				$geomtype = (int) $_POST["geom_type"];
	
				// polygon
				if ($geomtype == 2) {
					$points = array();
	
					$points[0][0] = $_POST["x1"];
					$points[0][1] = $_POST["y1"];
					$points[1][0] = $_POST["x2"];
					$points[1][1] = $_POST["y2"];
					$points[2][0] = $_POST["x3"];
					$points[2][1] = $_POST["y3"];
					$points[3][0] = $_POST["x4"];
					$points[3][1] = $_POST["y4"];
					$points[4][0] = $_POST["x5"];
					$points[4][1] = $_POST["y5"];
					$points[5][0] = $_POST["x6"];
					$points[5][1] = $_POST["y6"];
					$points[6][0] = $_POST["x7"];
					$points[6][1] = $_POST["y7"];
					$points[7][0] = $_POST["x8"];
					$points[7][1] = $_POST["y8"];
					$points[8][0] = $_POST["x9"];
					$points[8][1] = $_POST["y9"];
					$points[9][0] = $_POST["x10"];
					$points[9][1] = $_POST["y10"];
					
	
					if ($geomsrid == 4326)
						$geomvalues = $geom->generatePolygonGeom($points, 4326);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POLYGON");
				}
	
			  // file
					if($geomtype==3){
						$filename = $_FILES['geom_file']['name'];		
						if(!empty($filename)){
							$fullname = "upload/".$filename;
							echo $fullname;
							move_uploaded_file($_FILES['geom_file']['tmp_name'],$fullname);
							$handle = fopen($fullname, "r");
							if ($handle){					
								$i=0;
								$points = array();
								while ($buffer = fgets($handle, 4096)){					
									$elements = explode("\t", $buffer);
									$points[$i][0] = $elements[1];
									$points[$i][1] = $elements[2];
									$i++;
								}
							
								fclose($handle);
				
								if($geomsrid ==4326)
									$geomvalues = $geom->generatePolygonGeom($points, 4326);
								else
									$geomvalues = $geom->transformGeom(4326, $geomsrid, $points, "POLYGON");			
							}
							unlink($fullname);
						}
					}
	
				// geom
				if ($geomtype == 4) {
					if ($geomsrid == 4326)
						$geomvalues = $geom->generateGeometryGeom($_POST["geom_value"]);
					else
						$geomvalues = $geom->transformGeom(4326, $geomsrid, $_POST["geom_value"], "GEOM");
				}
				
				 // point
				if ($geomtype == 5) {
					$points = array();
	
					$points[0] = $_POST["x_coord"];
					$points[1] = $_POST["y_coord"];
				
					 $geomvalues = $geom->generatePointGeom($points, 4326);
				}
	
				// point
				if ($geomtype == 6) {
					$points = array();
					$points[0] = ($_POST["x_coordinate_sec"]/60 + $_POST["x_coordinate_min"])/60 + $_POST["x_coordinate_deg"];
					$points[1] = ($_POST["y_coordinate_sec"]/60 + $_POST["y_coordinate_min"])/60 + $_POST["y_coordinate_deg"];
						  
					$geomvalues = $geom->generatePointGeom($points, 4326);
	
				}
	
				if (empty($geomvalues))
					$geomvalues = "NULL";
				//IOPIO
				if($geomtype==7) {
						
					$fields = array("protect_type", "protect_date", "protect_org", "register_number", "certificate_number", "aimag_name", "soum_name", "place_name", "protect_area", "protect_abstract ", "protect_filename", "protect_pathname", "user_id");

					$checkvalues = array($_POST["protect_type"],  $protect_date,  $_POST["protect_org"],  $_POST["register_number"],  $_POST["certificate_number"],  $_POST["aimag_name"],  $_POST["soum_name"],  $_POST["place_name"],  $_POST["protect_area"],  $_POST["protect_abstract"],  $protect_filename,  $protect_pathname,  $_POST["user_id"]);
			
					$values = array();
					for ($i=0; $i<sizeof($checkvalues); $i++)
					{
						$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
					}
					
				} else 
				{
					$fields = array("protect_type", "protect_date", "protect_org", "register_number", "certificate_number", "aimag_name", "soum_name", "place_name", "protect_area", "protect_abstract ", "protect_filename", "protect_pathname", "geom", "user_id");

					$checkvalues = array($_POST["protect_type"],  $protect_date,  $_POST["protect_org"],  $_POST["register_number"],  $_POST["certificate_number"],  $_POST["aimag_name"],  $_POST["soum_name"],  $_POST["place_name"],  $_POST["protect_area"],  $_POST["protect_abstract"],  $protect_filename,  $protect_pathname);
					
					$values = array();
					for ($i=0; $i<sizeof($checkvalues); $i++)
					{
						$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
					}
					array_push($values, $geomvalues, (int) $_POST["user_id"]);
				}

				
				$result = $db->update("".$schemas.".tganimalprotection", $fields, $values, $wherevalues);
				//FSDJ				
				
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");		
				
			}
		}
		
		if (($action=="delete") && isset($_GET["protect_id"]))
		{
			$protect_id = (int) $_GET["protect_id"];
		
			if($sess_profile== 1)
				$wherevalues = "protect_id = ".$protect_id;
			else
				$wherevalues = "protect_id = ".$protect_id." AND user_id = ".$sess_user_id;
		
			$selQuery = "SELECT protect_filename, protect_pathname FROM ".$schemas.".tganimalprotection WHERE ".$wherevalues;	
			$rowfile = $db->query($selQuery);
		
			$result = $db->delete("".$schemas.".taanimalprotectexpense", $wherevalues);
			$result = $db->delete("".$schemas.".taanimalprotectname", $wherevalues);
			$result = $db->delete("".$schemas.".tganimalprotection", $wherevalues);
			if(! $result)
			{
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			}
			else {
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
				
				if (!empty($rowfile)) 
				{
					if(!empty($rowfile[0]["protect_pathname"]) && !empty($rowfile[0]["protect_filename"])) 
						unlink($rowfile[0]["protect_pathname"].$rowfile[0]["protect_filename"]);
				}
			}
		}
		
		if (isset($_POST["insertresearchexpensebttn"]) && (int) $_POST["insertresearchexpensebttn"]==1)
		{
			if (isset($_POST["protect_id"]) && isset($_POST["expense_resource"]))
			{			
				$fields = array("protect_id", "expense_resource", "expense_amount",  "user_id");

				$checkvalues = array((int)$_POST["protect_id"], (int)$_POST["expense_resource"], $_POST["expense_amount"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taanimalprotectexpense", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		

			}
		}

		if (isset($_POST["updateresearchexpensebttn"]) && (int) $_POST["updateresearchexpensebttn"]==1)
		{
			if (isset($_POST["protect_id"]) && isset($_POST["expense_resource"]))
			{	
				$wherevalues = "expense_id=".(int) $_POST["expense_id"];
				
				$fields = array("protect_id", "expense_resource", "expense_amount",  "user_id");

				$checkvalues = array((int)$_POST["protect_id"], (int)$_POST["expense_resource"], $_POST["expense_amount"], (int) $_POST["user_id"]);	
	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taanimalprotectexpense", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}

		if (($action=="expensedelete") && isset($_GET["expense_id"]))
		{
			$expense_id = (int) $_GET["expense_id"];
			
			if($sess_profile==1)
				$wherevalues = "expense_id = ".$expense_id;
			else
				$wherevalues = "expense_id = ".$expense_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".taanimalprotectexpense",$wherevalues);
			if(! $result)
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
		
		}	
	
	
		if (isset($_POST["insertanimalprotectbttn"]) && (int) $_POST["insertanimalprotectbttn"]==1)
		{
			if (isset($_POST["protect_id"]) && isset($_POST["species_code"]))
			{			
				$fields = array("protect_id", "species_name",  "user_id");

				$checkvalues = array((int)$_POST["protect_id"], (int)$_POST["species_code"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taanimalprotectname", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		

			}
		}

		if (isset($_POST["updatereanimalbttn"]) && (int) $_POST["updatereanimalbttn"]==1)
		{
			if (isset($_POST["protect_id"]) && isset($_POST["species_code"]))
			{	
				$wherevalues = "species_id=".(int) $_POST["species_id"];
				
				$fields = array("protect_id", "species_name", "user_id");

				$checkvalues = array((int)$_POST["protect_id"], (int)$_POST["species_code"], (int) $_POST["user_id"]);	
	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taanimalprotectname", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}

		if (($action=="animaldelete") && isset($_GET["species_id"]))
		{
			$species_id = (int) $_GET["species_id"];
			
			if($sess_profile==1)
				$wherevalues = "species_id = ".$species_id;
			else
				$wherevalues = "species_id = ".$species_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".taanimalprotectname",$wherevalues);
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
	
	$protect_type = (isset($_GET["protect_type"])) ?  (int)$_GET["protect_type"] : 0;
	$protect_date = (isset($_GET["protect_date"])) ? (int) $_GET["protect_date"] : 0;
	$aimag_code = (isset($_GET["aimag_code"])) ? (int) $_GET["aimag_code"] : 0;
	
	if($protect_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tgpp.protect_type = ".$protect_type;
		$search_url .= "&protect_type=".$protect_type;
	}
	
	if($protect_date==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year',tgpp.protect_date) = ".$protect_date;
		$search_url .= "&protect_date=".$protect_date;
	}	
		
    if ($aimag_code == 0) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND tgpp.aimag_name = " . $aimag_code;
        $search_url .= "&aimag_code=" . $aimag_code;
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
		require("tganimalprotection/inc.edit_animalprotectionform.php");
	}elseif ($action=="add")
	{
		require("tganimalprotection/inc.add_animalprotectionform.php");
	}elseif ($action=="expenseadd")
	{
		require("tganimalprotection/inc.add_animalprotectexpenseform.php");
	}elseif ($action=="expenseedit")
	{
		require("tganimalprotection/inc.edit_animalprotectexpenseform.php");
	}elseif ($action=="animaladd")
	{
		require("tganimalprotection/inc.add_animalprotectnameform.php");
	}elseif ($action=="animaledit")
	{
		require("tganimalprotection/inc.edit_animalprotectnameform.php");
	}elseif ($action == "output") {
	
		require("tganimalprotection/inc.output_animalprotectionform.php");
	}elseif ($action=="more")
	{
		require("tganimalprotection/inc.more_animalprotectionform.php");
	}else
	{
		require("tganimalprotection/inc.list_animalprotectionform.php");
	}
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}	
?>
