<?php
	/**
	 * Ajax Calls
	 */
	function cb_lwst_first_ajax_call(){
	    
	    // check_ajax_referer('WHATEVER');

	    // Default
	    $args = array(
	        'order'             => 'DESC',
	        'orderby'           => 'date',
	        'post_status'       => 'publish'
		);
	

	    $posts = new WP_Query($args);

	    if ( $posts->have_posts() ) : while ( $posts->have_posts() ) :
			global $post; $posts->the_post(); 
			
			// Do something 

		endwhile; endif;

	    echo wp_json_encode(array('OK'));
	    
	    wp_reset_postdata();
	    exit();
	}
	add_action('wp_ajax_[WHATEVER]', 'cb_lwst_first_ajax_call');
	add_action('wp_ajax_nopriv_[WHATEVER]', 'cb_lwst_first_ajax_call');
?>