<?php
if($sess_profile==1) 
{ 
	$my_url .= "?menuitem=".$menuitem;
	
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}else
	{
		$action = "";
	}
	
	if (isset($_POST["insertgroupbttn"]))
	{
		if (isset($_POST["group_name"]) && !empty($_POST["group_name"]))
		{
			$fields = array("group_name", "description");
			$checkvalues = array($_POST["group_name"], $_POST["description"]);
			
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}
			
			$result = $db->insert("".$schemas.".tagroups", $fields, $values);
	
			if(! $result)
				show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
		}
	}
					
	if (isset($_POST["updategroupbttn"]))
	{
		if (isset($_POST["group_name"]) && !empty($_POST["group_name"]))
		{	
			$wherevalues = "group_id=".(int) $_POST["group_id"];
			$fields = array("group_name", "description");
			$checkvalues = array($_POST["group_name"], $_POST["description"]);
			
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}
			
			$result = $db->update("".$schemas.".tagroups", $fields, $values, $wherevalues);
			if(! $result)
				show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
		}
	}
					
	if (($action=="delete") && isset($_GET["group_id"]))
	{
		$wherevalues = "group_id=".(int) $_GET["group_id"];
	
		$db->delete("".$schemas.".tausergroups",$wherevalues);
		
		$result = $db->delete("".$schemas.".tagroups", $wherevalues);
		if(! $result)
			show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
		else
			show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
	}
					
	$selQuery = "SELECT tg.* FROM ".$schemas.".tagroups tg";  
	$rows = $db->query($selQuery);
	
	$sum = sizeof($rows);
	$count = 10;
	$maxpage = ceil( $sum / $count);
	
	$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"]: 1;
	$my_page = "&page=".$page;

	$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
	show_notification("info", "", $notify);
	?>

<form action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
  <div class="list-table">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th colspan="4"><span class="title">Бүлгийн мэдээлэл</span></th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th class="span1">№</th>
          <th class="span4">Бүлгийн нэр</th>
          <th class="span4">Тайлбар</th>
          <th class="span4"></th>
        </tr>
      </thead>
      <tbody>
        <?php
				$limit = $count." OFFSET ".($page-1)*$count;
				$selQuery = "SELECT tg.* FROM ".$schemas.".tagroups tg ORDER BY	tg.group_name ASC	LIMIT ".$limit;
				$rows = $db->query($selQuery);
				
				for ($i=0; $i < sizeof($rows); $i++) 
				{
					if (($action=="edit") && (isset($_GET["group_id"])) && ($rows[$i]["group_id"]==(int)$_GET["group_id"]))
					{
					?>
        <tr>
          <td></td>
          <td><div class="controls">
              <input name="group_id" id="group_id" type="hidden" value="<?php echo $rows[$i]["group_id"]; ?>" />
              <input type="text" class="input-large" id="group_name" name="group_name" value="<?php echo $rows[$i]["group_name"]; ?>" >
            </div></td>
          <td><div class="controls">
              <input type="text" class="input-xlarge" id="description" name="description" value="<?php echo $rows[$i]["description"]; ?>" >
            </div></td>
          <td align="center"><button type="submit" class="btn btn-danger" name="updategroupbttn"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
            <a class="btn btn-danger" href="<?php echo $my_url.$my_page; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a></td>
        </tr>
        <?php		
					}else
					{
				?>
        <tr>
          <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
          <td><?php echo $rows[$i]["group_name"]; ?></td>
          <td><?php echo $rows[$i]["description"]; ?></td>
          <td align="center"><a href="<?php echo $my_url.$my_page."&action=edit&group_id=".$rows[$i]["group_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url."&action=delete&group_id=".$rows[$i]["group_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a> </td>
        </tr>
        <?php
					}
				}
			
				if (($action=="add"))
				{
				?>
        <tr>
          <td></td>
          <td><div class="controls">
              <input type="text" class="input-large" id="group_name" name="group_name" >
            </div></td>
          <td><div class="controls">
              <input type="text" class="input-xlarge" id="description" name="description" >
            </div></td>
          <td align="center"><button type="submit" class="btn btn-danger" name="insertgroupbttn"><i class="icon-ok-sign icon-white"></i>&nbsp;Хадгалах</button>
            <a class="btn btn-danger" href="<?php echo $my_url.$my_page; ?>"><i class="icon-share-alt icon-white"></i>&nbsp;Болих</a></td>
        </tr>
        <?php
				}
				?>
        <tr>
          <td colspan="4"><a class="btn btn-danger" href="<?php echo $my_url.$my_page."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a> </td>
        </tr>
      </tbody>
    </table>
    <?php
		require("pagination/inc.pagination.php");
		pagelink($count, $maxpage, $my_url, $page);
		?>
  </div>
</form>
<?php 
} else {
		$notify ="Таны хандалт буруу байна.";
		show_notification("error", "", $notify);
}
?>
