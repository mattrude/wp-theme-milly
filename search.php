<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) { ?>
		<!--This is "The Loop"-->
		<div class="tag-head post">
			<h1>Search Results for: <?php the_search_query(); ?></h1>
		</div>
		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h1 class="single-title entry-title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h1>
				<p class="byline">
					<span class="byline-prep byline-prep-author text">Posted on </span>
					<span class="published"><?php the_time('F jS, Y') ?></span>
					<?php if ( get_post_type() == 'technology' ) {
					    echo "<span>";
					    echo get_the_term_list( $post->ID, 'tech_category', ' | Filed Under: ', ', ', '' );
					    echo get_the_term_list( $post->ID, 'tech_tag', ' | Tagged as: ', ', ', '' );
					    echo "</span>";
				        } elseif ( get_post_type() == 'post' ) { ?>
					    <span > | Filed Under: <?php the_category(', '); the_tags(' | Tagged as: ', ', ', ''); ?></span>
					<?php } ?>
					<span ><?php edit_post_link(' | Edit', ''); ?></span>
				</p>
			</div><!--close post class and post# id-->
		<?php endwhile; ?>
		<!--The Loop has ended-->	
		<?php milly_pre_next_post_cat(); ?>
	<?php } else { ?>
		<div class="post">
			<h1 class="entry-title"><?php _e( 'Nothing Found' ); ?></h1>
			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.' ); ?></p>
                        <?php get_search_form(); ?>
		</div>
	<?php } ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
