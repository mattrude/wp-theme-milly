<?php

// add_action('admin_menu', 'ce_admin_menu');
add_filter('pre_get_posts','ce_exclude_categories');

function ce_process() {
	//echo '<pre>'; print_r( $_POST );
	if( !$_POST[ 'exclude_main' ] ) {
		$_POST[ 'exclude_main' ] = array();
	}
	if( !$_POST[ 'exclude_feed' ] ) {
		$_POST[ 'exclude_feed' ] = array();
	}
	if( !$_POST[ 'exclude_archives' ] ) {
		$_POST[ 'exclude_archives' ] = array();
	}
	$options['exclude_main'] = $_POST[ 'exclude_main' ];
	$options['exclude_feed'] = $_POST[ 'exclude_feed' ];
	$options['exclude_archives'] = $_POST[ 'exclude_archives' ];
	update_option('Milly_Excluded', $options);
	
	$message = "<div class='updated'><p>Excludes successfully updated</p></div>";
	return $message;
}

function ce_get_options(){
	$defaults = array();
	$defaults['exclude_main'] = array();
	$defaults['exclude_feed'] = array();
	$defaults['exclude_archives'] = array();

	$options = get_option('Milly_Excluded');
	if (!is_array($options)){
		$options = $defaults;
		update_option('Milly_Excluded', $options);
	}

	return $options;
}

function ce_exclude_categories($query) {
	$options = ce_get_options();
	if ($query->is_home) {
		$query->set('cat', implode( ', ', $options[ 'exclude_main' ] ) );
	}
	if ($query->is_feed) {
		$query->set('cat', implode(', ', $options[ 'exclude_feed' ] ) );
	}
	if ($query->is_archive) {
		$query->set('cat', implode(', ', $options[ 'exclude_archives' ] ) );
	}

	return $query;
}

?>
