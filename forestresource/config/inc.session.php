<?php
require("modules/session.class.php");

$session = new SecureSession();

if (!$session->isregistered('forestresource_session_id'))
{
	$session->deleteset('forestresource_session_id');
}

if (!$session->isregistered('forestresource_login_name'))
{
	$session->deleteset('forestresource_login_name');
}

if (!$session->isregistered('forestresource_profile'))
{
	$session->deleteset('forestresource_profile');
}
?>
