<?php get_header(); ?>

<div id="content">
  <?php if (have_posts()) : while (have_posts()) : the_post();
    include('functions/post-full.php');
    comments_template();
    include('navigation.php');
  endwhile; endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
