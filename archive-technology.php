<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>
		<!--This is "The Loop"-->
		<?php while (have_posts()) : the_post();
			if ( in_category( 'gallery' )) {
				include('functions/gallery-index.php');
			} else {
				milly_post_full();
			}
		endwhile; ?>
		<!--The Loop has ended-->	
		<?php milly_pre_next_post_cat(); ?>
	<?php endif; ?>
</div><!--close content id-->

<div id="primary" class="aside">
        <?php dynamic_sidebar('technology-widget-area'); ?>
</div>

<?php get_footer(); ?>
