<form method="get" class="form-inline" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" class="form-control field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search...', 'devvn' ); ?>" />
	<input type="submit" class="btn btn-default" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'devvn' ); ?>" />
</form>