<?php
$my_url .= "?menuitem=".$menuitem;

if(isset($_GET["action"]))
{
	$action = $_GET["action"];
}else
{
	$action = "";
}

if($sess_profile==1)
{
	if(isset($_POST["insertreferencestatusbttn"]))
	{
		if(isset($_POST["reference_code"]) && !empty($_POST["reference_name"]))
		{
			$fields = array("reference_code", "reference_name", "reference_name_en");
			$checkvalues = array($_POST["reference_code"], $_POST["reference_name"], $_POST["reference_name_en"]);
	
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}			
							
			$result = $db->insert("".$schemas.".tcreferencestatus", $fields, $values);
	
			if(! $result)
				show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
		}
	}
				
	if(isset($_POST["updatereferencestatusbttn"]))
	{
		if(isset($_POST["reference_id"]) && isset($_POST["reference_code"]) && !empty($_POST["reference_name"]))
		{	
			$wherevalues = "reference_id=".(int) $_POST["reference_id"];
			$fields = array("reference_code", "reference_name", "reference_name_en");
			$checkvalues = array($_POST["reference_code"], $_POST["reference_name"], $_POST["reference_name_en"]);
			
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}			
			
			$result = $db->update("".$schemas.".tcreferencestatus", $fields, $values, $wherevalues);
			if(! $result)
				show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
		}
	}
				
	if(($action=="delete") && isset($_GET["reference_id"]))
	{
		$wherevalues = "reference_id=".(int) $_GET["reference_id"];
	
		$result = $db->delete("".$schemas.".tcreferencestatus", $wherevalues);
		if(! $result)
			show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
		else
			show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
	}
}
		
$selQuery = "SELECT tcrs.* FROM ".$schemas.".tcreferencestatus tcrs";
$rows = $db->query($selQuery);

$sum = sizeof($rows);
$count = 20;
$maxpage = ceil( $sum / $count);

$page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"]: 1;
$my_page = "&page=".$page;

$notify ="<strong>Нийт $sum бичлэг байна.</strong>";
show_notification("info", "", $notify);
?>

<form action="<?php echo $my_url; ?>" method="post" name="mainform" id="mainform">
  <div class="list-table">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th colspan="7"><span class="title">Амьтны төлөв байдал</span></th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th class="span1">№</th>
          <th class="span2">Төлөв байдлын код</th>
          <th class="span2">Төлөв байдлын монгол нэр</th>
          <th class="span2">Төлөв байдлын англи нэр</th>
          <th class="span2"></th>
        </tr>
      </thead>
      <tbody>
        <?php
			$limit = $count." OFFSET ".($page-1)*$count;
			$selQuery = "SELECT tcrs.* FROM ".$schemas.".tcreferencestatus tcrs ORDER BY tcrs.reference_id ASC LIMIT ".$limit;
			$rows = $db->query($selQuery);
			
			for ($i=0; $i < sizeof($rows); $i++) 
			{
				if($sess_profile==1 && ($action=="edit") && (isset($_GET["reference_id"])) && ($rows[$i]["reference_id"]==(int) $_GET["reference_id"]))
				{
				?>
        <tr>
          <td><input name="reference_id" id="reference_id" type="hidden" value="<?php echo $rows[$i]["reference_id"]; ?>" /></td>
          <td><div class="controls">
              <input type="text" id="reference_code" name="reference_code" value="<?php echo $rows[$i]["reference_code"]; ?>" class="span1"/>
            </div></td>
          <td><div class="controls">
              <input type="text" id="reference_name" name="reference_name" value="<?php echo $rows[$i]["reference_name"]; ?>" class="span3"/>
            </div></td>
          <td><div class="controls">
              <input type="text" id="reference_name_en" name="reference_name_en" value="<?php echo $rows[$i]["reference_name_en"]; ?>" class="span3"/>
            </div></td>
          <td align="center"><button type="submit" class="btn btn-danger" name="updatereferencestatusbttn">Хадгалах</button>
            <a class="btn btn-danger" href="<?php echo $my_url.$my_page; ?>">Болих</a></td>
        </tr>
        <?php		
				}else
				{
			?>
        <tr>
          <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
          <td><?php echo $rows[$i]["reference_code"]; ?></td>
          <td><?php echo $rows[$i]["reference_name"]; ?></td>
          <td><?php echo $rows[$i]["reference_name_en"]; ?></td>
          <?php
					if($sess_profile==1){ 
					?>
          <td align="center"><a href="<?php echo $my_url.$my_page."&action=edit&reference_id=".$rows[$i]["reference_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url."&action=delete&reference_id=".$rows[$i]["reference_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a></td>
          <?php
					}else
					{
					?>
          <td></td>
          <?php
					}
			?>
        </tr>
        <?php
				}
			}
		
			if($sess_profile==1 && ($action=="add"))
			{
			?>
        <tr>
          <td></td>
          <td><div class="controls">
              <input type="text"  id="reference_code" name="reference_code" class="span1"/>
            </div></td>
          <td><div class="controls">
              <input type="text" id="reference_name" name="reference_name" class="span3"/>
            </div></td>
          <td><div class="controls">
              <input type="text"  id="reference_name_en" name="reference_name_en" class="span3"/>
            </div></td>
          <td align="center"><button type="submit" class="btn btn-danger" name="insertreferencestatusbttn">Хадгалах</button>
            <a class="btn btn-danger" href="<?php echo $my_url.$my_page; ?>">Болих</a></td>
        </tr>
        <?php
			}
		
			if($sess_profile==1)
			{ 
			?>
        <tr>
          <td colspan="7"><a class="btn btn-danger" href="<?php echo $my_url.$my_page."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a></td>
        </tr>
        <?php
			}
			?>
      </tbody>
    </table>
    <?php
		require("pagination/inc.pagination.php");
		pagelink($count, $maxpage, $my_url, $page);
		?>
  </div>
</form>
