<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>
		<div class="author-head post">
			<h1>Posts Filed Under: <?php single_cat_title(); ?></h1>
		</div>
		<!--This is "The Loop"-->
		<?php while (have_posts()) : the_post(); ?>
		<? if ( is_category( 'gallery' )) {
			include('functions/gallery-index.php');
                } elseif ( is_category( 'tweets' )) {
			include('functions/twitter-index.php');
                } else {
			include('functions/post-full.php');
		}
		endwhile; ?>
		<!--The Loop has ended-->	
		<div class="navigation">
			<div class="txtalignleft"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
			<div class="txtalignright"><?php next_posts_link('Older Entries &raquo;') ?></div>
		</div>
	<?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

</div><!--close container id-->
