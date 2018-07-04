<?php
function show_notification($notification_type, $title, $message)
{
	switch ($notification_type)
	{
		case "error": 
		{
?>

<div class="alert alert-error"> <a href="#" class="close" data-dismiss="alert">x</a> <strong><?php echo $title; ?></strong> <?php echo $message; ?> </div>
<?php
			break;
		};
		case "info": 
		{
?>
<div class="alert alert-info"> <a href="#" class="close" data-dismiss="alert">x</a> <strong><?php echo $title; ?></strong> <?php echo $message; ?> </div>
<?php
			break;
		};
		case "success": 
		{
?>
<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">x</a> <strong><?php echo $title; ?></strong> <?php echo $message; ?> </div>
<?php
			break;
		};
		case "warning": 
		{
?>
<div class="alert alert-warning"> <a href="#" class="close" data-dismiss="alert">x</a> <strong><?php echo $title; ?></strong> <?php echo $message; ?> </div>
<?php
			break;
		}
	}
}
?>
