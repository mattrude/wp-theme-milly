<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>
    <link rel='shortcut icon' href='<?php bloginfo('template_url') ?>/images/favicon.ico' />
    <?php wp_head(); ?>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <?php if ( $paged != '0' ) {
      ?><title><?php wp_title(' - ', true, 'right'); ?><?php bloginfo('name'); echo " - Page $paged" ?></title><?php
    } else {
      ?><title><?php wp_title(' - ', true, 'right'); ?><?php bloginfo('name'); ?></title><?php
    } ?>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

    <!--This is a plugin hook-->
    <?php wp_head(); ?>

</head>

<body>
<div id="body-container">
		<div id="header-container">
			<div id="header-title">
				<div id="site-title">
					<a class="standard" href="<?php bloginfo('url'); ?>">
						<b><?php bloginfo('description'); ?></b>
					</a>
				</div>
			</div>
			<div id="header">
				<img src='<?php bloginfo('template_url') ?>/images/header-cabin.jpg' alt='Saint Anthony Falls, Mpls, MN'/></div>
		</div><!--close header id-->
		<div id="navigation">
			<div id="menu" class="menu">
				<ul class="menu sf-menu">
				    <li>
					<a rel="me" href="<?php bloginfo('url'); ?>">Home</a> 
					<a rel="me" href="<?php bloginfo('url'); ?>/contact-me/">Contact Me</a> 
					<a rel="me" href="<?php bloginfo('url'); ?>/category/gallery/">Photo Gallery</a> 
					<a rel="me" href="<?php bloginfo('url'); ?>/projects/">Projects</a> 
					<a rel="me" href="<?php bloginfo('url'); ?>/category/tech/">Technology</a> 
					<a rel="me" href="<?php bloginfo('url'); ?>/category/tweets/">Twitter</a> 
				    </li>
				</ul>
			</div>
		</div>
		<div id="container">
