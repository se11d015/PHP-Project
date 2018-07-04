<h4 class="sub-header "><?php echo _p("ResourceSubTitle1"); ?></h4>
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <td><?php echo _p("SearchTitle"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><form class="form" role="form" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
		  <div class="form-group row col-md-12">
			<label class="col-md-4 col-form-label"><?php echo _p("StatisticsSearchText1"); ?>:</label>
			<div class="col-md-7">
			  <?php
				echo seldata("statistic_horizontal_id", "form-control", $HORIZONTAL_ELEMENT_ID, $statistic_horizontal_id);
				?>
			</div>
		  </div>		
		  <div class="form-group row col-md-12">
			<label class="col-md-4 col-form-label"><?php echo _p("StatisticsSearchText2"); ?>:</label>
			<div class="col-md-5">
			  <?php
				$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn ASC";					
				$rows = $db->query($selQuery);
				echo seldatadb("statistic_aimag_code", "form-control", $rows, "aimag_code", "aimag_name_$language_name", $statistic_aimag_code, "", _p("StatisticsAllAimags"));
				?>
			</div>
		  </div>		
		  <div class="form-group row col-md-12">
			<label class="col-md-4 col-form-label"><?php echo _p("StatisticsSearchText3");?>: </label>
			<div class="col-md-3">
			  <input type="text" class="form-control" name="statistic_year" id="statistic_year" value="<?php if($statistic_year>0) echo $statistic_year;?>"/>
			</div>
		  </div>
		  <div class="form-group row col-md-12">
			<label class="col-md-4 col-form-label"><?php echo _p("StatisticsSearchText4"); ?>:</label>
			<div class="col-md-7">
			  <?php
				echo seldata("statistic_vertical_id", "form-control", $VERTICAL_ELEMENT_ID, $statistic_vertical_id);
				?>
			</div>
		  </div>		  
            <div class="form-group row col-md-12 justify-content-end">
              <button type="submit" class="btn btn-success" name="searchforestareabttn"><i class="fa fa-search"></i> <?php echo _p("SearchButton"); ?></button>
            </div>
          </form></td>
      </tr>
    </tbody>
  </table>
</div>
