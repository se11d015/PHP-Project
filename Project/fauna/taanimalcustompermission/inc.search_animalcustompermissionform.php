<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span12">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Экспортлогч, импортлогчийн нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="entity_name" id="entity_name" value="<?php echo $entity_name;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Зөвшөөрөл өгсөн он:</label>
          <div class="controls">
            <input type="text" class="span3" name="approved_date" id="approved_date" value="<?php if($approved_date > 0) echo $approved_date;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Зөвшөөрөл дуусах он:</label>
          <div class="controls">
            <input type="text" class="span3" name="end_date" id="end_date" value="<?php if($end_date > 0) echo $end_date;?>"/>
          </div>
        </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Зөвшөөрлийн төрөл:</label>
          <div class="controls">
            <?php
				echo seldata("permission_type", "span2", $CUSTOM_PERMISSION_TYPE, $permission_type, "", "Бүх төрөл");
				?>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Зөвшөөрлийн дугаар:</label>
          <div class="controls">
            <input type="text" class="span3" name="permission_number" id="permission_number" value="<?php echo $permission_number;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchanimalcustomentitybttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
