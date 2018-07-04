
<div class="table-responsive-md">
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
                <label class="col-md-4 col-form-label"><?php echo _p("OrgNameSearchText2"); ?>:</label>
                <div class="col-md-6">
                  <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn";
					$row = $db->query($selQuery);
					echo seldatadb("aimag_name", "form-control", $row, "aimag_code", "aimag_name_$language_name", $aimag_name, "", _p("AllAimags"));					
					?>
                </div>
              </div>			
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("OrgNameSearchText1"); ?>:</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="org_name" id="org_name" value="<?php echo $org_name;?>"/>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("OrgNameSearchText3"); ?>:</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="permission_number" id="permission_number" value="<?php echo $permission_number;?>"/>
                </div>
              </div>
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("OrgNameSearchText4"); ?>:</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="approved_date" id="approved_date" value="<?php if($approved_date>0) echo $approved_date;?>"/>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("OrgNameSearchText5"); ?>:</label>
                <div class="col-md-8">
                  <?php
					$selQuery = "SELECT tcp.permissiontype_id, tcp.permissiontype_name permissiontype_name_mn, tcp.permissiontype_name permissiontype_name_en FROM ".$schemas.".tcpermissiontype tcp WHERE tcp.sectortype_id = 2 ORDER BY tcp.permissiontype_name";
					$row = $db1->query($selQuery);
					echo seldatadb("permission_type", "form-control", $row, "permissiontype_id", "permissiontype_name_$language_name", $permission_type, "", _p("AllActivities"));
					?>
                </div>
              </div>
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("OrgNameSearchText6"); ?>:</label>
                <div class="col-md-8">
                  <?php
					echo seldata("permission_valid", "form-control", $ORG_PERMISSION_ACTIVE, $permission_valid);
					?>
                </div>
              </div>
            </div>
            <div class="form-row">			  
              <div class="form-group row col-md-12 justify-content-end">
                <button type="submit" class="btn btn-success" name="searchorgbttn"><i class="fa fa-search"></i> <?php echo _p("SearchButton"); ?></button>
              </div>
            </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
