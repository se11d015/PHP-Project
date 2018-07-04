<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span12">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Мэргэжлийн байгууллагын нэр:</label>
          <div class="controls">
            <input type="text" class="span3" name="org_name" id="org_name" value="<?php echo $org_name;?>"/>
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
        <div class="control-group info">
          <label class="control-label">Эрх авсан чиглэл:</label>
          <div class="controls">
            <?php
				$selQuery = "SELECT tct.type_name, tct.type_id FROM ".$schemas.".tcactivitytype tct ORDER BY tct.type_name ";
				$rows = $db->query($selQuery);
				echo seldatadb("type_name", "span3", $rows, "type_id", "type_name", $type_name, "", "Бүх чиглэл");
				?>
          </div>
        </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group info">
          <label class="control-label">Эрхийн гэрчилгээний дугаар:</label>
          <div class="controls">
            <input type="text" class="span2" name="permission_number" id="permission_number" value="<?php echo $permission_number;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Эрх олгосон он:</label>
          <div class="controls">
            <input type="text" class="span2" name="approved_date" id="approved_date" value="<?php if($approved_date > 0) echo $approved_date;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Эрх дуусах он:</label>
          <div class="controls">
            <input type="text" class="span2" name="end_date" id="end_date" value="<?php if($end_date > 0) echo $end_date;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchanimalorgpermissionbttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
