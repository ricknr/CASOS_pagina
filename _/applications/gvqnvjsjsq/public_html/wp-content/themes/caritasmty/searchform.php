<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'twentyseventeen' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		<span class="input-group-btn">
			<button type="submit" class="search-submit btn btn-primary"><i class="fa fa-search"></i></button>
		</span>
		<input type="hidden" name="post_type" value="post">
	</div>
</form>