<?php
if (isset($_GET["user_id"]))
{
	$user_id = (int)$_GET["user_id"];
}else
{
	$user_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "tau.* FROM ".$schemas.".tausers tau";
$whereQuery = "WHERE tau.user_id = ".$user_id;

if($sess_profile==1) 
	$whereQuery .= "";
else
	$whereQuery .= " AND tau.user_id = ".$sess_user_id;
			
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>

  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th colspan="2"><?php echo _p("MoreText1")." "._p("UsersTitle")." "._p("MoreText2"); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th style="width: 30%"><?php echo _p("UsersColumn1"); ?>:</th>
          <td><?php echo $row[$i]["login_name"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("UsersColumn2"); ?>:</th>
          <td><?php echo getdata($USER_PROFILE, $row[$i]["profile"]); ?></td>
        </tr>
        <tr>
          <th><?php echo _p("UsersColumn3"); ?>:</th>
          <td><?php echo $row[$i]["firstname"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("UsersColumn4"); ?>:</th>
          <td><?php echo $row[$i]["lastname"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("UsersColumn5"); ?>:</th>
          <td><?php echo $row[$i]["organization"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("UsersColumn6"); ?>:</th>
          <td><?php echo $row[$i]["phone"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("UsersColumn7"); ?>:</th>
          <td><?php echo $row[$i]["email"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("UsersColumn8"); ?>:</th>
          <td><?php echo getdata($USER_ACTIVE, $row[$i]["login_status"]); ?></td>
        </tr>
        <tr>
          <th><?php echo _p("UsersColumn11"); ?>:</th>
          <td><?php echo $row[$i]["login_date"]; ?></td>
        </tr>
        <tr>
          <td colspan="2"><?php
			if($sess_profile==1)
			{ 
			?>
            <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&user_id=".$user_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
            <?php
			}
			?>
            <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?></a> </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
} else {
	$notify = " <a class=\"btn btn-danger\" href=\"".$my_url.$my_page.$search_url.$sort_url."\"><i class=\"fa fa-undo\"></i> "._p("BackButton")." </a>";
	show_notification("error", _p("NotRowText"), $notify);
}
?>
