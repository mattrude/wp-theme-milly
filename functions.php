<?php
require_once('functions/control-panel.php');
require_once('functions/category-excluder.php');
require_once('functions/google-analytics.php');
require_once('functions/google-webmaster-tools.php');
require_once('functions/random-image-block.php');
require_once('functions/regenerate-thumbnails.php');
require_once('functions/robots.php');
require_once('functions/random-image-function.php');
require_once('functions/twitter-post-type.php');

// Add Post Thumbnails for WordPress 2.9
add_theme_support('post-thumbnails');
set_post_thumbnail_size(200, 200);

// Add Custom Navigation Menu for WordPress 3.0
add_theme_support( 'nav-menus' );
if ( ! get_term_by( 'name', 'Top Navigation Menu', 'nav_menu' ) ) {
  echo "Creating Top Navigation Menu<br />";
  wp_create_nav_menu('Top Navigation Menu');
}
if ( ! get_term_by( 'name', 'Side Navigation Menu', 'nav_menu' ) ) {
  echo "Creating Side Navigation Menu<br />";
  wp_create_nav_menu('Side Navigation Menu');
}
if ( get_term_by( 'name', 'Menu 1', 'nav_menu' ) ) {
  echo "Deleting unwanted Menu 1 Navigation Menu";
  $milly_menu_1_id = get_term_by('name', 'Menu 1', 'nav_menu');
  wp_delete_nav_menu( $milly_menu_1_id );
}

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'milly', TEMPLATEPATH . '/languages' );

// Add Custom Taxonomies for WordPress 2.9
function create_milly_taxonomies() {
  register_taxonomy( 'people', 'post', array( 'hierarchical' => false, 'label' => 'People', 'query_var' => true, 'rewrite' => true ) );
  register_taxonomy( 'places', 'post', array( 'hierarchical' => false, 'label' => 'Places', 'query_var' => true, 'rewrite' => true ) );
  register_taxonomy( 'events', 'post', array( 'hierarchical' => false, 'label' => 'Events', 'query_var' => true, 'rewrite' => true ) );
}
add_action( 'init', 'create_milly_taxonomies', 0 );

// Add Custom Post Types for WordPress 2.9
function milly_post_type_init() {
  register_post_type('twitter', array(
      'label' => __('Twitter'), 
      'description' => __('Imported Twitter Posts'),
      'exclude_from_search' => true,
      'public' => true,
      'show_ui' => true,
      'supports' => array('title', 'editor', 'author')
  ));
  register_taxonomy_for_object_type('post_tag', 'twitter');
}
add_action('init','milly_post_type_init');

// Add Custom User Contact Methods
function add_milly_contactmethod( $contactmethods ) {
  // Add Twitter
  $contactmethods['facebook'] = 'Facebook URL';
  $contactmethods['googletalk'] = 'Google Talk';
  $contactmethods['twitter'] = 'Twitter ID';
 
  // Remove Yahoo IM
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
 
  return $contactmethods;
}
add_filter('user_contactmethods','add_milly_contactmethod',10,1);

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
	

/* This shortcode displays the years since the date provided.
   To use this shortcode, add some text to a post or page simmiler to:

     [ts date='1980-06-19']

   The date format is YYYY-MM-DD */
function mdr_timesince($atts, $content = null) {
  extract(shortcode_atts(array("date" => ''), $atts));
  if(empty($date)) {
    return "<br /><br />************No date provided************<br /><br />";
  }
  $mdr_unix_date = strtotime($date);
  $mdr_time_difference = time() - $mdr_unix_date ;
  $years = floor($mdr_time_difference / 31556926 );
  $num_years_since = $years;
  return $num_years_since;
}
add_shortcode('ts', 'mdr_timesince');


// Using WordPress functions to retrieve the extracted EXIF information from database
function mdr_exif() { ?>
  <div id="exif">
    <h3 class='comment-title exif-title'><?php _e('Images EXIF Data','mdr-theme-milly'); ?></h3>
    <div id="exif-data">
      <?php
      $imgmeta = wp_get_attachment_metadata( $id );
      // Convert the shutter speed retrieve from database to fraction
      if ((1 / $imgmeta['image_meta']['shutter_speed']) > 1)
      {
        if ((number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1)) == 1.3
          or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 1.5
          or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 1.6
          or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 2.5){
          $pshutter = "1/" . number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1, '.', '') ." ".__('second','mdr-theme-milly');
        } else{
          $pshutter = "1/" . number_format((1 / $imgmeta['image_meta']['shutter_speed']), 0, '.', '') ." ".__('second','mdr-theme-milly');
        }
      } else{
        $pshutter = $imgmeta['image_meta']['shutter_speed'] ." ".__('seconds','mdr-theme-milly');
      }

      // Start to display EXIF and IPTC data of digital photograph
      echo "<p>" . date("d-M-Y H:i:s", $imgmeta['image_meta']['created_timestamp'])."</p>";
      echo "<p>" . $imgmeta['image_meta']['camera']."</p>";
      echo "<p>" . $imgmeta['image_meta']['focal_length']."mm</p>";
      echo "<p>f/" . $imgmeta['image_meta']['aperture']."</p>";
      echo "<p>" . $imgmeta['image_meta']['iso']."</p>";
      echo "<p>" . $pshutter . "</p>"
      ?>
    </div>
    <div id="exif-lable">
      <?php // EXIF Titles
      echo "<p><span>".__('Date Taken:','mdr-theme-milly')."</span>";
      echo "<p><span>".__('Camera:','mdr-theme-milly')."</span>";
      echo "<p><span>".__('Focal Length:','mdr-theme-milly')."</span>";
      echo "<p><span>".__('Aperture:','mdr-theme-milly')."</span>";
      echo "<p><span>".__('ISO:','mdr-theme-milly')."</span>";
      echo "<p><span>".__('Shutter Speed:','mdr-theme-milly')."</span>"; ?>
    </div>
  </div>
<?php }

?>
