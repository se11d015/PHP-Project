<?php 
if ($sess_profile==1) 
{ 

	if (isset($_GET["type_id"]))
	{
		$type_id = (int)$_GET["type_id"];
	}else
	{
		$type_id = 0;
	}
	
	$i = 0;
	
	$startQuery = "SELECT";
	$valueQuery = "tct.* FROM ".$schemas.".tclandtype tct";
	$whereQuery = "WHERE tct.type_id = ".$type_id;

	$selQuery = $startQuery." ".$valueQuery." ".$whereQuery;
	
	$row = $db->query($selQuery);
	
	if (!empty($row))
	{
?>
<script language="JavaScript" type="text/javascript">
function updatesubmitform(){
	if (document.getElementById("type_code").value==""){
		alert("<?php echo _p("EnterText1")." "._p("ReferenceSub3Column1")." "._p("EnterText2");?>");
	}else if (document.getElementById("type_name_mn").value==""){
		alert("<?php echo _p("EnterText1")." "._p("ReferenceSub3Column2")." "._p("EnterText2");?>");
	}else {
		document.getElementById("updatetypebttn").value = "1";
		document.mainform.submit();
	}
}
</script>
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("EditText3")." "._p("ReferenceSubTitle3")." "._p("EditText4"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="alert alert-warning" role="alert"><?php echo _p("AlertText"); ?></div>
          <form class="form" role="form" action="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>" enctype="multipart/form-data" method="post" name="mainform" id="mainform">
          <input type="hidden" name="type_id" id="type_id" value="<?php echo $row[$i]["type_id"]; ?>">
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("ReferenceSub3Column1");?> *:</label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="type_code" id="type_code" value="<?php echo $row[$i]["type_code"]; ?>" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextInt1"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label text-danger"><?php echo _p("ReferenceSub3Column2");?> *:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="type_name_mn" id="type_name_mn" value="<?php echo $row[$i]["type_name_mn"]; ?>" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("ReferenceSub3Column3");?>:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="type_name_en" id="type_name_en" value="<?php echo $row[$i]["type_name_en"]; ?>" />
              </div>
              <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span> </div>
			<div class="form-group row">
              <label class="col-md-3 col-form-label"><?php echo _p("ReferenceSub3Column4");?>:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="type_name_ru" id="type_name_ru" value="<?php echo $row[$i]["type_name_ru"]; ?>" />
              </div>
			  <span class="col-md-3 form-text text-muted"><?php echo _p("AlertTextChar50"); ?></span> </div>
            <input type="hidden" id="updatetypebttn" name="updatetypebttn" value="0"/>
            <div class="form-group row col-md-10 justify-content-center">
              <div>
                <button type="button" class="btn btn-primary" onclick="updatesubmitform()"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
                <a class="btn btn-primary" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></a></div>
            </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
<?php 
	} else {
		$notify = " <a class=\"btn btn-danger\" href=\"".$my_url.$my_page.$search_url.$sort_url."\"><i class=\"fa fa-undo\"></i> "._p("BackButton")." </a>";
		show_notification("error", _p("NotAccessText"), "");
	}
} else {
	show_notification("error", _p("NotAccessText"), "");
}
?>
