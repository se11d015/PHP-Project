<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span12">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Аймаг, хотын нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="aimag_name_mn" id="aimag_name_mn" value="<?php echo $aimag_name_mn;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Сум, дүүргийн нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="soum_name_mn" id="soum_name_mn" value="<?php echo $soum_name_mn;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Экспортлогч, импортлогчийн нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="entity_name" id="entity_name" value="<?php echo $entity_name;?>"/>
          </div>
        </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Хуулийн этгээдийн төрөл:</label>
          <div class="controls">
            <?php
				echo seldata("entity_type", "span2", $CUSTOM_ENTITY_TYPE, $entity_type, "", "Бүх төрөл");
				?>
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
