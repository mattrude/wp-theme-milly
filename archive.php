<?php get_header(); ?>

<div id="content">
	<?php
	if (have_posts()) : ?>
		<!--This is "The Loop"-->
		<?php while (have_posts()) : the_post();
			if ( in_category( 'gallery' )) {
				include('functions/gallery-index.php');
			} else {
				milly_post_full();
			}
		endwhile; ?>
		<!--The Loop has ended-->	
		<?php milly_pre_next_post_cat();
	endif;
	query_posts( array( 'post_type' => 'attachment' ) );
	have_posts();
	if (have_posts()) : ?>
		<!--This is "The Loop"-->
		<?php while (have_posts()) : the_post();
			echo "test";
			the_content();
		endwhile; ?>
		<!--The Loop has ended-->	
		<?php milly_pre_next_post_cat();
	endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
