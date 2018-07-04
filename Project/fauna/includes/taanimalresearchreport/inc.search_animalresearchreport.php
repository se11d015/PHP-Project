<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span9">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span4 search-control">
        <div class="control-group info">
          <label class="control-label">Судалгааны нэр:</label>
          <div class="controls">
            <input type="text" class="span2" name="research_name" id="research_name" value="<?php echo $research_name;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Гүйцэтгэгч байгууллагын нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="executive_name" id="executive_name" value="<?php echo $executive_name;?>"/>
          </div>
        </div>
      </div>
      <div class="span5 search-control">
        <div class="control-group info">
          <label class="control-label">Судалгааны төрөл:</label>
          <div class="controls">
            <?php
				$selQuery = "SELECT tct.type_id, tct.type_name FROM ".$schemas.".tcresearchtype tct ORDER BY tct.type_name";
				$rows = $db->query($selQuery);
				echo seldatadb("research_type", "span3", $rows, "type_id", "type_name", $research_type, "", "Бүх судалгааны төрөл");
				?>
          </div>
        </div>
        <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchresearchreportbttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
