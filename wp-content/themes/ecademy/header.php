<!doctype html>
<?php if( ecademy_rtl() == true ): ?><html dir="rtl" <?php language_attributes(); ?>>
<?php else: ?><html <?php language_attributes(); ?>><?php endif; ?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php ecademy_preloader(); ?>

	<?php
	$header_style = '';
	global $ecademy_opt;
	if ( !empty($ecademy_opt['header_style']) && ($ecademy_opt['header_style'] != '' ) ):
		$header_style 			= new WP_Query(array(
			'post_type' 		=> 'header',
			'posts_per_page' 	=> -1,
			'p' 				=> $ecademy_opt['header_style'],
		));
	endif;

	if ( $header_style != '' ):
		if ( $header_style->have_posts() ):
			while ( $header_style->have_posts() ) : $header_style->the_post();
				the_content();
			endwhile;
			wp_reset_postdata();
		endif;
	else: 
		ecademy_header_area(); // Header Area
	endif;

	/**
	 * Banner Area
	 */
	$is_banner = '1';
	if ( is_page() || is_singular('post') || is_singular('product') || is_singular('events') ) :
		$is_banner = function_exists( 'get_field' ) ? get_field( 'is_banner' ) : '1';
		$is_banner = isset( $is_banner ) ? $is_banner : '1';
	endif;
	if ( is_404() || is_page_template('elementor_canvas') ) :
		$is_banner = '';
	endif;

	if ( 'lp_course' == get_post_type() ):
		$is_banner = '';
	endif;

	if ( 'courses' == get_post_type() ):
		$is_banner = '';
	endif;

	if ( 'sfwd-courses' == get_post_type() ):
		$is_banner = '';
	endif;

	if ( 'lesson' == get_post_type() ):
		$is_banner = '';
	endif;

	if ( class_exists( 'WooCommerce') ) {
        if ( is_shop() ) {
			$is_shop_banner = isset( $ecademy_opt['enable_shop_pages_banner'] ) ? $ecademy_opt['enable_shop_pages_banner'] : '1';
			if( $is_shop_banner != '1' ):
				$is_banner = '';
			endif;            
        }
	}

	$post_id = false;

	if( is_home() ) {
		$post_page_id = get_option( 'page_for_posts' );
		$is_banner = function_exists( 'get_field' ) ? get_field( 'is_banner', $post_page_id ) : '1';
	}

	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if ( strpos($actual_link, '/profile') !== false ):
		$is_banner = '';
	endif;

	if ( !isset($_GET['elementor_library']) ) :
		if ( $is_banner == '1' ) :
			get_template_part('template-parts/banner');
		endif;
	endif;