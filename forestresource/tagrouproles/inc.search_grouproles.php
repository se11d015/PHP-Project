<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("SearchTitle"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form" role="form" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
            <div class="form-row">
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("GroupRolesColumn1");?>:</label>
                <div class="col-md-6">
                  <?php
					$selQuery = "SELECT tag.group_id, tag.group_name_mn FROM ".$schemas.".tagroups tag	ORDER BY tag.group_name_mn";
					$row = $db->query($selQuery);
					echo seldatadb("groupid", "form-control", $row, "group_id", "group_name_$language_name", $group_id, "", _p("AllGroups"));
					?>
                </div>
              </div>
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("GroupRolesColumn2");?>:</label>
                <div class="col-md-6">
                  <?php
					echo seldata("roleid", "form-control", $ROLE_TYPE, $role_id, "", _p("AllRoles"));
					?>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("GroupRolesColumn3");?>:</label>
                <div class="col-md-6">
                  <?php
					echo seldata("itemid", "form-control", $ITEM_TYPE, $item_id, "", _p("AllDatasets"));
					?>
                </div>
              </div>
              <div class="form-group row col-md-4 justify-content-end">
                  <button type="submit" class="btn btn-primary" name="searchgrouprolebttn"><i class="fa fa-search"></i> <?php echo _p("SearchButton"); ?></button>
              </div>
            </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
