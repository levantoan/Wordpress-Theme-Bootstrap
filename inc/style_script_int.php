<?php
$style_file = array(
	'style'		=> 'css/devvn_style.css',
	'respon'	=>	'css/respon.css',
);
$script_file = array();
function useAjaxInWp() {
	global $style_file,$script_file;
	//Style
	if(file_exists( dirname(__FILE__) . '/css/style.min.css') ){
		wp_register_style( 'style_min', esc_url( trailingslashit( get_template_directory_uri() ) . 'css/style.min.css' ),array(), VERSIONOG, 'all' );
	}else{	
		foreach ($style_file as $k=>$v){
			wp_register_style( $k, esc_url( trailingslashit( get_template_directory_uri() ) . $v ),array(), VERSIONOG, 'all' );
		}
	}
	//Script
	if(file_exists( dirname(__FILE__) . '/js/devvn.jquery.min.js') ){
		wp_register_script( 'devvn-main', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/devvn.jquery.min.js' ), array( 'jquery' ), VERSIONOG, true );
	}else{
		wp_register_script( 'devvn-main', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/devvn_main.js' ), array( 'jquery' ), VERSIONOG, true );
		foreach ($script_file as $k=>$v){
			wp_register_script( $k, esc_url( trailingslashit( get_template_directory_uri() ) . $v ),  array( 'jquery' ), VERSIONOG, true );
		}	
	}
	$php_array = array( 
		'admin_ajax'		=>	admin_url( 'admin-ajax.php'),
		'home_url'			=>	home_url(),
		'tempURL'			=>	TEMP_URL,
	);
	wp_localize_script( 'devvn-main', 'devvn_array', $php_array );	
}
function enqueue_UseAjaxInWp() {
	global $style_file,$script_file;
	if(file_exists( dirname(__FILE__) .  '/css/style.min.css' ) ){
		wp_enqueue_style( 'style_min' );	
	}else{	
		foreach ($style_file as $k=>$v){
			wp_enqueue_style( $k );
		}
	}
	if(file_exists( dirname(__FILE__) . '/js/devvn.jquery.min.js') ){
		wp_enqueue_script( 'devvn-main' );
	}else{
		foreach ($script_file as $k=>$v){
			wp_enqueue_script( $k );
		}
		wp_enqueue_script( 'devvn-main' );
	}
}
add_action( 'wp_enqueue_scripts', 'useAjaxInWp', 1 );
add_action( 'wp_enqueue_scripts', 'enqueue_UseAjaxInWp' );