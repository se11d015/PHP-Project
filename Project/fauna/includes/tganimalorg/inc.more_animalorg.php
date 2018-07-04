<?php
if (isset($_GET["org_id"]))
{
	$org_id = (int)$_GET["org_id"];
}else
{
	$org_id = 0;
}

$i = 0;
$startQuery = "SELECT";
$valueQuery = "tgpo.*  FROM ".$schemas.".tganimalorg tgpo";
$whereQuery = "WHERE tgpo.org_id = ".$org_id."";

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

$row = $db->query($selQuery);

if (!empty($row))
{
?>

<div class="more-table">
<table class="table table-bordered table-striped table-hover">
  <thead>
    <tr>
      <th colspan="2">Дэлгэрэнгүй мэдээлэл</th>
    </tr>
  </thead>
</table>
<div class="accordion" id="accordion">
  <?php
	$i = 0;

	$startQuery = "SELECT";
	$valueQuery = "tgpo.*, vas.aimag_name_mn, vas.soum_name_mn  FROM ".$schemas.".tganimalorg tgpo , scadministrative.vasoumname vas ";
	$whereQuery = "WHERE tgpo.soum_name = vas.soum_code AND tgpo.org_id = ".$org_id."";

	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);

	if (!empty($row)) 
	{
	?>
  <div class="accordion-group">
    <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 40); ?></a></div>
    <div id="collapse2" class="accordion-body collapse">
      <div class="accordion-inner">
        <?php
            require("includes/tganimalorg/inc.query_animalorg.php");
            ?>
      </div>
    </div>
  </div>
  <?php
	}

	$i = 0;

	$startQuery = "SELECT";
	$valueQuery = "tapb.*  FROM ".$schemas.".taanimalorgpermission tapb";
	$whereQuery = "WHERE  tapb.org_name = ".$org_id;
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	//echo $selQuery;
	$row = $db->query($selQuery);
	
	if (!empty($row)) 
	{		
	?>
  <div class="accordion-group">
    <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 41); ?></a></div>
    <div id="collapse3" class="accordion-body collapse in">
      <div class="accordion-inner">
        <?php	
			require("includes/tganimalorg/inc.query_animalorgpermission.php");
			
			?>
      </div>
    </div>
  </div>
  <?php
	}

	$i = 0;
	
	$startQuery = "SELECT";
	$valueQuery = "tapr.*, tct.type_name as type_name FROM ".$schemas.".taanimalorgreport tapr, ".$schemas.".tcreporttype tct";
	$whereQuery = "WHERE tapr.report_type = tct.type_id AND tapr.org_name = ".$org_id." ORDER BY tapr.report_name ASC";
	
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);
	
	if (!empty($row)) 
	{
	?>
  <div class="accordion-group">
    <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse4"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 42); ?></a></div>
    <div id="collapse4" class="accordion-body collapse ">
      <div class="accordion-inner">
        <div class="more-table">
          <table class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th colspan="7"><?php echo getdata($ITEM_TYPE, 42); ?> дэлгэрэнгүй харах</th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>№</th>
                <th class="span4">Тайлангийн төрөл</th>
                <th class="span4">Тайлангийн нэр</th>
                <th class="span4">Тайлан хамрах хугацаа</th>
                <th class="span4">Тайлангийн хураангуй </th>
                <th class="span4">Ажлын тайлангийн файл</th>
              </tr>
            </thead>
            <tbody>
              <?php	
			for ($i=0; $i < sizeof($row); $i++) 
			{
				require("includes/tganimalorg/inc.query_animalorgreport.php");
			}
			?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php 
	}
	?>
</div>
<div><a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
