<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>
		<!--This is "The Loop"-->
		<?php while (have_posts()) : the_post();
			if ( in_category( 'gallery' )) {
				include('functions/gallery-index.php');
			} else {
				include('functions/post-full.php');
			}
		endwhile; ?>
		<!--The Loop has ended-->	
		<?php include('navigation-category.php'); ?>
	<?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
