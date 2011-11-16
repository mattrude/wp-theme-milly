<?php get_header();

global $Panel;
$twitterid = $Panel->Settings('TwitterID');
$twittername = $Panel->Settings('TwitterName');
$twittercount = $Panel->Settings('TwitterCount');
$twitterimgenabled = $Panel->Settings('TwitterImgEnabled');

$twitter_image_url = wp_cache_get( 'twitter_image_url' );
if ( false == $twitter_image_url ) {
  $twitterid = $ozh_ta['screen_name'];
  $xml = simplexml_load_file("http://twitter.com/users/".$twitterid.".xml");
  $twitter_image_url = (string)$xml->profile_image_url;
  wp_cache_set( 'twitter_image_url', $twitter_image_url );
}

?>
<div id="content">
	<?php if (have_posts()) : ?>
		<!--This is "The Loop"-->
		<?php while (have_posts()) : the_post(); ?>
  <div class="post" id="tweet_template-<?php echo $post->ID; ?>">
    <div id='tweet-<?php echo $post->ID; ?>' class='tweet_post' >
    <?php echo "<div class='twitter-avatar'><img src=$twitter_image_url></div>";
      the_content(); ?>
    </div>
      <?php milly_twitter_byline(); ?>
  </div>


	<?php endwhile; ?>
		<!--The Loop has ended-->	
		<?php milly_pre_next_post_cat(); ?>
	<?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
