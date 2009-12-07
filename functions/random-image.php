<?php

class random_image_widget extends WP_Widget {
  function random_image_widget() {
    $currentLocale = get_locale();
    if(!empty($currentLocale)) {
      $moFile = dirname(__FILE__) . "/languages/random_image_widget_" .  $currentLocale . ".mo";
      if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('', $moFile);
    }
    $random_image_widget_name = __('Random Image Widget', 'random_image_widget');
    $random_image_widget_description = __('Displays a random gallery image from the WordPress built in galleries.', 'random_image_widget');
    $widget_ops = array('classname' => 'random_image_widget', 'description' => $random_image_widget_description );
    $this->WP_Widget('random_image_widget', $random_image_widget_name, $widget_ops);
  }  
  
  function widget($args, $instance) {
    extract($args);
    $image_height = empty($instance['image_height']) ? '&nbsp;' : apply_filters('image_height', $instance['image_height']);
    global $wpdb;
    
    //http://codex.wordpress.org/Template_Tags/get_posts
    $random_postid = $args = array(
	'post_type' => 'attachment',
	'category_name' => 'gallery',
	'numberposts' => '1',
	'order_by' => 'rand',
	'post_status' => null,
	); 
    $attachments = get_posts($random_postid);
    
    $image_meta = wp_get_attachment_metadata( $random_pageid, true );
    $title = $image_meta->post_title;
    ?><div class="widget bookmarks widget-bookmarks">
      <h3 class="widget-title" >Random Image</h3>
      <div class"one-image">
        <a href="<?php echo get_permalink( $random_postid ) ?>" >
          <img src="<?php echo wp_get_attachment_thumb_url( $random_postid ) ?>" />
        </ a>
      </div>
        <br />
        <?php echo $title; ?>
      
    </div><?php
  
  }
  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['image_height'] = strip_tags($new_instance['image_height']);
    return $instance;
  }
  
  function form($instance) {
    $posts_per_page = strip_tags($instance['image_height']);
    ?>
    <p><label for="<?php echo $this->get_field_id('image_height'); ?>"><?php _e('Image Height in pix', 'image_height')?>:<input class="widefat" id="<?php echo $this->get_field_id('image_height'); ?>" name="<?php echo $this->get_field_name('image_height'); ?>" type="text" value="<?php echo attribute_escape($image_height); ?>" /></label></p>
    <?php
  }
  
}

add_action('widgets_init', 'random_image_widget_init');
function random_image_widget_init() {
        register_widget('random_image_widget');
}

?>
