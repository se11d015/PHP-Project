<?php
if($metadata_id==2) 
{
	$startQuery = "SELECT";
	$valueQuery = "tu.user_id, tu.lastname, tu.organization";
	$fromQuery = "FROM ".$schemas.".tausers tu";
	if($checkaimag==0)
		$whereQuery = "WHERE tu.user_id = ".$userid;
	else 
		$whereQuery = "WHERE tu.user_id = ".$userid." AND tu.user_id = ".$sess_user_id;

	$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$whereQuery;
	$row = $db->query($selQuery);
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="5"><span class="title"><?php echo _p("MetadataColumn4").": ".$row[0]["lastname"];?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th colspan="5"><?php echo _p("MetadataText7"); ?><span class="pull-right">
          <?php $metadate=_p("MetadataInfo1"); if(empty($action_date1)) $metadate.=" "._p("MetadataInfo2"); else $metadate.=" "._p("MetadataInfo8")." ".$action_date1." "._p("MetadataInfo3"); if(!empty($action_date2)) $metadate.=" "._p("MetadataInfo7")." ".$action_date2." "._p("MetadataInfo4");  echo $metadate;?>
          </span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th><?php echo _p("MetadataColumn1");?></th>
        <th><?php echo _p("MetadataColumn6");?></th>
        <th><?php echo _p("MetadataColumn7");?></th>
        <th><?php echo _p("MetadataColumn2");?></th>
      </tr>
    </thead>
    <tbody>
      <?php	
	
	$k = 0;
	$sum = 0;
	
	if($table_id==0) 
	{
		$startid = 1;
		$endid = sizeof($TABLE_ID)+1;
	} else {
		$startid = $table_id;
		$endid = $table_id+1;
	}
	
	for ($i=$startid; $i < $endid; $i++) 
	{
		$startQuery = "SELECT";
		$table_name = getdata($TABLE_NAME, $i);
		$pk_name = getdata($PK_NAME, $i);

		$valueQuery = "count(*) as meta_count, date_part('year', tm_h.action_date) as tm_year, date_part('month', tm_h.action_date) as tm_month";
		$fromQuery = "FROM ".$schemas.".".$table_name." tm, ".$schemas.".".$table_name."_h tm_h";
		$groupQuery = "GROUP BY tm_year, tm_month";
		$sortQuery = "ORDER BY tm_year DESC, tm_month ASC";
		
		if($checkaimag==0)
			$whereQuery = "WHERE tm.user_id = ".$userid." AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";
		else 
			$whereQuery = "WHERE tm.user_id = ".$userid." AND tm.user_id = ".$sess_user_id." AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";

		$fromQuery1 = "";
		$whereQuery1 = "";

		if(!$group_id==0)
		{
			$fromQuery1 .= ", ".$schemas.".tausergroups tug";
			$whereQuery1 .= " AND tm.user_id = tug.user_id";
		}

		$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$fromQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery." ".$groupQuery." ".$sortQuery;
		$rows = $db->query($selQuery);

		for ($j=0; $j < sizeof($rows); $j++) 
		{
			$sum = $sum + $rows[$j]["meta_count"];
?>
      <tr>
        <td><?php echo $k+1; ?></td>
        <td><?php echo getdata($TABLE_ID, $i); ?></td>
        <td><?php echo $rows[$j]["tm_year"]; ?></td>
        <td><?php echo $rows[$j]["tm_month"]; ?></td>
        <td><?php echo $rows[$j]["meta_count"]; ?></td>
      </tr>
      <?php
			$k++;
		}
	}
?>
      <tr>
        <th colspan="4"><?php echo _p("MetadataTotal");?></th>
        <th><?php echo $sum; ?></th>
      </tr>
      <tr>
        <td colspan="5"><a class="btn btn-primary" href="<?php echo $my_url.$search_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?> </a></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
}

if($metadata_id==3) 
{
	$startQuery = "SELECT";
	$valueQuery = "tg.group_name_mn, tg.group_name_en";
	$fromQuery = "FROM ".$schemas.".tagroups tg, ".$schemas.".tausergroups tug";
	if($checkaimag==0)
		$whereQuery = "WHERE tg.group_id = tug.group_id AND tug.group_id = ".$groupid;
	else 
		$whereQuery = "WHERE tg.group_id = tug.group_id AND tug.user_id = ".$sess_user_id." AND tug.group_id = ".$groupid;

	$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$whereQuery;
	$row = $db->query($selQuery);
?>
<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="5"><span class="title"><?php echo _p("MetadataColumn5").": ".$row[0]["group_name_$language_name"];?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th colspan="5"><?php echo _p("MetadataText7"); ?><span class="pull-right">
          <?php $metadate=_p("MetadataInfo1"); if(empty($action_date1)) $metadate.=" "._p("MetadataInfo2"); else $metadate.=" "._p("MetadataInfo8")." ".$action_date1." "._p("MetadataInfo3"); if(!empty($action_date2)) $metadate.=" "._p("MetadataInfo7")." ".$action_date2." "._p("MetadataInfo4");  echo $metadate;?>
          </span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th><?php echo _p("MetadataColumn1");?></th>
        <th><?php echo _p("MetadataColumn6");?></th>
        <th><?php echo _p("MetadataColumn7");?></th>
        <th><?php echo _p("MetadataColumn2");?></th>
      </tr>
    </thead>
    <tbody>
      <?php	
	
	$k = 0;
	$sum = 0;
	
	if($table_id==0) 
	{
		$startid = 1;
		$endid = sizeof($TABLE_ID)+1;
	} else {
		$startid = $table_id;
		$endid = $table_id+1;
	}
	
	for ($i=$startid; $i < $endid; $i++) 
	{
		$startQuery = "SELECT";
		$table_name = getdata($TABLE_NAME, $i);
		$pk_name = getdata($PK_NAME, $i);

		$valueQuery = "count(*) as meta_count, date_part('year', tm_h.action_date) as tm_year, date_part('month', tm_h.action_date) as tm_month";
		$fromQuery = "FROM ".$schemas.".".$table_name." tm, ".$schemas.".".$table_name."_h tm_h, ".$schemas.".tausergroups tug";
		$groupQuery = "GROUP BY tm_year, tm_month";
		$sortQuery = "ORDER BY tm_year DESC, tm_month ASC";
		
		if($checkaimag==0)
			$whereQuery = "WHERE tm.user_id = tug.user_id AND tug.group_id = ".$groupid." AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";
		else 
			$whereQuery = "WHERE tm.user_id = tug.user_id AND tm.user_id = ".$sess_user_id." AND tug.group_id = ".$groupid." AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";

		$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$whereQuery." ".$searchQuery." ".$groupQuery." ".$sortQuery;
		$rows = $db->query($selQuery);

		for ($j=0; $j < sizeof($rows); $j++) 
		{
			$sum = $sum + $rows[$j]["meta_count"];
?>
      <tr>
        <td><?php echo $k+1; ?></td>
        <td><?php echo getdata($TABLE_ID, $i); ?></td>
        <td><?php echo $rows[$j]["tm_year"]; ?></td>
        <td><?php echo $rows[$j]["tm_month"]; ?></td>
        <td><?php echo $rows[$j]["meta_count"]; ?></td>
      </tr>
      <?php
			$k++;
		}
	}
?>
      <tr>
        <th colspan="4"><?php echo _p("MetadataTotal");?></th>
        <th><?php echo $sum; ?></th>
      </tr>
      <tr>
        <td colspan="5"><a class="btn btn-primary" href="<?php echo $my_url.$search_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?> </a></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
}
?>
