<?php
if (isset($_GET["soum_code"]))
{
	$soum_code = (int)$_GET["soum_code"];
}else
{
	$soum_code = 0;
}

if (isset($_GET["volume_year"]))
{
	$volume_year = (int)$_GET["volume_year"];
}else
{
	$volume_year = 0;
}

$startQuery = "SELECT";
$valueQuery = "va.aimag_name_mn, va.soum_name_mn, va.aimag_name_en, va.soum_name_en, tct.tree_name_mn, tct.tree_name_en, taf.* FROM ".$schemas.".taforestvolume taf, ".$schemas.".tctreetype tct, scadministrative.vasoumname va";
$whereQuery = "WHERE taf.soum_code = va.soum_code AND taf.tree_code = tct.tree_code AND taf.soum_code=".$soum_code." AND taf.volume_year=".$volume_year;
    
$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$rows = $db->query($selQuery);

if (!empty($rows))
{
	$title = $rows[0]["aimag_name_$language_name"]." "._p("ForestResourceText1")." ".$rows[0]["soum_name_$language_name"]." "._p("ForestResourceText2").", ".$rows[0]["volume_year"]." "._p("ForestResourceText3");
?>
<h4 class="sub-omheader "><?php echo _p("ResourceSubTitle2"); ?></h4>	  
<div class="table-responsive-md">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="6"><?php echo $title; ?></th>
      </tr>
      <tr>
        <th><?php echo _p("Number");?></th>
        <th><?php echo _p("ResourceSub2Column7");?></th>
        <th><?php echo _p("ResourceSub2Column4");?></th>
        <th><?php echo _p("ResourceSub2Column8");?></th>
        <th><?php echo _p("ResourceSub2Column5");?></th>
        <th><?php echo _p("ResourceSub2Column6");?></th>
      </tr>
    </thead>
    <tbody>
      <?php       
		for ($i=0; $i < sizeof($rows); $i++) 
        {
        ?>
      <tr>
        <td><?php echo $i + 1; ?></td>
        <td><?php echo $rows[$i]["tree_name_$language_name"]; ?></td>
        <td><?php echo $rows[$i]["growing_volume"]; ?></td>
        <td><?php echo $rows[$i]["volume_change"]; ?></td>
        <td><?php echo $rows[$i]["driedstanding_volume"]; ?></td>
        <td><?php echo $rows[$i]["fallen_volume"]; ?></td>
      </tr>
      <?php
		}
        ?>
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
