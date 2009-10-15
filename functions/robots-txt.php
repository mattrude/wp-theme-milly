<?php
// Adds robots.txt support
$defaultrobotstxt = "# This is the default robots.txt file
User-agent: *
Disallow:";

add_option("robots_txt", $defaultrobotstxt, "Contents of robots.txt", 'no');            // default value

function robots_txt(){
        $request = str_replace( get_bloginfo('url'), '', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] );

        if ( (get_bloginfo('url').'/robots.txt' != 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) && ('/robots.txt' != $_SERVER['REQUEST_URI']) && ('robots.txt' != $_SERVER['REQUEST_URI']) )
                return;         // checking whether they're requesting robots.txt

        $robotstxt_out = get_option('robots_txt');

        if ( !$robotstxt_out)
                return;

        header('Content-type: text/plain');
        print $robotstxt_out;
        die;
}
?>
