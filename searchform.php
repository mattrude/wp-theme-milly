<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
 <div>
  <input type="text" name="s" id="s" onblur="if ( value == '' ) { this.value='Search Pages' }" onfocus="if ( value == 'Search Pages' ) { this.value='' }" tabindex="1" size="25 em" value="Search Pages" x-webkit-speech speech onwebkitspeechchange="this.form.submit();" />
  <input type="hidden" id="searchsubmit" value="Search" />
 </div>
</form>
