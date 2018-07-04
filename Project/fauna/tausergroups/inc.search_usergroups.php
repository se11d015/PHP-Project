<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span12">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group">
          <label class="control-label">Бүлгийн нэр:</label>
          <div class="controls">
            <?php
					$selQuery = "SELECT tag.group_id, tag.group_name FROM ".$schemas.".tagroups tag	ORDER BY tag.group_name";
					$row = $db->query($selQuery);
					echo seldatadb("groupid", "span3", $row, "group_id", "group_name", $groupid, "", "Бүх бүлэг");
					?>
          </div>
        </div>
      </div>
      <div class="span6 search-control">
        <div class="control-group">
          <label class="control-label">Хэрэглэгчийн нэр:</label>
          <div class="controls">
            <?php
					$selQuery = "SELECT tau.user_id, tau.organization||' - '||tau.lastname as user_name	FROM ".$schemas.".tausers tau	ORDER BY tau.organization, tau.lastname";
					$row = $db->query($selQuery);
					echo seldatadb("userid", "span3", $row, "user_id", "user_name", $userid, "", "Бүх хэрэглэгч");
					?>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchuserbttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
