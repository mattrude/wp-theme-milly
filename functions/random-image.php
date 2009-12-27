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
    $mdr_random_image_widget_title = empty($instance['widget_title']) ? '&nbsp;' : apply_filters('widget_title', $instance['widget_title']);
    global $wpdb;
    
    if ($mdr_random_image_widget_title == "&nbsp;") {
      $mdr_random_image_widget_title = __('Random Image','mdr_random_image_widget');
    }
    
    $args = array(
       'post_type' => 'attachment',
       'post_mime_type' => 'image',
       'numberposts' => -1,
       'post_status' => null,
       'post_category' => 23,
       'post_parent' => $post->ID,
       'orderby' => 'rand'
    );
    $attachments = get_posts($args);
    $noimages = count($attachments);
     
    if ($attachments) {
      foreach ($attachments as $attachment) {
        $imgtitle = $attachment->post_title;
        $caption = $attachment->post_excerpt;
        $imgid = $attachment->ID;
        $fileurl = $attachment->guid;
        $albumid = $attachment->post_parent;
        $albumtitle = get_the_title($albumid);
         
        $meta = wp_get_attachment_metadata($imgid);
        $imgw = $meta['sizes']['thumbnail']['width'];
        $imgh = $meta['sizes']['thumbnail']['height'];
          
        $imgext = substr($fileurl, -4);
        $fileurl = substr($fileurl, 0, -4);
        $fileurl = $fileurl."-".$imgw."x".$imgh.$imgext;
         
        // construct the image
        echo "<div class='widget bookmarks widget-bookmarks'>";
          echo "<h3 class='widget-title' >$mdr_random_image_widget_title</h3>";
          echo "<div class='random-widget'>";
            echo "<a href=".get_permalink( $imgid )." >";
            echo "<img src='".$fileurl."' alt='".$imgtitle."' class='center' />";
            echo "</a>";
            echo "<p><center><strong>$caption</strong></center></p>";
            echo "<p><small>Album: <a href=".get_permalink( $albumid ).">$albumtitle</a></small></p>";
          echo "</div>";
        echo "</div>";
        break;
      }
    }
  }
  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['widget_title'] = strip_tags($new_instance['widget_title']);
    return $instance;
  }
  
  function form($instance) {
    $mdr_random_image_widget_title = strip_tags($instance['widget_title']);
    ?><p><label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Widget title', 'mdr_random_image_widget')?>:<input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo attribute_escape($mdr_random_image_widget_title); ?>" /></label></p>
    <?php
  }
  
}

add_action('widgets_init', 'random_image_widget_init');
function random_image_widget_init() {
        register_widget('random_image_widget');
}

?>
