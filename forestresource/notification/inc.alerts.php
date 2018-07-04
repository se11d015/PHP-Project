<?php
function show_notification($notification_type, $title, $message)
{
	switch ($notification_type)
	{
		case "error" : 
		{
?>

<div class="alert alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?php echo $title; ?></strong> <?php echo $message; ?> </div>
<?php
			break;
		};
		case "info" : 
		{
?>
<div class="alert alert-info" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?php echo $title; ?></strong> <?php echo $message; ?> </div>
<?php
			break;
		};
		case "success" : 
		{
?>
<div class="alert alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?php echo $title; ?></strong> <?php echo $message; ?> </div>
<?php
			break;
		};
		case "warning" : 
		{
?>
<div class="alert alert-warning" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?php echo $title; ?></strong> <?php echo $message; ?> </div>
<?php
			break;
		}
	}
}
?>
