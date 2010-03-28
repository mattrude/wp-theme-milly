<?php
class random_footer_image extends WP_Widget {
  function random_footer_image() {
    $random_footer_image_name = __('Random Footer Image');
    $random_footer_image_description = __('Displays a random image from the Gallery category with no other data.');
    $widget_ops = array('classname' => 'random_footer_image', 'description' => $random_footer_image_description );
    $this->WP_Widget('random_footer_image', $random_footer_image_name, $widget_ops);
  }  
  
  function widget($args, $instance) { 
    $args = array(
       'post_type' => 'attachment',
       'post_mime_type' => 'image',
       'numberposts' => -1,
       'post_status' => null,
       'post_parent' => $post->ID,
       'orderby' => 'rand'
    );

    $attachments = get_posts($args);
    $riw_cat_id = get_category_by_slug(gallery)->term_id;
    $noimages = count($attachments);
    if ($attachments) {
      foreach ($attachments as $attachment) {
        $albumid = $attachment->post_parent;
        if (in_category($riw_cat_id, $albumid)) {
          $imgid = $attachment->ID;
          $meta = wp_get_attachment_metadata($imgid);

          // construct the image
          echo "<a href=".get_permalink( $imgid )." title='$attachment->post_excerpt' >";
          echo "<img width='".$meta['sizes']['thumbnail']['width']."'  height='".$meta['sizes']['thumbnail']['height']."' src='".wp_get_attachment_thumb_url($imgid)."' alt='Random image: ".$attachment->post_title."' />";
          echo "</a>";
          break;
        }
      }
    }
  }
  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['widget_title'] = strip_tags($new_instance['widget_title']);
    return $instance;
  }
  
  function form($instance) {
    $widget_title = strip_tags($instance['widget_title']);
  }
}

add_action('widgets_init', 'random_footer_image_init');
function random_footer_image_init() {
        register_widget('random_footer_image');
}

?>
