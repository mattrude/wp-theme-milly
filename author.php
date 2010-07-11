<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>
		<!--This is "The Loop"-->
			<?php if(isset($_GET['author_name'])) :
				$curauth = get_userdatabylogin($author_name);
			else :
				$curauth = get_userdata(intval($author));
			endif; ?>

		<div class="author-head post">
			<h1>Posts written by <?php echo $curauth->display_name; ?></h1>
			<?php if ($curauth->twitter or $curauth->facebook) { ?>
				<?php if ($curauth->user_url) { ?>
					You may also follow <a href="<?php echo $curauth->user_url;?>"><?php echo $curauth->first_name; ?></a> on 
				<?php } else { ?>
					You may also follow <?php echo $curauth->first_name; ?> on 
				<?php } ?>
				<?php if ($curauth->twitter){ ?>
					Twitter as <strong><a rel="nofollow" href="http://twitter.com/<?php echo $curauth->twitter; ?>">@<?php echo $curauth->twitter; ?></a></strong>
					<?php if ($curauth->facebook) { ?>
						or
					<?php } ?>
				<?php } ?>
				<?php if ($curauth->facebook) { ?>
				on Facebook as <strong><a rel="nofollow" href="http://www.facebook.com/<?php echo $curauth->facebook; ?>"><?php echo $curauth->facebook; ?></a></strong>.
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
