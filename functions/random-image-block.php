<?php
/*
Plugin Name: Random Image Block
Plugin URI: http://mattrude.com/projects/random-image-block/
Description: Display a random image from your native WordPress photo galley or in-beaded images.
Version: 0.7
Author: Matt Rude
Author URI: http://mattrude.com/
*/


class random_image_widget extends WP_Widget {
  function random_image_widget() {
    $currentLocale = get_locale();
    if(!empty($currentLocale)) {
      $moFile = dirname(__FILE__) . "/languages/random_image_widget_" .  $currentLocale . ".mo";
      if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('random-image-block', $moFile);
    }
    $random_image_widget_name = __('Random Image Widget', 'random-image-block');
    $random_image_widget_description = __('Displays a random gallery image.', 'random-image-block');
    $widget_ops = array('classname' => 'random_image_widget', 'description' => $random_image_widget_description );
    $this->WP_Widget('random_image_widget', $random_image_widget_name, $widget_ops);
  }  
  
  function widget($args, $instance) {
    extract($args);
    $riw_widget_title = empty($instance['widget_title']) ? '&nbsp;' : apply_filters('widget_title', $instance['widget_title']);
    $riw_center = empty($instance['center']) ? 'off' : apply_filters('center', $instance['center']);
    $riw_cat_id = empty($instance['gallery_category']) ? '&nbsp;' : apply_filters('gallery_category', $instance['gallery_category']);
    global $wpdb;

    if ($riw_widget_title == "&nbsp;") {
      $riw_widget_title = __('Random Image','random-image-block');
    }

    if ($riw_center == "on") {
      $riw_center_output = "align=center";
    } else {
      $riw_center_output = "";
    }

    $args = array(
       'post_type' => 'attachment',
       'post_mime_type' => 'image',
       'numberposts' => -1,
       'post_status' => null,
       'post_parent' => $post->ID,
       'orderby' => 'rand'
    );

    $attachments = get_posts($args);
    $noimages = count($attachments);
    if ($attachments) {
      foreach ($attachments as $attachment) {
        if ( $riw_cat_id !== "-1" ) {
          $albumid = $attachment->post_parent;
          //echo "on";
        } else {
          $albumid = $attachment->post_parent;
	  foreach((get_the_category($albumid)) as $category) { 
            $riw_cat_id = $category->cat_ID; 
          }

	}

        if (in_category($riw_cat_id, $albumid)) { 
          $imgid = $attachment->ID;
          $meta = wp_get_attachment_metadata($imgid);

          // construct the image
          echo "{$before_widget}{$before_title}$riw_widget_title{$after_title}";
          echo "<div class='random-image'>";
            echo "<p class='random-image-img' $riw_center_output >";
            echo "<a href=".get_permalink( $imgid )." >";
            echo "<img width='".$meta['sizes']['thumbnail']['width']."'  height='".$meta['sizes']['thumbnail']['height']."' src='".wp_get_attachment_thumb_url($imgid)."' alt='Random image: ".$attachment->post_title."' />";
            echo "</a></p>";
            echo "<p class='random-image-caption'><strong>$attachment->post_excerpt</strong></p>";
            echo "<p class='random-image-album'><small>".__('Album:','random-image-block')." <a href=".get_permalink( $albumid ).">".get_the_title($albumid)."</a></small></p>";
          echo "</div>";
          echo $after_widget;
          break;
	}
      }
    }
  }
  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['widget_title'] = strip_tags($new_instance['widget_title']);
    $instance['gallery_category'] = strip_tags($new_instance['gallery_category']);
    $instance['center'] = strip_tags($new_instance['center']);
    return $instance;
  }
  
  function form($instance) {
    $riw_widget_title = strip_tags($instance['widget_title']);
    $riw_center = $instance['center'];
    $riw_cat_id = strip_tags($instance['gallery_category']);
    ?><p><label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Widget Title', 'random-image-block')?>:<input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo attribute_escape($riw_widget_title); ?>" /></label></p>

    <p><input class="checkbox" type="checkbox" <?php if ("$riw_center" == "on" ){echo 'checked="checked"';} ?> id="<?php echo $this->get_field_id('center'); ?>" name="<?php echo $this->get_field_name('center'); ?>" />
    <label for="<?php echo $this->get_field_id('center'); ?>"><?php _e('Center the Image?', 'random-image-block')?></label></p>

    <p><label for="<?php echo $this->get_field_id('gallery_category'); ?>"><?php _e('Select a Post Category to display images from, or All Categories to disable filtering', 'random-image-block')?>:<br />
    <?php wp_dropdown_categories( array( 'name' => $this->get_field_name("gallery_category"), 'hide_empty' => 0, 'hierarchical' => 1, 'selected' =>  $instance["gallery_category"], 'show_option_none' => __('All Categories') ) ); ?>
    </label></p>

    <?php 
  }
}

add_action('widgets_init', 'random_image_widget_init');
function random_image_widget_init() {
        register_widget('random_image_widget');
}

?>
