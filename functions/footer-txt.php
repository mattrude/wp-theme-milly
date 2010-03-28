<?php
class footer_text extends WP_Widget {
  function footer_text() {
    $footer_text_name = __('Footer Text Widget');
    $footer_text_description = __('Displays infromation about this site in the footer.');
    $widget_ops = array('classname' => 'footer_text', 'description' => $footer_text_description );
    $this->WP_Widget('footer_text', $footer_text_name, $widget_ops);
  }  
  
  function widget($args, $instance) { 
  ?>
   <div id="footer-logo">
     <a href="http://wordpress.org/" rel="nofollow">
       <img src="<?php bloginfo('template_url') ?>/images/wordpress-logo.png" height='100' width='100' alt="WordPress Logo" />
     </a>
   </div>

    <div id="footer_text">
      <p>
        Copyright &copy; 1980 – <?php echo date("Y") ?> by <a href="http://mattrude.com/">Matt Rude</a><br />
        Site Designed by <a href="http://mattrude.com/">Matt Rude</a>.<br />
        Proudly powered by <a href="http://wordpress.org/" rel="nofollow">WordPress</a>.<br />
        This page took <?php timer_stop(1); ?> seconds of computer labor,<br/>
        and required <?php echo get_num_queries(); ?> questions to produce.<br />
        <?php global $Panel; echo $Panel->Settings('FooterText'); ?><br />
      </p>
    </div><?php 
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

add_action('widgets_init', 'footer_text_init');
function footer_text_init() {
        register_widget('footer_text');
}

?>
