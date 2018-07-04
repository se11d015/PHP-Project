<?php
if (isset($_POST["searchownerforestbttn"])) 
{
	$searchQuery = "";
	$search_url_new = "";

	$slowner_year = (isset($_POST["slowner_year"])) ? (int) $_POST["slowner_year"] : 0;		
	$slaimag_code = (isset($_POST["slaimag_code"])) ? (int) $_POST["slaimag_code"] : 0;

	if($slaimag_code==0)
	{
		$searchQuery .= "";
		$search_url_new .= "";
	} else
	{
		$searchQuery .= " AND vs.aimag_code = ".$slaimag_code;
		$search_url_new .= "&slaimag_code=".$slaimag_code;
	}
		
	if($slowner_year==0)
	{
		$searchQuery .= "";
		$search_url_new .= "";
		
	} else
	{
		$searchQuery .= " AND taf.owner_year = ".$slowner_year;
		$search_url_new .= "&slowner_year=".$slowner_year;
	}
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"])) 
{
    if ($_GET["sort"] == 2) 
	{
        $sortQuery .= " vs.aimag_name_mn";
    } else if ($_GET["sort"] == 3) 
	{
        $sortQuery .= " vs.soum_name_mn";
    } else if ($_GET["sort"] == 4) 
	{
        $sortQuery .= " taf.total_owner_number";
    } else if ($_GET["sort"] == 5) 
	{
        $sortQuery .= " taf.total_owner_area";					
    } else
	{
        $sortQuery .= " taf.owner_year";
    }
} else 
{
    $sortQuery .= " taf.owner_id";
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
    $sorttype = 2;
    $sortQuery .= " DESC";
}

if(isset($_GET["sort"]) && isset($_GET["sorttype"]))
{
	$sort_url_new = "";
	$sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
	$sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;

	if($sort==0)
		$sort_url_new .= "";
	else
		$sort_url_new .= "&sort=".$sort;
	
	if($sort_type==0)
		$sort_url_new .= "";
	else
		$sort_url_new .= "&sorttype=".$sort_type; 
}

$startQuery = "SELECT";
$valueQuery = "COUNT(*) AS num_count FROM ".$schemas.".taownerforest taf, scadministrative.vasoumname vs";
$whereQuery = "WHERE taf.soum_code = vs.soum_code";
/*
if($checkaimag==1) 
{
	$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
}
*/
if($sess_profile==2) 
{
	$whereQuery .= " AND taf.user_id = ".$sess_user_id;
}

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;
$rows = $db->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];

$maxpage = ceil( $sum / $count);

require("tgownerforest/inc.select_search_ownerforest.php");	

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");

?>

<div class="table-responsive">
  <table id="forestresource_datatables" class="table table-bordered table-hover" title_name="<?php echo _p("ResourceSubTitle7"); ?>" file_name="ownerforest" column_name="0, 1, 2, 3, 4, 5" language_name="<?php echo $language_name;?>" page_count="<?php echo $count;?>">
    <thead>	
      <tr>
        <th colspan="7"><form class="form-inline pull-right" action="<?php echo $my_count.$search_url_new.$sort_url_new; ?>" method="post" name="changeform" id="changeform">
		  <label class="mr-2"><?php echo _p("ShowRowsText");?></label>
		  <?php echo seldata("count", "form-control", $RECORD_COUNTS, $count, ""); ?>
        </form></th>
      </tr>
      <tr>
        <th>№</th>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url_new; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub7Column3"); ?></a></th>		
        <th><a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url_new; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub7Column1"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url_new; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub7Column2"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url_new; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub7Column4"); ?></a></th>
        <th><a href="<?php echo $my_url."&sort=5&sorttype=".$sorttype.$search_url_new; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("ResourceSub7Column5"); ?></a></th>		
        <th><?php echo _p("Operation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
		$limit = $count." OFFSET ".($page - 1) * $count;
		$startQuery = "SELECT";
		$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en FROM ".$schemas.".taownerforest taf, scadministrative.vasoumname vs";
		$whereQuery = "WHERE taf.soum_code = vs.soum_code";
/*		
		if($checkaimag==1) 
		{
			$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
		}
*/
		if($sess_profile==2) 
		{
			$whereQuery .= " AND taf.user_id = ".$sess_user_id;
		}
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
	
		$rows = $db->query($selQuery);
		
		for ($i = 0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page - 1) * $count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["owner_year"]; ?></td>
        <td><?php echo $rows[$i]["aimag_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["soum_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["total_owner_number"]; ?></td>
        <td><?php echo $rows[$i]["total_owner_area"]; ?></td>
        <td>
          <?php 
			if($sess_profile==1)
			{ 
			?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url_new.$sort_url_new."&action=add&owner_id=".$rows[$i]["owner_id"]; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a>
          <?php
			} else if($rows[$i]["user_id"]==$sess_user_id) {
			?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url_new.$sort_url_new."&action=add&owner_id=".$rows[$i]["owner_id"]; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a>
          <?php
			}
			?></td>
      </tr>
      <?php
		}
		?>
    </tbody>
  </table>
  <table>
    <tbody>
      <tr>
        <td><a class="btn btn-primary" href="<?php echo $my_url_old.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?></a></td>
      </tr>
    </tbody>
  </table>
  <?php
	require("pagination/inc.pagination3.php");
	pagelink3($count, $maxpage, $my_url, $page_new, $search_url_new.$sort_url_new);
	?>
</div>
