<?php
if (isset($_GET["permission_id"]))
{
	$permission_id = (int)$_GET["permission_id"];
} else {
	$permission_id = 0;
}

	
$i = 0;

$startQuery = "SELECT";
$valueQuery = "tgcpe.*, tgcen.entity_name FROM ".$schemas.".taanimalcustompermission tgcpe, ".$schemas.".tganimalcustomentity tgcen";
$whereQuery = "WHERE tgcpe.entity_name = tgcen.entity_id AND tgcpe.permission_id =".$permission_id;

$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
//echo $selQuery;
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
	$valueQuery = "tgcen.*, taaim.aimag_name_mn, tasou.soum_name_mn FROM ".$schemas.".taanimalcustompermission tgcpe,".$schemas.".tganimalcustomentity tgcen, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou ";
	$whereQuery = "WHERE taaim.aimag_code=tgcen.aimag_name  AND tasou.soum_code=tgcen.soum_name AND tgcpe.entity_name = tgcen.entity_id AND tgcpe.permission_id =".$permission_id;
		
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);

	if (!empty($row))
	{
	?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 60); ?></a></div>
      <div id="collapse3" class="accordion-body collapse">
        <div class="accordion-inner">
          <?php
			require("includes/taanimalcustompermission/inc.query_animalcustomentity.php");
			?>
        </div>
      </div>
    </div>
    <?php
	}
	    
	$i = 0;

	$startQuery = "SELECT";
	$valueQuery = "tgcpe.*, tgcen.entity_name FROM ".$schemas.".taanimalcustompermission tgcpe, ".$schemas.".tganimalcustomentity tgcen";
	$whereQuery = "WHERE tgcpe.entity_name = tgcen.entity_id AND tgcpe.permission_id =".$permission_id;
		
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

	$row = $db->query($selQuery);

	if (!empty($row))
	{
	?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 61); ?></a></div>
      <div id="collapse2" class="accordion-body collapse in">
        <div class="accordion-inner">
          <?php
			require("includes/taanimalcustompermission/inc.query_animalcustompermission.php");
			?>
        </div>
      </div>
    </div>
    <?php 
	} 

	$i = 0;
	$startQuery = "SELECT";
	$valueQuery = "tgcna.*, tgcpe.permission_number, tagn.genus_name, tagn.genus_name_mn, tapl.species_name_mn, tapl.species_name FROM ".$schemas.".taanimalcustompermission tgcpe, ".$schemas.".taanimalcustomname tgcna,".$schemas.".tagenusname tagn,".$schemas.".taanimalname tapl";
	$whereQuery = "WHERE tgcna.permission_id =".$permission_id." AND tgcpe.permission_id = tgcna.permission_id AND tgcna.species_name = tapl.species_code AND tapl.genus_code = tagn.genus_code ORDER BY tgcpe.approved_date DESC, tgcpe.permission_number ASC";
		
	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;

     //echo $selQuery;
	$row = $db->query($selQuery);
	if (!empty($row)) 
	{
	?>
    <div class="accordion-group">
      <div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse4"><i class="icon-folder-open"></i>&nbsp;<?php echo getdata($ITEM_TYPE, 62); ?></a></div>
      <div id="collapse4" class="accordion-body collapse">
        <div class="accordion-inner">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th colspan="6"><?php echo getdata($ITEM_TYPE, 62); ?> дэлгэрэнгүй харах</th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th class="span4">Зөвшөөрлийн дугаар</th>
                <th class="span4">Амьтны латин нэр</th>
                <th class="span4">Амьтны монгол нэр</th>
                <th class="span4">Амьтны тоо толгой</th>
                <th class="span4">Хэмжих нэгж</th>
                <th class="span4">Нэмэлт мэдээлэл</th>
              </tr>
            </thead>
            <tbody>
              <?php
				for ($i=0; $i < sizeof($row); $i++) 
				{
				?>
              <tr>
                <td><?php echo $row[$i]["permission_number"]; ?></td>
                <td><?php echo $row[$i]["genus_name"]." ".$row[$i]["species_name"]; ?></td>
                <td><?php echo $row[$i]["species_name_mn"]." ".$row[$i]["genus_name_mn"]; ?></td>
                <td><?php echo $row[$i]["species_amount"]; ?></td>
                <td><?php echo $row[$i]["amount_unit"]; ?></td>
                <td><?php echo $row[$i]["species_info"]; ?></td>
              </tr>
              <?php
				}
				?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php 
	} 
	?>
  </div>
</div>
<div> <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a> </div>
<?php
} else {
	$notify ="Таны хайсан мэдээлэл байхгүй байна. <a href=\"".$my_url.$my_page.$search_url.$sort_url."\">Буцах</a>";
	show_notification("error", "", $notify);
}
?>