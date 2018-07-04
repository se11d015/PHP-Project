
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
                <label class="col-md-5 col-form-label"><?php echo _p("GisSub4SearchText1"); ?>:</label>
                <div class="col-md-3">
                  <input type="text" class="form-control" name="sutilization_year" id="sutilization_year" value="<?php if($sutilization_year>0) echo $sutilization_year;?>"/>
                </div>
              </div>
              <div class="form-group row col-md-6">
                <label class="col-md-5 col-form-label"><?php echo _p("GisSub4SearchText2"); ?>:</label>
                <div class="col-md-5">
                  <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn ASC";
					
					if($checkaimag==1)
						$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va 
						WHERE EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = va.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id.")) ORDER BY va.aimag_name_mn";
						
					$rows = $db->query($selQuery);
					echo seldatadb("saimag_code", "form-control", $rows, "aimag_code", "aimag_name_$language_name", $saimag_code, "", _p("AllAimags"));
					?>
                </div>
              </div>
            </div>		
            <div class="form-row">
              <div class="form-group row col-md-6">
                <label class="col-md-5 col-form-label"><?php echo _p("GeometrySearchText"); ?>:</label>
                <div class="col-md-6">
					<?php
						echo seldata("sgeometry_status", "form-control", $GEOMETRY_STATUS, $sgeometry_status, "", _p("AllTypes"));
					?>
                </div>
              </div>
            </div>
            <?php
			if($sess_profile==1) 
			{
			?>
            <div class="form-row">
              <div class="form-group row col-md-6">
                <label class="col-md-5 col-form-label"><?php echo _p("DataEntryUserName"); ?>:</label>
                <div class="col-md-6">
                  <?php
					$selQuery = "SELECT tau.user_id, tau.organization||' - '||tau.lastname as user_name FROM ".$schemas.".tausers tau WHERE tau.profile!=3 ORDER BY tau.profile, tau.organization, tau.lastname";
					$row = $db->query($selQuery);
					echo seldatadb("user_id", "form-control", $row, "user_id", "user_name",  $user_id, "", _p("AllUsers"));
					?>
                </div>
              </div>
             <div class="form-group row col-md-6">
                <label class="col-md-5 col-form-label"><?php echo _p("DataEntryGroupName"); ?>:</label>
                <div class="col-md-5">
                  <?php
					$selQuery = "SELECT tag.group_id, tag.group_name_mn, tag.group_name_en FROM ".$schemas.".tagroups tag ORDER BY tag.group_name_mn";
					$row = $db->query($selQuery);
					echo seldatadb("group_id", "form-control", $row, "group_id", "group_name_$language_name", $group_id, "", _p("AllGroups"));
					?>
                </div>
              </div>
            </div>
            <?php
			}
			?>
            <div class="form-row">
              <div class="form-group row col-md-10 justify-content-end">
                <button type="submit" class="btn btn-primary" name="searchforestlogginggeombttn"><i class="fa fa-search"></i> <?php echo _p("SearchButton"); ?></button>
              </div>
            </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
