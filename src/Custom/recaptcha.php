<?php

$xhe_host = "127.0.0.1:7016";

// The following code is required to properly run XWeb Human Emulator
require("../Templates/xweb_human_emulator.php");

// navigate to google
//$browser->navigate("https://wamba.com/tips?turl=https%3A%2F%2Fwamba.com%2Firina_syzova%3Fhit%3D4&tip=antispamCaptcha#/app");
$browser->wait();
$browser->wait_js();

/*
		$anchor->get_by_href("google.com/intl/", false)->is_exist(),
		$anchor->get_by_href("google.com/intl/", false, "0")->is_exist(),
		$anchor->get_by_href("google.com/intl/", false, "1")->is_exist(),
		$anchor->get_by_href("google.com/intl/", false)->is_exist(),
		$anchor->is_exist_by_href("google.com/intl/", false, "1"),
		$element->get_by_inner_html("class=\"recaptcha-checkbox", false, "0")->is_exist(),
		$element->get_by_inner_html("class=\"recaptcha-checkbox", false)->is_exist(),
*/

$findRecaptcha = (function() use($anchor, $element, $hiddeninput) {
	$isExist = array(
		 $hiddeninput->get_by_id("recaptcha-token", false, "0")->get_value(),
		 $hiddeninput->get_by_id("recaptcha-token", false)->get_value()

	);

	
	$isExist = array_values(array_filter($isExist));
	
	if (count($isExist) > 0) return array_pop($isExist);
	return false;

});

$sentCaptcha = (function($type, $websiteURL, $websiteKey, $websiteSToken, $isInvisible) use() {
	

});

$solveCaptcha = (function($token, $key) use($webpage, $findRecaptcha, $sentCaptcha) {
	$token = $findRecaptcha($key, $webpage->get_url());
	
	if ($token) {
		$captchaId = $sentCaptcha($type, $websiteURL, $websiteKey, $websiteSToken, $isInvisible);
	}

});

solveCaptcha($secretKey, $url, $dataToken);

var_dump($findRecaptcha());
// Quit
$app->quit();
?>