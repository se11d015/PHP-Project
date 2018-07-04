<?php
if($metadata_id==1) 
{

	$sum=0;
	
	$startQuery = "SELECT";
	$table_name = getdata($TABLE_NAME, $tableid);
	$valueQuery = "count(*) as meta_count, tu.lastname, tu.organization";
	$fromQuery = "FROM ".$schemas.".".$table_name." tm, ".$schemas.".tausers tu";
	$groupQuery = "GROUP BY tu.lastname, tu.organization";
	$sortQuery = "ORDER BY tu.organization, tu.lastname";
	
	if($checkaimag==0)
		$whereQuery = "WHERE tm.user_id = tu.user_id";
	else 
		$whereQuery = "WHERE tm.user_id = tu.user_id AND tm.user_id = ".$sess_user_id;
	
	$fromQuery1 = "";
	$whereQuery1 = "";
	
	if(!empty($action_date1))
	{
		$pk_name = getdata($PK_NAME, $tableid);
		$fromQuery1 .= ", ".$schemas.".".$table_name."_h tm_h";
		$whereQuery1 .= " AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";
	}
	
	if(!$group_id==0)
	{
		$fromQuery1 .= ", ".$schemas.".tausergroups tug";
		$whereQuery1 .= " AND tm.user_id = tug.user_id";
	}
	
	$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$fromQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery." ".$groupQuery." ".$sortQuery;
	$rows = $db->query($selQuery);
	
	if (!empty($rows))
	{
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="4"><span class="title"><?php echo _p("MetadataColumn1").": ".getdata($TABLE_ID, $tableid); ?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th colspan="4"><?php echo _p("MetadataText1"); ?><span class="pull-right">
          <?php $metadate=_p("MetadataInfo1"); if(empty($action_date1)) $metadate.=" "._p("MetadataInfo2"); else $metadate.=" "._p("MetadataInfo8")." ".$action_date1." "._p("MetadataInfo3"); if(!empty($action_date2)) $metadate.=" "._p("MetadataInfo7")." ".$action_date2." "._p("MetadataInfo4");  echo $metadate;?>
          </span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th><?php echo _p("MetadataColumn3"); ?></th>
        <th><?php echo _p("MetadataColumn4"); ?></th>
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
        <td><?php echo $rows[$i]["organization"]; ?></td>
        <td><?php echo $rows[$i]["lastname"]; ?></td>
        <td><?php echo $rows[$i]["meta_count"]; ?></td>
      </tr>
      <?php
		}
?>
      <tr>
        <th colspan="3"><?php echo _p("MetadataTotal");?></th>
        <th><?php echo $sum; ?></th>
      </tr>
      <tr>
        <td colspan="4"><a class="btn btn-primary" href="<?php echo $my_url.$search_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?> </a></td>
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
        <th colspan="4"><span class="title"><?php echo _p("MetadataColumn5").": ".$row[0]["group_name_$language_name"];?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th colspan="4"><?php echo _p("MetadataText1"); ?><span class="pull-right">
          <?php $metadate=_p("MetadataInfo1"); if(empty($action_date1)) $metadate.=" "._p("MetadataInfo2"); else $metadate.=" "._p("MetadataInfo8")." ".$action_date1." "._p("MetadataInfo3"); if(!empty($action_date2)) $metadate.=" "._p("MetadataInfo7")." ".$action_date2." "._p("MetadataInfo4");  echo $metadate;?>
          </span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th><?php echo _p("MetadataColumn3"); ?></th>
        <th><?php echo _p("MetadataColumn4"); ?></th>
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
	
	$s1 = array();
	for ($j=0; $j < 100; $j++) 
	{
		$s1[$j]["user_id"] = NULL;
		$s1[$j]["organization"] = NULL;
		$s1[$j]["lastname"] = NULL;
	}
	
	for ($i=$startid; $i < $endid; $i++) 
	{
		$startQuery = "SELECT";
		$table_name = getdata($TABLE_NAME, $i);
		$pk_name = getdata($PK_NAME, $i);

		$valueQuery = "count(*) as meta_count, tu.user_id, tu.lastname, tu.organization";
		$fromQuery = "FROM ".$schemas.".".$table_name." tm, ".$schemas.".tausers tu, ".$schemas.".tausergroups tug";
		$groupQuery = "GROUP BY tu.user_id,tu.lastname, tu.organization";
		$sortQuery = "ORDER BY tu.organization, tu.lastname";
	
		if($checkaimag==0)
			$whereQuery = "WHERE tm.user_id = tu.user_id AND tu.user_id = tug.user_id AND tug.group_id = ".$groupid;
		else 
			$whereQuery = "WHERE tm.user_id = tu.user_id AND tm.user_id = ".$sess_user_id."AND tu.user_id = tug.user_id AND tug.group_id = ".$groupid;

		$fromQuery1 = "";
		$whereQuery1 = "";
	
		if(!empty($action_date1))
		{
			$fromQuery1 .= ", ".$schemas.".".$table_name."_h tm_h";
			$whereQuery1 .= " AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";
		}
		
		$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$fromQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery." ".$groupQuery." ".$sortQuery;
		$rows = $db->query($selQuery);

		for ($j=0; $j < sizeof($rows); $j++) 
		{
			$s1[$rows[$j]["user_id"]]["user_id"] = $s1[$rows[$j]["user_id"]]["user_id"] + $rows[$j]["meta_count"];
			$s1[$rows[$j]["user_id"]]["organization"] = $rows[$j]["organization"];
			$s1[$rows[$j]["user_id"]]["lastname"] = $rows[$j]["lastname"];
		}		
	}

	function normalize_array($array){
		$newarray = array();
		$array_keys = array_keys($array);
		
		$l=0;
		foreach($array_keys as $key){
			$newarray[$l][0] = $array[$key]["user_id"];
			$newarray[$l][1] = $array[$key]["organization"];
			$newarray[$l][2] = $array[$key]["lastname"];
			$l++;
		}
		return $newarray;
	}
	

	$s2 = array();
	$s2 = normalize_array($s1);

	for($j=0; $j<sizeof($s2); $j++)
	{
		if(!empty($s2[$j][0]))
		{	
			$sum = $sum + $s2[$j][0];
?>
      <tr>
        <td><?php echo $k+1; ?></td>
        <td><?php echo $s2[$j][1]; ?></td>
        <td><?php echo $s2[$j][2]; ?></td>
        <td><?php echo $s2[$j][0]; ?></td>
      </tr>
      <?php
			$k++;
		}
	}	
?>
      <tr>
        <th colspan="3"><?php echo _p("MetadataTotal");?></th>
        <th><?php echo $sum; ?></th>
      </tr>
      <tr>
        <td colspan="4"><a class="btn btn-primary" href="<?php echo $my_url.$search_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?> </a></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
}

if($metadata_id==4) 
{

	$tm_year = (isset($_GET["tm_year"])) ? (int) $_GET["tm_year"] : 1;
	$tm_month = (isset($_GET["tm_month"])) ? (int) $_GET["tm_month"] : 0;
?>
<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="4"><span class="title"><?php echo _p("MetadataColumn8").": ".$tm_year." "._p("MetadataInfo5")." ".$tm_month._p("MetadataInfo6");?></span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th colspan="4"><?php echo _p("MetadataText1"); ?><span class="pull-right">
          <?php $metadate=_p("MetadataInfo1"); if(empty($action_date1)) $metadate.=" "._p("MetadataInfo2"); else $metadate.=" "._p("MetadataInfo8")." ".$action_date1." "._p("MetadataInfo3"); if(!empty($action_date2)) $metadate.=" "._p("MetadataInfo7")." ".$action_date2." "._p("MetadataInfo4");  echo $metadate;?>
          </span></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>№</th>
        <th><?php echo _p("MetadataColumn3"); ?></th>
        <th><?php echo _p("MetadataColumn4"); ?></th>
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
	
	$s1 = array();
	for ($j=0; $j < 100; $j++) 
	{
		$s1[$j]["user_id"] = NULL;
		$s1[$j]["organization"] = NULL;
		$s1[$j]["lastname"] = NULL;
	}
	
	for ($i=$startid; $i < $endid; $i++) 
	{
		$startQuery = "SELECT";
		$table_name = getdata($TABLE_NAME, $i);
		$pk_name = getdata($PK_NAME, $i);

		$valueQuery = "count(*) as meta_count, tu.user_id, tu.lastname, tu.organization";
		$fromQuery = "FROM ".$schemas.".".$table_name." tm, ".$schemas.".tausers tu, ".$schemas.".".$table_name."_h tm_h";
		$groupQuery = "GROUP BY tu.user_id, tu.lastname, tu.organization";
		$sortQuery = "ORDER BY tu.organization, tu.lastname";
	
		if($checkaimag==0)
			$whereQuery = "WHERE tm.user_id = tu.user_id AND date_part('year', tm_h.action_date) = ".$tm_year." AND date_part('month', tm_h.action_date) = ".$tm_month." AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";
		else 
			$whereQuery = "WHERE tm.user_id = tu.user_id AND tm.user_id = ".$sess_user_id." AND date_part('year', tm_h.action_date) = ".$tm_year." AND date_part('month', tm_h.action_date) = ".$tm_month." AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";

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
			$s1[$rows[$j]["user_id"]]["user_id"] = $s1[$rows[$j]["user_id"]]["user_id"] + $rows[$j]["meta_count"];
			$s1[$rows[$j]["user_id"]]["organization"] = $rows[$j]["organization"];
			$s1[$rows[$j]["user_id"]]["lastname"] = $rows[$j]["lastname"];
		}		
	}

	function normalize_array($array){
		$newarray = array();
		$array_keys = array_keys($array);
		
		$l=0;
		foreach($array_keys as $key){
			$newarray[$l][0] = $array[$key]["user_id"];
			$newarray[$l][1] = $array[$key]["organization"];
			$newarray[$l][2] = $array[$key]["lastname"];
			$l++;
		}
		return $newarray;
	}
	

	$s2 = array();
	$s2 = normalize_array($s1);

	for($j=0; $j<sizeof($s2); $j++)
	{
		if(!empty($s2[$j][0]))
		{		
			$sum = $sum + $s2[$j][0];
?>
      <tr>
        <td><?php echo $k+1; ?></td>
        <td><?php echo $s2[$j][1]; ?></td>
        <td><?php echo $s2[$j][2]; ?></td>
        <td><?php echo $s2[$j][0]; ?></td>
      </tr>
      <?php
			$k++;
		}
	}	
?>
      <tr>
        <th colspan="3"><?php echo _p("MetadataTotal");?></th>
        <th><?php echo $sum; ?></th>
      </tr>
      <tr>
        <td colspan="4"><a class="btn btn-primary" href="<?php echo $my_url.$search_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?> </a></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
}
?>
