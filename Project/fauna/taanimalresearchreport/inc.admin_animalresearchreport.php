<?php
if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 1))
{				
	$my_url .= "?menuitem=".$menuitem;
	
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}else
	{
		$action = "";
	}
	

	if($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 5, 2))
	{	
		require("modules/upload_document.class.php");
		
		if (isset($_POST["insertresearchreportbttn"]) && (int) $_POST["insertresearchreportbttn"]==1)
		{
			if (isset($_POST["customer_name"]) && isset($_POST["research_type"]) && isset($_POST["research_name"]) && isset($_POST["executive_name"]))
			{
				$research_type = (int) $_POST["research_type"];
				$research_filename = "";
				$research_pathname = "";		
				
				if (is_uploaded_file($_FILES['research_filename']['tmp_name']))
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
					$path = $path."/".$_MY_CONF["ANIMALRESEARCHREPORT_PATH"];
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path."/".$research_type;
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
						
					$uploader = new file_upload();
					$uploader->first_values('','_'.$research_type,'MB','20') ;
					$uploader->uploader_set($_FILES['research_filename'], date("Y", strtotime($today)).date("m", strtotime($today)).date("d", strtotime ($today)), $path, $DOCUMENT_TYPES);
					
					if ($uploader->uploaded)
					{
						$research_filename = $uploader->uploaded_files[0];
						$research_pathname = $path;
					} else 
					{
						show_notification("error", "", $uploader->error);
					}	
				}	
				if($_POST["approved_date"]!='0000-00-00')
					$approved_date = $_POST["approved_date"];
				else
					$approved_date = NULL;					
							
				$fields = array("approved_org", "approved_date", "approved_statement", "customer_name", "research_type", "research_name", "research_time", "place_name", "executive_name", "researcher_name", "research_purpose", "research_abstract", "research_filename", "research_pathname", "user_id");

				$checkvalues = array($_POST["approved_org"], $approved_date, $_POST["approved_statement"], $_POST["customer_name"], (int)$_POST["research_type"], $_POST["research_name"], $_POST["research_time"], $_POST["place_name"], $_POST["executive_name"], $_POST["researcher_name"], $_POST["research_purpose"], $_POST["research_abstract"], $research_filename, $research_pathname, $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taanimalresearchreport", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		
			}
		
		}
		if (isset($_POST["updateresearchreportbttn"]) && (int) $_POST["updateresearchreportbttn"]==1)
		{
			if (isset($_POST["customer_name"]) && isset($_POST["research_type"]) && isset($_POST["research_name"]) && isset($_POST["executive_name"]) && isset($_POST["research_id"]))
			{	
				$wherevalues = "research_id=".(int) $_POST["research_id"];

				$research_type = (int) $_POST["research_type"];							
				$research_filename = "";
				$research_pathname = "";	
								
				if (is_uploaded_file($_FILES['research_filename']['tmp_name']))
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
					$path = $path."/".$_MY_CONF["ANIMALRESEARCHREPORT_PATH"];
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
					$path = $path."/".$research_type;
					if (!is_dir($path))
					{
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path."/index.php");
					}
						
					$uploader = new file_upload();
					$uploader->first_values('','_'.$research_type,'MB','20') ;
					$uploader->uploader_set($_FILES['research_filename'], date("Y", strtotime($today)).date("m", strtotime($today)).date("d", strtotime ($today)), $path, $DOCUMENT_TYPES);
					
					if ($uploader->uploaded)
					{
						$research_filename = $uploader->uploaded_files[0];
						$research_pathname = $path;
						if(!empty($_POST["research_pathname"]) && !empty($_POST["research_filename"]))
							unlink($_POST["research_pathname"]."/".$_POST["research_filename"]);							
					} else 
					{
						show_notification("error", "", $uploader->error);
					}	
				}else
				{
					if(isset($_POST["research_filename"]) && !empty($_POST["research_filename"]))
					{
						$research_filename = $_POST["research_filename"];				
					}					
				}
				
						
				if($_POST["approved_date"]!='0000-00-00')
					$approved_date = $_POST["approved_date"];
				else
					$approved_date = 'NULL';
				
				$fields = array("approved_org", "approved_date", "approved_statement", "customer_name", "research_type", "research_name", "research_time", "place_name", "executive_name", "researcher_name", "research_purpose", "research_abstract", "research_filename", "research_pathname", "user_id");

				$checkvalues = array($_POST["approved_org"], $approved_date, $_POST["approved_statement"], $_POST["customer_name"], (int) $_POST["research_type"], $_POST["research_name"], $_POST["research_time"], $_POST["place_name"], $_POST["executive_name"], $_POST["researcher_name"], $_POST["research_purpose"], $_POST["research_abstract"], $research_filename, $research_pathname, (int) $_POST["user_id"]);	
	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taanimalresearchreport", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");		
				
			}
		}
		if (($action=="delete") && isset($_GET["research_id"]))
		{
			$research_id = (int) $_GET["research_id"];
		
			if($sess_profile== 1)
				$wherevalues = "research_id = ".$research_id;
			else
				$wherevalues = "research_id = ".$research_id." AND user_id = ".$sess_user_id;
		
			$selQuery = "SELECT research_filename, research_pathname FROM ".$schemas.".taanimalresearchreport WHERE ".$wherevalues;	
			$rowfile = $db->query($selQuery);
		
			$result = $db->delete("".$schemas.".taanimalresearchreport", $wherevalues);
			if(! $result)
			{
				show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
			}
			else {
				show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
				
				if (!empty($rowfile)) 
				{
					if(!empty($rowfile[0]["research_pathname"]) && !empty($rowfile[0]["research_filename"])) 
						unlink($rowfile[0]["research_pathname"]."/".$rowfile[0]["research_filename"]);
				}
			}
		}
		
		if (isset($_POST["insertresearchbudgetbttn"]) && (int) $_POST["insertresearchbudgetbttn"]==1)
		{
			if (isset($_POST["research_id"]) && isset($_POST["budget_resource"]))
			{			
				$fields = array("research_id", "budget_resource", "budget_amount", "user_id");

				$checkvalues = array((int)$_POST["research_id"], (int)$_POST["budget_resource"], $_POST["budget_amount"], $sess_user_id);
		
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}
				
				$result = $db->insert("".$schemas.".taanimalresearchbudget", $fields, $values);
				if(! $result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");		

			}
		}

		if (isset($_POST["updateresearchbudgetbttn"]) && (int) $_POST["updateresearchbudgetbttn"]==1)
		{
			if (isset($_POST["research_id"]) && isset($_POST["budget_resource"]) && isset($_POST["budget_id"]))
			{	
				$wherevalues = "budget_id=".(int) $_POST["budget_id"];
				
				$fields = array("research_id", "budget_resource", "budget_amount",  "user_id");

				$checkvalues = array((int)$_POST["research_id"], (int)$_POST["budget_resource"], $_POST["budget_amount"], (int) $_POST["user_id"]);	

	
				$values = array();
				for ($i=0; $i<sizeof($checkvalues); $i++)
				{
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
				}			
			
				$result = $db->update("".$schemas.".taanimalresearchbudget", $fields, $values, $wherevalues);
				if(! $result)
					show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
			}
		}

		if (($action=="budgetdelete") && isset($_GET["budget_id"]))
		{
			$budget_id = (int) $_GET["budget_id"];
			
			if($sess_profile==1)
				$wherevalues = "budget_id = ".$budget_id;
			else
				$wherevalues = "budget_id = ".$budget_id." AND user_id = ".$sess_user_id;
			 
			$result = $db->delete("".$schemas.".taanimalresearchbudget",$wherevalues);
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
	
	$research_name = (isset($_GET["research_name"])) ? $_GET["research_name"] : "";
	$research_type = (isset($_GET["research_type"])) ?  (int)$_GET["research_type"] : 0;
	$executive_name = (isset($_GET["executive_name"])) ? $_GET["executive_name"] : "";

	if(empty($research_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapr.research_name) LIKE lower('%".$research_name."%')";
		$search_url .= "&research_name=".$research_name;
	}	
	
	if($research_type==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tapr.research_type = ".$research_type;
		$search_url .= "&research_type=".$research_type;
	}
	
	if(empty($executive_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tapr.executive_name) LIKE lower('%".$executive_name."%')";
		$search_url .= "&executive_name=".$executive_name;
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
		require("taanimalresearchreport/inc.edit_animalresearchreportform.php");
	}elseif ($action=="add")
	{
		require("taanimalresearchreport/inc.add_animalresearchreportform.php");
	}elseif ($action=="budgetadd")
	{
		require("taanimalresearchreport/inc.add_animalresearchbudgetform.php");
	}elseif ($action=="budgetedit")
	{
		require("taanimalresearchreport/inc.edit_animalresearchbudgetform.php");
	}elseif ($action=="more")
	{
		require("taanimalresearchreport/inc.more_animalresearchreportform.php");
	}else
	{
		require("taanimalresearchreport/inc.list_animalresearchreportform.php");
	}
} else {
	$notify ="Таны хандалт буруу байна.";
	show_notification("error", "", $notify);
}	
?>
