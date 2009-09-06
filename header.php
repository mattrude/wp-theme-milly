<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>
    <link rel='shortcut icon' href='<?php bloginfo('template_url') ?>/images/favicon.ico' />
    <?php wp_head(); ?>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

    <title><?php wp_title(' - ', true, 'right'); ?><?php bloginfo('name'); ?></title>

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

    <!--This is a plugin hook-->
    <?php wp_head(); ?>

</head>

<body <?php if(is_page() || is_single()) echo 'onload="hideTags();"'; ?>>

<div id="body-container">
		<div id="header-container">
			<div id="header">
				<div id="site-title">
					<a class="standard" href="<?php bloginfo('url'); ?>">
						<span><?php bloginfo('sitetitle'); ?></span>
					</a>
				</div>
				<div id="site-description">
					<span><?php bloginfo('description'); ?></span>
				</div>
			</div>
		</div><!--close header id-->
		<div id="navigation">
			<div id="page-nav" class="page-nav">
				<ul class="menu sf-menu">
					<?php get_bookmarks() ?> 
					<a rel="me" href="/about/">About</a> 
					<a rel="me" href="/contact-me/">Contact Me</a> 
					<a rel="me" href="/gallery/">Photo Gallery</a> 
					<a rel="me" href="/plugins/">Plugins</a> 
					<a rel="me" href="/calendar/">Calendar</a> 
					<a rel="me" href="/category/tweets/">My Tweets</a> 
					<a rel="me" href="https://mail.mattrude.com">Mail</a> 
					<a rel="me" href="http://wiki.mattrude.com/">Wiki</a> 
				</ul>
			</div>
		</div>
<div id="container">
