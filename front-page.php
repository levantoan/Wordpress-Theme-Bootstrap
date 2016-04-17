<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  	<head itemscope itemtype="http://schema.org/WebSite">
	    <meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	    <?php if(is_single())://Author Facebook Link?>
	    <meta property="article:author" content=""/>
	    <?php endif;?>
	    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>
	    <?php wp_head(); ?>
  	</head>
  	<body <?php body_class();?> itemscope itemtype="http://schema.org/WebPage">
  	<header class="header" itemscope itemtype="http://schema.org/WPHeader">
  		<div class="container">
  			<div class="logo">
  				<h1 id="logo" class="image-logo" itemprop="headline"><?php devvn_the_custom_logo(); ?></h1>
  			</div>
  			<div class="menu_header" role="navigation" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
  				<?php wp_nav_menu(array('theme_location'  => 'header','container'=> ''));?>
  			</div>
  		</div>
  	</header>
  	
  	<footer class="footer" role="contentinfo" itemscope="" itemtype="http://schema.org/WPFooter">
  		<div class="container">
  			<div class="footer_wrap">
  			<!-- Footer code in here -->
  			</div>
  		</div>
  	</footer>
  	<?php wp_footer(); ?>
  	</body>
</html>