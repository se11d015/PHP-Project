<?php
require("modules/session.class.php");

$session = new SecureSession();

if (!$session->isRegistered('fauna_session_id'))
{
	$session->deleteset('fauna_session_id');
}

if (!$session->isRegistered('fauna_login_name'))
{
	$session->deleteset('fauna_login_name');
}

if (!$session->isRegistered('fauna_profile'))
{
	$session->deleteset('fauna_profile');
}

?>
