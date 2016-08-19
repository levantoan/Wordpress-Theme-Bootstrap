<?php
function annointed_admin_bar_remove() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);

function mw_login_styles() {
	echo '<style type="text/css">.login h1 a { background: url('. get_bloginfo("template_directory") .'/inc/copyright/svl_icon.png) no-repeat center top;width: inherit;height: 45px;}</style>';
}
add_action('login_head', 'mw_login_styles');

// Change Login URL
function mw_login_url() {
	return 'http://levantoan.com';
}
add_filter( 'login_headerurl', 'mw_login_url' );

// Change Login Title
function mw_login_title() {
	return 'Thủ thuật WordPress';
}
add_filter( 'login_headertitle', 'mw_login_title' );

// Admin footer modification
function remove_footer_admin () 
{
    echo '<span id="footer-thankyou">Thank you for creating with <a href="https://wordpress.org/">WordPress</a>. Developed by <a href="http://levantoan.com" target="_blank">Lê Văn Toản</a></span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// Function that outputs the contents of the dashboard widget
function dashboard_widget_function() {
		$result = wp_remote_get('http://levantoan.com/feed/');
    	if (!is_wp_error($result)) {
	    	if ($result['response']['code'] == 200) {
	    		$xml = simplexml_load_string($result['body']);
	    		$rssPosts = $xml->channel;
	    	}?>
			<div class="rss-widget">
				<ul>
					<?php
					foreach ($rssPosts->item as $key=>$rssPost) {
						?>
						<li>
							<a href="<?php echo (string) $rssPost->link; ?>" target="_blank" class="rsswidget"><?php echo (string) $rssPost->title; ?></a>
							<span class="rss-date"><?php echo date('F j, Y', strtotime($rssPost->pubDate)); ?></span>
						</li>
						<?php	
					}
					?>
					<li>
						<hr />
						<a href="http://levantoan.com/category/wordpress/" class="wp_svl" target="_blank"><?php _e('Thủ thuật wordpress'); ?></a>
						<a href="http://levantoan.com/category/wordpress/woocommerce/" class="woo_svl" target="_blank"><?php _e('Thủ thuật Woocommerce'); ?></a>
						<a href="http://levantoan.com/" class="mywweb_svl" target="_blank"><?php _e('My Website'); ?></a>
					</li>
				</ul>
			</div>
	    <?php	
    	} else {
    		echo 'Visit <a href="http://levantoan.com">my website</a>';
    	} 
} 
// Function used in the action hook
function add_dashboard_widgets() {
	wp_add_dashboard_widget('dashboard_widget', 'Latest from LeVanToan.Com', 'dashboard_widget_function');
}
// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );
function adminScriptsAndCSS_svl() {
   wp_enqueue_style('themesvl-admin', get_template_directory_uri().'/inc/copyright/admin_svl.css', array(), '1.0'); 
}
add_action('admin_enqueue_scripts', 'adminScriptsAndCSS_svl');