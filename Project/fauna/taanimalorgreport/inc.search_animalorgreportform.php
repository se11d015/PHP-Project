<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span12">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Тайлангийн нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="report_name" id="report_name" value="<?php echo $report_name;?>"/>
          </div>
        </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Тайлангийн төрөл:</label>
          <div class="controls">
            <?php
				$selQuery = "SELECT tct.type_name, tct.type_id FROM ".$schemas.".tcreporttype tct ORDER BY tct.type_name ";
				$rows = $db->query($selQuery);
				echo seldatadb("type_name", "span3", $rows, "type_id", "type_name", $type_name, "", "Бүх төрөл");
				?>
          </div>
        </div>
        <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchanimalorgreportbttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
