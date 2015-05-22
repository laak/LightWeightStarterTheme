<?php
    // Set upload limit
    @ini_set( 'upload_max_size' , '64M' );
    @ini_set( 'post_max_size', '64M');
    @ini_set( 'max_execution_time', '300' );

    // Set default timezone
    date_default_timezone_set('Europe/Berlin');

    // Requires
    require_once('externals/theme-functions.php');
    require_once('externals/theme-settings.php');
    require_once('externals/ajax-calls.php');

    /**
     * On Theme Activation
     */
    function lwst_theme_activation($oldname, $oldtheme=false) {

    }
    add_action("after_switch_theme", "theme_activation", 10 ,  2); 

    /**
     * Custom thumbnails
     */
    function lwst_theme_support() {
        add_theme_support( 'post-thumbnails' );
        // add_image_size( '...', 300 ); 
        // add_image_size( '...', 80, 80, true ); // (cropped)
    }
    add_action( 'after_setup_theme', 'lwst_theme_support' );

    /**
     * Enqueue stylesheets ans javascript
     */
    function lwst_theme_resources() {
        wp_register_style('lwst-application-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0', 'all');
        wp_enqueue_style('lwst-application-style');

        if( !is_admin() ){
            wp_deregister_script('jquery');
            wp_register_script('jquery', ('https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'), false, '');
            wp_enqueue_script('jquery');
        }

        wp_enqueue_script( 'lwst-application-script', get_template_directory_uri() . '/assets/javascripts/app.min.js', array( 'jquery' ), '', true );
        wp_localize_script( 'lwst-application-script', 'WordpressGlobalVariables', array( 
            'ajaxurl'               => admin_url( 'admin-ajax.php' ),
            // 'wp_nonce_more_posts'   => wp_create_nonce('more_posts'),
            ) 
        );
    }
    add_action( 'wp_enqueue_scripts', 'lwst_theme_resources' );

    /**
     * Removes width and height attr from images
     */
    function remove_width_attribute( $html ) {
       $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
       return $html;
    }
    add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
    add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

    /**
     * Register sidebars
     */
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name'=> '',
            'id' => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>',
        ));
    }
?>