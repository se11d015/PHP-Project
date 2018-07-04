<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span9">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span5 search-control">
        <div class="control-group info">
          <label class="control-label">Хамгаалах арга хэмжээний төрөл:</label>
          <div class="controls">
            <?php
				$selQuery = "SELECT tcpt.type_id, tcpt.type_name FROM ".$schemas.".tcprotectiontype tcpt ORDER BY tcpt.type_name";
				$rows = $db->query($selQuery);
				echo seldatadb("protect_type", "span3", $rows, "type_id", "type_name", $protect_type, "", "Бүх арга хэмжээний төрөл");
				?>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Аймаг, хотын нэр:</label>
          <div class="controls">
            <?php
				$selQuery = "SELECT vaa.aimag_code, vaa.aimag_name_mn FROM scadministrative.vaaimagname vaa ORDER BY vaa.aimag_name_mn";
				$rows = $db->query($selQuery);
				echo seldatadb("aimag_code", "span3", $rows, "aimag_code", "aimag_name_mn", $aimag_code, "", "Бүх аймаг");
				?>
          </div>
        </div>
      </div>
      <div class="span4 search-control">
        <div class="control-group info">
          <label class="control-label">Хамгаалах арга хэмжээний авсан он:</label>
          <div class="controls">
            <input type="text" class="span2" name="protect_date" id="protect_date" value="<?php if($protect_date > 0) echo $protect_date;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchanimalprotectionbttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
