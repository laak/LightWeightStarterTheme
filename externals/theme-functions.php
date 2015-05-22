<?php
	/**
	 * Debug
	 */
	function debug($pre) {
		echo "<pre>";
		print_r($pre);
		echo "<pre>";
	}
	
	/**
	 * Get the theme root path
	 * Ex /wp-content/themes/[THEMENAME]
	 */
	function theme_root() {
	    return bloginfo('stylesheet_directory');
	}

	/**
	 * Same as get_template_part
	 * Except this returns the value instead of printing it out
	 * Ex. $html = load_template_part( 'loop' )
	 */
	function load_template_part($template_name, $part_name=null) {
	    ob_start();
	    get_template_part($template_name, $part_name);
	    $var = ob_get_contents();
	    ob_end_clean();
	    return $var;
	}
?>