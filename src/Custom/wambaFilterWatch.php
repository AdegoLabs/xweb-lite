<?php

$xhe_host = "127.0.0.1:7017";

require("C:\XWeb\Templates\xweb_human_emulator.php");

function navigate($url) {
	global $browser;

	$browser->navigate($url);
	$browser->wait();
	$browser->wait_js();
}

function randSleep($limit = 3) {
	sleep(rand(0, $limit));
}


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
	randSleep();

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
		$rand = rand(1,5);
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

$randScroll = (function($times = 3) use($browser, $mouse, $keyboard, $element) {
	$els = $element->get_all();
	$limit = rand(0, $times);
	shuffle(($els->elements));
	for($i = 0; $i <= $limit; $i++) { 
		$el = array_pop($els->elements);
		if (is_null($el)) continue;
		else $el->send_mouse_move_to();
		if ($limit % 2 == 0) randSleep(1);
	}
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

$watch = (function($url, $close = true) use($randScroll, $browser) {
	$active = $browser->get_active_browser();
	$count = $browser->get_count();

	$browser->set_count($count + 1);
	$browser->set_active_browser($count + 1);	
	$browser->navigate($url);
	randSleep();
	$randScroll();
	$browser->close();
	$browser->set_active_browser($active);
});

$filterAge = function($low = 27) use($webpage, $div, $randScroll) {
	$randScroll();
	$ageLimit = $div->get_by_attribute("class","b-anketa_field-content", true)->get_inner_text();
	switch($ageLimit):
		case 'с парнем': return true; break;
		case 'с парнем или девушкой' : return true; break;
		case 'с девушкой или парнем' : return true; break;
		default: false;
	endswitch;

	preg_match("#.*([0-9]{2}).* - #", $ageLimit, $matches);	

	$result = (int) (count($matches) > 0 ? $matches[1] : null);

	return (!is_null($result) ? ($result <= $low ? true : false) : false);
};

$writeMessage = (function($msg = 'привет', $click = true) use($randScroll, $anchor, $browser, $textarea, $button) {
	$active = $browser->get_active_browser();
	if ($click === true) {
		

		$anchor->click_by_inner_text("Написать сообщение", false);

		$browser->wait();
		$browser->wait_js();
		randSleep();

		$browser->set_active_browser($browser->get_count() + 1);
		$browser->wait();
		$browser->wait_js();
	
	}
	$textarea->get_by_name("message")->send_input($msg);
	$browser->wait();
	$browser->wait_js();
	$button->click_by_value("Отправить", false);
	$browser->wait();
	$browser->wait_js();
	randSleep();
	//$randScroll();
	if ($click === true) {
		$browser->close();
	}
	$browser->set_active_browser($active + 1);
}); 

$watchFilter = (function($url = false, $msg = 'привет') use($randScroll, $browser, $watch, $filterAge, $writeMessage) {
	$active = $browser->get_active_browser();
	$count = $browser->get_count();
	if ($url !== false) {
		$browser->set_count($count + 1);
		$browser->set_active_browser($count + 1);
		$browser->navigate($url);
		$browser->wait();
		$browser->wait_js();
	} else {
		$browser->set_active_browser($active + 1);
	}

	
	//randSleep();
	$randScroll();
	if ($filterAge())
		$writeMessage($msg);

	$browser->close();
	$browser->set_active_browser($active);
});

$search = (function($girls = true, $click = false, $msg = "привет") use($randScroll, $watchFilter, $filter, $keyboard, $watch, $image, $editProfile, $span, $btn, $div, $listbox, $anchor, $browser, $button) {
	//$editProfile($girls);
	navigate('https://wamba.com/search.phtml');
		$browser->wait_js();
		$browser->wait();
	$randScroll();
	$filter($girls);
	for($i = 0; $i < (rand(1,6)); $i++) {
		$browser->wait_js();
		$browser->wait();
		$randScroll(1);
		$keyboard->send_key(VK_END);

	}
	$urls = $anchor->get_all_by_href('nactive=')->get_href();

	$links =  array_slice(array_unique($urls), rand(0, count($urls)/rand(1, (count($urls) - 1) / 3)));
	shuffle($links);
	array_map((function($url) use($watchFilter, $anchor, $browser, $click, $msg) {
		if ($click) {
			$anchor->get_by_href()->send_mouse_click();
			$browser->wait_js();
			$browser->wait();
			$watchFilter(false, $msg);
		} else {
			$watchFilter($url, $msg);
		}
	}), $links);
});



$clickMeet = (function($girls) use($div, $span, $btn, $filter, $browser, $watchFilter, $writeMessage) {
	$startUrl = 'https://wamba.com/rating#/app';
	navigate($startUrl);
	$browser->wait();
	$browser->wait_js();
	randSleep();
	$filter($girls);
	while(!$div->get_by_inner_text("Сегодня у вас закончились 400 ", false)->is_visibled()) {
		$browser->wait();
		$browser->wait_js();
		randSleep();
		if (!$btn->get_by_inner_text("Мне нравится", false)->is_visibled()) {
			$span->click_by_inner_text("Дальше", false);
			continue;
		}
		$div->get_by_attribute("class", "photo-vote-wrapper", false)->click();
		$browser->wait();
		$browser->wait_js();
		randSleep();
		$watchFilter();
		if (!$btn->click_by_inner_text("Мне нравится", false)) {
			$browser->wait();
			$browser->wait_js();
			$span->click_by_inner_text("Дальше", false);
		}
		if ($btn->get_by_inner_text("Написать сообщение", false)->send_mouse_click());

		$browser->wait();
		$browser->wait_js();
		randSleep();
		$writeMessage("привет", false);
	}
	
});

$girls = true;
$credentials = array(
	array('log' => 'smokutry@gmail.com', 'pass' => 'L2LGMPLh'),
	array('log' => 'vvyyhyij@gmail.com', 'pass' => 'rYFrtXPk'),
	array('log' => 'postestament@gmail.com', 'pass' => 'mndYpHdc'),

);
shuffle($credentials);


foreach($credentials as $data) {
	$browser->close_all_tabs();
	$browser->recreate();
	extract($data);

	if ($authorize($log, $pass)) {
		if (rand(0,10) % 2 == 0)
			$clickMeet($girls);
		else $search($girls);
	}
}
$app->restart();

$app->quit();
?>