<h4 class="sub-header "><?php echo _p("ResourceSubTitle2"); ?></h4>
<div class="table-responsive-md">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th colspan="2"><?php echo _p("SearchTitle"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="row"><div class="col-md-6"><form class="form" role="form" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
            <div class="form-group row">
              <div class="col-md-5">
                <label class="col-form-label"><?php echo _p("ResourceSub2SearchText1"); ?>:</label>
                <input type="text" class="form-control" name="svolume_year" id="svolume_year" value="<?php if($svolume_year>0) echo $svolume_year;?>"/>
              </div>
              <div class="col-md-7">
                <label class="col-form-label"><?php echo _p("ResourceSub2SearchText2"); ?>:</label>
                  <?php
					$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn";
					$row = $db->query($selQuery);
					echo seldatadb("saimag_code", "form-control", $row, "aimag_code", "aimag_name_$language_name", $saimag_code, "", _p("AllAimags"));
					?>
              </div>
            </div>
            <div class="form-group row col-md-12 justify-content-end">
              <button type="submit" class="btn btn-success" name="searchforestvolumebttn"><i class="fa fa-search"></i> <?php echo _p("SearchButton"); ?></button>
            </div>
		  </form></div><div class="col-md-6"><img src="images/om2.jpg" class="img-fluid" alt="om2"/></div></div></td>
      </tr>
    </tbody>
  </table>
</div>
