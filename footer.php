</div> 
<div id="footer-container">
	<div id="footer">
                <div id="primary" class="aside">
		  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget-area') ) ?>
		</div>
		<div id="footer-logo">
			<a href="http://wordpress.org/" rel="nofollow"><img src="<?php echo get_template_directory_uri(); ?>/images/wordpress-logo.png" height='100' width='100' alt="WordPress Logo" /></a>
		</div>
		<?php global $Panel;
		$copyright = $Panel->Settings('copyenable');
		if ($copyright == 'true') { ?>
			<div id="footer-copyright">
				<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" rel="nofollow"><img alt="Creative Commons Attribution-Share Alike 3.0 Unported License" style="border-width:0" src="<?php echo get_template_directory_uri(); ?>/images/cc-by-sa.png" /></a>
			</div>
		<?php } ?>
		<div id="footer-text">
			<p>
			Copyright &copy; 1980 – <?php echo date("Y") ?> by <a href="http://mattrude.com/">Matt Rude</a><br />
			Site Designed by <a href="http://mattrude.com/">Matt Rude</a>.<br />
			Proudly powered by <a href="http://wordpress.org/" rel="nofollow">WordPress</a>.<br />
			This page took <?php timer_stop(1); ?> seconds of computer labor,<br/>
			and required <?php echo get_num_queries(); ?> questions to produce.<br />
			<?php global $Panel; echo $Panel->Settings('FooterText'); ?><br />
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
