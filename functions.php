<?php
require_once('functions/control-panel.php');
require_once('functions/category-excluder.php');
require_once('functions/google-analytics.php');
require_once('functions/random-image.php');
require_once('functions/robots.php');

// Add Post Thumbnails for WordPress 2.9
if (function_exists(add_theme_support)) {
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size(200, 200);
}

// Add Custom Taxonomies
function create_my_taxonomies() {
	register_taxonomy( 'people', 'post', array( 'hierarchical' => false, 'label' => 'People', 'query_var' => true, 'rewrite' => true ) );
	register_taxonomy( 'places', 'post', array( 'hierarchical' => false, 'label' => 'Places', 'query_var' => true, 'rewrite' => true ) );
	register_taxonomy( 'events', 'post', array( 'hierarchical' => false, 'label' => 'Events', 'query_var' => true, 'rewrite' => true ) );
        }
add_action( 'init', 'create_my_taxonomies', 0 );

// Add Custom Post Types
function milly_post_type_init() {
        register_post_type('twitter',array('exclude_from_search' => true) );
        }
add_action('init','milly_post_type_init');

// Add Custom User Contact Methods
function add_twitter_contactmethod( $contactmethods ) {
  // Add Twitter
  $contactmethods['facebook'] = 'Facebook URL';
  $contactmethods['twitter'] = 'Twitter';
 
  // Remove Yahoo IM
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
 
  return $contactmethods;
}
add_filter('user_contactmethods','add_twitter_contactmethod',10,1);

// Changing excerpt length
function new_excerpt_length($length) {
	return 80;
}
add_filter('excerpt_length', 'new_excerpt_length');
 
// Changing excerpt more
function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

// Add Widget sidebar to Theme
if(function_exists('register_sidebar'))
	register_sidebar(array (
		'before_widget' => '<div class="widget bookmarks widget-bookmarks">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
/*
This shortcode displays the years since the date provided.
To use this shortcode, add some text to a post or page simmiler to:

    [ts date='1983-09-02']

The date format is YYYY-MM-DD
*/

function mdr_timesince($atts, $content = null) {
  extract(shortcode_atts(array("date" => ''), $atts));
  if(empty($date)) {
    return "<br /><br />************No date provided************<br /><br />";
  }
  $mdr_unix_date = strtotime($date);
  $mdr_time_difference = time() - $mdr_unix_date ;
  $years = round($mdr_time_difference / 31556926 );
  $num_years_since = $years;
  return $num_years_since;
}

add_shortcode('ts', 'mdr_timesince');

?>
