<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
  <link rel='shortcut icon' href='<?php echo get_template_directory_uri(); ?>/images/favicon.ico' />
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <?php if ( $paged != '0' ) {
    ?><title><?php wp_title(' - ', true, 'right'); ?><?php bloginfo('name'); echo " - Page $paged" ?></title><?php
  } else {
    ?><title><?php wp_title(' - ', true, 'right'); ?><?php bloginfo('name'); ?></title><?php
  } ?>
  <link rel="alternate" type="application/rss2+xml" title="<?php bloginfo('name'); ?> &raquo; RSS 2 Feed" href="<?php echo home_url(); ?>/feed/rss2/" />
  <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> &raquo; Atom Feed" href="<?php echo home_url(); ?>/feed/atom/" />
  <link rel="alternate" type="application/rss2+xml" title="<?php bloginfo('name'); ?> &raquo; RSS 2 Comments Feed" href="<?php echo home_url(); ?>/comments/feed/rss2/" />
  <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> &raquo; Atom Comments Feed" href="<?php echo home_url(); ?>/comments/feed/atom/" />
  <link rel="alternate" type="application/rss2+xml" title="<?php bloginfo('name'); ?> &raquo; Technology RSS 2 Feed" href="<?php echo home_url(); ?>/technology/feed/rss2/" />
  <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> &raquo; Technology Atom Feed" href="<?php echo home_url(); ?>/technology/feed/atom/" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
  <?php if (function_exists('google_webmaster_tools')) { google_webmaster_tools(); } ?>
  <!--This is the start of the plugin hook-->
  <?php wp_head(); ?>
  <!--This is the end of the plugin hook-->
</head>

<body <?php body_class( $class ); ?>>
  <?php if (function_exists('google_analytics')) { google_analytics(); } ?>
  <div id="wrapper" >
    <div id="header-title">
      <div id="site-title">
        <a class="standard" href="<?php echo home_url(); ?>"><b><?php bloginfo('description'); ?></b></a>
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
