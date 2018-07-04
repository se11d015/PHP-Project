
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
                <label class="col-md-4 col-form-label"><?php echo _p("GroupsColumn1");?>:</label>
                <div class="col-md-6">
                  <?php
					$selQuery = "SELECT tag.group_id, tag.group_name_mn, tag.group_name_en FROM ".$schemas.".tagroups tag ORDER BY tag.group_name_mn";
					$row = $db->query($selQuery);
					echo seldatadb("groupid", "form-control", $row, "group_id", "group_name_$language_name", $groupid, "", _p("AllGroups"));
					?>
                </div>
              </div>
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("UsersColumn4"); ?>:</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $lastname;?>"/>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group row col-md-10 justify-content-end">
                  <button type="submit" class="btn btn-primary" name="searchuserbttn"><i class="fa fa-search"></i> <?php echo _p("SearchButton"); ?></button>
              </div>
            </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
