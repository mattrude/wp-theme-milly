<?php get_header(); ?>

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
				} else {
					if ( in_category( 'gallery' ) ) {
                                        	set_post_format( $post->ID, 'gallery');
                               		} elseif ( in_category( 'aside' ) ) {
                                        	set_post_format( $post->ID, 'aside' );
					}
					milly_post_full();
				}
			} else {
				if ( in_category( 'gallery' ) ) {
					set_post_format( $post->ID, 'gallery');
					include( 'functions/gallery-index.php' );
                                } elseif ( in_category( 'aside' ) ) {
					set_post_format( $post->ID, 'aside' );
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
