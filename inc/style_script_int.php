<?php
function useAjaxInWp() {
	//Style
	if(file_exists( dirname(__FILE__) . '/css/style.min.css') ){
		wp_register_style( 'style_min', esc_url( trailingslashit( get_template_directory_uri() ) . 'css/style.min.css' ), VERSIONOG, true );
	}else{
		wp_register_style( 'normalize', esc_url( trailingslashit( get_template_directory_uri() ) . 'css/normalize.css' ), VERSIONOG, true );
		wp_register_style( 'style', esc_url( trailingslashit( get_template_directory_uri() ) . 'css/devvn_style.css' ), VERSIONOG, true );	
		wp_register_style( 'respon', esc_url( trailingslashit( get_template_directory_uri() ) . 'css/respon.css' ), VERSIONOG, true );
	}
	
	//Script
	if(file_exists( dirname(__FILE__) . '/js/devvn.jquery.min.js') ){
		wp_register_script( 'devvn-main', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/devvn.jquery.min.js' ), array( 'jquery' ), VERSIONOG, true );
	}else{
		wp_register_script( 'devvn-main', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/devvn_main.js' ), array( 'jquery' ), VERSIONOG, true );	
	}
	$php_array = array( 
		'admin_ajax'		=>	admin_url( 'admin-ajax.php'),
		'home_url'			=>	home_url(),
		'tempURL'			=>	TEMP_URL,
	);
	wp_localize_script( 'devvn-main', 'devvn_array', $php_array );	
}
function enqueue_UseAjaxInWp() {
	if(file_exists( dirname(__FILE__) .  '/css/style.min.css' ) ){
		wp_enqueue_style( 'style_min' );	
	}else{
		wp_enqueue_style( 'normalize' );
		wp_enqueue_style( 'style' );
		wp_enqueue_style( 'respon' );	
	}
	if(file_exists( dirname(__FILE__) . '/js/devvn.jquery.min.js') ){
		wp_enqueue_script( 'devvn-main' );
	}else{
		wp_enqueue_script( 'devvn-main' );
	}
}
add_action( 'wp_enqueue_scripts', 'useAjaxInWp', 1 );
add_action( 'wp_enqueue_scripts', 'enqueue_UseAjaxInWp' );