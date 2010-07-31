<?php

$theme_name = get_current_theme();

function google_analytics() {
  if ( is_user_logged_in() ) {
    ?>
    <!--User is logged in, so this request will NOT be tracked by Google Analytics-->
    <?php
  } else {
    global $Panel;
    $GAEnabled = $Panel->Settings('GoogleAnalyticsEnabled');
    $GAID = $Panel->Settings('GoogleAnalyticsID');
    if ($GAEnabled == 'true') {
      if ($GAID != NULL) { ?>
      <!--Begin Google Analytics tracking script-->
      <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', '<?php echo $GAID; ?>']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
        })();

      </script>
      <!--End Google Analytics tracking script-->
      <?php } else {
        ?>
        <!--No user is logged in and Google Analytics is enabled, but there is not Google Analytics ID filled in-->
        <?php
      }
    } else {
      ?>
      <!--No user is logged in and Google Analytics is disabled-->
      <?php
    }
  } 
}

function register_mysettings() {
  register_setting( $theme_name, 'GoogleAnalyticsEnabled' );
  register_setting( $theme_name, 'GoogleAnalyticsID' );
}

function mdr_ga_controlpanel() {
  ?>
  <div class="wrap">
    <div class="stuffbox custom">
      <h3 class="hndle">Google Analytics Options</h3>
      <div class="inside">
      <div class="wrap">
      <form method="post" action="themes.php?page=control-panel.php">
        <?php wp_nonce_field('update-options'); ?>
	<?php settings_fields( $theme_name ); ?>
        <label for="GoogleAnalyticsEnabled">
          <input class="checkbox" id="GoogleAnalyticsEnabled" name="GoogleAnalyticsEnabled" value="<?php echo get_option('GoogleAnalyticsEnabled'); ?>" type="checkbox"> 
          <strong>Enable Google Analytics</strong>
        </label>
        <p class="description">This module requres a <a href="http://analytics.google.com">Google Analytics</a> account.<br>The Google Analytics code will NOT be displayed for logged in users.</p>
        <label for="GoogleAnalyticsID">
          <strong>Google Analytics ID</strong>
          <br>
          <input class="textbox" id="GoogleAnalyticsID" name="GoogleAnalyticsID" value="<?php echo get_option('GoogleAnalyticsID'); ?>" type="text">
        </label>
        <p class="description">Enter your <a href="http://analytics.google.com">Google Analytics</a> account ID.</p>
        <input type="hidden" name="page_options" value="GoogleAnalyticsEnabled,GoogleAnalyticsID" />
        <input type="hidden" name="action" value="update" />
        <p class="submit">
          <input type="submit" class="button" value="<?php _e('Save Above Changes','mdr-theme-milly') ?>" />
        </p>
      </form>
    </div>
    </div>
    </div>
  </div>
  <?php
}

?>
