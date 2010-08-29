<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>
    <link rel='shortcut icon' href='<?php bloginfo('template_url') ?>/images/favicon.ico' />
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php wp_title(' - ', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
    <?php if (function_exists('google_webmaster_tools')) { google_webmaster_tools(); } ?>
    <script type="text/javascript" src="http://use.typekit.com/iqz0som.js"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <!--This is a plugin hook-->
    <?php wp_head(); ?>

</head>

<body>

<?php if (function_exists('google_analytics')) { google_analytics(); } ?>

<div id="body-container">
		<div id="header-container">
			<div id="header-title">
				<div id="site-title">
					<a class="standard" href="<?php bloginfo('url'); ?>">
						<?php bloginfo('description'); ?>
					</a>
				</div>
			</div>
		</div><!--close header id-->
<div id="container">
