</div> 
<div id="footer-container">
	<div id="footer">
		<div id="footer-logo">
			<a href="http://wordpress.org/"><img src="<?php bloginfo('template_url') ?>/images/wordpress-logo.png"></a>
		</div>
		<div id="footer-text">
			<p>
			This page took <?php timer_stop(1); ?> seconds of computer labor to produce.<br />
			Site Designed by <a href="http://mattrude.com/">Matt Rude</a>.<br />
			Proudly powered by <a href="http://wordpress.org/">WordPress</a>.<br />
			Copyright &copy; 1980 – <?php echo date("Y") ?> <a href="http://mattrude.com/">Matt Rude</a><br />
			<?php global $Panel; echo $Panel->Settings('FooterText'); ?><br />
			</p>
		</div>
	</div>
	<!--footer plugin hook-->
	<?php wp_footer(); ?>
</div>

<?php if ( is_user_logged_in() ) { 
	?><!--User is logged in, so this request will Not be tracked by Google Analytics-->
<?php
} else {
	global $Panel;
	$GAEnabled = $Panel->Settings('GoogleAnalyticsEnabled');
	$GAID = $Panel->Settings('GoogleAnalyticsID');
	if ($GAEnabled == 'true') {
		if ($GAID != NULL) { ?>
			<!--Google Analytics tracking script-->
			<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
			</script>
			<script type="text/javascript">
			try {
			var pageTracker = _gat._getTracker("<?php echo $GAID; ?>");
			pageTracker._trackPageview();
			} catch(err) {}</script>
<?php 		} else {
			?><!--No user is logged in and Google Analytics is enabled, but there is not Google Analytics ID filled in-->
<?php		}
	} else {
		?><!--No user is logged in and Google Analytics is disabled-->
<?php	}
} ?>
<!--Closeing tags-->
</body>
</html>
