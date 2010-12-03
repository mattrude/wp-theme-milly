<div id="primary" class="aside">
	<?php
	if ( get_post_type($post->ID) == 'technology' ) {
		if ( is_active_sidebar( 'technology-widget-area' ) ) {
			dynamic_sidebar( 'technology-widget-area' );
        	} else { ?>
			<div class="widget bookmarks widget-bookmarks">
				<p><?php _e('Welcome to your new site!'); ?></p>
               			<p><?php _e('This is your Technology Widget area.  To add items to this sidebar, go to the'); ?>
				<a href="<?php echo home_url(); ?>/wp-admin/widgets.php"><?php _e('widgets page'); ?></a>
				<?php _e("from your admin Dashboard, and add items to the 'Technology Widget Area' on the right hand side."); ?></p>
			</div> <?php
		}
	} else {
		if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
	    		dynamic_sidebar( 'sidebar-widget-area' );
		} else { ?>
			<div class="widget bookmarks widget-bookmarks">
				<p><?php _e('Welcome to your new site!'); ?></p>
				<p><?php _e('To add items to your sidebar, go to the'); ?>
				<a href="<?php echo home_url(); ?>/wp-admin/widgets.php"><?php _e('widgets page'); ?></a>
				<?php _e("from your admin Dashboard, and add items to the 'Sidebar Widget Area' on the right hand side."); ?></p>	
			</div> <?php
		}
	} ?>
</div>
