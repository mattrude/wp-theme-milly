<?php get_header(); ?>

<div id="content">
  <?php if (have_posts()) : while (have_posts()) : the_post();
    if ( function_exists(‘get_shortlink’) ) : ?> | <a href="" rel=”shortlink”>Shortlink</a> <?php else : endif;
    milly_post_full();
    comments_template();
    milly_pre_next_post();
  endwhile; endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
