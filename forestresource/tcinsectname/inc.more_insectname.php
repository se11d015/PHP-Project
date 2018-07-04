<?php
if (isset($_GET["insect_id"]))
{
	$insect_id = (int)$_GET["insect_id"];
}else
{
	$insect_id = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "tct.* FROM ".$schemas.".tcinsectname tct";
$whereQuery = "WHERE tct.insect_id = ".$insect_id;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>

  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th colspan="2"><?php echo _p("MoreText1")." "._p("ReferenceSubTitle4")." "._p("MoreText2"); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th style="width: 30%"><?php echo _p("ReferenceSub4Column1");?>:</th>
          <td><?php echo $row[$i]["insect_code"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("ReferenceSub4Column2");?>:</th>
          <td><?php echo $row[$i]["order_name_mn"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("ReferenceSub4Column3");?>:</th>
          <td><?php echo $row[$i]["family_name_mn"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("ReferenceSub4Column4");?>:</th>
          <td><?php echo $row[$i]["species_name"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("ReferenceSub4Column5");?>:</th>
          <td><?php echo $row[$i]["insect_name_mn"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("ReferenceSub4Column6");?>:</th>
          <td><?php echo $row[$i]["insect_name_en"]; ?></td>
        </tr>
        <tr>
          <th><?php echo _p("ReferenceSub4Column7");?>:</th>
          <td><?php echo $row[$i]["insect_name_ru"]; ?></td>
        </tr>
        <tr>
          <td colspan="2"><?php
			if($sess_profile==1)
			{ 
			?>
            <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url."&action=edit&insect_id=".$insect_id; ?>"><i class="fa fa-pencil"></i> <?php echo _p("EditButton");?></a>
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
