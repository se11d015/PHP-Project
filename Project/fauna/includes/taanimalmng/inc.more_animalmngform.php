<?php
if (isset($_GET["doc_id"])) {
$doc_id = (int) $_GET["doc_id"];
} else {
$doc_id = 0;
}

$i = 0;

$startQuery = "SELECT";

$valueQuery = "taamn.*, tganz.zone_name as zone_name_mn, taaim.aimag_name_mn, tasou.soum_name_mn, tcfty.type_name  FROM scfauna.tganimalzone tganz, scadministrative.taaimagname taaim, scadministrative.tasoumname tasou, ".$schemas . ".tcfiletype tcfty, ".$schemas . ".taanimalmng taamn ";
		$whereQuery = "WHERE taaim.aimag_code=tganz.aimag_name AND tasou.soum_code=tganz.soum_name AND taamn.zone_name=tganz.gid AND taamn.doc_type=tcfty.type_id AND taamn.doc_id = " . $doc_id;

$selQuery = $startQuery . " " . $valueQuery . " " . $whereQuery ;

$row = $db->query($selQuery);

if (!empty($row)) {
?>

<div class="more-table">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th colspan="2"><?php echo getdata($ITEM_TYPE, 120); ?>  (дэлгэрэнгүй харах) </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="span3"><strong>Хэрэгжих аймаг, хотын нэр  :</strong></td>
        <td><?php echo $row[$i]["aimag_name_mn"]; ?></td>
      </tr>
      <tr>
        <td><strong>Хэрэгжих сум, дүүргийн нэр :</strong></td>
        <td><?php echo $row[$i]["soum_name_mn"]; ?></td>
      </tr>
     
      <tr>
        <td><strong>Бүсийн нэр:</strong></td>
        <td><?php echo $row[$i]["zone_name_mn"]; ?></td>
      </tr>
	  <tr>
        <td><strong>Баримт бичгийн төрөл:</strong></td>
        <td><?php echo $row[$i]["type_name"]; ?></td>
      </tr>
      <tr>
        <td ><strong>Баримт бичгийн боловсруулсан огноо:</strong></td>
        <td><?php echo $row[$i]["doc_date"]; ?></td>
      </tr>
         <tr>
      <td><strong>Баримт бичиг:</strong></td>
      <td><?php if(strlen($row[$i]["doc_filename"])>0) { ?>
        <a href="<?php echo $row[$i]["doc_pathname"]."/".$row[$i]["doc_filename"]; ?>" target="_blank">Файл харах</a>&nbsp;
        <?php } ?></td>
    </tr>
    </tbody>
  </table>
</div>
<div>
  <a class="btn btn-danger" href="<?php echo $my_url . $my_page . $search_url . $sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Буцах</a></div>
<?php
                } else {
                    $notify = "Таны хайсан мэдээлэл байхгүй байна. <a href=\"" . $my_url . $my_page . $search_url . $sort_url . "\">Буцах</a>";
                    show_notification("error", "", $notify);
                }
                ?>
