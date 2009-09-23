<div id="primary" class="aside">
	<?php
 	/* Widgetized sidebar, if you have the plugin installed. */
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		<div class="side">
		Welcome to your new site!<br />
		To add items to your side bar, go to your widgets page from the admin Dashboard.	
		</div>
	
		
	<?php endif; ?>
	</ul>
</div>
