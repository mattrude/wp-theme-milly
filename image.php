<?php require_once('header-simple.php'); ?>

<div id="image_content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="single"><!--Slightly different styling for single posts and single pages-->
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!--<h1><?php the_title(); ?></h1>-->
			<small class="attr"><?php the_time('F jS, Y') ?></small>
			<div class="image_entry">
				<p class="attachment"><?php echo wp_get_attachment_image( $post->ID, array(930,930) ); ?></p>
				<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></div>
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

		<p class="attachment">
			Next Image<br />
			<a href="<?php echo $next_url; ?>"><?php echo wp_get_attachment_image( $post->ID+1, 'thumbnail' ); ?></a>
		</p>
		<p class="attachment">
			Previous Image<br />
			<a href="<?php echo $previous_url; ?>"><?php echo wp_get_attachment_image( $post->ID-1, 'thumbnail' ); ?></a>
		</p>
	</div>
				<p><a class="wrapper" href="<?php echo get_permalink($post->post_parent); ?>" rev="up post">&larr; <?php printf(__('back to &#8220;%s&#8221;', 'carrington-blog'), get_the_title($post->post_parent)); ?></a></p>
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
	
			</div><!--close entry class-->
			<br />
					<small>
						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							<!--You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.-->
	
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.
	
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							You can skip to the end and leave a response. Pinging is currently not allowed.
	
						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							Both comments and pings are currently closed.
	
						<?php } ?>
					</small>
				</p><!--close p.postmetadata alt-->
		</div><!--close post class & post# id-->
	
<div id="image-comments" >
	<?php comments_template(); ?>
</div>
	</div><!--close single class-->

<?php endwhile; else: ?>

	<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

	</div><!--close content id-->
<?php get_footer(); ?>
