<?php get_header(); ?>

<div id="content">
  <?php if (have_posts()) : ?>
    <!--This is "The Loop"-->
    <?php while (have_posts()) : the_post(); ?>
      <div class="post" id="tweet_template-<?php echo $post->ID; ?>">
        <div id='tweet-<?php echo $post->ID; ?>' class='tweet_post' >
          <div class='twitter-avatar'><img src=<?php milly_twitter_image_url(); ?>></div>
          <?php the_content(); ?>
        </div><!--close tweet id-->
        <?php milly_twitter_byline(); ?>
      </div><!--close post id-->
    <?php endwhile; ?>
    <!--The Loop has ended-->	
    <?php milly_pre_next_post_cat(); ?>
  <?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
