<?php /* Template Name: Project Page */ ?>
<?php get_header(); ?>

	<div id="content">
		<div class="hfeed content">
		<?php if (function_exists('adsensem_ad')) { ?>
		<div class="post">
			<?php adsensem_ad('Projects'); ?><!--adsense--> 
		</div>
		<?php } ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h1 class="attr"><?php the_title(); ?></h1>
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
		<?php if (function_exists('adsensem_ad')) { ?>
		<div class="post">
			<?php adsensem_ad('Projects'); ?><!--adsense--> 
		</div>
		<?php } ?>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	<?php comments_template(); ?>
	<?php if (function_exists('adsensem_ad')) { ?>
	<div class="post">
		<?php adsensem_ad('Projects'); ?><!--adsense--> 
	</div>
	<?php } ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
