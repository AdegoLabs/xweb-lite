<?php

$xhe_host = "127.0.0.1:7016";

require("../Templates/xweb_human_emulator.php");

function navigate($url) {
	global $browser;

	$browser->navigate($url);
	$browser->wait();
	$browser->wait_js();
}

$credentials = array(
	array('log' => 'smokutry@gmail.com', 'pass' => 'L2LGMPLh'),
	array('log' => 'vvyyhyij@gmail.com', 'pass' => 'rYFrtXPk'),
	array('log' => 'postestament@gmail.com', 'pass' => 'mndYpHdc'),

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

$filter = (function($girls = true) use($i, $span, $btn, $div, $listbox, $anchor, $browser, $button) {
	($div->get_by_attribute("class","photo-vote-header-section-settings", false)->click() || 
$i->get_by_attribute("class","icn icn-settings-small action ", false)->click());
		$browser->wait();
	$browser->wait_js();
sleep(1);

	$span->get_by_outer_html("<span>Ищу</span>", false)->click();

	$browser->wait();
	$browser->wait_js();
	
	if ($girls)
		$div->click_by_attribute("id", "F", true);

	else $div->click_by_attribute("id", "M", true);
	
	$browser->wait();
	$browser->wait_js();
	$anchor->get_by_attribute("data-name","close-action", true)->click();
	$browser->wait();
	$browser->wait_js();
	if ($span->get_by_inner_text("Сортировки", false)->is_visibled()) {
		$span->get_by_outer_html("<span>Сортировки</span>", false)->click();
		$browser->wait();
		$browser->wait_js();
		$span->get_by_outer_html("<span>Новизна</span>", false)->click();
		$browser->wait();
		$browser->wait_js();
		$rand = rand(1,4);
		switch($rand):
			case 1: $period = 'd'; break;
			case 2: $period = 'w'; break;
			case 3: $period = 'm'; break;
			default: $period = 'a';
		endswitch;

		$div->get_by_attribute("id",$period, true)->click();
		$browser->wait();
		$browser->wait_js();
		$anchor->get_by_attribute("data-name","close-action", true)->click();
		$browser->wait();
		$browser->wait_js();
		$anchor->get_by_attribute("data-name","close-action", true)->click();
		$browser->wait();
		$browser->wait_js();
	}

	if ($button->get_by_value("Готово")->is_disabled())
		$anchor->get_by_attribute("data-name","close-action", true)->click();
	else
		$button->click_by_value("Готово", true);
	
	$browser->wait();
	$browser->wait_js();
});

$editProfile = (function($girl) use($span, $anchor, $browser, $div, $checkbox, $image, $radiobox, $label, $listbox, $button) {
	$image->get_by_attribute("class","b-photo", false)->send_mouse_click();
	$span->click_by_inner_text("Анкета", true);
		$browser->wait();
	$browser->wait_js();

	$anchor->click_by_inner_text("Редактировать блок", false);
	$browser->wait();
	$browser->wait_js();

	if ($girl) {
		if (!$checkbox->is_check_by_value("F",true)) {
			$checkbox->get_by_outer_html("<input type=\"checkbox\" name=\"lookfor[]\" value=\"F\">", true)->click();
		}
		if ($checkbox->is_check_by_value("M",true)) {
			$checkbox->get_by_outer_html("<input type=\"checkbox\" name=\"lookfor[]\" value=\"M\" checked=\"\">", false)->click();
		}
		$label->click_by_inner_text("Гетеро", false);
		$radiobox->get_by_outer_html("<input type=\"radio\" name=\"home\" value=\"Along\"", false)->click();
		$radiobox->get_by_outer_html("<input type=\"radio\" name=\"home", false)->click();
		//$radiobox->get_by_outer_html("<input type=\"radio\" name=\"circumstance\" value=\"Huge\"", false)->click();
		$label->click_by_inner_text("Спортивное", false);

	} else {
		if (!$checkbox->is_check_by_value("M",true)) {
			$checkbox->get_by_outer_html("<input type=\"checkbox\" name=\"lookfor[]\" value=\"M\">", true)->click();
		}
		$radiobox->get_by_outer_html("<input type=\"radio\" value=\"Thin\" name=\"constitution\">", false)->click();
		$radiobox->get_by_outer_html("<input type=\"radio\" name=\"circumstance\" value=\"None\"", false)->click();

		if ($checkbox->is_check_by_value("F",true)) {
			$checkbox->get_by_outer_html("<input type=\"checkbox\" name=\"lookfor[]\" value=\"M\" checked=\"\"", false)->click();
		}
		$radiobox->get_by_outer_html("<input type=\"radio\" name=\"orientation\" value=\"None\"", false)->click();
		$radiobox->get_by_outer_html("<input type=\"radio\" name=\"home\" value=\"Friend\"", false)->click();


	}

	$listbox->set_value_by_name("age[from]", "18");
	$listbox->set_value_by_name("age[to]", "80");
	$label->click_by_inner_text("Пью в компаниях изредка", false);
	$label->click_by_inner_text("Редко", false);
	
	$checkbox->get_all_by_name("target[]")->click();

	for($i = 0; $i < 6; $i++) {
		$gen = rand(2,10);
		if (!$checkbox->is_check_by_number($gen))
			$checkbox->check_by_number($gen, True);
	}

	$label->click_by_inner_text("(English)", false);
	//$radiobox->click_by_name("marital");
	$radiobox->click_by_value("HigherEducationUniversity", false);


	$button->get_by_number(5)->click();

	$button->get_by_attribute("class","button-blue", false)->send_mouse_click();
	$browser->wait();
	$browser->wait_js();
});

$watch = (function($url) use($browser) {
	$browserCount = $browser->get_count();
	$browser->set_count($browserCount + 1);
	$browser->set_active_browser($browserCount + 1);
	$browser->navigate($url);
	sleep(1);
	$browser->close();
	$browser->set_active_browser($browserCount);
});

$search = (function($girls = true) use($filter, $keyboard, $watch, $image, $editProfile, $span, $btn, $div, $listbox, $anchor, $browser, $button) {
	//$editProfile($girls);
	navigate('https://wamba.com/search.phtml');
	$filter($girls);
	for($i = 0; $i < 10; $i++) {
		$keyboard->send_key(VK_END);
		$browser->wait_js();
		$browser->wait();

	}
	$links = (array_unique($anchor->get_all_by_href('nactive=')->get_href()));
	shuffle($links);
	array_map($watch, $links);
	
	
});



$clickMeet = (function($girls) use($div, $span, $btn, $filter, $browser) {
	$startUrl = 'https://wamba.com/rating#/app';
	navigate($startUrl);
	$filter($girls);
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

$girls = true;

foreach($credentials as $data) {
	extract($data);

	if ($authorize($log, $pass))
		$search($girls);
}
$app->restart();

$app->quit();
?>