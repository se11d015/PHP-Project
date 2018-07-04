<div class="add-table">
  <form class="form-horizontal" action="<?php echo $my_url.$search_url; ?>" method="post" name="mainform" id="mainform">
    <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th colspan="4">Хэрэглэгчийн бүлэгт эрх тавих</th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th>Бүлгийн нэр</th>
          <th>Мэдээний нэр</th>
          <th>Эрхийн нэр</th
         ><th></th>
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
				echo seldata("item_id", "span4", $GROUP_ITEM_TYPE, 1, "", "Бүх мэдээ");
				?>
          </td>
          <td><?php
				echo seldata("role_id", "span2", $ROLE_TYPE, 1);
				?>
          </td>          
          <td align="center"><button type="submit" class="btn btn-danger" name="insertgrouprolebttn"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
            <a class="btn btn-danger" href="<?php echo $my_url.$my_page.$search_url; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
