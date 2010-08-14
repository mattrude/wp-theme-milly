<?php

function twitter_import() {
  require "twitter.lib.php";
  
  $username = "mdrude";
  $password = "master12";
  
  global $wp_query;
  $wp_query = new WP_Query("post_type=twitter&post_status=publish&posts_per_page=1");
  while (have_posts()) : the_post();
    setup_postdata($post); 
    global $post; 
    $old_post_id = $post->ID;
    $old_id = get_post_meta( $old_post_id, 'aktt_twitter_id', true);
  endwhile;
  
  $twitter = new Twitter($username, $password);
  $xml = $twitter->getUserTimeline("user_id=$username&since_id=$old_id");
  $twitter_status = new SimpleXMLElement($xml);
  global $user_ID;
  foreach($twitter_status->status as $status){
    if ( $status->id > $old_id ) {
      foreach($status->user as $user){
        $tweet_name = $user->name;
      }
      $tweet_text = $status->text;
      $tweet_created_at = $status->created_at;
      $tweet_date_gmt = date("Y-m-d H:i", strtotime($tweet_created_at));
      $tweet_id = $status->id;
      $new_post = array(
        'post_title' => $tweet_text,
        'post_content' => $tweet_text,
        'post_status' => 'publish',
        'post_date' => $tweet_date_gmt,
        'post_type' => 'twitter'
      );
      $post_id = wp_insert_post($new_post);
      add_post_meta($post_id, 'aktt_twitter_id', "$tweet_id");
      add_post_meta($post_id, 'twitter_id', "$tweet_id");
      add_post_meta($post_id, 'twitter_name', "$tweet_name");
      add_post_meta($post_id, 'twitter_user', "$username");
      $post_date = array(
        'ID' => $post_id,
        'post_date_gmt' => $tweet_date_gmt
      );
      wp_update_post( $post_date );
    }
  }
}

add_filter('cron_schedules', 'cron_add_milly'); 
function cron_add_milly( $schedules )
{
	$schedules['milly'] = array(
		'interval' => 300,
		'display' => __('Every 5 Mins')
	);
	return $schedules;
}

if (!wp_next_scheduled('twitter_import_hook')) {
  echo "Updating schedule";
  wp_schedule_event( time(), 'milly', 'twitter_import_hook' );
}

add_action( 'twitter_import_hook', 'twitter_import' );

twitter_import();
?>
