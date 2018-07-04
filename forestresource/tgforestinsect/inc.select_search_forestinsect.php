
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo _p("SelectText1")." "._p("ResourceSubTitle4")." "._p("SelectText2"); ?></th>
      </tr>	
      <tr>
        <th><?php echo _p("SearchTitle"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form" role="form" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
            <div class="form-row">
              <div class="form-group row col-md-6">
                <label class="col-md-5 col-form-label"><?php echo _p("ResourceSub4SearchText1"); ?>:</label>
                <div class="col-md-3">
                  <input type="text" class="form-control" name="slinsect_year" id="slinsect_year" value="<?php if($slinsect_year>0) echo $slinsect_year;?>"/>
                </div>
              </div>
              <div class="form-group row col-md-6">
                <label class="col-md-5 col-form-label"><?php echo _p("ResourceSub4SearchText2"); ?>:</label>
                <div class="col-md-5">
                  <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn ASC";
					
					if($checkaimag==1)
						$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va 
						WHERE EXISTS(SELECT * FROM ".$schemas.".taaimagusers taua WHERE taua.aimag_code = va.aimag_code AND taua.user_id in (SELECT user_id FROM ".$schemas.".tausergroups WHERE user_id = ".$sess_user_id.")) ORDER BY va.aimag_name_mn";
						
					$rows = $db->query($selQuery);
					echo seldatadb("slaimag_code", "form-control", $rows, "aimag_code", "aimag_name_$language_name", $slaimag_code, "", _p("AllAimags"));
					?>
                </div>
              </div>
            </div>			
            <div class="form-row">
              <div class="form-group row col-md-10 justify-content-end">
                <button type="submit" class="btn btn-primary" name="searchforestinsectbttn"><i class="fa fa-search"></i> <?php echo _p("SearchButton"); ?></button>
              </div>
            </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
