<?php
function sitepoint_customize_register($wp_customize) 
{
	//Section Quảng cáo
	$wp_customize->add_section("ads", array(
		"title" => __("Advertising", "customizer_ads_sections"),
		"priority" => 130,
	));
	
	//Chèn code quảng cáo
	$wp_customize->add_setting("ads_code", array(
		"default" => "",
		"transport" => "postMessage",
	));
	
	$wp_customize->add_control(new WP_Customize_Control($wp_customize,"ads_code",array(
		"label" => __("Enter Ads Code", "customizer_ads_code_label"),
		"section" => "ads",
		"settings" => "ads_code",
		"type" => "textarea",
	)));
}

add_action("customize_register","sitepoint_customize_register");