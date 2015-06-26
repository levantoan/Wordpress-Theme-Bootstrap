<?php
//Theme Options
function my_acf_options_page_settings( $settings )
{
	$settings['title'] = 'Theme Options';
	$settings['pages'] = array('General');

	return $settings;
}

add_filter('acf/options_page/settings', 'my_acf_options_page_settings');