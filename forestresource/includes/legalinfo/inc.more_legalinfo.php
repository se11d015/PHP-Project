<?php
if (isset($_GET["legalid"]))
{
	$legalid = (int)$_GET["legalid"];
}else
{
	$legalid = 0;
}

$i = 0;

$startQuery = "SELECT";
$valueQuery = "tli.*, tclt.type_name_mn, tclto.topic_name_mn, tclt.type_name_en, tclto.topic_name_en, tau.organization||' - '|| tau.lastname as user_name FROM sclegal.talegalinfo tli, sclegal.tclegaltype tclt, sclegal.tclegaltopic tclto, sclegal.tausers tau";
$whereQuery = "WHERE tli.legal_type = tclt.type_id AND tli.legal_topic = tclto.topic_id AND tli.user_id=tau.user_id AND tli.legal_id = ".$legalid;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db1->query($selQuery);

if (!empty($row))
{
?>

<div class="table-responsive-md">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo _p("MoreText1")." "._p("LegalInfoTitle")." "._p("MoreText2"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th style="width: 30%"><?php echo _p("LegalInfoColumn1");?>:</th>
        <td><?php echo $row[$i]["type_name_$language_name"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("LegalInfoColumn2");?>:</th>
        <td><?php echo $row[$i]["topic_name_$language_name"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("LegalInfoColumn3");?>:</th>
        <td><?php echo getdata($LEGAL_ACTIVE, $row[$i]["legal_status"]); ?></td>
      </tr>
      <?php
			if($row[$i]["legal_type"] !=1 && $row[$i]["legal_type"] !=3)
			{
			?>
      <tr>
        <th><?php echo _p("LegalInfoColumn4");?>:</th>
        <td><?php echo $row[$i]["act_number"]; ?></td>
      </tr>
      <?php
			}
		
			if($row[$i]["legal_type"] > 7 && $row[$i]["legal_type"] < 11)
			{
				$selQuery = "SELECT tao.org_id, tao.org_name_mn, tao.org_name_en FROM sclegal.taorgname tao ORDER BY tao.org_name_mn ASC";
				$rows = $db1->query($selQuery);
      ?>
      <tr>
        <th><?php echo _p("LegalInfoColumn5");?>:</th>
        <td><?php echo getdatadb($rows, "org_id", "org_name_$language_name", $row[$i]["org_name"]); ?></td>
      </tr>
      <?php
			}
			?>
      <tr>
        <th><?php echo _p("LegalInfoColumn6");?>:</th>
        <td><?php echo $row[$i]["legal_name"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("LegalInfoColumn7");?>:</th>
        <td><?php echo $row[$i]["issued_date"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("LegalInfoColumn8");?>:</th>
        <td><?php echo $row[$i]["followed_date"]; ?></td>
      </tr>
      <tr>
        <th><?php echo _p("LegalInfoColumn9");?>:</th>
        <td><?php if(strlen($row[$i]["pathname"])>0 && strlen($row[$i]["filename"])>0) { ?>
          <a href="<?php echo "http://"."www.eic.mn/legalinfo/".$row[$i]["pathname"]."/".$row[$i]["filename"]; ?>" target="_blank"><?php echo _p("BrowseFileButton");?></a>
          <?php } else echo "-"; ?></td>
      </tr>
    </tbody>
  </table>
  <?php 
	if($row[$i]["annex_number"] > 0)
	{

		$selQuery = "SELECT tla.annex_id, tla.annex_name, tla.annex_number, tla.filename, tla.pathname, tla.user_id FROM sclegal.talegalannex tla WHERE tla.legal_id = ".$legalid." ORDER BY tla.annex_number";
		$rows = $db1->query($selQuery);
		if (!empty($rows))
		{
	?>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th colspan="3"><?php echo _p("LegalAnnexTitle");?></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th><?php echo _p("LegalAnnexColumn1");?></th>
        <th style="width: 70%"><?php echo _p("LegalAnnexColumn2");?></th>
        <th><?php echo _p("LegalAnnexColumn3");?></th>
      </tr>
    </thead>
    <tbody>
      <?php 	
		  for ($j=0; $j < sizeof($rows); $j++) 
			{
			?>
      <tr>
        <td><?php echo $rows[$j]["annex_number"]; ?></td>
        <td><?php echo $rows[$j]["annex_name"]; ?></td>
        <td><?php if(strlen($rows[$j]["pathname"])>0 && strlen($rows[$j]["filename"])>0) { ?>
          <a href="<?php echo "http://"."www.eic.mn/legalinfo/".$rows[$j]["pathname"]."/".$rows[$j]["filename"]; ?>" target="_blank"><?php echo _p("BrowseFileButton");?></a>
          <?php } else echo "-";  ?></td>
      </tr>
      <?php 	
		  }
			?>
    </tbody>
  </table>
  <?php 
		}
	}
?>
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
