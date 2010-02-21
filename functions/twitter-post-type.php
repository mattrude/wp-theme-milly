<?php

// Change all post in category Twitter to post type twitter
global $Panel;
$TwitterEnabled = $Panel->Settings('TwitterEnabled');
$TwitterCategory = $Panel->Settings('TwitterCategory');

//echo $TwitterEnabled;
//echo $TwitterCategory;

if ( $TwitterEnabled == 'true' ) {
  //echo " enabled";
  if ( $TwitterCategory ) {
    //echo " set";
    if ( $TwitterCategory != 1 ) {
      //echo " !=1 - ";
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
    //      echo $mdr_postid;
          $wpdb->query("UPDATE $wpdb->posts SET post_type = 'twitter' WHERE ID = $mdr_postid");
          $wpdb->query("UPDATE $wpdb->term_taxonomy SET count = 0 WHERE term_id = '$TwitterCategory'");
        }
      }
      milly_twitter_post_type();
    }
  }
}

?>
