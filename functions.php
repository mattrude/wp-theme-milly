<?php
require_once('functions/category-excluder.php');
require_once('functions/control-panel.php');
require_once('functions/google-analytics.php');
require_once('functions/robots.php');

// Add Post Thumbnails
add_theme_support('post-thumbnails');

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
	
$Options =
array
(
	array
	(
		'Type'=>'Title',
		'Value'=>'Google Analytics Options'
	),
	array
	(
		'Type'=>'CheckBox',
		'ID'=>'GoogleAnalyticsEnabled',
		'Label'=>'<strong>Enable Google Analytics</strong>',
		'Description' => 'This module requres a <a href="http://analytics.google.com">Google Analytics</a> account.<br />The Google Analytics code will NOT be displayed for logged in users.',
		'Default'=> 'false'
	),
	array
	(
		'Type'=>'Text',
		'ID'=>'GoogleAnalyticsID',
		'Label'=>'<strong>Google Analytics ID</strong>',
		'Description'=>'Enter your <a href="http://analytics.google.com">Google Analytics</a> account ID.'
	),
	array
	(
		Type=>'End'
	),
	array
	(
                'Type'=>'Title',
                'Value'=>'Copyright logo'
        ),
        array
        (
                'Type'=>'CheckBox',
                'ID'=>'copyenable',
                'Label'=>'<strong>Enable CC Copyright Logo</strong>',
                'Description' => '',
                'Default'=> 'false'
        ),
        array
        (
                Type=>'End'
        ),
	array
	(
		Type=>'Close'
	)
);

$Panel = new ControlPanel('Milly');
$Panel->SetOptions($Options);
$Panel->Initialize();

?>
