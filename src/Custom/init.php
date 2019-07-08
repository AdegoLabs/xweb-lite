<?php
var_dump($argv);


$xhe_host = $argv[1] . ":" . $argv[2];

require_once("C:/xampp/htdocs/skeleton/vendor/xweb/xweb-lite/Templates/xweb_human_emulator.php");

$browser->navigate('facebook.com');

$app->exitapp();

