<div <?php post_class(); ?> id="tweet_template">
	<div id=tweet_post>
	<img src="<?php bloginfo('template_url'); ?>/images/twitter-logo.jpg" class='tweet-image' width="60" height="60" align='left' style='margin-right: 5px;' />
			<?php the_excerpt(); ?>
	</div>
	<div id=tweet_date>
		<?php global $wp_query; ?>
	 	<?php $tweet_id = get_post_meta( $wp_query->post->ID, 'aktt_twitter_id', true ); ?>
		Posted to <a href="http://twitter.com">Twitter</a> by <?php the_author_posts_link(); ?> on <a href="http://twitter.com/mdrude/status/<?php echo $tweet_id ?>"><?php the_time('F jS, h:ma T Y ') ?></a>
	</div>	
</div><!--close post class and post# id-->

