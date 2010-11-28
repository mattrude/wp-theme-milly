<?php get_header();

global $Panel;
$twitterid = $Panel->Settings('TwitterID');
$twittername = $Panel->Settings('TwitterName');
$twittercount = $Panel->Settings('TwitterCount');
$twitterimgenabled = $Panel->Settings('TwitterImgEnabled');
$t=new twitterImage($twitterid);

?>
<div id='content'>
  <?php $pageposts = $wpdb->get_results($querystr, OBJECT); ?>
  <?php setup_postdata($post); ?>
  <?php global $post; ?>
  <div class="post" id="tweet_template-<?php echo $post->ID; ?>">
    <div id='tweet-<?php echo $post->ID; ?>' class='tweet_post' >
    <?php
        if ( $twitterimgenabled == 'true' ) {
          $t->profile_image(true,true);
        } else {
           ?><img src="<?php bloginfo('template_url'); ?>/images/twitter-bird.png" class='tweet-image' width="60" height="60" style='margin-right: 5px;' alt='Twitter bird' /><?php
        }
      the_content(); ?>
    </div>
      <?php milly_twiiter_byline(); ?>
  </div><!--close post class-->
</div><!--close content class-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
