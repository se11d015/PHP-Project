<?php
if($sess_profile==1) 
{ 
	$my_url_old = $my_url;
	$my_url .= "&action=".$action;
	
	if (isset($_GET["user_id"]))
	{
		$user_id = (int) $_GET["user_id"];
	}else
	{
		$user_id = 0;
	}
	
	$my_url .= "&user_id=".$user_id;
	
	if (isset($_GET["actiongroup"]))
	{
		$actiongroup = $_GET["actiongroup"];
	}else
	{
		$actiongroup = "";
	}
	
	if (isset($_POST["insertusergroupbttn"]))
	{
		if (isset($_POST["group_id"]))
		{
			$fields = array("group_id", "user_id");
			$checkvalues = array($_POST["group_id"], $user_id);
			
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}
			
			$result = $db->insert("".$schemas.".tausergroups", $fields, $values);
	
			if(! $result)
				show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
		}
	}
	
				
	if (($actiongroup=="groupdelete") && isset($_GET["group_id"]) && isset($_GET["user_id"]))
	{
		$group_id = (int) $_GET["group_id"];
		$user_id = (int) $_GET["user_id"];
		$wherevalues = "group_id = ".$group_id." AND user_id=".$user_id;
	
		$result = $db->delete("".$schemas.".tausergroups", $wherevalues);
		if(! $result)
			show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
		else
			show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
	}
	
	$valueQuery = "SELECT tau.lastname FROM ".$schemas.".tausers tau WHERE tau.user_id = ".$user_id;
	
	$selQuery = $valueQuery;
	
	$row = $db->query($selQuery);

?>

<div class="edit-table">
  <form action="<?php echo $my_url; ?>" method="post">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th colspan="2"><?php echo $row[0]["lastname"]; ?> хэрэглэгчийн бүлгийн мэдээлэл</th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th class="span4">Бүлгийн нэр</th>
          <th class="span4"></th>
        </tr>
      </thead>
      <tbody>
        <?php
				$sortQuery = "ORDER BY tag.group_name";	  
				$valueQuery = "SELECT taug.group_id, taug.user_id, tag.group_name	
					FROM ".$schemas.".tausergroups taug, ".$schemas.".tagroups tag, ".$schemas.".tausers tau 
					WHERE taug.group_id = tag.group_id AND taug.user_id = tau.user_id AND tau.user_id = ".$user_id;
			
				$selQuery = $valueQuery." ".$sortQuery;
			
				$rows = $db->query($selQuery);
				for ($i=0; $i < sizeof($rows); $i++) 
				{
				?>
        <tr>
          <td><?php echo $rows[$i]["group_name"]; ?></td>
          <td align="center"><a href="<?php echo $my_url."&actiongroup=groupdelete&group_id=".$rows[$i]["group_id"]."&user_id=".$rows[$i]["user_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a> </td>
        </tr>
        <?php
				}
			
				if ($actiongroup=="groupadd")
				{
				?>
        <tr>
          <td><?php
					$selQuery = "SELECT 
								  tag.group_id, tag.group_name
								FROM 
								  ".$schemas.".tagroups tag
								ORDER BY
								  tag.group_name";
					$row = $db->query($selQuery);
					echo seldatadb("group_id", "span3", $row, "group_id", "group_name", $row[0]["group_id"]);
					?>
          </td>
          <td align="center"><button type="submit" class="btn btn-danger" name="insertusergroupbttn"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
            <button class="btn btn-danger"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</button></td>
        </tr>
        <?php
				}
				?>
        <tr>
          <td colspan="2"><a class="btn btn-danger" href="<?php echo $my_url."&actiongroup=groupadd"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a> <a class="btn btn-danger" href="<?php echo $my_url_old.$my_page.$search_url.$sort_url; ?>"><i class="icon-refresh icon-white"></i>&nbsp;Хэрэглэгчийн мэдээлэлд буцах</a> </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<?php 
} else {
		$notify ="Таны хандалт буруу байна.";
		show_notification("error", "", $notify);
}
?>
