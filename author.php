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
					Twitter as <strong><a href="http://twitter.com/<?php echo $curauth->twitter; ?>">@<?php echo $curauth->twitter; ?></a></strong>
					<?php if ($curauth->facebook) { ?>
						or
					<?php } ?>
				<?php } ?>
				<?php if ($curauth->facebook) { ?>
				on Facebook as <strong><a href="http://www.facebook.com/<?php echo $curauth->facebook; ?>"><?php echo $curauth->facebook; ?></a></strong>.
				<?php } ?>
			<?php } ?>
		</div>
		<?php while (have_posts()) : the_post(); ?>
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<h1 class="single-title entry-title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h1>
				<p class="byline">
					<span class="byline-prep byline-prep-author text">Posted on </span>
					<span class="published"><?php the_time('F jS, Y') ?></span>
					<span >Filed Under: <?php the_category(', ') . the_tags(' | Tags: ', ', ', ''); ?><?php edit_post_link('Edit', ' | '); ?></span>
				</p>
			</div><!--close post class and post# id-->
		<?php endwhile; ?>
		<!--The Loop has ended-->	
		<div class="navigation">
			<div class="txtalignleft"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
			<div class="txtalignright"><?php next_posts_link('Older Entries &raquo;') ?></div>
		</div>
	<?php endif; ?>
</div><!--close content id-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

</div><!--close container id-->
