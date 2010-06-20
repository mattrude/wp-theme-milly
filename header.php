<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
  <link rel='shortcut icon' href='<?php bloginfo('template_url') ?>/images/favicon.ico' />
  <?php wp_head(); ?>
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <?php if ( $paged != '0' ) {
    ?><title><?php wp_title(' - ', true, 'right'); ?><?php bloginfo('name'); echo " - Page $paged" ?></title><?php
  } else {
    ?><title><?php wp_title(' - ', true, 'right'); ?><?php bloginfo('name'); ?></title><?php
  } ?>
  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
  <?php if (function_exists('google_webmaster_tools')) { google_webmaster_tools(); } ?>
  <!--This is a plugin hook-->
  <?php wp_head(); ?>
</head>

<body>
  <?php if (function_exists('google_analytics')) { google_analytics(); } ?>
  <div id="wrapper" >
    <div id="header-title">
      <div id="site-title">
        <a class="standard" href="<?php bloginfo('url'); ?>"><b><?php bloginfo('description'); ?></b></a>
      </div>
    </div>
    <div id="header">
      <img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
    </div>
    <div id="access">
      <?php /* The navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assiged
      to the primary position is the one used. If none is assigned, the menu with the lowest ID is used.  */
      wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu-header', 'theme_location' => 'header', 'fallback_cb' => 'milly_nav_fallback' ) ); ?>
    </div>
  <div id="container">
