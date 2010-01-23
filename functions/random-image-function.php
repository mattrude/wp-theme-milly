<?php
  function random_images() {
    $args = array(
       'post_type' => 'attachment',
       'post_mime_type' => 'image',
       'numberposts' => -1,
       'post_status' => null,
       'post_parent' => $post->ID,
       'orderby' => 'rand'
    );

    $attachments = get_posts($args);
    $riw_cat_id = get_category_by_slug(gallery)->term_id;
    $noimages = count($attachments);
    if ($attachments) {
      foreach ($attachments as $attachment) {
        $albumid = $attachment->post_parent;
        if (in_category($riw_cat_id, $albumid)) { 
          $imgid = $attachment->ID;
          $meta = wp_get_attachment_metadata($imgid);

          // construct the image
          echo "<a href=".get_permalink( $imgid )." title='$attachment->post_excerpt' >";
          echo "<img width='".$meta['sizes']['thumbnail']['width']."'  height='".$meta['sizes']['thumbnail']['height']."' src='".wp_get_attachment_thumb_url($imgid)."' alt='Random image: ".$attachment->post_title."' />";
          echo "</a>";
          break;
	}
      }
    }
  }
  
?>
