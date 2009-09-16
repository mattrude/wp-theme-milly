<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>
		<!--This is "The Loop"-->
		<?php while (have_posts()) : the_post(); ?>
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<h1 class="single-title entry-title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h1>
				<p class="byline">
					<span class="byline-prep byline-prep-author text">Posted on </span>
					<span class="published"><?php the_time('F jS, Y') ?></span>
					<span >filed under <?php the_category(', ') ?> | <?php the_tags('Tags: ', ', ', ''); ?> | <?php edit_post_link('Edit', ''); ?></span>
				</p>
			</div><!--close post class and post# id-->
		<?php endwhile; ?>
		<!--The Loop has ended-->	
		<div class="navigation">
			<div class="txtalignleft"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
			<div class="txtalignright"><?php next_posts_link('Older Entries &raquo;') ?></div>
		</div>
	<?php else : ?>
		<h2 class="center">Oops! Couldn't find what you were looking for. Maybe you'll want to search for it:</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	<?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

</div><!--close container id-->
