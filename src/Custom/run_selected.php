<?php

$xhe_host = "127.0.0.1:7783";

// The following code is required to properly run XWeb Human Emulator
require("C:/XWeb/Templates/xweb_human_emulator.php");
$file = "XWeb.exe";
$port = rand(7010, 7999);
$script = "/init.php";
$script_args = $port;
$in_tray = false;
echo realpath('./') . $script;

$app->quit();
?>