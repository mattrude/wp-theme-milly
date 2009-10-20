<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<?php if ( is_sticky() ) {
} else { ?>

	<h1 class="single-title entry-title">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</h1>
	<p class="byline">
		<span class="byline-prep byline-prep-author text">Posted by </span>
		<span class="author vcard"><?php the_author_posts_link(); ?></span>
		<span class="byline-prep byline-prep-author text"> on </span>
		<span class="published"><?php the_time('F jS, Y') ?></span>
		<span > | Filed Under: <?php the_category(', '); the_tags(' | Tagged as: ', ', ', ''); ?></span>
		<span><?php edit_post_link('Edit', ' | '); ?></span>
	</p>
<?php } ?>
<div class="entry-content entry">
	<?php the_excerpt(); ?>
</div><!--close entry class-->
</div><!--close post class-->
