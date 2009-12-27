<?php require_once('header-simple.php'); ?>

<div id="image_content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="single"><!--Slightly different styling for single posts and single pages-->
		<?php if ( !empty($post->post_excerpt) ) {
		echo "<div class='post'><h3>";
		the_excerpt();
		echo "</h3></div>" ;// this is the "caption"
		} ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<small class="attr"><?php the_time('F jS, Y') ?></small>
			<!--<h1><?php the_title(); ?></h1>-->
			<div class="image_entry">
				<?php $image_full_url = wp_get_attachment_image_src( $post->ID, "full" ); ?>
				<p class="attachment"><a href="<?php echo $image_full_url[0]; ?>"><?php echo wp_get_attachment_image( $post->ID, array(894,894) ); ?></a></p>
				<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></div>
				<div class="description"><?php if ( !empty($post->post_content) ) post_content(); // this is the "description" ?></div>
	<div class="image-navigation">
		<div class="floatright">
		<?php $attachments = array_values(get_children( array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') ));
			foreach ( $attachments as $k => $attachment )
			  if ( $attachment->ID == $post->ID )
			    break;
		$attachments = array_values(get_children( array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') ));

		$next_url =  isset($attachments[$k+1]) ? get_permalink($attachments[$k+1]->ID) : get_permalink($attachments[0]->ID);
		$previous_url =  isset($attachments[$k-1]) ? get_permalink($attachments[$k-1]->ID) : get_permalink($attachments[0]->ID);
		?>
		<?php if ( wp_get_attachment_image( $post->ID+1 ) != null ) { ?>
		<p class="attachment">
			<?php _e('Next Image', 'mdr-milly-theme') ?><br />
			<a href="<?php echo $next_url; ?>"><?php echo wp_get_attachment_image( $post->ID+1, 'thumbnail' ); ?></a>
		</p>
		<?php } ?>

		<?php if ( wp_get_attachment_image( $post->ID-1 ) != null ) { ?>
		<p class="attachment">
			<?php _e('Previous Image', 'mdr-milly-theme') ?><br />
			<a href="<?php echo $previous_url; ?>"><?php echo wp_get_attachment_image( $post->ID-1, 'thumbnail' ); ?></a>
		</p>
		<?php } ?>
	</div>
				<p><a class="wrapper" href="<?php echo get_permalink($post->post_parent); ?>" rev="up post">&larr; <?php printf(__('back to &#8220;%s&#8221;', 'mdr-milly-theme'), get_the_title($post->post_parent)); ?></a></p>
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
	
</div><!--close entry class-->
<br />
</div><!--close post class & post# id-->
<div id="image-comments" >
  <?php comments_template(); ?>
</div>
</div>
</div><!--close single class-->
<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.', 'mdr-milly-theme') ?></p>
<?php endif; ?>
</div><!--close content id-->
<?php get_footer(); ?>
