<?php

$xhe_host = "127.0.0.1:7012";

// The following code is required to properly run XWeb Human Emulator
require("C:/XWeb/Templates/xweb_human_emulator.php");
$girl = true;

$editProfile = (function($girl) use($span, $anchor, $browser, $div, $checkbox, $radiobox, $label, $listbox, $button) {
	$span->click_by_inner_text("Анкета", false);
	$anchor->click_by_inner_text("Редактировать блок", false);
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
$editProfile($girl);
//array_map((function($var) use($div) {if (method_exists($var,'check')) $var->check();}), (array) $div->get_all_by_attribute('role', 'checkbox', true));
//$div->get_by_attribute("class","sc-gojNiO", false)->click();

// Quit
$app->quit();
?>