<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span12">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group">
          <label class="control-label">Хэрэглэгчийн нэр:</label>
          <div class="controls">
            <input type="text" class="span4" name="lastname" id="lastname" value="<?php echo $lastname;?>"/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Хандах нэр:</label>
          <div class="controls">
            <input type="text" class="span4" name="login_name" id="login_name" value="<?php echo $login_name;?>"/>
          </div>
        </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group">
          <label class="control-label">Хэрэглэгчийн төрөл:</label>
          <div class="controls">
            <?php
						echo seldata("profile", "span3", $USER_PROFILE, $profile, "", "Бүх төрөл");
						?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Бүлгийн нэр:</label>
          <div class="controls">
            <?php
					$selQuery = "SELECT tg.group_id, tg.group_name FROM ".$schemas.".tagroups tg ORDER BY	tg.group_name ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("group_id", "span3", $rows, "group_id", "group_name", $group_id, "", "Бүх бүлэг");
					?>
          </div>
        </div>
      </div>
      <div class="span12 offset8">
        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchuserbttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
