<?php

$xhe_host = "127.0.0.1:7026";

require("../Templates/xweb_human_emulator.php");
function randSleep($limit = 3) {
	sleep(rand(0, $limit));
}

function randScroll($times = 3) {
	global $element;

	$els = $element->get_all();
	shuffle(($els->elements));
	$limit = rand(1, $times);
	for($i = 0; $i <= $limit; $i++) { 
		$el = array_pop($els->elements);
		if (is_null($el)) continue;
		else $el->send_mouse_move_to();
		if ($limit % 2 == 0) randSleep(1);
	}
}

function navigate($url) {
	global $browser;

	$browser->navigate($url);
	$browser->wait();
	$browser->wait_js();
}

function flatten(array $array) {
    $return = array();
    array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
    return $return;
}

$credentials = array(
	array('log' => 'smokutry@gmail.com', 'pass' => 'kanipyhe'),
	array('log' => 'vvyyhyij@gmail.com', 'pass' => 'nygobehi'),
	array('log' => 'postestament@gmail.com', 'pass' => 'xapunawi'),
	array('log' => 'alphagoblin4@gmail.com', 'pass' => 'VaNNaV1!'),

);
shuffle($credentials);

$authorize = (function($log, $pass) use($app, $webpage, $browser, $input, $btn) {
	$browser->clear_cookies("badoo.com");
	$app->clear();
	$startUrl = 'https://badoo.com/signin/?f=top';
	navigate($startUrl);
	$input->get_by_name("email")->set_value('');
	$input->get_by_name("email")->send_input($log);
	$input->get_by_name("password")->send_input($pass);

	$btn->get_by_name("post")->click();
	$browser->wait();
	$browser->wait_js();

	if ($webpage->get_url() != $startUrl)
		return true;
	return false;
});

$like = (function() use($div) {
	$rand = rand(0, 10);
	
	if ($div->get_by_attribute("class","js-profile-header-vote-yes", false)->is_exist())
		$div->get_by_attribute("class","js-profile-header-vote-yes", false)->click();
	
});

$checkWrite = (function() use($i) {
	if ($i->get_by_inner_html("icon-fast-message-start", false)->is_exist())
		return true;
	else return false;
});

$writeMessage = (function() use($browser, $input, $div) {
	$input->get_by_attribute("class","text-field__input js-message-i", false)->send_input("привет");
	$browser->wait();
	$browser->wait_js();
	$div->get_by_attribute("class","js-send-message", false)->click();
	$browser->wait();
	$browser->wait_js();
});


$filter = (function($girls = true, $bi = false) use($label, $span, $btn, $div, $listbox, $anchor, $browser, $button) {
	$div->get_by_attribute("class","js-search-settings-toggle", false)->click();
	$browser->wait();
	$browser->wait_js();
	
	$target = (rand(1, 4) % 2 == 0 ? 'Пойти на свидание' : 'Общаться');
	$label->click_by_inner_text($target, false);
	$browser->wait();
	$browser->wait_js();
	/*
	if ($bi) {
		$label->get_by_inner_text("Мужчин", false)->click();
		$label->get_by_inner_text("Девушек", false)->click();
	}elseif($girls)	{$label->click_by_inner_text("Девушек", false);}
	else {$label->click_by_inner_text("Мужчин", false);}
	*/
	$btn->get_by_inner_text("Показать результаты", false)->click();

});

$watch = (function($url, $msg = "привет") use($like, $browser, $checkWrite, $writeMessage) {
	$active = $browser->get_active_browser();
	$count = $browser->get_count();
	$browser->set_count($count + 1);
	$browser->set_active_browser($count + 1);	
	navigate($url);
	randScroll();
	$like();
	if ($checkWrite())
		$writeMessage($msg);
	$browser->close();
	$browser->set_active_browser($active);
});

$search = (function($girls = true) use($like, $filter, $keyboard, $watch, $image, $span, $btn, $div, $listbox, $anchor, $browser, $button) {
	$rand = rand(0, 10);
	if ($rand % 3 == 0) {
		$searchType = 'all';
	} elseif($rand % 2 == 0) {
		$searchType = 'online';
	}
	else {
		$searchType = 'new';
	}

	navigate('https://badoo.com/search?filter=' . $searchType);
	//$filter($girls);
	$links = array();
	$limit = rand(2,10);
	for ($i = 1; $i < $limit; $i++) {
		array_push($links, $anchor->get_all_by_href('section_id')->get_href());
		$anchor->click_by_inner_text("Следующие", false);
		//randScroll();

	}
	shuffle($links);
	$links = flatten($links);

	array_map($watch, $links);
	
	
});




$girls = true;

foreach($credentials as $data) {
	$browser->close_all_tabs();
	$browser->recreate();
	extract($data);

	if ($authorize($log, $pass))
		$search($girls);
}


$app->quit();
?>