<?php

if (isset($_POST["searchmetabttn"]))
{
	$searchQuery = "";
	$search_url = "";
	
	$metadata_id = (isset($_POST["metadata_id"])) ? (int) $_POST["metadata_id"] : 1;
	$table_id = (isset($_POST["table_id"])) ? (int) $_POST["table_id"] : 0;
	
	$action_date1 = (isset($_POST["action_date1"])) ? pg_prep($_POST["action_date1"]) : "";
	$action_date2 = (isset($_POST["action_date2"])) ? pg_prep($_POST["action_date2"]) : "";
	
	$user_id = (isset($_POST["user_id"])) ? (int) $_POST["user_id"] : 0;
	$group_id = (isset($_POST["group_id"])) ? (int) $_POST["group_id"] : 0;
	
	$search_url .= "&metadata_id=".$metadata_id;
	
	if($table_id==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= "";
		$search_url .= "&table_id=".$table_id;
	}
	
	$today = date('Y-m-d');
	
	if(empty($action_date1))
	{
		$action_date1 = "";
		$action_date2 = $today;
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		if($action_date1 > $today)
			$action_date1 = $today;
			
		if(empty($action_date2))
		{
			$action_date2 = $today;
			$searchQuery .= " AND (tm_h.action_date::date >= '$action_date1' AND tm_h.action_date::date <= '$action_date2')";
			$search_url .= "&action_date1=".$action_date1."&action_date2=".$action_date2;
		}else
		{
			if($action_date1 > $action_date2)
				$action_date2 = $action_date1;
			if($action_date2 > $today)
				$action_date2 = $today;
			$searchQuery .= " AND (tm_h.action_date::date >= '$action_date1' AND tm_h.action_date::date <= '$action_date2')";
			$search_url .= "&action_date1=".$action_date1."&action_date2=".$action_date2;
		}
	}
	
	if($user_id==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tm.user_id = ".$user_id;
		$search_url .= "&user_id=".$user_id;
	}
		
	if($group_id==0)
	{
		$searchQuery .= "";
		$search_url .= "";
	} else
	{
		$searchQuery .= " AND tug.group_id = ".$group_id;
		$search_url .= "&group_id=".$group_id;
	}
}

$metadate=_p("MetadataInfo1"); 
if(empty($action_date1)) $metadate.=" "._p("MetadataInfo2"); 
else $metadate.=" "._p("MetadataInfo8")." ".$action_date1." "._p("MetadataInfo3"); 
if(!empty($action_date2)) $metadate.=" "._p("MetadataInfo7")." ".$action_date2." "._p("MetadataInfo4"); 
echo "<h4>".$metadate."</h4>";

require("metadata/inc.search_metadata.php");
?>
<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <?php 
		if($metadata_id==1) 
		{
		?>
    <thead>
      <tr>
        <th>№</th>
        <th><?php echo _p("MetadataColumn1");?></th>
        <th><?php echo _p("MetadataColumn2");?></th>
        <th><?php echo _p("MetadataOperation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
			$k=0;
			$sum=0;
	
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
				$valueQuery = "count(*) as meta_count";
				$fromQuery = "FROM ".$schemas.".".$table_name." tm";
				if($checkaimag==0)
					$whereQuery = "WHERE tm.user_id = tm.user_id";
				else 
					$whereQuery = "WHERE tm.user_id = ".$sess_user_id;
					
				$fromQuery1 = "";
				$whereQuery1 = "";
			
				if(!empty($action_date1))
				{
					$pk_name = getdata($PK_NAME, $i);
					$fromQuery1 .= ", ".$schemas.".".$table_name."_h tm_h";
					$whereQuery1 .= " AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";
				}
	
				if(!$group_id==0)
				{
					$fromQuery1 .= ", ".$schemas.".tausergroups tug";
					$whereQuery1 .= " AND tm.user_id = tug.user_id";
				}
				
				$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$fromQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery;
				
				$row = $db->query($selQuery);
				
				if(!empty($row) && $row[0]["meta_count"]>0) 
				{
					
					$sum = $sum + $row[0]["meta_count"];
		?>
      <tr>
        <td><?php echo $k+1; ?></td>
        <td><?php echo getdata($TABLE_ID, $i); ?></td>
        <td><?php echo $row[0]["meta_count"]; ?></td>
        <td><?php if($row[0]["meta_count"]>0) { ?>
          <a href="<?php echo $my_url.$search_url."&action=moreuser&tableid=".$i; ?>" title="<?php echo _p("MetadataText1"); ?>"><i class="fa fa-list-alt"></i></a> <a href="<?php echo $my_url.$search_url."&action=moregroup&tableid=".$i; ?>" title="<?php echo _p("MetadataText2"); ?>"><i class="fa fa-user"></i></a> <a href="<?php echo $my_url.$search_url."&action=moretime&tableid=".$i; ?>" title="<?php echo _p("MetadataText3"); ?>"><i class="fa fa-th-list"></i> <a href="<?php echo $my_url.$search_url."&action=moreusertime&tableid=".$i; ?>" title="<?php echo _p("MetadataText4"); ?>"><i class="fa fa-th-large"></i></a> <a href="<?php echo $my_url.$search_url."&action=moregrouptime&tableid=".$i; ?>" title="<?php echo _p("MetadataText5"); ?>"><i class="fa fa-paperclip"></i></a>
          <?php } else { echo "&nbsp;";} ?></td>
      </tr>
      <?php
					$k++;
				}
			}
		?>
      <tr>
        <th colspan="2"><?php echo _p("MetadataTotal");?></th>
        <th colspan="2"><?php echo $sum; ?></th>
      </tr>
    </tbody>
    <?php		
		}
		?>
    <?php if($metadata_id==2) 
		{
		?>
    <thead>
      <tr>
        <th>№</th>
        <th><?php echo _p("MetadataColumn3"); ?></th>
        <th><?php echo _p("MetadataColumn4"); ?></th>
        <th><?php echo _p("MetadataColumn2");?></th>
        <th><?php echo _p("MetadataOperation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
			$startQuery = "SELECT";
			$valueQuery = "tu.user_id, tu.lastname, tu.organization";
			$fromQuery = "FROM ".$schemas.".tausers tu";
			if($checkaimag==0)
				$whereQuery = "WHERE tu.user_id = tu.user_id";
			else 
				$whereQuery = "WHERE tu.user_id = ".$sess_user_id;
			$sortQuery = "ORDER BY tu.profile, tu.organization, tu.lastname";
		
			$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$whereQuery." ".$sortQuery;
			$rows = $db->query($selQuery);

			$k=0;
			$totalsum = 0;
			
			for ($j=0; $j < sizeof($rows); $j++) 
			{
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
					$valueQuery = "count(*) as meta_count";
					$fromQuery = "FROM ".$schemas.".".$table_name." tm";
					$whereQuery = "WHERE tm.user_id = ".$rows[$j]["user_id"];
	
					$fromQuery1 = "";
					$whereQuery1 = "";
				
					if(!empty($action_date1))
					{
						$pk_name = getdata($PK_NAME, $i);
						$fromQuery1 .= ", ".$schemas.".".$table_name."_h tm_h";
						$whereQuery1 .= " AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";
					}
	
					if(!$group_id==0)
					{
						$fromQuery1 .= ", ".$schemas.".tausergroups tug";
						$whereQuery1 .= " AND tm.user_id = tug.user_id";
					}
					
					$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$fromQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery;

					$row = $db->query($selQuery);
					$sum = $sum + $row[0]["meta_count"];
				}				
				
				if($sum>0)
				{
					$totalsum = $totalsum + $sum;
		?>
      <tr>
        <td><?php echo $k+1; ?></td>
        <td><?php echo $rows[$j]["organization"]; ?></td>
        <td><?php echo $rows[$j]["lastname"]; ?></td>
        <td><?php echo $sum;?></td>
        <td><?php if($sum>0) { ?>
          <a href="<?php echo $my_url.$search_url."&action=moretable&userid=".$rows[$j]["user_id"]; ?>" title="<?php echo _p("MetadataText6"); ?>"><i class="fa fa-th-list"></i> <a href="<?php echo $my_url.$search_url."&action=moretime&userid=".$rows[$j]["user_id"]; ?>" title="<?php echo _p("MetadataText3"); ?>"><i class="fa fa-th-large"></i></a> <a href="<?php echo $my_url.$search_url."&action=moretabletime&userid=".$rows[$j]["user_id"]; ?>" title="<?php echo _p("MetadataText7"); ?>"><i class="fa fa-paperclip"></i></a>
          <?php } else { echo "&nbsp;";} ?></td>
      </tr>
      <?php
					$k++;
				}
			}
			?>
      <tr>
        <th colspan="3"><?php echo _p("MetadataTotal");?></th>
        <th colspan="2"><?php echo $totalsum; ?></th>
      </tr>
    </tbody>
    <?php		
		}
		?>
    <?php if($metadata_id==3) 
		{
		?>
    <thead>
      <tr>
        <th>№</th>
        <th><?php echo _p("MetadataColumn5");?></th>
        <th><?php echo _p("MetadataColumn2");?></th>
        <th><?php echo _p("MetadataOperation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
			$startQuery = "SELECT DISTINCT";
			$valueQuery = "tg.group_id, tg.group_name_mn, tg.group_name_en";
			$fromQuery = "FROM ".$schemas.".tagroups tg, ".$schemas.".tausergroups tug";
			if($checkaimag==0)
				$whereQuery = "WHERE tg.group_id = tug.group_id";
			else 
				$whereQuery = "WHERE tg.group_id = tug.group_id AND tug.user_id = ".$sess_user_id;
			$sortQuery = "ORDER BY tg.group_id, tg.group_name_mn, tg.group_name_en";
		
			$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$whereQuery." ".$sortQuery;
			$rows = $db->query($selQuery);

			$k=0;
			$totalsum = 0;
			
			for ($j=0; $j < sizeof($rows); $j++) 
			{
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
					$valueQuery = "count(*) as meta_count";
					$fromQuery = "FROM ".$schemas.".".$table_name." tm, ".$schemas.".tausergroups tug";
					if($checkaimag==0)
						$whereQuery = "WHERE tm.user_id = tug.user_id AND tug.group_id = ".$rows[$j]["group_id"];
					else 
						$whereQuery = "WHERE tm.user_id = tug.user_id AND tug.group_id = ".$rows[$j]["group_id"]." AND tm.user_id = ".$sess_user_id;
					
					$fromQuery1 = "";
					$whereQuery1 = "";
				
					if(!empty($action_date1))
					{
						$pk_name = getdata($PK_NAME, $i);
						$fromQuery1 .= ", ".$schemas.".".$table_name."_h tm_h";
						$whereQuery1 .= " AND tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";
					}
					
					$selQuery = $startQuery." ".$valueQuery." ".$fromQuery." ".$fromQuery1." ".$whereQuery." ".$whereQuery1." ".$searchQuery;

					$row = $db->query($selQuery);
							
					$sum = $sum + $row[0]["meta_count"];
				}		
				
				if($sum>0)
				{			
					$totalsum = $totalsum + $sum;
		?>
      <tr>
        <td><?php echo $k+1; ?></td>
        <td><?php echo $rows[$j]["group_name_$language_name"]; ?></td>
        <td><?php echo $sum;?></td>
        <td><?php if($sum>0) { ?>
          <a href="<?php echo $my_url.$search_url."&action=moreuser&groupid=".$rows[$j]["group_id"]; ?>" title="<?php echo _p("MetadataText1"); ?>"><i class="fa fa-list-alt"></i></a> <a href="<?php echo $my_url.$search_url."&action=moretable&groupid=".$rows[$j]["group_id"]; ?>" title="<?php echo _p("MetadataText6"); ?>"><i class="fa fa-th-list"></i> <a href="<?php echo $my_url.$search_url."&action=moretime&groupid=".$rows[$j]["group_id"]; ?>" title="<?php echo _p("MetadataText3"); ?>"><i class="fa fa-th-large"></i></a> <a href="<?php echo $my_url.$search_url."&action=moretabletime&groupid=".$rows[$j]["group_id"]; ?>" title="<?php echo _p("MetadataText7"); ?>"><i class="fa fa-paperclip"></i></a>
          <?php } else { echo "&nbsp;";} ?></td>
      </tr>
      <?php
					$k++;
				}
			}
			?>
      <tr>
        <th colspan="2"><?php echo _p("MetadataTotal");?></th>
        <th colspan="2"><?php echo $totalsum; ?></th>
      </tr>
    </tbody>
    <?php		
		}
		?>
    <?php if($metadata_id==4) 
		{
		?>
    <thead>
      <tr>
        <th>№</th>
        <th><?php echo _p("MetadataColumn6");?></th>
        <th><?php echo _p("MetadataColumn7");?></th>
        <th><?php echo _p("MetadataColumn2");?></th>
        <th><?php echo _p("MetadataOperation");?></th>
      </tr>
    </thead>
    <tbody>
      <?php
			$k=0;
			$sum=0;

			if($table_id==0) 
			{
				$startid = 1;
				$endid = sizeof($TABLE_ID)+1;
			} else {
				$startid = $table_id;
				$endid = $table_id+1;
			}

			$s1 = array();
			for ($j=2010; $j < 2050; $j++) 
				for ($i=0; $i < 13; $i++) 
					$s1[$j][$i] = NULL;
					
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
					$whereQuery = "WHERE tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT'";
				else 
					$whereQuery = "WHERE tm.".$pk_name." = tm_h.".$pk_name." AND tm_h.action_name = 'INSERT' AND tm.user_id = ".$sess_user_id;
	
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
					$s1[$rows[$j]["tm_year"]][$rows[$j]["tm_month"]] = $s1[$rows[$j]["tm_year"]][$rows[$j]["tm_month"]] + $rows[$j]["meta_count"];
				}
			}
				
	
			function normalize_array($array){
				$newarray = array();
				$array_keys = array_keys($array);
				
				$l=0;
				foreach($array_keys as $key){
					$newarray[$l][0] = $key;
					$newarray[$l][1] = $array[$key];
					$l++;
				}
				return $newarray;
			}
			
			$s2 = array();
			$s2 = normalize_array($s1);
					
			for($j=0; $j<sizeof($s2); $j++)
			{
				$s3 = array();
				$s3 = normalize_array($s2[$j][1]);
				
				for($l=0; $l<sizeof($s3); $l++)
				{
					if(!empty($s3[$l][1]))
					{
						$sum = $sum + $s3[$l][1];
      				?>
      <tr>
        <td><?php echo $k+1; ?></td>
        <td><?php echo $s2[$j][0]; ?></td>
        <td><?php echo $s3[$l][0]; ?></td>
        <td><?php echo $s3[$l][1];?></td>
        <td><?php if($s3[$l][1]>0) { ?>
          <a href="<?php echo $my_url.$search_url."&action=moreuser&tm_year=".$s2[$j][0]."&tm_month=".$s3[$l][0]; ?>" title="<?php echo _p("MetadataText1"); ?>"><i class="fa fa-list-alt"></i></a> <a href="<?php echo $my_url.$search_url."&action=moregroup&tm_year=".$s2[$j][0]."&tm_month=".$s3[$l][0]; ?>" title="<?php echo _p("MetadataText2"); ?>"><i class="fa fa-user"></i></a> <a href="<?php echo $my_url.$search_url."&action=moretable&tm_year=".$s2[$j][0]."&tm_month=".$s3[$l][0]; ?>" title="<?php echo _p("MetadataText6"); ?>"><i class="fa fa-th-list"></i>
          <?php } else { echo "&nbsp;";} ?></td>
      </tr>
      <?php
						$k++;
					}
				}			
			}	
			?>
      <tr>
        <th colspan="3"><?php echo _p("MetadataTotal");?></th>
        <th colspan="2"><?php echo $sum; ?></th>
      </tr>
    </tbody>
    <?php		
		}
		?>
  </table>
</div>
