<?php
//This plugin will create a custom post-type 


// Add Custom Post Types for WordPress 2.9
function Twiiter_post_type_init() {
  $args = array(
    'labels' => array(
        'name' => __('Twitter'),
        'singular_name' => _x('Tweet','Tweet'),
        'add_new' => __('Add New Tweet', 'tweet'),
        'add_new_item' => __('Add New Tweet'),
        'edit_item' => __('Edit Tweet'),
        'new_item' => __('New Tweet'),
        'view_item' => __('View Tweet'),
        'search_items' => __('Search Tweets'),
        'not_found' =>  __('No tweets found'),
        'not_found_in_trash' => __('No tweets found in Trash')
    ),
    'description' => __('Imported Twitter Posts'),
    'exclude_from_search' => true,
    'public' => true,
    'show_ui' => true,
    'hierarchical' => false,
    'rewrite' => array('slug' => 'twitter'),
    'supports' => array('title', 'editor', 'custom-fields')
  );
  register_post_type('twitter',$args);
}
add_action('init','Twiiter_post_type_init');



// Change all post in category Twitter to post type twitter
function twitter_post_type_convert() {
  global $Panel;
  $TwitterEnabled = $Panel->Settings('TwitterEnabled');
  $TwitterCategory = $Panel->Settings('TwitterCategory');

  if ( $TwitterEnabled == 'true' ) {
    if ( $TwitterCategory ) {
      if ( $TwitterCategory != 1 ) {
        function milly_twitter_post_type() {
          global $wpdb, $Panel;
          $TwitterCategory = $Panel->Settings('TwitterCategory');
          $TwitterCatSlug = $wpdb->get_row("SELECT * FROM $wpdb->terms WHERE term_id = $TwitterCategory");
          $args = array(
              'numberposts' => -1,
              'category_name' => $TwitterCatSlug->slug,
              'post_type' => 'post'
          );
          $mdr_postslist = get_posts($args);
          foreach ($mdr_postslist as $post) {
            $mdr_postid = $post->ID;
            if ($mdr_postid > 0) {
              $wpdb->query("UPDATE $wpdb->posts SET post_type = 'twitter' WHERE ID = $mdr_postid");
              $wpdb->query("DELETE FROM $wpdb->term_relationships WHERE object_id = $mdr_postid");
              $wpdb->query("UPDATE $wpdb->term_taxonomy SET count = 0 WHERE term_id = '$TwitterCategory'");
            }
          }
        }
        milly_twitter_post_type();
      }
    }
  }
}

twitter_post_type_convert();


// Get the users image from twitter
class twitterImage
{
  var $user='';
  var $image='';
  var $displayName='';
  var $url='';
  var $format='json';
  var $requestURL='http://twitter.com/users/show/';
  var $imageNotFound=''; //any generic image/avatar. It will display when the twitter user is invalid
  var $noUser=true;
 
  function __construct($user)
  {
    $this->user=$user;
    $this->__init();
 
  }
  /*
   * fetches user info from twitter
   * and populates the related vars
   */
  private function __init()
  {
    $data=json_decode($this->get_data($this->requestURL.$this->user.'.'.$this->format)); //gets the data in json format and decodes it
    if(strlen($data->error)<=0) //check if the twitter profile is valid
 
    {
      $this->image=$data->profile_image_url;
      $this->displayName=$data->name;
      $this->url=(strlen($data->url)<=0)?'http://twitter.com/'.$this->user:$data->url;
      $this->location=$data->location;
    }
    else
    {
      $this->image=$this->imageNotFound;
    }
 
 
  }
  /* creates image tag
   * @params
   * passing linked true -- will return an image which will link to the user's url defined on twitter profile
   * passing display true -- will render the image, else return
   */
  function profile_image($linked=false,$display=false)
  {
    $img="<img src='$this->image?size=bigger' class='tweet-image' width='60' height='60' margin-right: 5px; alt='$this->displayName' />";
    $linkedImg="<a href='$this->url' rel='nofollow' title='$this->displayName'>$img</a>";
    if(!$linked && !$display) //the default case
      return $img;
 
    if($linked && $display)
      echo $linkedImg;
 
    if($linked && !$display)
      return $linkedImg;
 
    if($display && !$linked)
      echo $img;
 
 
  }
  /* gets the data from a URL */
 
  private function get_data($url)
  {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
  }
 
}

?>
