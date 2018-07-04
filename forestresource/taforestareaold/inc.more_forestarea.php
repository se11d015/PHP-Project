<?php
if (isset($_GET["area_id"]))
{
	$area_id = (int)$_GET["area_id"];
}else
{
	$area_id = 0;
}
	

$i = 0;
$startQuery = "SELECT";
$valueQuery = "taf.*, vs.aimag_name_mn, vs.aimag_name_en, vs.soum_name_mn, vs.soum_name_en, tct.type_name_mn, tct.type_name_en, tau.organization||' - '|| tau.lastname as user_name  FROM ".$schemas.".taforestarea taf, scadministrative.vasoumname vs, ".$schemas.".tclandtype tct, ".$schemas.".tausers tau";
$whereQuery = "WHERE taf.soum_code = vs.soum_code AND taf.type_code = tct.type_code AND taf.user_id = tau.user_id AND taf.area_id = ".$area_id;
		
if($checkaimag==1) 
{
	$whereQuery .= " AND EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = vs.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id."))";
}	

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
$row = $db->query($selQuery);

if (!empty($row))
{
	$user_id  = $row[$i]["user_id"];
	$area_id  = $row[$i]["area_id"];
?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo _p("MoreText1")." "._p("ResourceSubTitle1")." "._p("MoreText2"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th style="width: 30%"><?php echo _p("ResourceSub1Column3"); ?></th>
        <td><?php echo $row[$i]["area_year"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("ResourceSub1Column1"); ?></th>
        <td><?php echo $row[$i]["aimag_name_$language_name"]; ?></td>
      </tr> 
      <tr>
        <th><?php echo _p("ResourceSub1Column2"); ?></th>
        <td><?php echo $row[$i]["soum_name_$language_name"]; ?></td>
      </tr>  
      <tr>
        <th><?php echo _p("ResourceSub1Column5"); ?></th>
        <td><?php echo $row[$i]["type_name_$language_name"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("ResourceSub1Column4"); ?></th>
        <td><?php echo $row[$i]["forest_area"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("ResourceSub1Column6"); ?></th>
        <td><?php echo $row[$i]["area_change"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("DataEntryUserName");?>:</th>
        <td><?php echo $row[$i]["user_name"]; ?></td>
      </tr>
    </tbody>
  </table>
</div>

<div class="table-responsive">
  <table class="table">
    <tbody>
      <tr>
        <td><?php if($sess_profile==1) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&area_id=".$area_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
          <?php } else if($user_id==$sess_user_id) { ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&area_id=".$area_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
          <?php } ?>
          <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("BackButton");?></a></td>
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
