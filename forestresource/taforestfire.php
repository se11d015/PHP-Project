<div class="row">
  <div class="col">
    <?php	
		$my_url = "forestresource.php?id=3";
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
		$sfire_year = (isset($_GET["sfire_year"])) ? (int) $_GET["sfire_year"] : 0;		
	
		if($saimag_code==0)
		{
			$searchQuery .= "";
			$search_url .= "";
		} else
		{
			$searchQuery .= " AND va.aimag_code = ".$saimag_code;
			$search_url .= "&saimag_code=".$saimag_code;
		}
			
		if($sfire_year==0)
		{
			$searchQuery .= "";
			$search_url .= "";
			
		} else
		{
			$searchQuery .= " AND taf.fire_year = ".$sfire_year;
			$search_url .= "&sfire_year=".$sfire_year;
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
			require("includes/taforestfire/inc.more_forestfire.php");
		}else
		{
			require("includes/taforestfire/inc.list_forestfire.php");
		}	
		?>
  </div>
</div>
