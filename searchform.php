<div itemscope itemtype="http://schema.org/WebSite">
    <meta itemprop="url" content="<?php echo home_url();?>"/>
    <form itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction" method="get" class="form-inline" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    	<meta itemprop="target" content="<?php echo home_url();?>?s={s}"/>      
		<input itemprop="query-input" type="text" class="form-control field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search...', 'devvn' ); ?>" />
		<input type="submit" class="btn btn-default" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'devvn' ); ?>" />
    </form>
</div>