<?php /*
Example template
Author: mitcho (Michael Yoshitaka Erlewine)
*/ 
?>
<?php if ($related_query->have_posts()):?>
<h3>Related Posts</h3>
<ol>
	<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
	<li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><!-- (<?php the_score(); ?>)--></li>
	<?php endwhile; ?>
</ol>
<?php endif; ?>
