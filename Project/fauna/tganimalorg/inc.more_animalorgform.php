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
$valueQuery = "tapr.*  FROM ".$schemas.".tganimalorg tapr";
$whereQuery = "WHERE tapr.org_id = ".$org_id."";

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
  <!-- Nav tabs -->
  <ul class="nav nav-tabs nav-justified">
    <li class="active"><a href="#animalorg" data-toggle="tab"><?php echo getdata($ITEM_TYPE, 40); ?></a></li>
    <li><a href="#animalorgpermission" data-toggle="tab"><?php echo getdata($ITEM_TYPE, 41); ?></a></li>
    <li><a href="#animalorgreport" data-toggle="tab"><?php echo getdata($ITEM_TYPE, 42); ?></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane active" id="animalorg">
      <?php
		$i = 0;

		$startQuery = "SELECT";
		$valueQuery = "tapr.*, vas.aimag_name_mn, vas.soum_name_mn  FROM ".$schemas.".tganimalorg tapr , scadministrative.vasoumname vas ";
		$whereQuery = "WHERE tapr.soum_name = vas.soum_code AND tapr.org_id = ".$org_id."";
	
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	
		$row = $db->query($selQuery);
	
		if (!empty($row))
		{
			require("tganimalorg/inc.query_animalorgform.php");
		}
				
		?>
      </br>
      <div>
        <?php
	if ($sess_profile == 1) {
		?>
        <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=edit&org_id=" . $org_id; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp;
        <?php
	} else if ($user_id == $sess_user_id) {
		?>
        <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url . "&action=edit&org_id=" . $org_id; ?>"><i class="icon-edit icon-white"></i>&nbsp;Засварлах</a>&nbsp;
        <?php
	}
	?>
        <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
    </div>
    <!--start-->
    <div class="tab-pane" id="animalorgpermission">
      <?php
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
      <table class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th colspan="7"><?php echo getdata($ITEM_TYPE, 41); ?> дэлгэрэнгүй харах</th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th>№</th>
            <th class="span4">Эрхийн гэрчилгээний дугаар</th>
            <th class="span4">Эрх олгосон шийдвэрийн нэр, дугаар</th>
            <th class="span4">Эрх олгосон огноо</th>
            <th class="span4">Эрх дуусах огноо</th>
            <th class="span4">Эрх авсан чиглэл</th>
            <th class="span2"></th>
          </tr>
        </thead>
        <tbody>
          <?php	
			for ($i=0; $i < sizeof($row); $i++) 
			{
				require("tganimalorg/inc.query_animalorgpermissionform.php");
			}
			?>
        </tbody>
      </table>
      <?php
		}
		?>
      </br>
      <div> <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
    </div>
    <!--end-->
    <!--start-->
    <div class="tab-pane" id="animalorgreport">
      <?php
		$i = 0;
		
		$startQuery = "SELECT";
		$valueQuery = "tapr.*, tct.type_name as type_name FROM ".$schemas.".taanimalorgreport tapr, ".$schemas.".tcreporttype tct";
		$whereQuery = "WHERE tapr.report_type = tct.type_id AND tapr.org_name = ".$org_id." ORDER BY tapr.report_name ASC";
		
		$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	
		$row = $db->query($selQuery);
		
		if (!empty($row)) 
		{
		?>
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
            <th class="span2"></th>
          </tr>
        </thead>
        <tbody>
          <?php	
			for ($i=0; $i < sizeof($row); $i++) 
			{
				require("tganimalorg/inc.query_animalorgreportform.php");
			}
			?>
        </tbody>
      </table>
      <?php 
	  	}
		?>
      </br>
      <div> <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
    </div>
    <!--end-->
  </div>
</div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>
