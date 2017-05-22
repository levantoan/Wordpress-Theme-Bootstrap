<?php
//Hỗ trợ woocommerce
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
/*woo mini cart*/
function woo_mini_cart_int(){
	global $woocommerce; ?>
	<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'devvn'); ?>">
	<?php
	echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'devvn'), $woocommerce->cart->cart_contents_count);
	?>
	</a>
<?php
}
add_action('woo_mini_cart', 'woo_mini_cart_int');
/*Woocommerce update minicart with Ajax*/
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	do_action('woo_mini_cart');
	$fragments['a.cart-contents'] = ob_get_clean();
	return $fragments;
}
/*Action mini cart*/
function mini_cart_int(){?>
	<div class="mini-cart-body">
	<?php woocommerce_mini_cart();?>
	</div>
<?php
}
add_action('devvn_mini_cart','mini_cart_int');
/*Woocommerce update minicart with Ajax*/
add_filter('add_to_cart_fragments', 'woocommerce_mini_cart_fragment');
function woocommerce_mini_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	do_action('devvn_mini_cart');
	$fragments['.mini-cart-body'] = ob_get_clean();
	return $fragments;
}
