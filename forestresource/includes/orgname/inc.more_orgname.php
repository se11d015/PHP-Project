<?php
if (isset($_GET["permission_id"]))
{
	$permission_id = (int)$_GET["permission_id"];
}else
{
	$permission_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "tgo.org_name, tao.*, va.aimag_name_mn, va.aimag_name_en FROM ".$schemas.".tgorgpername tgo,".$schemas.".taorgpermission tao, scadministrative.vaaimagname va";
$whereQuery = "WHERE tgo.gid = tao.org_id AND tgo.aimag_name = va.aimag_code AND tgo.sector_status = 2 AND tao.permission_id = ".$permission_id;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db1->query($selQuery);

if (!empty($row))
{
?>

<div class="table-responsive-md">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo _p("MoreText1")." "._p("OrgNameTitle")." "._p("MoreText2"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th style="width: 30%"><?php echo _p("OrgNameColumn1");?>:</th>
        <td><?php echo $row[$i]["aimag_name_$language_name"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("OrgNameColumn2");?>:</th>
        <td><?php echo $row[$i]["org_name"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("OrgNameColumn3");?>:</th>
        <td><?php echo $row[$i]["permission_number"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("OrgNameColumn6");?>:</th>
        <td><?php 
			$permission_type = "";
			$fldCode = explode(', ', $row[$i]["permission_type"]);

			if(is_array($fldCode)){
				for($j=0; $j<sizeof($fldCode); $j++){
					if(!empty($fldCode[$j])){
						$values = $db1->query("SELECT tcp.permissiontype_name FROM ".$schemas.".tcpermissiontype tcp WHERE tcp.permissiontype_id = ".$fldCode[$j]."");	
						$permission_type .= (empty($values[0]) ? " ": $values[0]["permissiontype_name"].", ");
					}
				}
			}		
			echo $permission_type; 
			?></td>
      </tr>
      <tr>
        <th><?php echo _p("OrgNameColumn7");?>:</th>
        <td><?php echo $row[$i]["approved_org"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("OrgNameColumn4");?>:</th>
        <td><?php echo $row[$i]["approved_date"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("OrgNameColumn8");?>:</th>
        <td><?php echo $row[$i]["approved_statement"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("OrgNameColumn5");?>:</th>
        <td><?php echo $row[$i]["end_date"]; ?></td>
      <tr>
        <?php  if(!empty($row[$i]["extended_org"])){ ?>
      <tr>
        <th><?php echo _p("OrgNameColumn9");?>:</th>
        <td><?php echo $row[$i]["extended_org"]; ?></td>
      </tr>
      <?php } ?>
      <?php  if(!empty($row[$i]["extended_date"])){ ?>
      <tr>
        <th><?php echo _p("OrgNameColumn10");?>:</th>
        <td><?php echo $row[$i]["extended_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php  if(!empty($row[$i]["extended_statement"])){ ?>
      <tr>
        <th><?php echo _p("OrgNameColumn11");?>:</th>
        <td><?php echo $row[$i]["extended_statement"]; ?></td>
      </tr>
      <?php } ?>
      <?php  if(!empty($row[$i]["canceled_org"])){ ?>
      <tr>
        <th><?php echo _p("OrgNameColumn12");?>:</th>
        <td><?php echo $row[$i]["canceled_org"]; ?></td>
      </tr>
      <?php } ?>
      <?php  if(!empty($row[$i]["canceled_date"])){ ?>
      <tr>
        <th><?php echo _p("OrgNameColumn13");?>:</th>
        <td><?php echo $row[$i]["canceled_date"]; ?></td>
      </tr>
      <?php } ?>
      <?php  if(!empty($row[$i]["canceled_statement"])){ ?>
      <tr>
        <th><?php echo _p("OrgNameColumn14");?>:</th>
        <td><?php echo $row[$i]["canceled_statement"]; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <table class="table">
    <tbody>
      <tr>
        <td><a class="btn btn-success" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?></a></td>
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
