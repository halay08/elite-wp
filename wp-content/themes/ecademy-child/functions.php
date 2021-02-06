<?php

function ecademy_enqueue_style() {
    wp_enqueue_style( "parent-style" , get_parent_theme_file_uri( "/style.css" ) );
}
add_action( 'wp_enqueue_scripts', 'ecademy_enqueue_style' );