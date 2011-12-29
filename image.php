<?php require_once('header-simple.php'); ?>

<div id="image_content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php if ( ! get_post_meta($post->ID, 'sharing_disabled') ) { add_post_meta($post->ID, 'sharing_disabled', '1'); }; ?>
	<?php if ( !empty($post->post_excerpt) ) {
		  echo "<div class='post'><div class='comment-title'><h2>";
		  the_excerpt();
		  echo "</h2></div>";
		  the_content();
		  echo "</div>" ;// this is the "caption"
	} ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<small class="attr"><?php the_time('F jS, Y') ?></small>
		<?php $image_full_url = wp_get_attachment_image_src( $post->ID, "full" ); ?>
		<p class="attachment"><a href="<?php echo $image_full_url[0]; ?>"><?php echo wp_get_attachment_image( $post->ID, array(894,894) ); ?></a></p>
		<div class="floatright">
			<?php $attachments = array_values(get_children( array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') ));
			foreach ( $attachments as $k => $attachment )
			  if ( $attachment->ID == $post->ID )
			    break;

			$attachments = array_values(get_children( array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') ));
			$next_url =  isset($attachments[$k+1]) ? get_permalink($attachments[$k+1]->ID) : get_permalink($attachments[0]->ID);
			$previous_url =  isset($attachments[$k-1]) ? get_permalink($attachments[$k-1]->ID) : get_permalink($attachments[0]->ID);
			if ( wp_get_attachment_image( $post->ID+1 ) != null ) { ?>
				<p class="attachment">
					<?php _e('Next Image', 'milly') ?><br />
					<a href="<?php echo $next_url; ?>"><?php echo wp_get_attachment_image( $post->ID+1, 'thumbnail' ); ?></a>
				</p>
			<?php }

			if ( wp_get_attachment_image( $post->ID-1 ) != null ) { ?>
				<p class="attachment">
					<?php _e('Previous Image', 'milly') ?><br />
					<a href="<?php echo $previous_url; ?>"><?php echo wp_get_attachment_image( $post->ID-1, 'thumbnail' ); ?></a>
				</p>
			<?php } ?>
			<?php edit_post_link('Edit Image'); ?>
               	</div>
		<div class="image-meta">
			<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></div>
				<p><a class="wrapper" href="<?php echo get_permalink($post->post_parent); ?>" rev="up post">&larr; <?php printf(__('back to &#8220;%s&#8221;', 'mdr-milly-theme'), get_the_title($post->post_parent)); ?></a></p>
				<div id="community-tags">
					<h3 class="comment-title exif-title">Who is this?</h3>	
					<div id="tagthis"></div>
				</div>
				<p><?php echo get_the_term_list( $post->ID, 'people', '<br />' .__('Already Tagged', 'milly'). ': ', ', ', '' ); ?></p>
			</div><!--close caption id-->
		        <?php mdr_exif(); ?>
			<br />
		<div id="image-comments" >
		<?php comments_template(); ?>
		</div><!--close post class & post# id-->
	</div>
	<br />
</div><!--close image_content id-->

<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.', 'milly') ?></p>
<?php endif; ?>

</div><!--close content id-->

<?php get_footer(); ?>
