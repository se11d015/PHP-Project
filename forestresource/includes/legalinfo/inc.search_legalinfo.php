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
                <label class="col-md-4 col-form-label"><?php echo _p("LegalSearchText1"); ?>:</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="slegal_name" id="slegal_name" value="<?php echo $legal_name;?>"/>
                </div>
              </div>
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("LegalSearchText2"); ?>:</label>
                <div class="col-md-8">
                  <?php
					$selQuery = "SELECT tclt.type_id, tclt.type_name_mn, tclt.type_name_en FROM sclegal.tclegaltype tclt WHERE tclt.type_id IN (1, 2, 4, 7, 8, 12)";
					$rows = $db1->query($selQuery);
					echo seldatadb("slegal_type", "form-control", $rows, "type_id", "type_name_$language_name", $legal_type, "", _p("AllTypes"));
					?>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("LegalSearchText3"); ?>:</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="sissued_date" id="sissued_date" value="<?php if($issued_date>0) echo $issued_date;?>"/>
                </div>
              </div>			
              <div class="form-group row col-md-6">
                <label class="col-md-4 col-form-label"><?php echo _p("LegalSearchText4"); ?>:</label>
                <div class="col-md-6">
                  <?php
					echo seldata("slegal_status", "form-control", $LEGAL_ACTIVE, $legal_status);
					?>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group row col-md-12 justify-content-end">
                <button type="submit" class="btn btn-success" name="searchlegalbttn"><i class="fa fa-search"></i> <?php echo _p("SearchButton"); ?></button>
              </div>
            </div>			
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
