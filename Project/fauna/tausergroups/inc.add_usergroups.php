<div class="add-table">
  <form class="form-horizontal" action="<?php echo $my_url.$search_url; ?>" method="post" name="mainform" id="mainform">
    <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th colspan="3">Бүлгийн хэрэглэгч бүртгэх хэсэг</th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th>Бүлгийн нэр</th>
          <th>Хэрэглэгчийн нэр</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php
					$selQuery = "SELECT tag.group_id, tag.group_name FROM ".$schemas.".tagroups tag	ORDER BY tag.group_name";
					$row = $db->query($selQuery);
					echo seldatadb("group_id", "span3", $row, "group_id", "group_name", $row[0]["group_id"]);
				?>
          </td>
          <td><?php
					$selQuery = "SELECT tau.user_id, tau.organization||' - '||tau.lastname as user_name	FROM ".$schemas.".tausers tau	ORDER BY tau.organization, tau.lastname";
					$row = $db->query($selQuery);
					echo seldatadb("user_id", "span4", $row, "user_id", "user_name", $row[0]["user_id"]);
				?>
          </td>
          <td align="center"><button type="submit" class="btn btn-danger" name="insertuserbttn"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
            <a class="btn btn-danger" href="<?php echo $my_url.$search_url; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
