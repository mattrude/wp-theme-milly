<div id="gallerypost-<?php the_ID(); ?>" class="gallerypost post">
    <div id="gallerypost_main-<?php the_ID(); ?>" class="gallerypost_main">
	<div id="gallerypost_thumbnail-<?php the_ID(); ?>" class="gallerypost_thumbnail">
		<a href="<?php the_permalink() ?>"><?php the_post_thumbnail() ?></a>
	</div>
	<div id="gallerypost_body-<?php the_ID(); ?>" class="gallerypost_body">
		<?php $images =& get_children( 'post_type=attachment&post_mime_type=image' ); ?>
		<h1><a rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<div><p class="byline">Posted by <?php the_author(); ?> on <?php the_time('F jS, Y') . edit_post_link('Edit', ' | '); ?></p></div>
		<div class="entry">
			<?php the_excerpt(); ?>
		</div>
	</div>
    </div>
    <div id="gallerypost_sub-<?php the_ID(); ?>" class="gallerypost_sub">
	<div id="gallerypost_sub_left-<?php the_ID(); ?>" class="gallerypost_sub_left">
		<p><?php echo get_the_term_list( $post->ID, 'people', 'Who: ', ', ', '<br />' ); ?></p>
		<p><?php echo get_the_term_list( $post->ID, 'events', 'What: ', ', ', '<br />' ); ?></p>
             	<p><?php echo get_the_term_list( $post->ID, 'places', 'Where: ', ', ', '' ); ?></p>
	</div>
	<div id="gallerypost_sub_right-<?php the_ID(); ?>" class="gallerypost_sub_right">
		This Album contains <?php echo $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_type = 'attachment'" ); ?> items.
	</div>
    </div>
</div>
