<?php 
echo "<div id='primary' class='aside'>";
if ( get_post_type($post->ID) == 'technology' ) {
         dynamic_sidebar('technology-widget-area');
} else {
 	/* Widgetized sidebar, if you have the plugin installed. */
	dynamic_sidebar('sidebar-widget-area');
}
echo "</div>";
