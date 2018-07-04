<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span12">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Аймгийн нэр :</label>
          <div class="controls">
             <input type="text" class="span3" name="aimag_name_mn" id="aimag_name_mn" value="<?php echo $aimag_name_mn;?>"/>
          </div>
        </div>
		<div class="control-group info">
          <label class="control-label">Бүсийн нэр :</label>
          <div class="controls">
            <input type="text" class="span3" name="zone_name" id="zone_name" value="<?php echo $zone_name;?>"/>
          </div>
        </div>
		
      </div>
      <div class="span6 search-control">
	     <div class="control-group info">
          <label class="control-label">Баримт бичгийн төрөл:</label>
          <div class="controls">
            <?php
				$selQuery = "SELECT tcrn.type_id, tcrn.type_name FROM ".$schemas.".tcfiletype tcrn ORDER BY tcrn.type_id";
				$row = $db->query($selQuery);
				echo seldatadb("type_id", "span3", $row, "type_id", "type_name", "", "", "Бүх төрөл");
				?>
          </div>
        </div>
		 <div class="control-group info">
          <label class="control-label">Баримт бичгийн боловсруулсан огноо:</label>
          <div class="controls">
            <input type="text" class="span3" name="doc_date" id="doc_date" value="<?php if($doc_date > 0) echo $doc_date;?>"/>
          </div>
        </div>
		 <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchmngbttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
