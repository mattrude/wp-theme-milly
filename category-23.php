<?php

get_header();

$cat_title = '<a href="'.get_category_link(intval(get_query_var('cat'))).'">'.single_cat_title('', false).'</a>'; ?>

<div id="content">
<div id="title" class="post">
	<h1>Matt Rude's Personal Photo Gallery</h1>
</div>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="gallerypost-<?php the_ID(); ?>" class="gallerypost post">
		<div id="gallerypost_main-<?php the_ID(); ?>" class="gallerypost_main">
		<div id="gallerypost_thumbnail-<?php the_ID(); ?>" class="gallerypost_thumbnail">
			<?php global $wp_query; ?>
			<?php $gallery_thumbnail = get_post_meta( $wp_query->post->ID, 'gallery thumbnail', true ); ?>
			<a href="<?php the_permalink() ?>" rel="bookmark"><img src="<?php echo $gallery_thumbnail; ?>" alt="<?php echo get_post_meta( $post->ID, 'gallery thumbnail', true); ?> Gallery" border='1' color='000' align='left' style='margin-right: 5px;' /></a>
		</div>
		<div id="gallerypost_body-<?php the_ID(); ?>" class="gallerypost_body">
			<?php $images =& get_children( 'post_type=attachment&post_mime_type=image' ); ?>
			<h2><a rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="attr"><small>Written by <?php the_author() ?> on <?php the_time('F jS, Y') ?></small></div>
			<div class="entry">
				<?php the_excerpt(); ?>
			</div>
		</div>
		</div>
		<div id="gallerypost_sub-<?php the_ID(); ?>" class="gallerypost_sub">
			<div id="gallerypost_sub_left-<?php the_ID(); ?>" class="gallerypost_sub_left">
				<p><?php echo get_the_term_list( $post->ID, 'people', 'Who: ', ', ', '<br />' ); ?></p>
				<p><?php echo get_the_term_list( $post->ID, 'places', 'Where: ', ', ', '' ); ?></p>
			</div>
			<div id"gallerypost_sub_right-<?php the_ID(); ?>" class="gallerypost_sub_right">
				This Album contains <?php echo $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_type = 'attachment'" ); ?> items.
			</div>
		</div>
	</div>
<?php endwhile; else: ?>

<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>
</div>
<?php 
get_sidebar();

get_footer();

?>
