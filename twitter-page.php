<?php /* Template Name: Twitter Page */ ?>
<?php get_header();

?><div id="content"><?php
 $querystr = "
    SELECT wposts.* 
    FROM $wpdb->posts wposts
    WHERE 
    wposts.post_status = 'publish' 
    AND wposts.post_type = 'twitter' 
    AND wposts.post_date < NOW() 
    ORDER BY wposts.post_date DESC
 ";

 $pageposts = $wpdb->get_results($querystr, OBJECT); ?>
 <?php if ($pageposts): ?>
  <?php foreach ($pageposts as $post): ?>
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
	?> Posted to <a href="http://twitter.com">Twitter</a> by <?php the_author_posts_link(); ?> on <a href="http://twitter.com/mdrude/status/<?php echo $tweet_id ?>"><?php the_time('F jS, h:ma T Y ') ?></a>
	<?php edit_post_link('Edit', ' | '); ?>
      </div>	
    </div><!--close post class and post# id-->
  <?php endforeach; ?>
 <div class="navigation">
 <div class="txtalignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
   <div class="txtalignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
 </div>
 <?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
