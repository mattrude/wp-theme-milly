<?php get_header(); 
global $blog_id;
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$places_name = $term->name;
$places_slug = $term->slug;
if ( $term->description == "" ) {
  $places_description = $term->name;

} else {
  $places_description = $term->description;
} ?>

<div id="content">
	<?php if (have_posts()) : ?> <!--This is "The Loop"-->
		<h2>Posts at <?php echo $places_description; ?>:</h2>
		<?php while (have_posts()) : the_post();
			if ( in_category( 'gallery' )) {
				include('functions/gallery-index.php');
			} else {
				milly_post_full();
			}
		endwhile; ?><!--The Loop has ended-->	
	<?php endif;
        $attachments = wp_cache_get( "places_tax_$places_slug" );
	if ( false == $attachments ) {
	    $args = array( 
		'post_type' => 'attachment',
		'numberposts' => -1,
		'post_status' => null,
		'post_parent' => null,
	    	'orderby' => 'post_date',
    		'order' => 'DESC',
		'tax_query'=>array(array(
			'taxonomy' => 'places',
			'field' => 'slug',
			'terms' => $places_slug
			))
		); 
		$attachments = get_posts( $args );
		wp_cache_set( "places_tax_$places_slug", $attachments, $blog_id, 1400 );
	}
	if ($attachments) { ?>
		<br />
		<a name="pics" ></a>
		<h2>Pictures taken at <?php echo $places_description; ?>:</h2>
		<div class="post"><center><?php
		foreach ( $attachments as $attachment ) {
			setup_postdata($attachment);
			the_attachment_link($attachment->ID, false, null, 1);
			the_excerpt();
		} ?>
		</center></div>
	<?php } ?>
</div><!--close content id-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
