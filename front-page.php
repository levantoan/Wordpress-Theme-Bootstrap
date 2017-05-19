<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  	<head itemscope itemtype="http://schema.org/WebSite">
	    <meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	    <?php wp_head(); ?>
  	</head>
  	<body <?php body_class();?> itemscope itemtype="http://schema.org/WebPage">
  	<header class="header" itemscope itemtype="http://schema.org/WPHeader">
  		<div class="container">
  			<div class="logo">
	  			<?php 
	  			$logo = get_field('logo','option');
	  			$logo = ($logo) ? $logo : TEMP_URL.'/images/logo.png';
	  			?>
	  			<a href="<?=esc_url(home_url('/'))?>" title="<?php bloginfo('description')?>"><img src="<?=$logo?>" alt="<?php bloginfo('name')?>"/></a>
	  		</div>
	  		<?php if(has_nav_menu('header')):?>
  			<div class="menu_header" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
  				<?php wp_nav_menu(array('theme_location'  => 'header','container'=> ''));?>
  			</div>
            <button type="button" class="button_menu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
  			<?php endif;?>
  		</div>
  	</header>
  	
  	<footer class="footer" itemscope="" itemtype="http://schema.org/WPFooter">
  		<div class="container">
  			<div class="footer_wrap">
  			<!-- Footer code in here -->
  			</div>
  		</div>
  	</footer>
    <div class="over_wrap"></div>
  	<?php wp_footer(); ?>
  	</body>
</html>