<?php

// Change all post in category Twitter to post type twitter
global $Panel;
$TwitterEnabled = $Panel->Settings('TwitterEnabled');
$TwitterCategory = $Panel->Settings('TwitterCategory');

if ( $TwitterEnabled == 'true' ) {
  if ( $TwitterCategory ) {
    if ( $TwitterCategory != 1 ) {
      function milly_twitter_post_type() {
        global $wpdb, $Panel;
        $TwitterCategory = $Panel->Settings('TwitterCategory');
        $TwitterCatSlug = $wpdb->get_row("SELECT * FROM $wpdb->terms WHERE term_id = $TwitterCategory");
          $args = array(
            'numberposts' => -1,
            'category_name' => $TwitterCatSlug->slug,
            'post_type' => 'post'
         );
        $mdr_postslist = get_posts($args);
        foreach ($mdr_postslist as $post) {
          $mdr_postid = $post->ID;
          if ($mdr_postid > 0) {
            $wpdb->query("UPDATE $wpdb->posts SET post_type = 'twitter' WHERE ID = $mdr_postid");
            $wpdb->query("DELETE FROM $wpdb->term_relationships WHERE object_id = $mdr_postid");
            $wpdb->query("UPDATE $wpdb->term_taxonomy SET count = 0 WHERE term_id = '$TwitterCategory'");
          }
        }
      }
      milly_twitter_post_type();
    }
  }
}

?>
