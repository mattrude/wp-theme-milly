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
					<span class="byline-prep byline-prep-author text">Posted by </span>
					<span class="author vcard"><?php the_author_posts_link(); ?></span>
					<span class="byline-prep byline-prep-published text"> on </span>
					<span class="published"><?php the_time('F jS, Y') ?></span>
				</p>
				<div class="entry-content entry">
					<?php
					// If post excerpt exists, show that, otherwise, show content
					if($post->post_excerpt != '')
						the_excerpt();
					else
						the_content('Click to continue &raquo;');
					?>
				</div><!--close entry class-->
			</div><!--close post class and post# id-->
		<?php endwhile; ?>
		<!--The Loop has ended-->	
		<div class="navigation">
			<div class="txtalignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="txtalignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
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
