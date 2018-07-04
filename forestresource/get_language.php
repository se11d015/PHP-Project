<?php
require("modules/session.class.php");

$session = new SecureSession();

$session->set('forestresource_lang', (int) $_GET['lang']);

$goback = $_SERVER['HTTP_REFERER'];

header("location: $goback");
?>