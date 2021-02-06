<?php
/**
 * Jetpack Compatibility File
 * @package eCademy
 */

/**
 * Jetpack setup function.
 */
if ( ! function_exists( 'ecademy_jetpack_setup' ) ) {
	function ecademy_jetpack_setup() {
		// Add theme support for Infinite Scroll.
		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => 'ecademy_infinite_scroll_render',
			'footer'    => 'page',
		) );

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );

		// Add theme support for Content Options.
		add_theme_support( 'jetpack-content-options', array(
			'post-details'    => array(
				'stylesheet' => 'ecademy-style',
				'date'       => '.posted-on',
				'categories' => '.cat-links',
				'tags'       => '.tags-links',
				'author'     => '.byline',
				'comment'    => '.comments-link',
			),
			'featured-images' => array(
				'archive'    => true,
				'post'       => true,
				'page'       => true,
			),
		) );
	}
}
add_action( 'after_setup_theme', 'ecademy_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
if ( ! function_exists( 'ecademy_infinite_scroll_render' ) ) {
	function ecademy_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
				get_template_part( 'template-parts/content', 'search' );
			else :
				get_template_part( 'template-parts/content', get_post_type() );
			endif;
		}
	}
}
