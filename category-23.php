<?php

get_header();

$cat_title = '<a href="'.get_category_link(intval(get_query_var('cat'))).'">'.single_cat_title('', false).'</a>'; ?>

<div id="content">
<div id="title" class="post">
	<h1>Matt Rude's Personal Photo Gallery</h1>
</div>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php include('functions/gallery-index.php'); ?>
<?php endwhile; else: ?>

<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>
</div>
<?php 
get_sidebar();

get_footer();

?>
