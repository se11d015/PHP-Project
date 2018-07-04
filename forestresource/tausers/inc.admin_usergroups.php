<?php
if($sess_profile==1) 
{ 
	$my_url_old = $my_url;
	$my_url .= "&action=".$action;
	
	if (isset($_GET["user_id"]))
	{
		$user_id = (int) $_GET["user_id"];
	}else
	{
		$user_id = 0;
	}
	
	$my_url .= "&user_id=".$user_id;
	
	if (isset($_GET["actiongroup"]))
	{
		$actiongroup = pg_prep($_GET["actiongroup"]);
	}else
	{
		$actiongroup = "";
	}
	
	if (isset($_POST["insertusergroupbttn"]))
	{
		if (isset($_POST["group_id"]))
		{
			$fields = array("group_id", "user_id");
			$checkvalues = array((int) $_POST["group_id"], $user_id);
			
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
			}
			
			$result = $db->insert("".$schemas.".tausergroups", $fields, $values);
	
			if(! $result)
				show_notification("error", _p("AddText1"), "");
			else
				show_notification("success", _p("AddText2"), "");
		}
	}
				
	if (($actiongroup=="groupdelete") && isset($_GET["group_id"]) && isset($_GET["user_id"]))
	{
		$group_id = (int) $_GET["group_id"];
		$user_id = (int) $_GET["user_id"];
		$wherevalues = "group_id = ".$group_id." AND user_id=".$user_id;
	
		$result = $db->delete("".$schemas.".tausergroups", $wherevalues);
		if(! $result)
			show_notification("error", _p("DeleteText1"), "");
		else
			show_notification("success", _p("DeleteText2"), "");
	}
	
	$valueQuery = "SELECT tau.lastname FROM ".$schemas.".tausers tau WHERE tau.user_id = ".$user_id;
	
	$selQuery = $valueQuery;
	
	$row = $db->query($selQuery);

?>

<div class="table-responsive">
  <form action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform" role="form">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th colspan="2"><?php echo $row[0]["lastname"]." - "._p("GroupsTitle"); ?></th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th><?php echo _p("GroupsColumn1");?></th>
          <th><?php echo _p("Operation");?></th>
        </tr>
      </thead>
      <tbody>
        <?php
			$selQuery = "SELECT taug.group_id, taug.user_id, tag.group_name_mn, tag.group_name_en FROM ".$schemas.".tausergroups taug, ".$schemas.".tagroups tag, ".$schemas.".tausers tau WHERE taug.group_id = tag.group_id AND taug.user_id = tau.user_id AND tau.user_id = ".$user_id." ORDER BY tag.group_name_mn"; 		
			$rows = $db->query($selQuery);
			for ($i=0; $i < sizeof($rows); $i++) 
			{
			?>
        <tr>
          <td><?php echo $rows[$i]["group_name_$language_name"]; ?></td>
          <td><a href="<?php echo $my_url."&actiongroup=groupdelete&group_id=".$rows[$i]["group_id"]."&user_id=".$rows[$i]["user_id"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a></td>
        </tr>
        <?php
			}
		
			if ($actiongroup=="groupadd")
			{
			?>
        <tr>
          <td><?php
				$selQuery = "SELECT tag.group_id, tag.group_name_mn, tag.group_name_en FROM ".$schemas.".tagroups tag ORDER BY tag.group_name_mn";
				$row = $db->query($selQuery);
				if(!empty($row))
					echo seldatadb("group_id", "form-control", $row, "group_id", "group_name_$language_name", $row[0]["group_id"]);
				else
					echo seldatadb("group_id", "form-control", $row, "group_id", "group_name_$language_name", NULL);
				?></td>
          <td><button type="submit" class="btn btn-primary mb-2" name="insertusergroupbttn"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
            <button class="btn btn-primary mb-2"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></button></td>
        </tr>
        <?php
			}
			?>
        <tr>
          <td colspan="2"><a class="btn btn-primary" href="<?php echo $my_url."&actiongroup=groupadd"; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a> <a class="btn btn-primary" href="<?php echo $my_url_old; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?></a></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<?php 
} else {
	show_notification("error", _p("NotAccessText"), $notify);
}
?>
