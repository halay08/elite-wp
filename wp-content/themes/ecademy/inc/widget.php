<?php
/**
 * Register Theme Widget
 * @package eCademy
 */


// Register sidebar
if ( ! function_exists( 'ecademy_widgets_init' ) ) {
    function ecademy_widgets_init() {
        register_sidebar( array(
            'name'          => esc_html__( 'Blog Sidebar', 'ecademy' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'ecademy' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        // bbPress Sidebar
        if ( class_exists( 'bbPress' ) ) {
            register_sidebar( array(
                'name' => esc_html__( 'bbPress Sidebar', 'ecademy' ),
                'id' => 'bbpress-sidebar',
                'class' => '',
                'description' => esc_html__( 'A sidebar that only appears on bbPress pages.', 'ecademy' ),
                'before_widget' => '<div id="%1$s" class="widget blog_widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h5 class="widget-title"><span>',
                'after_title' => '</span></h5>',
            ) );
        }

        // Shop Sidebar
        register_sidebar( array( 
            'name'          => esc_html__( 'Shop Sidebar', 'ecademy' ),
            'id'            => 'shop',
            'description'   => esc_html__( 'Add widgets here.', 'ecademy' ),
            'before_widget' => '<div class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        ) );
        
        // Footer Sidebar
        global $ecademy_opt;
        $footer_column = !empty($ecademy_opt['footer_column']) ? $ecademy_opt['footer_column'] : '';
        register_sidebar( array( 
            'name'          => esc_html__( 'Footer Widgets', 'ecademy' ),
            'id'            => 'footer_widgets',
            'description'   => esc_html__( 'Add widgets here.', 'ecademy' ),
            'before_widget' => '<div class="single-footer-widget col-lg-'.$footer_column.' col-md-'.$footer_column.' %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        ) );
        
        // Page
        if( function_exists('acf_add_options_page') ) {
            register_sidebar( array(
                'name'          => esc_html__( 'Page Widget', 'ecademy' ),
                'id'            => 'page-widget',
                'description'   => esc_html__( 'Add widgets here.', 'ecademy' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ) );
        }    

        // Course Sidebar
        register_sidebar( array( 
            'name'          => esc_html__( 'LearnPress/LearnDash Course Widget', 'ecademy' ),
            'id'            => 'course-sidebar',
            'description'   => esc_html__( 'Add widgets here.', 'ecademy' ),
            'before_widget' => '<div class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
    }
}
add_action( 'widgets_init', 'ecademy_widgets_init' );