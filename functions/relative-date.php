<?php

### Function: Display Post Relative Date (Today/Yesterday/Days Ago/Weeks Ago)
add_filter('the_date', 'relative_post_date', 999, 4);
function relative_post_date($the_date, $d = '', $before = '', $after = '', $display_ago_only = false) {
	global $post, $previous_day;
	$the_date = strip_tags($the_date);
	if(gmdate('Y', current_time('timestamp')) != mysql2date('Y', $post->post_date, false) && !empty($the_date)) {
		return $before.$the_date.$after;
	}
	$day_diff = (gmdate('z', current_time('timestamp')) - mysql2date('z', $post->post_date, false));
	if($day_diff < 0) { $day_diff = 32; }
	if ($the_date != $previous_day) {
		if($day_diff == 0) {
			return $before.__('Today').$after;
		} elseif($day_diff == 1) {
			return $before. __('Yesterday').$after;
		} elseif ($day_diff < 7) {
			if($display_ago_only) {
				return $before.sprintf(_n('%s day ago', '%s days ago', $day_diff, 'milly'), number_format_i18n($day_diff)).$after;
			} else {
				return $before.$the_date.' ('.sprintf(_n('%s day ago', '%s days ago', $day_diff, 'milly'), number_format_i18n($day_diff)).')'.$after;
			}
		} elseif ($day_diff < 31) {
			if($display_ago_only) {
				return $before.sprintf(_n('%s week ago', '%s weeks ago', ceil($day_diff/7), 'milly'), number_format_i18n(ceil($day_diff/7))).$after;
			} else {
				return $before.$the_date.' ('.sprintf(_n('%s week ago', '%s weeks ago', ceil($day_diff/7), 'milly'), number_format_i18n(ceil($day_diff/7))).')'.$after;
			}
		} else {
			return $before.$the_date.$after;
		}
		$previous_day = $the_date;
	}
}


### Alternative To WordPress the_date().
function relative_post_the_date($d = '', $before = '', $after = '', $display_ago_only = false, $display = true) {
	global $post;
	if (empty($d)) {
		$the_date = mysql2date(get_option('date_format'), $post->post_date);
	} else {
		$the_date = mysql2date($d, $post->post_date);
	}
	$output = '';
	if(gmdate('Y', current_time('timestamp')) != mysql2date('Y', $post->post_date, false)) {
		$output = $before.$the_date.$after;
	} else {
		$day_diff = (gmdate('z', current_time('timestamp')) - mysql2date('z', $post->post_date, false));
		if($day_diff < 0) { $day_diff = 32; }
		if($day_diff == 0) {
			$output = $before.__('Today', 'milly').$after;
		} elseif($day_diff == 1) {
			$output = $before. __('Yesterday', 'milly').$after;
		} elseif ($day_diff < 7) {
			if($display_ago_only) {
				$output = $before.sprintf(_n('%s day ago', '%s days ago', $day_diff, 'milly'), number_format_i18n($day_diff)).$after;
			} else {
				$output = $before.$the_date.' ('.sprintf(_n('%s day ago', '%s days ago', $day_diff, 'milly'), number_format_i18n($day_diff)).')'.$after;
			}
		} elseif ($day_diff < 31) {
			if($display_ago_only) {
				$output = $before.sprintf(_n('%s week ago', '%s weeks ago', ceil($day_diff/7), 'milly'), number_format_i18n(ceil($day_diff/7))).$after;
			} else {
				$output = $before.$the_date.' ('.sprintf(_n('%s week ago', '%s weeks ago', ceil($day_diff/7), 'milly'), number_format_i18n(ceil($day_diff/7))).')'.$after;
			}
		} else {
			$output = $before.$the_date.$after;
		}
	}
	if($display) {
		echo $output;
	} else {
		return $output;
	}
}


### Function: Display Post Relative Time (Seconds Ago/Minutes Ago/Hours Ago)
add_filter('the_time', 'relative_post_time', 999);
function relative_post_time($current_timeformat, $display_ago_only = 0) {
  global $post;
	$current_time = current_time('timestamp');
	$date_today_time = gmdate('j-n-Y H:i:s', $current_time);
	$post_date_time = mysql2date('j-n-Y H:i:s', $post->post_date, false);
	$date_today = gmdate('j-n-Y', $current_time);
	$post_date = mysql2date('j-n-Y', $post->post_date, false);
	$time_diff = (strtotime($date_today_time) - strtotime($post_date_time));
	$format_ago = '';
	if($post_date == $date_today) {
		if($time_diff < 60) {
			$format_ago = sprintf(_n('%s second ago', '%s seconds ago', $time_diff, 'milly'), number_format_i18n($time_diff));
		} elseif ($time_diff < 3600) {
			$format_ago = sprintf(_n('%s minute ago', '%s minutes ago', intval($time_diff/60), 'milly'), number_format_i18n(intval($time_diff/60)));
		} elseif ($time_diff < 86400) {
			$format_ago = sprintf(_n('%s hour ago', '%s hours ago', intval($time_diff/3600), 'milly'), number_format_i18n(intval($time_diff/3600)));
		}
		if($display_ago_only) {
			return $format_ago;
		} else {
			return $current_timeformat.' ('.$format_ago.')';
		}
	} else {
		return $current_timeformat;
	}
}


### Function: Display Comment Relative Date (Today/Yesterday/Days Ago/Weeks Ago)
add_filter('get_comment_date', 'relative_comment_date', 999);
function relative_comment_date($current_dateformat, $display_ago_only = 0) {
	global $comment;
	$comment_date = $comment->comment_date;
	if(gmdate('Y', current_time('timestamp')) != mysql2date('Y', $comment_date, false)) {
		return $current_dateformat;
	}
	$day_diff = (gmdate('z', current_time('timestamp')) - mysql2date('z', $comment_date, false));
	if($day_diff < 0) { $day_diff = 32; }
	if($day_diff == 0) {
		return __('Today', 'milly');
	} elseif($day_diff == 1) {
		return __('Yesterday', 'milly');
	} elseif ($day_diff < 7) {
		if($display_ago_only) {
			return sprintf(_n('%s day ago', '%s days ago', $day_diff, 'milly'), number_format_i18n($day_diff));
		} else {
			return $current_dateformat.' ('.sprintf(_n('%s day ago', '%s days ago', $day_diff, 'milly'), number_format_i18n($day_diff)).')';
		}
	} elseif ($day_diff < 31) {
		if($display_ago_only) {
			return sprintf(_n('%s week ago', '%s weeks ago', ceil($day_diff/7), 'milly'), number_format_i18n(ceil($day_diff/7)));
		} else {
			return $current_dateformat.' ('.sprintf(_n('%s week ago', '%s weeks ago', ceil($day_diff/7), 'milly'), number_format_i18n(ceil($day_diff/7))).')';
		}
	} else {
		return $current_dateformat;
	}
}


### Function: Display Comment  Relative Time (Seconds Ago/Minutes Ago/Hours Ago)
add_filter('get_comment_time', 'relative_comment_time', 999);
function relative_comment_time($current_timeformat, $display_ago_only = 0) {
	global $comment;	
	$current_time = current_time('timestamp');
	$date_today_time = gmdate('j-n-Y H:i:s', $current_time);
	$comment_date_time = mysql2date('j-n-Y H:i:s', $comment->comment_date, false);
	$date_today = gmdate('j-n-Y', $current_time);
	$comment_date = mysql2date('j-n-Y', $comment->comment_date, false);
	$time_diff = (strtotime($date_today_time) - strtotime($comment_date_time));
	$format_ago = '';
	if($comment_date == $date_today) {
		if($time_diff < 60) {
			$format_ago = sprintf(_n('%s second ago', '%s seconds ago', $time_diff, 'milly'), number_format_i18n($time_diff));
		} elseif ($time_diff < 3600) {
			$format_ago = sprintf(_n('%s minute ago', '%s minutes ago', intval($time_diff/60), 'milly'), number_format_i18n(intval($time_diff/60)));
		} elseif ($time_diff < 86400) {
			$format_ago = sprintf(_n('%s hour ago', '%s hours ago', intval($time_diff/3600), 'milly'), number_format_i18n(intval($time_diff/3600)));
		}
		if($display_ago_only) {
			return $format_ago;
		} else {
			return $current_timeformat.' ('.$format_ago.')';
		}
	} else {
		return $current_timeformat;
	}
}
?>
