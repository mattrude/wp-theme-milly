<?php get_header(); ?>

<div id="content">
  <div class="author-head post">
    <h1>Posts Filed Under: <?php single_cat_title(); ?></h1>
  </div>
  <!--This is "The Loop"-->
  <?php while (have_posts()) : the_post();
    if ( is_category( 'gallery' )) {
      include('functions/gallery-index.php');
    } elseif ( is_category( 'tweets' )) {
      include('functions/twitter-index.php');
    } else {
      include('functions/post-full.php');
    } endwhile; ?>
  <!--The Loop has ended-->	
  <?php include('navigation-category.php'); ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
