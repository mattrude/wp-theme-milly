<?php get_header(); ?>

<?php if ( is_active_sidebar( 'top-widget-area' ) ) { echo "<div id='primary'>"; dynamic_sidebar( 'top-widget-area' ); echo "</div>"; } ?>

<div id="content">
	<?php if (have_posts()) : ?>
		<!--Starting "The Loop"-->
		<?php while (have_posts()) : the_post();
			if( function_exists( 'get_post_format' ) ) {
				$current_posts_format = get_post_format();
				if ( $current_posts_format == 'gallery' ) {
					include( 'functions/gallery-index.php' );
				} elseif ( $current_posts_format == 'aside' ) {
					milly_post_aside();
				} elseif ( $current_posts_format == 'image' ) {
					milly_post_aside();
				} elseif ( $current_posts_format == 'status' ) {
					milly_post_aside();
				} else {
					milly_post_full();
				}
			} else {
				if ( in_category( 'gallery' ) ) {
					include( 'functions/gallery-index.php' );
                                } elseif ( in_category( 'aside' ) ) {
                                        milly_post_aside();
				} else {
				        milly_post_full();
                                }
			}
		endwhile; ?>
		<!--The Loop has ended-->	
		<?php milly_pre_next_post_cat(); ?>
	<?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
