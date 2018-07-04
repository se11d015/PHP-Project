<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span12">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Аймгийн латин нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="kingdom_name" id="kingdom_name" value="<?php echo $kingdom_name;?>"/>
          </div>
        </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Аймгийн монгол нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="kingdom_name_mn" id="kingdom_name_mn" value="<?php echo $kingdom_name_mn;?>"/>
          </div>
        </div>
      </div>
      <div class="span12 offset8">
        <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchkingdombttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
