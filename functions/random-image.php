<?php

class random_image_widget extends WP_Widget {
  function random_image_widget() {
    $currentLocale = get_locale();
    if(!empty($currentLocale)) {
      $moFile = dirname(__FILE__) . "/languages/random_image_widget_" .  $currentLocale . ".mo";
      if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('', $moFile);
    }
    $random_image_widget_name = __('Random Image Widget', 'mdr_random_image_widget');
    $random_image_widget_description = __('Displays a random gallery image from the WordPress built in galleries.', 'mdr_random_image_widget');
    $widget_ops = array('classname' => 'random_image_widget', 'description' => $random_image_widget_description );
    $this->WP_Widget('random_image_widget', $random_image_widget_name, $widget_ops);
  }  
  
  function widget($args, $instance) {
    extract($args);
    $riw_widget_title = empty($instance['widget_title']) ? '&nbsp;' : apply_filters('widget_title', $instance['widget_title']);
    $riw_cat_slug = empty($instance['gallery_category']) ? 'empty' : apply_filters('gallery_category', $instance['gallery_category']);
    global $wpdb;

    if ($riw_widget_title == "&nbsp;") {
      $riw_widget_title = __('Random Image','mdr_random_image_widget');
    }

    $args = array(
       'post_type' => 'attachment',
       'post_mime_type' => 'image',
       'numberposts' => -1,
       'post_status' => null,
       'post_parent' => $post->ID,
       'orderby' => 'rand'
    );
    $riw_cat_id = get_category_by_slug($riw_cat_slug);
    $attachments = get_posts($args);
    $noimages = count($attachments);
     
    if ($attachments) {
      foreach ($attachments as $attachment) {
        $albumid = $attachment->post_parent;
        if ( in_category( $riw_cat_id, $albumid )) { 
          $imgid = $attachment->ID;
          $meta = wp_get_attachment_metadata($imgid);
          $imgw = $meta['sizes']['thumbnail']['width'];
          $imgh = $meta['sizes']['thumbnail']['height'];

          // construct the image
          echo "<div class='widget bookmarks widget-bookmarks'>";
            echo "<h3 class='widget-title' >$riw_widget_title</h3>";
            echo "<div class='random-image'>";
              echo "<a href=".get_permalink( $imgid )." >";
              echo "<img src='".wp_get_attachment_thumb_url($imgid)."' height='".$imgh."' width='".$imgw."' alt='Random image: ".$attachment->post_title."' />";
              echo "</a>";
              echo "<p class='random-image-caption'><strong>$attachment->post_excerpt</strong></p>";
              echo "<p class='random-image-album'><small>".__('Album:','mdr_random_image_widget')." <a href=".get_permalink( $albumid ).">".get_the_title($albumid)."</a></small></p>";
            echo "</div>";
          echo "</div>";
          break;
	}
      }
    }
  }
  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['widget_title'] = strip_tags($new_instance['widget_title']);
    $instance['gallery_category'] = strip_tags($new_instance['gallery_category']);
    return $instance;
  }
  
  function form($instance) {
    $riw_widget_title = strip_tags($instance['widget_title']);
    $riw_cat_slug = strip_tags($instance['gallery_category']);
    ?><p><label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Widget title', 'mdr_random_image_widget')?>:<input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo attribute_escape($riw_widget_title); ?>" /></label></p><?php
    ?><p><label for="<?php echo $this->get_field_id('gallery_category'); ?>"><?php _e('Gallery Category slug (only one)', 'mdr_random_image_widget')?>:<input class="widefat" id="<?php echo $this->get_field_id('gallery_category'); ?>" name="<?php echo $this->get_field_name('gallery_category'); ?>" type="text" value="<?php echo attribute_escape($riw_cat_slug); ?>" /></label></p><?php
  }
}

add_action('widgets_init', 'random_image_widget_init');
function random_image_widget_init() {
        register_widget('random_image_widget');
}

?>
