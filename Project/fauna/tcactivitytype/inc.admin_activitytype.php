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
	if(isset($_POST["inserttypebttn"]))
	{
		if(isset($_POST["type_name"]))
		{
			$fields = array("type_name");
			$checkvalues = array($_POST["type_name"]);
	
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}			
							
			$result = $db->insert("".$schemas.".tcactivitytype", $fields, $values);
	
			if(! $result)
				show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
		}
	}
				
	if(isset($_POST["updatetypebttn"]))
	{
		if(isset($_POST["type_id"]) && isset($_POST["type_name"]))
		{	
			$wherevalues = "type_id=".(int) $_POST["type_id"];
			$fields = array("type_name");
			$checkvalues = array($_POST["type_name"]);
			
			$values = array();
			for ($i=0; $i<sizeof($checkvalues); $i++)
			{
				$values[$i] = (empty($checkvalues[$i]) ? "NULL": "'".$checkvalues[$i]."'");
			}			
			
			$result = $db->update("".$schemas.".tcactivitytype", $fields, $values, $wherevalues);
			if(! $result)
				show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
			else
				show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
		}
	}
				
	if(($action=="delete") && isset($_GET["typeid"]))
	{
		$wherevalues = "type_id=".(int) $_GET["typeid"];
	
		$result = $db->delete("".$schemas.".tcactivitytype", $wherevalues);
		if(! $result)
			show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
		else
			show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
	}
}
		
$selQuery = "SELECT tct.* FROM ".$schemas.".tcactivitytype tct";
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
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th colspan="3"><span class="title"><?php echo getdata($ITEM_TYPE, 44); ?></span></th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th class="span1">№</th>
          <th class="span4">Эрх авсан чиглэл</th>
          <th class="span6"></th>
        </tr>
      </thead>
      <tbody>
        <?php
			$limit = $count." OFFSET ".($page-1)*$count;
			$selQuery = "SELECT tct.* FROM ".$schemas.".tcactivitytype tct ORDER BY tct.type_name ASC LIMIT ".$limit;
			$rows = $db->query($selQuery);
			
			for ($i=0; $i < sizeof($rows); $i++) 
			{
				if($sess_profile==1 && ($action=="edit") && (isset($_GET["typeid"])) && ($rows[$i]["type_id"]==(int) $_GET["typeid"]))
				{
			?>
        <tr>
          <td><input name="type_id" id="type_id" type="hidden" value="<?php echo $rows[$i]["type_id"]; ?>" /></td>
          <td><div class="controls">
              <input type="text" class="span4" id="type_name" name="type_name" value="<?php echo $rows[$i]["type_name"]; ?>" >
            </div></td>  
          <td align="center"><button type="submit" class="btn btn-danger" name="updatetypebttn">Хадгалах</button>
            <a class="btn btn-danger" href="<?php echo $my_url.$my_page; ?>">Болих</a></td>
        </tr>
        <?php		
				}else
				{
				?>
        <tr>
          <td><?php echo (($page-1)*$count) + $i + 1; ?></td>
          <td><?php echo $rows[$i]["type_name"]; ?></td>   
          <?php
					if($sess_profile==1){ 
				?>
          <td align="center"><a href="<?php echo $my_url.$my_page."&action=edit&typeid=".$rows[$i]["type_id"]; ?>" title="Засварлах"><i class="icon-edit"></i></a> <a href="<?php echo $my_url."&action=delete&typeid=".$rows[$i]["type_id"]; ?>" title="Устгах" onClick="return confirm('Та устгахдаа итгэлтэй байна уу?');"><i class="icon-trash"></i></a> </td>
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
              <input type="text" class="span4" id="type_name" name="type_name" >
            </div></td>         
          <td align="center"><button type="submit" class="btn btn-danger" name="inserttypebttn">Хадгалах</button>
            <a class="btn btn-danger" href="<?php echo $my_url.$my_page; ?>">Болих</a></td>
        </tr>
        <?php
			}
		
			if($sess_profile==1)
			{ 
			?>
        <tr>
          <td colspan="6"><a class="btn btn-danger" href="<?php echo $my_url.$my_page."&action=add"; ?>"><i class="icon-plus icon-white"></i>&nbsp;Шинээр нэмэх</a> </td>
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
