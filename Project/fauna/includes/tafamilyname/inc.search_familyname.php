<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span9">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span4 search-control">
        <div class="control-group info">
          <label class="control-label">Ангийн монгол нэр:</label>
          <div class="controls">
            <input type="text" class="span2" name="class_name_mn" id="class_name_mn" value="<?php echo $class_name_mn;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Багийн монгол нэр:</label>
          <div class="controls">
            <input type="text" class="span2" name="order_name_mn" id="order_name_mn" value="<?php echo $order_name_mn;?>"/>
          </div>
        </div>
      </div>
      <div class="span5 search-control">
        <div class="control-group info">
          <label class="control-label">Овгийн латин нэр:</label>
          <div class="controls">
            <input type="text" class="span2" name="family_name" id="family_name" value="<?php echo $family_name;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Овгийн монгол нэр:</label>
          <div class="controls">
            <input type="text" class="span2" name="family_name_mn" id="family_name_mn" value="<?php echo $family_name_mn;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchfamilybttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>