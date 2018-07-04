<?php

require("modules/pgsql.class.php");

$db = new pgsql($_MY_CONF["DATABASE_NAME"], $_MY_CONF["DATABASE_SERVER"], $_MY_CONF["DATABASE_USER"], $_MY_CONF["DATABASE_PASS"], $_MY_CONF["DATABASE_PORT"]);
?>
