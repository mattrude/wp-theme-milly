<?php /* Template Name: Twitter Page */ ?>
<?php get_header();

add_filter( 'pre_get_posts', 'my_get_posts' );
function my_get_posts( $query ) {
	$query->set( 'post_type', 'twitter' );
	return $query;
} ?>
<div id="content">
  <?php query_posts('posts_per_page=20');
  if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div <?php post_class(); ?> id="tweet_template-<?php echo $wp_query->post->ID; ?>">
      <div id='tweet-<?php echo $wp_query->post->ID; ?>' class='tweet_post' >
        <img src="<?php bloginfo('template_url'); ?>/images/twitter-bird.png" class='tweet-image' width="60" height="60" style='margin-right: 5px;' alt='Twitter bird' />
        <?php the_content(); ?>
      </div>
      <div id='tweet_date-<?php echo $wp_query->post->ID; ?>' class='byline tweet_date' >
        <?php global $wp_query; ?>
        <?php $tweet_id = get_post_meta( $wp_query->post->ID, 'aktt_twitter_id', true ); ?>
        -Posted to <a href="http://twitter.com">Twitter</a> by <?php the_author_posts_link(); ?> on <a href="http://twitter.com/mdrude/status/<?php echo $tweet_id ?>"><?php the_time('F jS, h:ma T Y ') ?></a>
	<?php edit_post_link('Edit', ' | '); ?>
      </div>	
    </div><!--close post class and post# id-->
  <?php endwhile; ?>
  <div class="navigation">
    <div class="txtalignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
    <div class="txtalignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
  </div>
  <?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
