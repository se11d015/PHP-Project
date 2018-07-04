<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i> <a href="<?php echo $my_url."?menuitem=1"; ?>"><?php echo _p("Dashboard"); ?></a> </li>
      <li class="breadcrumb-item active"><i class="fa fa-user"></i> <?php echo _p("User"); ?> </li>		  
    </ol>    
    <div class="row">
      <div class="col">
        <h1> <?php echo _p("GroupsTitle"); ?> </h1>
		  <?php
			if($sess_profile==1) 
			{ 
				$my_url .= "?menuitem=".$menuitem;
				
				if (isset($_GET["action"]))
				{
					$action = pg_prep($_GET["action"]);
				}else
				{
					$action = "";
				}
				
				if (isset($_POST["insertgroupbttn"]))
				{
					if (isset($_POST["group_name_mn"]) && !empty($_POST["group_name_mn"]))
					{
						$fields = array("group_name_mn", "group_name_en", "description");
						$checkvalues = array($_POST["group_name_mn"], $_POST["group_name_en"], $_POST["description"]);
						
						$values = array();
						for ($i=0; $i<sizeof($checkvalues); $i++)
						{
							$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
						}
						
						$result = $db->insert("".$schemas.".tagroups", $fields, $values);
				
						if(! $result)
							show_notification("error", _p("AddText1"), "");
						else
							show_notification("success", _p("AddText2"), "");
					}
				}
								
				if (isset($_POST["updategroupbttn"]))
				{
					if (isset($_POST["group_name_mn"]) && !empty($_POST["group_name_mn"]))
					{	
						$wherevalues = "group_id=".(int) $_POST["group_id"];
						$fields = array("group_name_mn", "group_name_en", "description");
						$checkvalues = array($_POST["group_name_mn"], $_POST["group_name_en"], $_POST["description"]);
						
						$values = array();
						for ($i=0; $i<sizeof($checkvalues); $i++)
						{
							$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
						}
						
						$result = $db->update("".$schemas.".tagroups", $fields, $values, $wherevalues);
						if(! $result)
							show_notification("error", _p("EditText1"), "");
						else
							show_notification("success", _p("EditText2"), "");
					}
				}
								
				if (($action=="delete") && isset($_GET["group_id"]))
				{
					$wherevalues = "group_id=".(int) $_GET["group_id"];
				
					$db->delete("".$schemas.".tausergroups",$wherevalues);
					
					$result = $db->delete("".$schemas.".tagroups", $wherevalues);
					if(! $result)
						show_notification("error", _p("DeleteText1"), "");
					else
						show_notification("success", _p("DeleteText2"), "");
				}
								
				$selQuery = "SELECT tg.* FROM ".$schemas.".tagroups tg";  
				$rows = $db->query($selQuery);
				
				$sum = sizeof($rows);
				$count = 10;
				$maxpage = ceil( $sum / $count);
				
				$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
				$my_page = "&page=".$page;

				$notifytitle =_p("TotalRowsText1")." ".$sum." "._p("TotalRowsText2");
				show_notification("info", $notifytitle, "");
		  ?>
		  <div class="table-responsive">
			<form action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform" role="form">
			  <table class="table table-bordered table-striped table-hover">
				<thead>
				  <tr>
					<th>№</th>
					<th><?php echo _p("GroupsColumn3");?></th>
					<th><?php echo _p("GroupsColumn4");?></th>
					<th><?php echo _p("GroupsColumn2");?></th>
					<th><?php echo _p("Operation");?></th>
				  </tr>
				</thead>
				<tbody>
				  <?php
					$limit = $count." OFFSET ".($page-1)*$count;
					$selQuery = "SELECT tg.* FROM ".$schemas.".tagroups tg ORDER BY	tg.group_name_mn ASC	LIMIT ".$limit;
					$rows = $db->query($selQuery);
					
					for ($i=0; $i < sizeof($rows); $i++) 
					{
						if (($action=="edit") && (isset($_GET["group_id"])) && ($rows[$i]["group_id"]==(int)$_GET["group_id"]))
						{
					?>
				  <tr>
					<td><input name="group_id" id="group_id" type="hidden" value="<?php echo $rows[$i]["group_id"]; ?>" /></td>
					<td><input type="text" class="form-control" id="group_name_mn" name="group_name_mn" value="<?php echo $rows[$i]["group_name_mn"]; ?>" /></td>
					<td><input type="text" class="form-control" id="group_name_en" name="group_name_en" value="<?php echo $rows[$i]["group_name_en"]; ?>" /></td>
					<td><input type="text" class="form-control" id="description" name="description" value="<?php echo $rows[$i]["description"]; ?>" /></td>
					<td><button type="submit" class="btn btn-primary mb-2" name="updategroupbttn"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
					  <a class="btn btn-primary mb-2" href="<?php echo $my_url.$my_page; ?>"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></a></td>
				  </tr>
				  <?php		
						}else
						{
					?>
				  <tr>
					<td><?php echo (($page-1)*$count) + $i + 1; ?></td>
					<td><?php echo $rows[$i]["group_name_mn"]; ?></td>
					<td><?php echo $rows[$i]["group_name_en"]; ?></td>
					<td><?php echo $rows[$i]["description"]; ?></td>
					<td><a href="<?php echo $my_url.$my_page."&action=edit&group_id=".$rows[$i]["group_id"]; ?>" title="<?php echo _p("EditTitle"); ?>"><i class="fa fa-pencil"></i></a>&nbsp;<a href="<?php echo $my_url."&action=delete&group_id=".$rows[$i]["group_id"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a></td>
				  </tr>
				  <?php
						}
					}
				
					if (($action=="add"))
					{
					?>
				  <tr>
					<td></td>
					<td><input type="text" class="form-control" id="group_name_mn" name="group_name_mn" /></td>
					<td><input type="text" class="form-control" id="group_name_en" name="group_name_en" /></td>
					<td><input type="text" class="form-control" id="description" name="description" /></td>
					<td><button type="submit" class="btn btn-primary mb-2" name="insertgroupbttn"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
					  <a class="btn btn-primary mb-2" href="<?php echo $my_url.$my_page; ?>"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></a></td>
				  </tr>
				  <?php
					}
					?>
				  <tr>
					<td colspan="5"><a class="btn btn-primary" href="<?php echo $my_url.$my_page."&action=add"; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a></td>
				  </tr>
				</tbody>
			  </table>
			  <?php
				require("pagination/inc.pagination.php");
				pagelink($count, $maxpage, $my_url, $page);
				?>
			</form>
		  </div>
		  <?php 
			} else {
				show_notification("error", _p("NotAccessText"), $notify);
			}
		?>
	  </div>
    </div>
  </div>
  <!-- /.container-fluid -->  