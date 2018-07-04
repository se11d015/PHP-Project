
<div class="table-responsive">
  <form class="form" role="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" method="post" name="mainform" id="mainform">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th colspan="3"><?php echo _p("AddText5")." "._p("UserAimagsTitle")." "._p("AddText6"); ?></th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th><?php echo _p("UsersColumn10"); ?></th>
          <th><?php echo _p("UsersColumn4"); ?></th>
          <th><?php echo _p("Operation");?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php
				$selQuery = "SELECT va.aimag_code, va.aimag_name_mn, va.aimag_name_en FROM scadministrative.vaaimagname va ORDER BY va.aimag_name_mn";
				$row = $db->query($selQuery);
				if(!empty($row))
					echo seldatadb("aimag_code", "form-control", $row, "aimag_code", "aimag_name_$language_name", $row[0]["aimag_code"]);
				else
					echo seldatadb("aimag_code", "form-control", $row, "aimag_code", "aimag_name_$language_name", NULL);
				?></td>
          <td><?php
				$selQuery = "SELECT tau.user_id, tau.organization||' - '||tau.lastname as user_name FROM ".$schemas.".tausers tau WHERE tau.profile = 2 ORDER BY tau.organization, tau.lastname";
				$row = $db->query($selQuery);
				if(!empty($row))
					echo seldatadb("user_id", "form-control", $row, "user_id", "user_name", $row[0]["user_id"]);
				else
					echo seldatadb("user_id", "form-control", $row, "user_id", "user_name", NULL);	
				?></td>
          <td><button type="submit" class="btn btn-primary mb-2" name="insertuserbttn"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
            <a class="btn btn-primary mb-2" href="<?php echo $my_url.$my_page.$search_url.$sort_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></a></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
