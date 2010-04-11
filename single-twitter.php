<?php get_header();

global $Panel;
$twitterid = $Panel->Settings('TwitterID');
$twittername = $Panel->Settings('TwitterName'); ?>

<div id='content'>
  <?php $pageposts = $wpdb->get_results($querystr, OBJECT); ?>
  <?php setup_postdata($post); ?>
  <?php global $post; ?>
  <div class="post" id="tweet_template-<?php echo $post->ID; ?>">
    <div id='tweet-<?php echo $post->ID; ?>' class='tweet_post' >
      <img src="<?php bloginfo('template_url'); ?>/images/twitter-bird.png" class='tweet-image' width="60" height="60" style='margin-right: 5px;' alt='Twitter bird' />
      <?php the_content(); ?>
    </div>
    <div id='tweet_date-<?php echo $post->ID; ?>' class='byline tweet_date' >
      <?php 
      //$tweet_id = get_post_meta( $wp_query->post->ID, 'aktt_twitter_id', true );
      $post_id = $post->ID;
      $tweet_id = get_post_meta( $post_id, 'aktt_twitter_id', true);
      ?> Posted to <a href="http://twitter.com">Twitter</a> by <a href="http://twitter.com/<?php echo $twitterid; ?>"><?php echo $twittername; ?></a><?php
      if ($tweet_id) { 
        echo " on ";
        echo "<a href='http://twitter.com/$twitterid/status/$tweet_id'>";
        the_time('F jS, h:ma T Y ');
        echo "</a>";
      } else {
        echo " off ";
        the_time('F jS, h:ma T Y ');
      }
      edit_post_link('Edit', ' | '); ?>
    </div><!--close tweet_post class-->	
  </div><!--close post class-->
  <div class="navigation">
    <div class="txtalignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
    <div class="txtalignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
  </div>
</div><!--close content class-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>