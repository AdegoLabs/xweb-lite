<?php

$xhe_host = "127.0.0.1:7010";

require("../Templates/xweb_human_emulator.php");

function navigate($url) {
	global $browser;

	$browser->navigate($url);
	$browser->wait();
	$browser->wait_js();
}

$credentials = array(
	array('log' => 'postestament@gmail.com', 'pass' => 'mndYpHdc'),
	array('log' => 'vvyyhyij@gmail.com', 'pass' => 'rYFrtXPk'),
	array('log' => 'smokutry@gmail.com', 'pass' => 'L2LGMPLh'),
);

$authorize = (function($log, $pass) use($app, $webpage, $browser, $input, $button) {
	$browser->clear_cookies("wamba.com");
	$app->clear();
	$startUrl = 'https://wamba.com/login';
	navigate($startUrl);
	
	$input->get_by_name("login")->send_input($log);
	$input->get_by_name("password")->send_input($pass);
	$button->click_by_value("Войти", false);
	$browser->wait();
	$browser->wait_js();

	if ($webpage->get_url() != $startUrl)
		return true;
	return false;
});

$filterMeet = (function($girls = true) use($span, $btn, $div, $listbox, $anchor, $browser, $button) {
	$div->get_by_attribute("class","photo-vote-header-section-settings", false)->click();
	$span->click_by_inner_text("Ищу", false);
	$browser->wait();
	$browser->wait_js();
	sleep(1);

	if ($girls)
		$div->click_by_attribute("id", "F", false);

	else $div->click_by_attribute("id", "M", false);
	
	$browser->wait();
	$browser->wait_js();
	$anchor->get_by_attribute("data-name","close-action", false)->click();
	$browser->wait();
	$browser->wait_js();
	
	if ($button->get_by_value("Готово")->is_disabled())
		$anchor->get_by_attribute("data-name","close-action", false)->click();
	else
		$button->click_by_value("Готово", false);
	
	$browser->wait();
	$browser->wait_js();
});

$clickMeet = (function($girls) use($div, $span, $btn, $filterMeet, $browser) {
	$startUrl = 'https://wamba.com/rating#/app';
	navigate($startUrl);
	$filterMeet($girls);
	while(!$div->get_by_inner_text("Сегодня у вас закончились 400 ", false)->is_view_now()) {
		if (!$btn->click_by_inner_text("Мне нравится", false))
			$span->click_by_inner_text("Дальше", false);
		if ($btn->get_by_inner_text("Написать сообщение", false)->is_view_now());
			$btn->get_by_inner_text("Написать сообщение", false)->send_click();
			
			$browser->wait();
			$browser->wait_js();
			$browser->set_active_browser(1);
			$browser->close();
			$browser->set_active_browser(0);
	}
	
});

foreach($credentials as $data) {
	extract($data);

	if ($authorize($log, $pass))
		$clickMeet(true);
}

$app->quit();
?>