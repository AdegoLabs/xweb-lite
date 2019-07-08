<?php

$xhe_host = "127.0.0.1:7028";

// The following code is required to properly run XWeb Human Emulator
require("C:/XWeb/Templates/xweb_human_emulator.php");

$url = 'http://web.archive.org/';
$target = 'http://game-girl.ru';

$btn->get_by_inner_text("Clear", false)->click();
$input->get_by_attribute("class","rbt-input-main", false)->send_input($target);
$input->get_by_attribute("class","rbt-input-main", false)->send_key(VK_ENTER);


$browser->navigate('http://web.archive.org/web/sitemap/http://game-girl.ru');
$browser->wait();
$browser->wait_js();
sleep(5);

//$child = $div->get_by_id("chart", false)->get_child_by_number(0)->get_child_by_number(0)->get_child_count();

$changeYear = function() use ($btn) {
	return $btn->get_number_by_attribute("class", "year-btn", false);
};

$explodeTime = function($url)  {
	preg_match("#.*(20[0-9]{2}+)([0-9]{2}+)([0-9]{2}+).*#", $url, $match);
	var_dump($match );
	if ($match && count($match) > 1) {
		$result['year'] = $match[1];
		$result['month ']= $match[2];
		$result['day'] = $match[3];

		return ($result);
	}
};

$get_hrefs = function() use ($element) {
	$count = $element->get_by_id('d3_container')->get_child_count();
	$result = array();

	for($i = 0; $i < $count; $i++) {
		$result[] = $element->get_by_id('d3_container')->get_child_by_number($i)->get_attribute('href');
	}

	return ($result);
};


$getParam = function($item, $param = 'get_href') use ($btn) {
	return (method_exists($item, $param) ? ($item)->$param() : false);
};

$rotate = function() use ($getParam, $changeYear, $btn, $get_hrefs) {
	$nums = (array) $changeYear();
	$result = array();
	foreach($nums as $num) {
		$result = (array_merge($result, $get_hrefs()));
		$btn->get_by_number($num)->click();
	}

	return ($result);
};

$allUrls = array_unique($rotate());
$explodeTime = function($url) {
	preg_match("#.*(20[0-9]{2})([0-9]{2})([0-9]{2}).*#", $url, $match);
	if (count($match) > 1) {
	
		$year = $match[1];
		$month = $match[2];
		$day = $match[3];

		return compact($year, $month, $day);
	}
};
$timeUrls = array_map($explodeTime, $allUrls);




$app->quit();
?>