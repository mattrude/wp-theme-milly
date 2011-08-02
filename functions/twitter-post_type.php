<?php
//This plugin will create a custom post-type 

// Add Custom Post Types for WordPress 2.9
  register_post_type('twitter', array(
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
    'has_archive' => true,
    'show_ui' => true,
    'hierarchical' => false,
    'rewrite' => array('slug' => 'twitter'),
    'supports' => array('title', 'editor'),
    'feed' => true,
    'register_meta_box_cb' => 'twitter_save_metabox'
  ));
  
// Twitter Posts Meta Data
add_action('admin_menu', 'twitter_add_metabox');
add_action('save_post', 'twitter_save_metabox');

function twitter_add_metabox() {
  add_meta_box('twitter-id', __('Tweets Meta Data'), 'twitter_metabox', 'twitter', 'side');
}

function twitter_metabox() {
  echo '<input type="hidden" name="twitter_id_metabox" id="twitter_id_metabox" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

  // The actual fields for data entry
  global $post;
  $post_id_var = get_post_meta($post->ID, 'aktt_twitter_id', true);
  $post_name_var = get_post_meta($post->ID, 'twitter_name', true);
  $post_user_var = get_post_meta($post->ID, 'twitter_user', true);
  echo '<input type="text" name="aktt_twitter_id" value="' . $post_id_var . '" size="25" />';
  echo '<label for="aktt_twitter_id">' . __(" Tweet Post ID") . '</label><br />';
  echo '<input type="text" name="twitter_name" value="' . $post_name_var . '" size="25" />';
  echo '<label for="twitter_user">' . __(" Twitter Name") . '</label>';
  echo '<input type="text" name="twitter_user" value="' . $post_user_var . '" size="25" />';
  echo '<label for="twitter_user">' . __(" Twitter User") . '</label>';
}

function twitter_save_metabox() {
  global $post;
  $post_id = $post->ID;
  $post_id_var = $_POST['aktt_twitter_id'];
  $post_user_var = $_POST['twitter_user'];
  
  if(get_post_meta($post_id, 'aktt_twitter_id') == "") 
    add_post_meta($post_id, 'aktt_twitter_id', $post_id_var, true);
  elseif($post_id_var != get_post_meta($post_id, 'aktt_twitter_id', true))
    update_post_meta($post_id, 'aktt_twitter_id', $post_id_var); 
  elseif($post_id_var == "")
    delete_post_meta($post_id, 'aktt_twitter_id');  

  if(get_post_meta($post_id, 'twitter_user') == "") 
    add_post_meta($post_id, 'twitter_user', $post_user_var, true);
  elseif($post_user_var != get_post_meta($post_id, 'twitter_user', true))
    update_post_meta($post_id, 'twitter_user', $post_user_var); 
  elseif($post_user_var == "")
    delete_post_meta($post_id, 'twitter_user');  

  if(get_post_meta($post_id, 'twitter_name') == "") 
    add_post_meta($post_id, 'twitter_name', $post_name_var, true);
  elseif($post_name_var != get_post_meta($post_id, 'twitter_name', true))
    update_post_meta($post_id, 'twitter_name', $post_user_var); 
  elseif($post_name_var == "")
    delete_post_meta($post_id, 'twitter_name');  
}

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
    $img="<img src='$this->image?size=bigger' class='tweet-image' width='60' height='60' style='margin-right: 5px;' alt='$this->displayName' />";
    $linkedImg="<a href='http://twitter.com/$this->user' rel='nofollow' title='$this->displayName'>$img</a>";
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

function milly_twitter_byline() { ?>
<div id='tweet_date-<?php echo $post->ID; ?>' class='byline tweet_date' >
      <?php
      $post_id = $post->ID;
      $tweet_id = get_post_meta( $post_id, 'aktt_twitter_id', true);
      ?><p>Posted to <a href="http://twitter.com">Twitter</a> <?php
//	by <a href="http://twitter.com/<?php echo $tweet_id; echo '">'; <?php echo $twittername; echo $tweet_id; echo "</a>"; <?php
      echo " on ";
      if ($tweet_id) {
        echo "<a href='http://twitter.com/$twitterid/status/$tweet_id'>";
        the_time('F jS, h:ma T Y ');
        echo "</a></p>";
      } else {
        the_time('F jS, h:ma T Y ');
      }
      edit_post_link('Edit', ' | '); ?>
    </div><!--close tweet_post class--><?php
}

class milly_twitter_widget extends WP_Widget {
  function milly_twitter_widget() {
    $milly_twitter_widget_name = __('Twitter Widget');
    $milly_twitter_widget_description = __('Displays Tweets from the tweet post type.');
    $widget_ops = array('classname' => 'milly_twitter_widget', 'description' => $milly_twitter_widget_description );
    $this->WP_Widget('milly_twitter_widget', $milly_twitter_widget_name, $widget_ops);
  }  
  
  function widget($args, $instance) { 
    extract($args);
    $widget_title = strip_tags($instance['widget_title']);
    echo "{$before_widget}{$before_title}<a href='/twitter/'>$widget_title</a>{$after_title}<ul class='tweets'>";
    global $wp_query;
    $wp_query = new WP_Query("post_type=twitter&posts_per_page=8");
    while (have_posts()) : the_post();
      global $post;
      echo "<li>";
      the_content();
      ?><small><a href='<?php echo get_permalink(); ?>'><?php relative_post_the_date(); ?></a></small>
      </li><?php
    endwhile;
    echo "</ul>";
    echo $after_widget;
  }
  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['widget_title'] = strip_tags($new_instance['widget_title']);
    return $instance;
  }
  
  function form($instance) {
    $widget_title = strip_tags($instance['widget_title']);
    ?><p><label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Widget Title')?>:<input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo esc_attr($widget_title); ?>" /></label></p><?php
  }
}

add_action('widgets_init', 'milly_twitter_widget_init');
function milly_twitter_widget_init() {
        register_widget('milly_twitter_widget');
}

?>
