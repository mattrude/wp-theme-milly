</div> 
<div id="footer-container">
	<div id="footer">
                <div id="primary" class="aside">
		  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget-area') ) ?>
		</div>
		<div id="footer-logo">
			<a href="http://wordpress.org/" rel="nofollow"><img src="<?php echo get_template_directory_uri(); ?>/images/wordpress-logo.png" height='100' width='100' alt="WordPress Logo" /></a>
		</div>
		<div id="footer-text">
			<p>
			Copyright &copy; 1980 – <?php echo date("Y") ?> by <a href="http://mattrude.com/">Matt Rude</a><br />
			Site Designed by <a href="http://mattrude.com/">Matt Rude</a>.<br />
			Proudly powered by <a href="http://wordpress.org/" rel="nofollow">WordPress</a>.<br />
			This page took <?php timer_stop(1); ?> seconds of computer labor,<br/>
			and required <?php echo get_num_queries(); ?> questions to produce.<br />
			</p>
		</div>
	</div>
	<!--footer plugin hook-->
	<?php wp_footer(); ?>
</div>

<!--Closeing tags-->
</div>
</body>
</html>
