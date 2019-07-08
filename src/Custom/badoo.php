<?php

$xhe_host = "127.0.0.1:7011";

require("../Templates/xweb_human_emulator.php");

function navigate($url) {
	global $browser;

	$browser->navigate($url);
	$browser->wait();
	$browser->wait_js();
}

$credentials = array(
	array('log' => 'alphagoblin4@gmail.com', 'pass' => 'VaNNaV1!'),
	array('log' => 'smokutry@gmail.com', 'pass' => 'kanipyhe'),
	array('log' => 'postestament@gmail.com', 'pass' => 'xapunawi'),
	array('log' => 'vvyyhyij@gmail.com', 'pass' => 'nygobehi'),
);

$authorize = (function($log, $pass) use($app, $webpage, $browser, $input, $btn) {
	$browser->clear_cookies("badoo.com");
	$app->clear();
	$startUrl = 'https://badoo.com/signin/?f=top';
	navigate($startUrl);
	$input->get_by_name("email")->send_input($log);
	$input->get_by_name("password")->send_input($pass);

	$btn->get_by_name("post")->meta_click();
	$browser->wait();
	$browser->wait_js();

	if ($webpage->get_url() != $startUrl)
		return true;
	return false;
});

$filterMeet = (function($girls, $bi) use($label, $span, $btn, $div, $listbox, $anchor, $browser, $button) {
	$div->get_by_attribute("class","sidebar-menu__filter-icon", false)->click();
	if ($bi) $label->click_by_inner_text("Всех", false);
	elseif($girls)	$label->click_by_inner_text("Девушек", false);
	else $label->click_by_inner_text("Мужчин", false);

	$span->get_by_inner_text("Готово", false)->event("onclick");
	$browser->wait();
	$browser->wait_js();

return;	
});

$clickMeet = (function($girls = true, $bi = false) use($div, $span, $btn, $filterMeet, $browser) {
	$startUrl = 'https://badoo.com/encounters';
	navigate($startUrl);
	$filterMeet($girls, $bi);

	while(!$div->get_by_inner_text("Получить больше голосов", false)->is_view_now()) {
		$div->get_by_attribute("class","profile-action--yes", false)->click();	}

	return;	
});

foreach($credentials as $data) {
	extract($data);

	if ($authorize($log, $pass))
		$clickMeet(true);
}

$app->quit();
?>