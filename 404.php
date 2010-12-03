<?php get_header(); ?>

<div id="content">
  <div class="page">
    <h2 class="center"><center><?php _e('Oops! - 404 Error'); ?></center></h2> 
    <p class="center"><center><?php _e('No sense sticking around here for very long. Check out the sidebar where you will be able to search, or checkout my'); ?> <a href="<?php bloginfo('url'); ?>/category/gallery/"><?php _e('Photo Gallery'); ?></a> <?php _e('or'); ?> <a href="<?php bloginfo('url'); ?>/technology/"><?php _e('Technology'); ?></a> <?php _e('section if your into those sorts of things. If you feel you\'ve reached this page as an error on my part, please'); ?> <a href="<?php bloginfo('url'); ?>/contact-me/"><?php _e('contact me'); ?></a>.</center></p>
    <center><img src="<?php bloginfo('template_url') ?>/images/404.jpg"></center>

  </div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
</div>
