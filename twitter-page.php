<?php /* Template Name: Twitter Page */ ?>
<?php get_header(); ?>

<div id="content">
	 <?php query_posts('category_name=tweets&posts_per_page=20');
	if (have_posts()) : while (have_posts()) : the_post();
		include('functions/twitter-index.php');
	endwhile; ?>
	<div class="navigation">
		<div class="txtalignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
		<div class="txtalignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
	</div>
	<?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
