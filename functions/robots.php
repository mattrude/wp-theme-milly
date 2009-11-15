<?php

// Adds robots.txt support
$defaultrobotstxt = "# This is the default robots.txt file
User-agent: *
Disallow:";

add_option("robots_txt", $defaultrobotstxt, "Contents of robots.txt", 'no');            // default value

$request = str_replace( get_bloginfo('url'), '', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] );
if ( (get_bloginfo('url').'/robots.txt' != 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) && ('/robots.txt' != $_SERVER['REQUEST_URI']) && ('robots.txt' != $_SERVER['REQUEST_URI']) )
  return;         // checking whether they're requesting robots.txt
  $robotstxt_out = get_option('robots_txt');
  if ( !$robotstxt_out)
  return;
    header('Content-type: text/plain');
    print $robotstxt_out;
die;

function mdr_robots_controlpanel() {
  if ( $_POST['robots_txt'] ){
    update_option( 'robots_txt', $_POST['robots_txt'] );
    $urlwarning = str_replace('http://', '', get_bloginfo('url') );
    $urlwarning = substr( $urlwarning, 0, -1 );     // in case there is a trailing slash--don't want it so set off our warning
    if ( strpos( $urlwarning, '/' ) )                       // this is our warning checker
      $urlwarning = '<p>It appears that your blog is installed in a subdirectory, not in a subdomain or at your domain\'s root. Be aware that search engines do not look for robots.txt files in subdirectories. <a href="http://www.robotstxt.org/wc/exclusion-admin.html">Read more</a>.</p>';
   } else {
      unset($urlwarning);
      print '<div id="message" class="updated fade"><p><strong>Robots.txt updated.</strong> <a href="'.get_bloginfo('url').'/robots.txt">View robots.txt</a>.</p>'.$urlwarning.'</div>';
  }

  $robotstxt_out = get_option('robots_txt');

  print '
  <div class="wrap">
    <div class="stuffbox custom">
      <h3 class="hndle">Robots.txt Editor</h3>
      <div class="inside">
        <div class="wrap">
          <p>Edit your robots.txt file in the space below. Lines beginning with <code>#</code> are treated as comments.</p>
          <p>Using robots.txt, you can ban specific robots, ban all robots, or block robot access to specific pages or areas of your site. If you are not sure what to type, look at the bottom of this page for examples.</p>
          <form method="post" action="http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'">
            <textarea id="robots_txt" name="robots_txt" rows="10" cols="45" class="widefat">'.$robotstxt_out.'</textarea>
            <p class="submit" style="width:420px;"><input type="submit" value="Submit Robots.txt &raquo;" /></p>
          </form>
          <h2>Robots.txt Samples</h2>
          <h4>Ban all robots</h4> 
          <blockquote><code>User-agent: *<br />Disallow: /</code></blockquote>
          <h4>Allow all robots</h4>
          <p>To allow any robot to access your entire site, you can simply leave the robots.txt file blank, or you could use this:</p>
          <blockquote><code>User-agent: *<br />Allow: /</code></blockquote>
        </div>
      </div>
    </div>
  </div>
  ';
}

?>
