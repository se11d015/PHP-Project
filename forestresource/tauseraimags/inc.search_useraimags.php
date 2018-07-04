
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
                <label class="col-md-5 col-form-label"><?php echo _p("UsersColumn10"); ?>:</label>
                <div class="col-md-6">
                  <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn";
					$row = $db->query($selQuery);
					echo seldatadb("aimagcode", "form-control", $row, "aimag_code", "aimag_name_$language_name", $aimagcode, "", _p("AllAimags"));
					?>
                </div>
              </div>
              <div class="form-group row col-md-6">
                <label class="col-md-5 col-form-label"><?php echo _p("UsersColumn4"); ?>:</label>
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
