<?php /* Template Name: Twitter Page */ ?>
<?php get_header();

global $Panel;
$twitterid = $Panel->Settings('TwitterID');
$twittername = $Panel->Settings('TwitterName');
$twittercount = $Panel->Settings('TwitterCount');
$twitterimgenabled = $Panel->Settings('TwitterImgEnabled');
$t=new twitterImage($twitterid);

echo "<div id='content'>";
global $wp_query;
$wp_query = new WP_Query("post_type=twitter&post_status=publish&posts_per_page=20");
while (have_posts()) : the_post();
    setup_postdata($post); ?>
    <?php global $post; ?>
    <div class="post" id="tweet_template-<?php echo $post->ID; ?>">
      <div id='tweet-<?php echo $post->ID; ?>' class='tweet_post' >
        <?php
        if ( $twitterimgenabled == 'true' ) {
          $t->profile_image(true,true);
        } else {
           ?><img src="<?php bloginfo('template_url'); ?>/images/twitter-bird.png" class='tweet-image' width="60" height="60" style='margin-right: 5px;' alt='Twitter bird' /><?php
        }
        the_content(); 
        ?>
      </div>
      <div id='tweet_date-<?php echo $post->ID; ?>' class='byline tweet_date' >
        <?php 
        $post_id = $post->ID;
        $tweet_id = get_post_meta( $post_id, 'aktt_twitter_id', true);
	?> Posted to <a href="http://twitter.com">Twitter</a> by <a href="http://twitter.com/<?php echo $twitterid; ?>"><?php echo $twittername; ?></a>, <?php
        if ($tweet_id) { 
          echo "<a href='http://twitter.com/$twitterid/status/$tweet_id'>";
          the_time('F jS, h:ma T Y ');
          echo "</a>";
        } else {
          the_time('F jS, h:ma T Y ');
        }
	edit_post_link('Edit', ' | '); ?>
      </div>	
    </div><!--close post class and post# id-->

<?php endwhile; ?>

</div><!--close content id-->

<?php get_sidebar(); ?>


<?php get_footer(); ?>
