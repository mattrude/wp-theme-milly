<div id="primary" class="aside">
	<?php
 	/* Widgetized sidebar, if you have the plugin installed. */
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		<div class="side">
		Welcome to your new site!<br />
		To add items to your sidebar, go to the widgets page from your admin Dashboard.	
		</div>
	
		
	<?php endif; ?>
</div>
