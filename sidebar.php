<div id="primary" class="aside">
	<?php
	if ( get_post_type($post->ID) == 'technology' ) {
		if ( is_active_sidebar( 'technology-widget-area' ) ) {
			dynamic_sidebar( 'technology-widget-area' );
        	} else { ?>
			<div class="widget bookmarks widget-bookmarks">
				<p>Welcome to your new site!</p>
               			<p>This is your Technology Widget area.  To add items to this sidebar, go to the
				<a href="<?php bloginfo('url'); ?>/wp-admin/widgets.php">widgets page</a>
				from your admin Dashboard, and add items to the 'Technology Widget Area' on the right hand side.</p>
			</div> <?php
		}
	} else {
		if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
	    		dynamic_sidebar( 'sidebar-widget-area' );
		} else { ?>
			<div class="widget bookmarks widget-bookmarks">
				<p>Welcome to your new site!</p>
				<p>To add items to your sidebar, go to the
				<a href="<?php bloginfo('url'); ?>/wp-admin/widgets.php">widgets page</a>
				from your admin Dashboard, and add items to the 'Sidebar Widget Area' on the right hand side.</p>	
			</div> <?php
		}
	} ?>
</div>
