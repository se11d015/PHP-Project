<?php
if (isset($_POST["searchorgbttn"])) 
{
	$searchQuery = "";
	$search_url = "";

	$aimag_name = (isset($_POST["aimag_name"])) ? (int) $_POST["aimag_name"] : 0;
	$org_name = (isset($_POST["org_name"])) ? pg_prep($_POST["org_name"]) : "";
	$permission_number = (isset($_POST["permission_number"])) ? pg_prep($_POST["permission_number"]) : "";
	$approved_date = (isset($_POST["approved_date"])) ? (int) $_POST["approved_date"]: 0;
	$permission_type = (isset($_POST["permission_type"])) ? (int) $_POST["permission_type"]: 0;
	$permission_valid = (isset($_POST["permission_valid"])) ? (int) $_POST["permission_valid"]: 1;
	
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
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"])) 
{
    if ($_GET["sort"] == 2) 
	{
       $sortQuery .= " va.aimag_name_mn";
    } else if($_GET["sort"]==3) {
		$sortQuery .= " tao.permission_number";
    } else if($_GET["sort"]==4) {
		$sortQuery .= " tao.approved_date";
	} else if($_GET["sort"]==5)	{
		$sortQuery .= " tao.end_date";
	} else {
        $sortQuery .= " tgo.org_name";
    }
} else {
    $sortQuery .= " tgo.org_name";
}

if (isset($_GET["sorttype"])) 
{
    if ($_GET["sorttype"] == 2) 
	{
        $sorttype = 1;
        $sortQuery .= " ASC";
    } else {
        $sorttype = 2;
        $sortQuery .= " DESC";
    }
} else {
    $sorttype = 1;
    $sortQuery .= " ASC";
}

if(isset($_GET["sort"]) && isset($_GET["sorttype"]))
{
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
}

$startQuery = "SELECT";
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".tgorgpername tgo, ".$schemas.".taorgpermission tao, scadministrative.vaaimagname va";
$whereQuery = "WHERE tgo.gid = tao.org_id AND tgo.aimag_name = va.aimag_code AND tgo.sector_status = 2";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
$rows = $db1->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];
$maxpage = ceil( $sum / $count);

require("includes/orgname/inc.search_orgname.php");	

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");

?>

<div class="table-responsive-md">
  <table id="forestresource_datatables" class="table table-bordered table-hover" title_name="<?php echo _p("OrgNameTitle"); ?>" file_name="forestresourcedata" column_name="0, 1, 2, 3, 4, 5, 6" language_name="<?php echo $language_name;?>" page_count="<?php echo $count;?>">
    <thead>
      <tr>
        <th colspan="8"><form class="form-inline pull-right" action="<?php echo $my_count.$search_url.$sort_url; ?>" method="post" name="changeform" id="changeform">
		  <label class="mr-2"><?php echo _p("ShowRowsText");?></label>
		  <?php echo seldata("count", "form-control", $RECORD_COUNTS, $count, ""); ?>
        </form></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("OrgNameColumn1");?></a></th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("OrgNameColumn2");?></a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("OrgNameColumn3");?></a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("OrgNameColumn4");?></a></th>
        <th><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("OrgNameColumn5");?></a></th>
        <th><?php echo _p("OrgNameColumn6");?></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page - 1) * $count;
		$startQuery = "SELECT";
		$valueQuery = "tgo.org_name, tao.permission_id, tao.permission_number, tao.approved_date, tao.end_date, tao.permission_type, va.aimag_name_mn, va.aimag_name_en FROM ".$schemas.".tgorgpername tgo,".$schemas.".taorgpermission tao, scadministrative.vaaimagname va";
		$whereQuery = "WHERE tgo.gid = tao.org_id AND tgo.aimag_name = va.aimag_code AND tgo.sector_status = 2";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
	
		$rows = $db1->query($selQuery);
		
		for ($i = 0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page - 1) * $count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["aimag_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["org_name"]; ?></td>
        <td><?php echo $rows[$i]["permission_number"]; ?></td>
        <td><?php echo $rows[$i]["approved_date"]; ?></td>
        <td><?php echo $rows[$i]["end_date"]; ?></td>
        <td><?php
			$permission_type = "";
			$fldCode = explode(', ', $rows[$i]["permission_type"]);

			if(is_array($fldCode)){
				for($j=0; $j<sizeof($fldCode); $j++){
					if(!empty($fldCode[$j])){
						$values = $db1->query("SELECT tcp.permissiontype_name FROM ".$schemas.".tcpermissiontype tcp WHERE tcp.permissiontype_id = ".$fldCode[$j]."");	
						$permission_type .= (empty($values[0]) ? " ": $values[0]["permissiontype_name"].", ");
					}
				}
			}		
			echo $permission_type; 
			?></td>
        <td><a class="btn btn-success" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&permission_id=".$rows[$i]["permission_id"]; ?>" title="<?php echo _p("MoreTitle"); ?>"><?php echo _p("MoreButton"); ?></a></td>
      </tr>
      <?php
		}
		?>
    </tbody>
  </table>
  <?php
	require("pagination/inc.pagination1.php");
	pagelink1($count, $maxpage, $my_url, $page, $search_url.$sort_url);
	?>
</div>
