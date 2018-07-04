<?php
if($metadata_id==1) 
{
	$sum=0;
	
	$startQuery = "SELECT";
	$table_name = getdata($TABLE_NAME, $tableid);
	$pk_name = getdata($PK_NAME, $tableid);
	
	$valueQuery = "count(*) as meta_count, date_part('year', tm_h.action_date) as tm_year, date_part('month', tm_h.action_date) as tm_month, tg.group_name_mn, tg.group_name_en";
	$fromQuery = "FROM ".$schemas.".".$table_name." tm, ".$schemas.".".$table_name."_h tm_h, ".$schemas.".tagroups tg, ".$schemas.".tausergroups tug";
	$groupQuery = "GROUP BY tm_year, tm_month, tg.group_name_mn, tg.group_name_en";
	$sortQuery = "ORDER BY tg.group_name_mn, tm_year DESC, tm_month ASC";
	
	if($checkaimag==0)
		$whereQuery = "WHERE tm.user_id = tug.user_id AND tug.group_id = tg.group_id AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";
	else 
		$whereQuery = "WHERE tm.user_id = tug.user_id AND tug.group_id = tg.group_id AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT' AND tm.user_id = ".$sess_user_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$whereQuery." ".$searchQuery." ".$groupQuery." ".$sortQuery;
	$rows = $db->query($selQuery);

	if (!empty($rows))
	{
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="5"><span class="title"><?php echo _p("MetadataColumn1").": ".getdata($TABLE_ID, $tableid); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th colspan="5"><?php echo _p("MetadataText5"); ?><span class="pull-right">
          <?php $metadate=_p("MetadataInfo1"); if(empty($action_date1)) $metadate.=" "._p("MetadataInfo2"); else $metadate.=" "._p("MetadataInfo8")." ".$action_date1." "._p("MetadataInfo3"); if(!empty($action_date2)) $metadate.=" "._p("MetadataInfo7")." ".$action_date2." "._p("MetadataInfo4"); echo $metadate;?>
          </span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th><?php echo _p("MetadataColumn5");?></th>
        <th><?php echo _p("MetadataColumn6");?></th>
        <th><?php echo _p("MetadataColumn7");?></th>
        <th><?php echo _p("MetadataColumn2");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
		for ($i=0; $i < sizeof($rows); $i++) 
		{
			$sum = $sum + $rows[$i]["meta_count"];
?>
      <tr>
        <td><?php echo $i+1; ?></td>
        <td><?php echo $rows[$i]["group_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["tm_year"]; ?></td>
        <td><?php echo $rows[$i]["tm_month"]; ?></td>
        <td><?php echo $rows[$i]["meta_count"]; ?></td>
      </tr>
      <?php
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
	} else {
		$notify = " <a class=\"btn btn-danger\" href=\"".$my_url.$search_url."\"><i class=\"fa fa-undo\"></i> "._p("BackButton")." </a>";
		show_notification("error", _p("NotRowText"), $notify);
	}
}
?>
