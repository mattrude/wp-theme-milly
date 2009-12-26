<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>
		<!--This is "The Loop"-->
		<div class="tag-head post"
			<h1><?php single_tag_title('Posts Tagged as: '); ?></h1>
		</div>
		<div class="post" id="tag-list">
		<?php while (have_posts()) : the_post(); ?>
				<h2 class="single-title entry-title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h2>
		<?php endwhile; ?>
		</div><!--close post class and post# id-->
		<!--The Loop has ended-->	
		<div class="navigation">
                  <div class="txtalignleft"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
                  <div class="txtalignright"><?php next_posts_link('Older Entries &raquo;') ?></div>
		</div>
	<?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
