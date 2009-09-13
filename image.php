<?php require_once('header-simple.php'); ?>

<div id="image_content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="single"><!--Slightly different styling for single posts and single pages-->
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!--<h1><?php the_title(); ?></h1>-->
			<small class="attr"><?php the_time('F jS, Y') ?></small>
			<div class="image_entry">
				<p class="attachment"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></p>
				<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></div>
				<p><a class="wrapper" href="<?php echo get_permalink($post->post_parent); ?>" rev="up post">&larr; <?php printf(__('back to &#8220;%s&#8221;', 'carrington-blog'), get_the_title($post->post_parent)); ?></a></p>
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
	
	<!--
	<div class="navigation">
		<div class="floatleft"><?php previous_image_link('&laquo; %link') ?></div>
		<div class="floatright"><?php next_image_link('%link &raquo;') ?></div>
		<div class="clearfloatthick">&nbsp;</div>
	</div>
	-->
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
	</div><!--close single class-->
	
<?php comments_template(); ?>

<?php endwhile; else: ?>

	<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

	</div><!--close content id-->
<?php get_footer(); ?>
