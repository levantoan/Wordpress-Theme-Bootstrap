<?php
//Theme Options
function my_acf_options_page_settings( $settings )
{
	$settings['title'] = 'Theme Options';
	$settings['pages'] = array('General');

	return $settings;
}

add_filter('acf/options_page/settings', 'my_acf_options_page_settings');
//Logo, Favicon, Copyright Text
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_general',
		'title' => 'General',
		'fields' => array (
			array (
				'key' => 'field_5589102012fff',
				'label' => 'General',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_5589102f13000',
				'label' => 'Logo',
				'name' => 'logo',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_558cedbdb61d9',
				'label' => 'Favicon',
				'name' => 'favicon',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_55892dd9b6c66',
				'label' => 'Copyright text',
				'name' => 'copyright_text',
				'type' => 'text',
				'default_value' => '© 2015 Copyright All Rights Reserved',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-general',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}