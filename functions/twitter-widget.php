<?php
class milly_twitter_widget extends WP_Widget {
  function milly_twitter_widget() {
    $milly_twitter_widget_name = __('Twitter Widget');
    $milly_twitter_widget_description = __('Displays Tweets from the tweet post type.');
    $widget_ops = array('classname' => 'milly_twitter_widget', 'description' => $milly_twitter_widget_description );
    $this->WP_Widget('milly_twitter_widget', $milly_twitter_widget_name, $widget_ops);
  }  
  
  function widget($args, $instance) { 
    extract($args);
    $widget_title = strip_tags($instance['widget_title']);
    echo "{$before_widget}{$before_title}<a href='/twitter/'>$widget_title</a>{$after_title}<ul class='tweets'>";
    global $wp_query;
    $wp_query = new WP_Query("post_type=twitter&posts_per_page=8");
    while (have_posts()) : the_post();
      global $post;
      echo "<li>";
      the_content();
      echo "</li>";
    endwhile;
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
    ?><p><label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Widget Title')?>:<input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo attribute_escape($widget_title); ?>" /></label></p><?php
  }
}

add_action('widgets_init', 'milly_twitter_widget_init');
function milly_twitter_widget_init() {
        register_widget('milly_twitter_widget');
}

?>
