</div> 
<div id="footer-container">
	<div id="footer">
		<div id="footer-logo">
			<a href="http://wordpress.org/"><img src="<?php bloginfo('template_url') ?>/images/wordpress-logo.png" alt="WordPress Logo" /></a>
		</div>
		<?php global $Panel;
		$copyright = $Panel->Settings('copyenable');
		if ($copyright == 'true') { ?>
			<div id="footer-copyright">
				<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"><img alt="Creative Commons Attribution-Share Alike 3.0 Unported License" style="border-width:0" src="<?php bloginfo('template_url') ?>/images/cc-by-sa.png" /></a>
			</div>
		<?php } ?>
		<div id="footer-text">
			<p>
			Copyright &copy; 1980 – <?php echo date("Y") ?> <a href="http://mattrude.com/">Matt Rude</a><br />
			Site Designed by <a href="http://mattrude.com/">Matt Rude</a>.<br />
			Proudly powered by <a href="http://wordpress.org/">WordPress</a>.<br />
			This page took <?php timer_stop(1); ?> seconds of computer labor,<br/>
			and required <?php echo get_num_queries(); ?> questions to produce.<br />
			<?php global $Panel; echo $Panel->Settings('FooterText'); ?><br />
			</p>
		</div>
	</div>
	<!--footer plugin hook-->
	<?php wp_footer(); ?>
</div>
</div>

<?php google_analytics(); ?>

<!--Closeing tags-->
</body>
</html>
