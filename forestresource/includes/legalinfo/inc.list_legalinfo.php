<?php
if (isset($_POST["searchlegalbttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$legal_type = (isset($_POST["slegal_type"])) ? (int) $_POST["slegal_type"] : 0;
	$legal_name = (isset($_POST["slegal_name"])) ? pg_prep($_POST["slegal_name"]) : "";
	$issued_date = (isset($_POST["sissued_date"])) ? (int) $_POST["sissued_date"] : 0;
	$legal_status = (isset($_POST["slegal_status"])) ? pg_prep($_POST["slegal_status"]) : "t";
	
	if($legal_type == 0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND tli.legal_type = ".$legal_type;
		$search_url .= "&legal_type=".$legal_type;
	}

	if($issued_date == 0)
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND date_part('year', tli.issued_date) = ".$issued_date;
		$search_url .= "&issued_date=".$issued_date;
	}
	
	if(empty($legal_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND lower(tli.legal_name) LIKE lower('%".$legal_name."%')";
		$search_url .= "&legal_name=".$legal_name;
	}
	
	if($legal_status == "t")
	{
		$searchQuery .= " AND tli.legal_status = 't'";
		$search_url .= "&legal_status=t";
	}else
	{
		$searchQuery .= " AND tli.legal_status = 'f'";
		$search_url .= "&legal_status=f";
	}
}

$sortQuery = " ORDER BY ";

if (isset($_GET["sort"]))
{
	if ($_GET["sort"] == 2)
	{
		$sortQuery .= " tli.issued_date";
	}
	else if ($_GET["sort"] == 3)
	{
		$sortQuery .= " tli.act_number";
	}
	else if ($_GET["sort"] == 4)
	{
		$sortQuery .= " tli.legal_type";
	}
	else
	{
		$sortQuery .= " tli.legal_name";
	}
}else
{
	$sortQuery .= " tli.issued_date";
}

if (isset($_GET["sorttype"]))
{
	if ($_GET["sorttype"] == 2)
	{
		$sorttype = 1;
		$sortQuery .= " ASC";
	}else
	{
		$sorttype = 2;
		$sortQuery .= " DESC";
	}
}else
{
	$sorttype = 2;
	$sortQuery .= " DESC";
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
$valueQuery = "COUNT(*) AS num_count FROM sclegal.talegalinfo tli, sclegal.tclegaltype tclt";
$whereQuery = "WHERE tli.legal_type = tclt.type_id AND tli.legal_topic = 3";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$searchQuery;

$rows = $db1->query($selQuery);

$sum = 0;
if(sizeof($rows)>0)
	$sum = $rows[0]["num_count"];

$maxpage = ceil( $sum / $count);

require("includes/legalinfo/inc.search_legalinfo.php");

$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
show_notification("info", $notifytitle, "");
?>

<div class="table-responsive-md">
  <table id="forestresource_datatables" class="table table-bordered table-hover" title_name="<?php echo _p("LegalInfoTitle"); ?>" file_name="forestresourcedata" column_name="0, 1, 2, 3, 4, 5" language_name="<?php echo $language_name;?>" page_count="<?php echo $count;?>">
    <thead>
      <tr>
        <th colspan="8"><form class="form-inline pull-right" action="<?php echo $my_count.$search_url.$sort_url; ?>" method="post" name="changeform" id="changeform">
		  <label class="mr-2"><?php echo _p("ShowRowsText");?></label>
		  <?php echo seldata("count", "form-control", $RECORD_COUNTS, $count, ""); ?>
        </form></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th><a href="<?php echo $my_url."&sort=4&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("LegalInfoColumn1");?></a></th>
        <?php if($legal_type!=1 && $legal_type!=3) { ?>
        <th><a href="<?php echo $my_url."&sort=3&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("LegalInfoColumn4");?></a></th>
        <?php } ?>
        <?php if($legal_type>7 && $legal_type<11) { ?>
        <th><?php echo _p("LegalInfoColumn5");?></th>
        <?php } ?>
        <th><a href="<?php echo $my_url."&sort=1&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("LegalInfoColumn6");?></a></th>
        <th> <a href="<?php echo $my_url."&sort=2&sorttype=".$sorttype.$search_url; ?>" style="color:#FFFFFF"><i class="fa fa-sort"></i> <?php echo _p("LegalInfoColumn7");?></a> </th>
        <th><?php echo _p("LegalInfoColumn8");?></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php

		$limit = $count." OFFSET ".($page-1)*$count;
	
		$startQuery = "SELECT";
	
		$valueQuery = "tli.*, tclt.type_name_mn, tclt.type_name_en";
	
		if($legal_type>7 && $legal_type<11)
			$valueQuery .= ", tao.org_name_mn, tao.org_name_en";
	
		$fromQuery = " FROM sclegal.talegalinfo tli, sclegal.tclegaltype tclt ";
	
		if($legal_type>7 && $legal_type<11)
			$fromQuery .= ", sclegal.taorgname tao ";
		
		$whereQuery = " WHERE tli.legal_type = tclt.type_id AND tli.legal_topic = 3";
		
		if($legal_type>7 && $legal_type<11)
			$whereQuery .= " AND tli.org_name = tao.org_id ";
	
		$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$whereQuery." ".$searchQuery." ".$sortQuery." LIMIT ".$limit;
	
		$rows = $db1->query($selQuery);
	
		for ($i=0; $i < sizeof($rows); $i++) 
		{
		?>
      <tr>
        <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
        <td><?php echo $rows[$i]["type_name_$language_name"]; ?></td>
        <?php if($legal_type!=1 && $legal_type!=3) { ?>
        <td><?php echo $rows[$i]["act_number"]; ?></td>
        <?php } ?>
        <?php if($legal_type>7 && $legal_type<11) { ?>
        <td><?php echo $rows[$i]["org_name_$language_name"]; ?></td>
        <?php } ?>
        <td><?php if(strlen($rows[$i]["pathname"])>0 && strlen($rows[$i]["filename"])>0) { ?>
          <a href="<?php echo "http://"."www.eic.mn/legalinfo/".$rows[$i]["pathname"]."/".$rows[$i]["filename"]; ?>" target="_blank"><?php echo $rows[$i]["legal_name"]; ?></a>
          <?php } else { echo $rows[$i]["legal_name"]; } ?></td>
        <td><?php echo $rows[$i]["issued_date"]; ?></td>
        <td><?php echo $rows[$i]["followed_date"]; ?></td>
        <td><a class="btn btn-success" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=more&legalid=".$rows[$i]["legal_id"]; ?>" title="<?php echo _p("MoreTitle"); ?>"><?php echo _p("MoreButton"); ?></a></td>
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
