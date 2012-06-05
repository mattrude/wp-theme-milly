<?php
require_once('functions/community-tags.php');
#require_once('functions/control-panel.php');
require_once('functions/keep-in-touch-widget.php');
#require_once('functions/keep-in-touch-widget2.php');
require_once('functions/twitter-post_type.php');
#require_once('functions/category-excluder.php');
#require_once('functions/google-analytics.php');
#require_once('functions/google-webmaster-tools.php');
#require_once('functions/robots.php');
#require_once('functions/footnotes.php');
#require_once('functions/relative-date.php');
#require_once('functions/typekit-fonts.php');
#require_once('functions/twitter-import.php');


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
        $content_width = 500;

$themecolors = array(
        'bg' => 'ffffff',
        'text' => '000000',
        'link' => '0060ff'
);

load_theme_textdomain( 'millytheme', get_template_directory() . '/languages' );

/** Tell WordPress to run milly_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'milly_setup' );


/********************************************************************************
  Add Post Format for WordPress 3.1
*/

add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'link', 'status', 'video' ) );

/********************************************************************************
  Add Post Type Technology for WordPress 3.1
*/

register_post_type('technology', array(
	'label' => __('Technology', 'millytheme'),
	'public' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'rewrite' => 'technology/%year%/%monthnum%/',
    	'has_archive' => true,
	'query_var' => true,
	'supports' => array('title', 'editor', 'author', 'excerpt', 'sticky', 'trackbacks', 'comments', 'revisions' ),
	'taxonomies' => array('category', 'post_tag')
));

// Create the Technology Tag & Category taxonomies.
function create_technology_taxonomies() {
  register_taxonomy( 'tech_category', 'technology', array( 'hierarchical' => true, 'label' => __('Categories', 'millytheme'), 'query_var' => true, 'rewrite' => true ) );
  register_taxonomy( 'tech_tag', 'technology', array( 'hierarchical' => false, 'label' => __('Technology Tags', 'millytheme'), 'query_var' => true, 'rewrite' => true ) );
}
add_action( 'init', 'create_technology_taxonomies', 0 );

// Create the Technology Category Widget
class milly_technology_cat_widget extends WP_Widget {
  function milly_technology_cat_widget() {
    $milly_technology_cat_widget_name = __('Technology Category', 'millytheme');
    $milly_technology_cat_widget_description = __('Displays Technology Category.', 'millytheme');
    $widget_ops = array('classname' => 'milly_technology_cat_widget', 'description' => $milly_technology_cat_widget_description );
    $this->WP_Widget('milly_technology_cat_widget', $milly_technology_cat_widget_name, $widget_ops);
  }  
  
  function widget($args, $instance) { 
    extract($args);
    $widget_title = strip_tags($instance['widget_title']);
    echo "{$before_widget}{$before_title}$widget_title{$after_title}<ul class='technology_cat'>";
    $args=array(
	'orderby' => 'name',
	'order' => 'ASC',
	'show_count' => 1,
	'hide_empty' => 1,
	'title_li' => '',
	'taxonomy' => 'tech_category'
    );
    wp_list_categories($args);
    echo "</ul>";
    echo $after_widget;
  }
  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['widget_title'] = strip_tags($new_instance['widget_title']);
    return $instance;
  }
  
  function form($instance) {
    $widget_title = strip_tags($instance['widget_title']);
    ?><p><label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Widget Title', 'millytheme')?>:<input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo esc_attr($widget_title); ?>" /></label></p><?php
  }
}

add_action('widgets_init', 'milly_technology_cat_widget_init');
function milly_technology_cat_widget_init() {
        register_widget('milly_technology_cat_widget');
}

// Create the Technology Tag Widget
class milly_technology_tag_widget extends WP_Widget {
  function milly_technology_tag_widget() {
    $milly_technology_tag_widget_name = __('Technology Tags', 'millytheme');
    $milly_technology_tag_widget_description = __('Displays Technology Tags.', 'millytheme');
    $widget_ops = array('classname' => 'milly_technology_tag_widget', 'description' => $milly_technology_tag_widget_description );
    $this->WP_Widget('milly_technology_tag_widget', $milly_technology_tag_widget_name, $widget_ops);
  }  
  
  function widget($args, $instance) { 
    extract($args);
    $widget_title = strip_tags($instance['widget_title']);
    echo "{$before_widget}{$before_title}$widget_title{$after_title}<div class='technology_tags'>";
    wp_tag_cloud(array('taxonomy' => 'tech_tag'));
    echo "</div>";
    echo $after_widget;
  }
  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['widget_title'] = strip_tags($new_instance['widget_title']);
    return $instance;
  }
  
  function form($instance) {
    $widget_title = strip_tags($instance['widget_title']);
    ?><p><label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Widget Title', 'millytheme')?>:<input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo esc_attr($widget_title); ?>" /></label></p><?php
  }
}

add_action('widgets_init', 'milly_technology_tag_widget_init');
function milly_technology_tag_widget_init() {
        register_widget('milly_technology_tag_widget');
}


/********************************************************************************
  Add Custom Navigation Menu for WordPress 3.0
*/

add_theme_support( 'nav-menus' );
if ( ! get_term_by( 'name', 'Header Navigation Menu', 'nav_menu' ) ) {
  echo "Creating Header Navigation Menu<br />";
  wp_create_nav_menu('Header Navigation Menu');
}
if ( ! get_term_by( 'name', 'Sidebar Navigation Menu', 'nav_menu' ) ) {
  echo "Creating Sidebar Navigation Menu<br />";
  wp_create_nav_menu('Sidebar Navigation Menu');
}
if ( get_term_by( 'name', 'Menu 1', 'nav_menu' ) ) {
  echo "Deleting unwanted Menu 1 Navigation Menu";
  $milly_menu_1_id = get_term_by('name', 'Menu 1', 'nav_menu');
  wp_delete_nav_menu( $milly_menu_1_id );
}
function milly_nav_fallback() {
    wp_page_menu( 'number=10&show_home=Home' );
}

// This theme uses wp_nav_menu() in one location.
register_nav_menus( array(
    'header' => __( 'The Header Navigation Menu', 'millytheme' ),
) );

function milly_admin_favicon() {
    $url = get_option('siteurl');
    $url = $url . '/wp-content/themes/milly/images/favicon.ico';
    echo '
    <link rel="shortcut icon" href="' . $url . '" />
    ';
}

add_action('admin_head', 'milly_admin_favicon');

/********************************************************************************
  Add Custom Taxonomies for WordPress 2.9
*/

function create_milly_taxonomies() {
  register_taxonomy( 'people', array( 'post', 'attachment' ), array( 'hierarchical' => false, 'label' => __('People', 'millytheme'), 'query_var' => true, 'rewrite' => true ) );
  register_taxonomy( 'places', array( 'post', 'attachment' ), array( 'hierarchical' => false, 'label' => __('Places', 'millytheme'), 'query_var' => true, 'rewrite' => true ) );
  register_taxonomy( 'events', array( 'post', 'attachment' ), array( 'hierarchical' => false, 'label' => __('Events', 'millytheme'), 'query_var' => true, 'rewrite' => true ) );
}
add_action( 'init', 'create_milly_taxonomies', 0 );


/********************************************************************************
  Add Custom User Contact Methods
*/

function add_milly_contactmethod( $contactmethods ) {
  // Add Twitter
  $contactmethods['facebook'] = __('Facebook URL', 'millytheme');
  $contactmethods['googletalk'] = __('Google Talk', 'millytheme');
  $contactmethods['twitter'] = __('Twitter ID', 'millytheme');
 
  // Remove Yahoo IM
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
 
  return $contactmethods;
}
add_filter('user_contactmethods','add_milly_contactmethod',10,1);


/********************************************************************************
  Add Widget sidebar to Theme
*/

add_action( 'widgets_init', 'milly_register_sidebars' );
function milly_register_sidebars() {
  register_sidebar(array (
    'id' => 'top-widget-area',
    'name' => __('Top Widget Area', 'millytheme'),
    'description' => __('This is the top Main Right Hand Sidebar', 'millytheme'),
    'before_widget' => '<div class="widget bookmarks widget-bookmarks">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ));

  register_sidebar(array (
    'id' => 'sidebar-widget-area',
    'name' => __('Sidebar Widget Area', 'millytheme'),
    'description' => __('This is the Main Right Hand Sidebar', 'millytheme'),
    'before_widget' => '<div class="widget bookmarks widget-bookmarks">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ));
    
  register_sidebar(array (
    'id' => 'technology-widget-area',
    'name' => __('Technology Widget Area', 'millytheme'),
    'description' => __('This widget area is only used on the technology pages and archives.', 'millytheme'),
    'before_widget' => '<div class="widget bookmarks widget-bookmarks">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ));
    
  register_sidebar( array (
    'id' => 'footer-widget-area',
    'name' => __('Footer Widget Area', 'millytheme'),
    'description' => __('The footer widget area', 'millytheme'),
    'before_widget' => '<div class="widget-footer">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ));
}


/********************************************************************************
  Make theme available for translation
  Translations can be filed in the /languages/ directory
*/

load_theme_textdomain( 'milly', TEMPLATEPATH . '/languages' );


/********************************************************************************
  Random Settings Changes
*/
function milly_setup() {

        // This theme has some pretty cool theme options
        //require_once ( get_template_directory() . '/theme-options.php' );

	// This theme allows users to set a custom background
	//add_theme_support( 'custom-background', $args );
	
	// This theme allows users to use custom header images
	add_theme_support( 'custom-header' );

	// Add Post Thumbnails for WordPress 2.9
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(200, 200);
	
	// Changing excerpt more
	function new_excerpt_more($more) {
	  return '...';
	}
	add_filter('excerpt_more', 'new_excerpt_more');
	
	// Changing excerpt length
	function new_excerpt_length($length) {
	  return 29;
	}
	add_filter('excerpt_length', 'new_excerpt_length');
	 
	// Disable gallery CSS insertes
	add_filter('gallery_style',
	  create_function(
	    '$css',
	    'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'
	  )
	);
}
	
/**
 *  Returns the current Milly layout as selected in the theme options
 *
 * @since Milly 1.7
 */
function milly_current_layout() {
        $options = get_option( 'milly_theme_options' );
        $current_layout = $options['theme_layout'];

        $two_columns = array( 'content-sidebar', 'sidebar-content' );

        if ( in_array( $current_layout, $two_columns ) )
                return 'two-column ' . $current_layout;
        else
                return 'three-column ' . $current_layout;
}

/**
 *  Adds milly_current_layout() to the array of body classes
 *
 * @since Milly 1.7
 */
function milly_body_class($classes) {
        $classes[] = milly_current_layout();

        return $classes;
}
add_filter( 'body_class', 'milly_body_class' );


/********************************************************************************
  This is the Posts section
*/

// This is the Full Message Block, Most posts show this block.
function milly_post_full() { ?>
  <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
      <h1 class="single-title entry-title">
        <?php if (is_single()) {
          the_title();
        } else { ?>
	  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	<?php } ?>
      </h1>
      <p class="byline">
	<span class="byline-prep byline-prep-author text">Posted by </span>
	<span class="fn author"><a class="fn url" rel="author" href="<?php the_author_meta('user_url'); ?>"><?php the_author(); ?></a></address></span>
	<span class="byline-prep byline-prep-author text"> on </span>
	<span class="published updated"><?php the_time('F jS, Y') ?></span>
        <?php if ( get_post_type() == 'technology' ) {
	  echo "<span>";
	  echo get_the_term_list( $post->ID, 'tech_category', ' | Filed Under: ', ', ', '' );
	  echo get_the_term_list( $post->ID, 'tech_tag', ' | Tagged as: ', ', ', '' );
	  echo "</span>";
        } else { ?>
	  <span > | Filed Under: <?php the_category(', '); the_tags(' | Tagged as: ', ', ', ''); ?></span>
        <?php } ?>
	<span><?php if ( function_exists('the_shortlink') ) the_shortlink( __('Shortlink', 'millytheme'), __('A smaller version of this pages URL', 'millytheme'), ' | ' ); ?></span>
        <span><?php edit_post_link('Edit', ' | '); ?></span>
      </p>
    <div class="entry-content entry">
      <?php the_content(); ?>
    </div><!--close entry class-->
    <?php if ( is_single() ) { ?>
      <!--Adding Related Entries if Yet Another Related Posts Plugin is installed-->
      <div class="related-entries">
        <?php if (function_exists('related_entries')) { related_entries(); } ?>
      </div>
    <?php } ?>
  </div><!--close post class-->
<?php }

// This is the Short Message Block
function milly_post_short() { ?>
  <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <h1 class="single-title entry-title">
	  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</h1>
	<p class="byline">
	  <span class="byline-prep byline-prep-author text">Posted by </span>
	  <span class="author"><?php the_author(); ?></span>
	  <span class="byline-prep byline-prep-author text"> on </span>
	  <span class="published"><?php the_time('F jS, Y') ?></span>
      	  <?php if ( get_post_type() == 'technology' ) {
	    echo "<span>";
	    echo get_the_term_list( $post->ID, 'tech_category', ' | Filed Under: ', ', ', '' );
	    echo get_the_term_list( $post->ID, 'tech_tag', ' | Tagged as: ', ', ', '' );
	    echo "</span>";
          } else { ?>
	    <span > | Filed Under: <?php the_category(', '); the_tags(' | Tagged as: ', ', ', ''); ?></span>
          <?php } ?>
	  <span><?php edit_post_link('Edit', ' | '); ?></span>
	</p>
    <div class="entry-content entry">
      <?php the_excerpt(); ?>
    </div><!--close entry class-->
  </div><!--close post class-->
<?php }

// The Post format Aside
function milly_post_aside() { ?>
  <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div class="entry-content entry">
      <?php the_content(); ?>
    </div><!--close entry class-->
  </div><!--close post class-->
<?php }


/********************************************************************************
 Your changeable header business starts here
*/

define( 'HEADER_TEXTCOLOR', '' );
define( 'HEADER_IMAGE', '%s/images/header-cabin.jpg' );
define( 'HEADER_IMAGE_WIDTH', apply_filters( 'milly_header_image_width', 984 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'milly_header_image_height', 200 ) );
define( 'NO_HEADER_TEXT', true );

/*********************************************************************************
 Change the page naviagion forward and back buttons
*/

function milly_pre_next_post() {
  ?>
  <div class="navigation">
     <div class="floatleft"><?php next_post_link('&laquo; %link') ?></div>
     <div class="floatright"><?php previous_post_link('%link &raquo;') ?></div>
     <div class="clearfloatthick">&nbsp;</div>
   </div>
  <?php
}

function milly_pre_next_post_cat() {
  ?>
  <div class="navigation">
    <div class="txtalignleft"><?php previous_posts_link('&laquo; Newer Entries'); ?></div>
    <div class="txtalignright"><?php next_posts_link('Older Entries &raquo;') ?></div>
    <div class="clearfloatthick">&nbsp;</div>
  </div>
  <?php
}


/*********************************************************************************
   This shortcode displays the years since the date provided.
   To use this shortcode, add some text to a post or page simmiler to:

     [ts date='1980-06-19']

   The date format is YYYY-MM-DD 
*/
if ( !function_exists('mdr_timesince') ) {
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
}

/*********************************************************************************
  Using WordPress functions to retrieve the extracted EXIF 
  information from database
*/
function mdr_exif() { ?>
  <div id="exif">
    <h3 class='comment-title exif-title'><?php _e('Images EXIF Data', 'millytheme'); ?></h3>
    <div id="exif-data">
      <?php
      $imgmeta = wp_get_attachment_metadata( $id );
      // Convert the shutter speed retrieve from database to fraction
      $image_shutter_speed = $imgmeta['image_meta']['shutter_speed'];
      if ($image_shutter_speed > 0) {
        if ((1 / $image_shutter_speed) > 1) {
          if ((number_format((1 / $image_shutter_speed), 1)) == 1.3
            or number_format((1 / $image_shutter_speed), 1) == 1.5
            or number_format((1 / $image_shutter_speed), 1) == 1.6
            or number_format((1 / $image_shutter_speed), 1) == 2.5){
            $pshutter = "1/" . number_format((1 / $image_shutter_speed), 1, '.', '') ." ".__('second', 'millytheme');
          } else {
            $pshutter = "1/" . number_format((1 / $image_shutter_speed), 0, '.', '') ." ".__('second', 'millytheme');
          }
        } else {
          $pshutter = $image_shutter_speed ." ".__('seconds', 'millytheme');
        }
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
      echo "<p><span>".__('Date Taken:', 'millytheme')."</span>";
      echo "<p><span>".__('Camera:', 'millytheme')."</span>";
      echo "<p><span>".__('Focal Length:', 'millytheme')."</span>";
      echo "<p><span>".__('Aperture:', 'millytheme')."</span>";
      echo "<p><span>".__('ISO:', 'millytheme')."</span>";
      echo "<p><span>".__('Shutter Speed:', 'millytheme')."</span>"; ?>
    </div>
  </div>
<?php }

/*   A query to correct taxonomy count

UPDATE wp_term_taxonomy tt1
SET count =
(SELECT count(p.ID) FROM wp_term_relationships tr
LEFT JOIN wp_posts p
ON ( p.ID = tr.object_id )
WHERE tr.term_taxonomy_id = tt1.term_taxonomy_id)
WHERE tt1.taxonomy = 'people';

*/

?>
