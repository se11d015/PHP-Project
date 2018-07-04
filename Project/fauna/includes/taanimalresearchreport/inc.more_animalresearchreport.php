<?php
if (isset($_GET["research_id"]))
{
	$research_id = (int)$_GET["research_id"];
}else
{
	$research_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tapr.*  FROM ".$schemas.".taanimalresearchreport tapr";
$whereQuery = "WHERE tapr.research_id = ".$research_id."";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
	$userid  = $row[$i]["user_id"];
?>

<div class="more-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Дэлгэрэнгүй мэдээлэл</th>
      </tr>
    </thead>
  </table>
  <div class="accordion" id="accordion">
    <?php

	$i = 0;

	$startQuery = "SELECT";
	$valueQuery = "tapr.*, tcrt.type_name  FROM ".$schemas.".taanimalresearchreport tapr, ".$schemas.".tcresearchtype tcrt ";
	$whereQuery = "WHERE tapr.research_type = tcrt.type_id AND tapr.research_id = ".$research_id."";
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);

	if (!empty($row))
	{
	?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 30); ?></a></div>
      <div id="collapse2" class="accordion-body collapse in">
        <div class="accordion-inner">
          <?php
			require("includes/taanimalresearchreport/inc.query_animalresearchreport.php");
			?>
        </div>
      </div>
    </div>
    <?php
	}
	
	$i = 0;
	
	$startQuery = "SELECT";
	$valueQuery = "tapb.*, tct.type_name as budget_type_name FROM ".$schemas.".taanimalresearchbudget tapb, ".$schemas.".tcbudgettype tct";
	$whereQuery = "WHERE tapb.budget_resource = tct.type_id AND tapb.research_id = ".$research_id;
	$sortQuery = " ORDER BY tapb.budget_resource ASC";
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery." ".$sortQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row)) 
	{
	?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 31); ?></a></div>
      <div id="collapse3" class="accordion-body collapse">
        <div class="accordion-inner">
          <table class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th colspan="3"><?php echo getdata($ITEM_TYPE, 31); ?> дэлгэрэнгүй харах</th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th class="span4">Санхүүжилтийн эх үүсвэр</th>
                <th class="span4">Санхүүжилтийн хэмжээ, мян төг</th>
              </tr>
            </thead>
            <tbody>
              <?php
				$sum = 0.0;
				
				for ($i=0; $i < sizeof($row); $i++) 
				{
					$sum = $sum + $row[$i]["budget_amount"];

					require("includes/taanimalresearchreport/inc.query_animalresearchbudget.php");
				}
				?>
              <tr>
                <th>Нийт дүн</th>
                <th colspan="2"><?php echo $sum; ?></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php 
	} 
	?>
  </div>
  <div> <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a> </div>
</div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
