<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span12">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span6 search-control">
		 <div class="control-group info">
          <label class="control-label">Овгийн монгол нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="family_name_mn" id="family_name_mn" value="<?php echo $family_name_mn;?>"/>
          </div>
        </div>
		  <div class="control-group info">
          <label class="control-label">Амьтны латин нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="species_name" id="species_name" value="<?php echo $species_name;?>"/>
          </div>
        </div>
		
		<div class="control-group info">
          <label class="control-label">Амьтны монгол нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="species_name_mn" id="species_name_mn" value="<?php echo $species_name_mn;?>"/>
          </div>
        </div>
		<div class="control-group info">
          <label class="control-label">Халдварт өвчний нэр:</label>
          <div class="controls">
             <input type="text" class="span3" name="contagion_name" id="contagion_name" value="<?php echo $contagion_name;?>"/>
          </div>
        </div>
      </div>
      <div class="span6 search-control">
	    
        <div class="control-group info">
          <label class="control-label">Аймаг, хотын нэр :</label>
          <div class="controls">
             <input type="text" class="span3" name="aimag_name_mn" id="aimag_name_mn" value="<?php echo $aimag_name_mn;?>"/>
          </div>
        </div>    
		<div class="control-group info">
          <label class="control-label">Сум, дүүргийн нэр :</label>
          <div class="controls">
            <input type="text" class="span3" name="soum_name_mn" id="soum_name_mn" value="<?php echo $soum_name_mn;?>"/>
          </div>
        </div> 
		 <div class="control-group info">
          <label class="control-label">Зарчил гаргасан он:</label>
          <div class="controls">
            <input type="text" class="span1" name="contagion_date" id="contagion_date" value="<?php if($contagion_date > 0) echo $contagion_date;?>"/>
          </div>
        </div>
		 <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchcontagionbttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
