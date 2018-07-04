
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
                <label class="col-md-4 col-form-label"><?php echo _p("UsersSearchText1"); ?>:</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="login_name" id="login_name" value="<?php echo $login_name;?>"/>
                </div>
              </div>
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("UsersSearchText2"); ?>:</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $lastname;?>"/>
                </div>
              </div>           
            </div>
            <div class="form-row">
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("UsersSearchText3"); ?>:</label>
                <div class="col-md-6">
                  <?php
					echo seldata("profile", "form-control", $USER_PROFILE, $profile, "", _p("AllTypes"));
					?>
                </div>
              </div>
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("UsersSearchText4"); ?>:</label>
                <div class="col-md-6">
                  <?php
					$selQuery = "SELECT tg.group_id, tg.group_name_mn, tg.group_name_en FROM ".$schemas.".tagroups tg ORDER BY tg.group_name_mn ASC";
					$rows = $db->query($selQuery);
					echo seldatadb("group_id", "form-control", $rows, "group_id", "group_name_$language_name", $group_id, "", _p("AllGroups"));
					?>
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
