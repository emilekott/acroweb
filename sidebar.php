<?php if ( function_exists('dynamic_sidebar')) {
	
	global $post;
	$posttype = get_post_type($post);
	
	if( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post') ) {
		dynamic_sidebar('Blog Sidebar');
	}	
	else {
		dynamic_sidebar('Page Sidebar');
	}
	
} ?>
    
