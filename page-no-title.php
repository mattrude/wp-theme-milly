<?php /* Template Name: No Title Page */ ?>
<?php get_header(); ?>

	<div id="content">
		<div class="hfeed content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<!--Add Related Entries if Yet Another Related Posts Plugin is installed-->
				<?php global $wp_query; ?>
                        	<?php $related_entries = get_post_meta( $wp_query->post->ID, 'Display Related Entries', true ); ?>
				<?php if (function_exists('related_entries')) { 
					if ($related_entries == '1') {
						echo related_entries();
					}
				}?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
			</div>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	<?php comments_template(); ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
