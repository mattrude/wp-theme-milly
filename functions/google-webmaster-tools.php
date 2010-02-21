<?php

$theme_name = get_current_theme();

function google_webmaster_tools() {
  global $Panel;
  $GWTEnabled = $Panel->Settings('GoogleWebmasterToolsEnabled');
  $GWTID = $Panel->Settings('GoogleWebmasterToolsID');
  if ($GWTEnabled == 'true') {
    if ($GWTID != NULL) { 
    ?><meta name="google-site-verification" content="<?php echo $GWTID; ?>" />
<?php
    }
  }
}

function register_gwt_settings() {
  register_setting( $theme_name, 'GoogleWebmasterToolsEnabled' );
  register_setting( $theme_name, 'GoogleWebmasterToolsID' );
}

function mdr_gwt_controlpanel() {
  ?>
  <div class="wrap">
    <div class="stuffbox custom">
      <h3 class="hndle">Google Webmaster Tools Options</h3>
      <div class="inside">
      <div class="wrap">
      <form method="post" action="themes.php?page=control-panel.php">
        <?php wp_nonce_field('update-options'); ?>
	<?php settings_fields( $theme_name ); ?>
        <label for="GoogleWebmasterToolsEnabled">
          <input class="checkbox" id="GoogleWebmasterToolsEnabled" name="GoogleWebmasterToolsEnabled" value="<?php echo get_option('GoogleWebmasterToolsEnabled'); ?>" type="checkbox"> 
          <strong>Enable Goolge Webmaster Tools ID</strong>
        </label>
        <p class="description">This module requres a <a href="http://www.google.com/webmasters/tools">Google Webmaster Tools</a> account.</p>
        <label for="GoogleWebmasterToolsID">
          <strong>Google Webmaster Tools ID</strong>
          <br>
          <input class="textbox" id="GoogleWebmasterToolsID" name="GoogleWebmasterToolsID" value="<?php echo get_option('GoogleWebmasterToolsID'); ?>" type="text">
        </label>
        <p class="description">Enter your <a href="http://www.google.com/webmasters/tools">Google Webmaster Tools</a> site ID.</p>
        <input type="hidden" name="page_options" value="GoogleWebmasterToolsEnabled,GoogleWebmasterToolsID" />
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
