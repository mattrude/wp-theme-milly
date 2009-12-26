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
    //http://codewordpress.com/wordpress-hack/display-random-images-from-media-gallery
    $args = array(
       'post_type' => 'attachment',
       'post_mime_type' => 'image',
       'numberposts' => -1,
       'post_status' => null,
       'post_parent' => $post->ID,
       'post_category' => '4',
       'orderby' => 'rand'
    );
    $attachments = get_posts($args);
    $noimages = count($attachments);
     
    if ($attachments) {
      foreach ($attachments as $attachment) {
        $imgtitle = $attachment->post_title;
        $alttxt = $attachment->image_alt;
        $imgid = $attachment->ID;
        $fileurl = $attachment->guid;
         
        $meta = wp_get_attachment_metadata($imgid);
        $imgw = $meta['sizes']['thumbnail']['width'];
        $imgh = $meta['sizes']['thumbnail']['height'];
          
        $imgext = substr($fileurl, -4);
        $fileurl = substr($fileurl, 0, -4);
        $fileurl = $fileurl."-".$imgw."x".$imgh.$imgext;
         
        // construct the image
        ?><div class="widget bookmarks widget-bookmarks">
          <h3 class="widget-title" >Random Image</h3>
          <div class"one-image">
            <a href="<?php echo get_permalink( $imgid ) ?>" ><?php 
            echo "<div class='aligncenter'><img src='".$fileurl."' alt='".$imgtitle."' class='center highlightimg' /></div></ a>";
            echo "$alttxt";
            break;
      }
      echo "</div>";
      echo "</div>";
    }
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
