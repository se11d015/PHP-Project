    <?php	
		$my_url = "forestresource.php?id=1";
		$schemas = "scforestresource";
		
		$count = (isset($_POST["count"]) && (int) $_POST["count"] > 0) ? (int) $_POST["count"] : ((isset($_GET["count"]) && (int) $_GET["count"] > 0) ? (int) $_GET["count"] : 10);
		$my_count = $my_url."?page=1";
		$my_url .= "&count=".$count;
		
		if (isset($_GET["action"])) {
			$action = pg_prep($_GET["action"]);
		} else {
			$action = "";
		}
				
		$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
		$my_page = "&page=".$page;		
		
		$searchQuery = "";
		$search_url = "";
		
		$saimag_code = (isset($_GET["saimag_code"])) ? (int) $_GET["saimag_code"] : 0;
		$sarea_year = (isset($_GET["sarea_year"])) ? (int) $_GET["sarea_year"] : 0;		
	
		if($saimag_code==0)
		{
			$searchQuery .= "";
			$search_url .= "";
		} else
		{
			$searchQuery .= " AND va.aimag_code = ".$saimag_code;
			$search_url .= "&saimag_code=".$saimag_code;
		}
			
		if($sarea_year==0)
		{
			$searchQuery .= "";
			$search_url .= "";
			
		} else
		{
			$searchQuery .= " AND taf.area_year = ".$sarea_year;
			$search_url .= "&sarea_year=".$sarea_year;
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
			require("includes/taforestarea/inc.more_forestarea.php");
		}else
		{
			require("includes/taforestarea/inc.list_forestarea.php");
		}	
		?>

