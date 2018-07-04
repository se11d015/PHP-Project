<div class="search-table">
  <div class="row">
    <form class="form-horizontal" action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
      <div class="span9">
        <div class="search-title">Хайлтын хэсэг </div>
      </div>
      <div class="span4 search-control">
        <div class="control-group info">
          <label class="control-label">Байгууллагын нэр:</label>
          <div class="controls">
            <input type="text" class="span2" name="org_name" id="org_name" value="<?php echo $org_name;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Эрхийн дугаар:</label>
          <div class="controls">
            <input type="text" class="span2" name="permission_number" id="permission_number" value="<?php echo $permission_number;?>"/>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Эрх олгосон он:</label>
          <div class="controls">
            <input type="text" class="span2" name="approved_date" id="approved_date" value="<?php if($approved_date>0) echo $approved_date;?>"/>
          </div>
        </div>
      </div>
      <div class="span5 search-control">
        <div class="control-group info">
          <label class="control-label">Эрх авсан чиглэл:</label>
          <div class="controls">
             <?php
					$selQuery = "SELECT tcp.permissiontype_id, tcp.permissiontype_name permissiontype_name_mn, tcp.permissiontype_name permissiontype_name_en FROM ".$schemas.".tcpermissiontype tcp 
					WHERE tcp.sectortype_id = 3 ORDER BY tcp.permissiontype_name";
					$row = $db1->query($selQuery);
					echo seldatadb("permission_type", "span3", $row, "permissiontype_id", "permissiontype_name_mn", $permission_type, "", "Бүх чиглэл");
					?>
          </div>
        </div>
        <div class="control-group info">
          <label class="control-label">Эрх хүчинтэй эсэх:</label>
          <div class="controls">
			<?php
				echo seldata("permission_valid", "span3", $ORG_PERMISSION_ACTIVE, $permission_valid);
			?>
          </div>
        </div>
        
        <div class="control-group info">
          <div class="controls">
            <button type="submit" class="btn btn-danger" name="searchorgbttn"><i class="icon-search icon-white"></i>&nbsp;Хайх</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
