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
	
	if (isset($_GET["actionaimag"]))
	{
		$actionaimag = pg_prep($_GET["actionaimag"]);

	}else
	{
		$actionaimag = "";
	}
	
	if (isset($_POST["insertuseraimagbttn"]))
	{
		if (isset($_POST["aimag_code"]))
		{
			$fields = array("aimag_code", "user_id");
			$checkvalues = array((int) $_POST["aimag_code"], $user_id);
			
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'".$checkvalues[$i]."'");
			}
			
			$result = $db->insert("".$schemas.".taaimagusers", $fields, $values);
	
			if(! $result)
				show_notification("error", _p("AddText1"), "");
			else
				show_notification("success", _p("AddText2"), "");
		}
	}
				
	if (($actionaimag=="aimagdelete") && isset($_GET["aimag_code"]) && isset($_GET["user_id"]))
	{
		$aimag_code = (int) $_GET["aimag_code"];
		$user_id = (int) $_GET["user_id"];
		$wherevalues = "aimag_code = ".$aimag_code." AND user_id=".$user_id;
	
		$result = $db->delete("".$schemas.".taaimagusers", $wherevalues);
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
          <th colspan="2"><?php echo $row[0]["lastname"]." - "._p("UserAimagsTitle"); ?></th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th><?php echo _p("UsersColumn10");?></th>
          <th><?php echo _p("Operation");?></th>
        </tr>
      </thead>
      <tbody>
        <?php
			$selQuery = "SELECT taua.aimag_code, taua.user_id, va.aimag_name_mn, va.aimag_name_en FROM ".$schemas.".taaimagusers taua, scadministrative.vaaimagname va, ".$schemas.".tausers tau WHERE taua.aimag_code = va.aimag_code AND taua.user_id = tau.user_id AND tau.user_id = ".$user_id." ORDER BY va.aimag_name_mn"; 		
			$rows = $db->query($selQuery);
			for ($i=0; $i < sizeof($rows); $i++) 
			{
			?>
        <tr>
          <td><?php echo $rows[$i]["aimag_name_$language_name"]; ?></td>
          <td><a href="<?php echo $my_url."&actionaimag=aimagdelete&aimag_code=".$rows[$i]["aimag_code"]."&user_id=".$rows[$i]["user_id"]; ?>" title="<?php echo _p("DeleteTitle"); ?>" onClick="return confirm('<?php echo _p("DeleteText3"); ?>');"><i class="fa fa-trash"></i></a></td>
        </tr>
        <?php
			}
		
			if ($actionaimag=="aimagadd")
			{
			?>
        <tr>
          <td><?php
				$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn";
				$row = $db->query($selQuery);
				if(!empty($row))
					echo seldatadb("aimag_code", "form-control", $row, "aimag_code", "aimag_name_$language_name", $row[0]["aimag_code"]);
				else
					echo seldatadb("aimag_code", "form-control", $row, "aimag_code", "aimag_name_$language_name", NULL);
				?></td>
          <td><button type="submit" class="btn btn-primary mb-2" name="insertuseraimagbttn"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
            <button class="btn btn-primary mb-2"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></button></td>
        </tr>
        <?php
			}
			?>
        <tr>
          <td colspan="2"><a class="btn btn-primary" href="<?php echo $my_url."&actionaimag=aimagadd"; ?>"><i class="fa fa-plus"></i> <?php echo _p("AddButton");?></a> <a class="btn btn-primary" href="<?php echo $my_url_old; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?></a></td>
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
