<?php

function ecademy_enqueue_style() {
    wp_enqueue_style( "parent-style" , get_parent_theme_file_uri( "/style.css" ) );
}
add_action( 'wp_enqueue_scripts', 'ecademy_enqueue_style' );

function enqueue_custom_scripts() {
    wp_enqueue_script( 'custom-count-down', get_stylesheet_directory_uri() . '/assets/js/countdown.js', array( 'jquery' ), 1.0, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_scripts' );
