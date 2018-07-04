
<div class="table-responsive">
  <form class="form" role="form" action="<?php echo $my_url.$search_url.$sort_url; ?>" method="post" name="mainform" id="mainform">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th colspan="4"><?php echo _p("AddText5")." "._p("GroupRolesTitle")." "._p("AddText6"); ?></th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th><?php echo _p("GroupRolesColumn1");?></th>
          <th><?php echo _p("GroupRolesColumn3");?></th>
          <th><?php echo _p("GroupRolesColumn2");?></th>
          <th><?php echo _p("Operation");?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php
				$selQuery = "SELECT tag.group_id, tag.group_name_mn, tag.group_name_en FROM ".$schemas.".tagroups tag ORDER BY tag.group_name_mn";
				$row = $db->query($selQuery);
				if(!empty($row))
					echo seldatadb("group_id", "form-control", $row, "group_id", "group_name_$language_name", $row[0]["group_id"], "", _p("AllGroups"));
				else
					echo seldatadb("group_id", "form-control", $row, "group_id", "group_name_$language_name", NULL);
				?></td>
          <td><?php
				echo seldata("item_id", "form-control", $ITEM_TYPE, 1, "", _p("AllDatasets"));
				?></td>
          <td><?php
				echo seldata("role_id", "form-control", $ROLE_TYPE, 1);
				?></td>
          <td><button type="submit" class="btn btn-primary mb-2" name="insertgrouprolebttn"><i class="fa fa-check"></i> <?php echo _p("SaveButton");?></button>
            <a class="btn btn-primary mb-2" href="<?php echo $my_url.$search_url; ?>"><i class="fa fa-undo"></i> <?php echo _p("UndoButton");?></a></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
