<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span12">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Ангийн монгол нэр :</label>
          <div class="controls">
            <input type="text" class="span3" name="class_name_mn" id="class_name_mn" value="<?php echo $class_name_mn;?>"/>
          </div>
        </div>       
        <div class="control-group info">
          <label class="control-label">Аймгийн нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="aimag_name_mn" id="aimag_name_mn" value="<?php echo $aimag_name_mn;?>"/>
          </div>
        </div>
		<div class="control-group info">
          <label class="control-label">Сумын нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="soum_name_mn" id="soum_name_mn" value="<?php echo $soum_name_mn;?>"/>
          </div>
        </div>
      </div>
      <div class="span6 search-control">
	    <div class="control-group info">
          <label class="control-label">Зүйлийн нэрc:</label>
          <div class="controls">
            <input type="text" class="span3" name="species_names" id="species_names" value="<?php echo $species_names;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Бүсийн нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="zone_name" id="zone_name" value="<?php echo $zone_name;?>"/>
          </div>
        </div>
		<div class="control-group info">
          <label class="control-label">Бүсийн  зургийг хийсэн он:</label>
          <div class="controls">
            <input type="text" class="span3" name="zone_year" id="zone_year" value="<?php  if($zone_year > 0) echo $zone_year;?>"/>
          </div>
        </div>	
        <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchanimalzonebttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
