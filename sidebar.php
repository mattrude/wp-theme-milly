<div id="primary" class="aside">
	<?php
 	/* Widgetized sidebar, if you have the plugin installed. */
	if ( is_active_sidebar( 'sidebar-widget-area') ) {
		dynamic_sidebar( 'sidebar-widget-area');
	} else { ?>
		<div id="primary" class="aside">
		<div class="widget bookmarks widget-bookmarks">
		Welcome to your new site!<br />
		To add items to your sidebar, go to the <a href="<?php bloginfo('url'); ?>/wp-admin/widgets.php">widgets page</a> from your admin Dashboard.	
		</div>
		</div>
	<?php } ?>
</div>
