<?php
require_once "config.php";
require_once "classes/SenderManager.php";
define("KEY", "5F5760E10614AAEAFD66992AD0A97CE67AE677D6EDA6B97F48823715278873EB");

$senderManager = new SenderManager();


if(isset ($_GET['key']) === true && $_GET['key']===KEY) {
    $senderManager->inviaDati();
}