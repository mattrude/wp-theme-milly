<?php get_header(); ?>

<div id="content">
  <!--<div class="author-head post"><h1>Posts Filed Under: <?php single_cat_title(); ?></h1></div>-->
  <!--This is "The Loop"-->
  <?php while (have_posts()) : the_post();
    if ( is_category( 'gallery' )) {
      include('functions/gallery-index.php');
    } else {
      milly_post_full();
    } endwhile; ?>
  <!--The Loop has ended-->	
  <?php milly_pre_next_post_cat(); ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
