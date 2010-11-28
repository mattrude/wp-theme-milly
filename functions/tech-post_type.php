<?php

add_action('init','Technology_post_type_init');
function Technology_post_type_init() {
  $args = array(
    'labels' => array(
        'name' => __('Technology'),
    ),
    'public' => true,
    'has_archive' => true,
    'show_ui' => true,
    'rewrite' => array('slug' => 'technology'),
    'supports' => array('title', 'editor'),
    'feed' => true,
  );
  register_post_type('technology',$args);
}

?>
