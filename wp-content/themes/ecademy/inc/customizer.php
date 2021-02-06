<?php
/**
 * eCademy Theme Customizer
 * @package eCademy
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
if ( ! function_exists( 'ecademy_customize_register' ) ) {
	function ecademy_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'blogname', array(
				'selector'        => '.site-title a',
				'render_callback' => 'ecademy_customize_partial_blogname',
			) );
			$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => 'ecademy_customize_partial_blogdescription',
			) );
		}
	}
}
add_action( 'customize_register', 'ecademy_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 */
if ( ! function_exists( 'ecademy_customize_partial_blogname' ) ) {
	function ecademy_customize_partial_blogname() {
		bloginfo( 'name' );
	}
}

/**
 * Render the site tagline for the selective refresh partial.
 */
if ( ! function_exists( 'ecademy_customize_partial_blogdescription' ) ) {
	function ecademy_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}
}
