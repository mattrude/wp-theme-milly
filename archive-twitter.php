<?php get_header();

global $Panel;
$twitterid = $Panel->Settings('TwitterID');
$twittername = $Panel->Settings('TwitterName');
$twittercount = $Panel->Settings('TwitterCount');
$twitterimgenabled = $Panel->Settings('TwitterImgEnabled');
$t=new twitterImage($twitterid);

?>
<div id="content">
	<?php if (have_posts()) : ?>
		<!--This is "The Loop"-->
		<?php while (have_posts()) : the_post(); ?>
  <div class="post" id="tweet_template-<?php echo $post->ID; ?>">
    <div id='tweet-<?php echo $post->ID; ?>' class='tweet_post' >
    <?php
        if ( $twitterimgenabled == 'true' ) {
          $t->profile_image(true,true);
        } else {
           ?><img src="<?php echo get_template_directory_uri(); ?>/images/twitter-bird.png" class='tweet-image' width="60" height="60" style='margin-right: 5px;' alt='Twitter bird' /><?php
        }
      the_content(); ?>
    </div>
      <?php milly_twiiter_byline(); ?>
  </div>


	<?php endwhile; ?>
		<!--The Loop has ended-->	
		<?php milly_pre_next_post_cat(); ?>
	<?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
