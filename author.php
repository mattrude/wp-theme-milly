<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>
		<!--This is "The Loop"-->
			<?php if(isset($_GET['author_name'])) :
				$curauth = get_userdatabylogin($author_name);
			else :
				$curauth = get_userdata(intval($author));
			endif; ?>

		<div class="author-head post"> <?php
			echo "<h1>";
			_e('Posts written by ');
			echo $curauth->display_name;
			echo "</h1>";
			if ($curauth->twitter or $curauth->facebook) {
				if ($curauth->user_url) {
					_e('You may also follow'); ?> 
					<a href="<?php echo $curauth->user_url;?>"><?php echo $curauth->first_name; ?></a><?php 
					_e(' on ');
				} else {
					_e('You may also follow');
					echo $curauth->first_name;
					_e(' on ');
				} ?>
				<?php if ($curauth->twitter){
					_e('Twitter as '); ?>
					<strong><a rel="nofollow" href="http://twitter.com/<?php echo $curauth->twitter; ?>">@<?php echo $curauth->twitter; ?></a></strong>
					<?php if ($curauth->facebook) {
						_e(' or ');
					}
				}
				if ($curauth->facebook) {
				_e('on Facebook as '); ?>
				<strong><a rel="nofollow" href="http://www.facebook.com/<?php echo $curauth->facebook; ?>"><?php echo $curauth->facebook; ?></a></strong>.
				<?php } ?>
			<?php } ?>
		</div>
		<?php while (have_posts()) : the_post();
	        if ( in_category( 'gallery' )) {
	                include('functions/gallery-index.php');
	        } elseif ( in_category( 'tweets' )) {
	                include('functions/twitter-index.php');
	        } else {
			milly_post_full();
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
