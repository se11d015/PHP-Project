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
        <div class="control-group">
          <label class="control-label">Мэдээний нэр:</label>
          <div class="controls">
            <?php
						echo seldata("itemid", "span4", $GROUP_ITEM_TYPE, $itemid, "", "Бүх мэдээ");
						?>
          </div>
        </div>
        </div>
      <div class="span6 search-control">        
        <div class="control-group">
          <label class="control-label">Эрхийн нэр:</label>
          <div class="controls">
            <?php
						echo seldata("roleid", "span2", $ROLE_TYPE, $roleid, "", "Бүх эрх");
						?>
          </div>
        </div>        
        <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchgrouprolebttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
    </form>
  </div>
</div>
