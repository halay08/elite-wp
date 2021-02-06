<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
$pcs = trim( get_option( 'ecademy_purchase_code_status' ) );

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

if ( $pcs == 'valid' ) {
	add_action( 'tgmpa_register', 'ecademy_register_required_plugins' );
}

if ( ! function_exists( 'ecademy_register_required_plugins' ) ) {
	function ecademy_register_required_plugins() {

		$plugins = array(
			
			array(
				'name'               => esc_html__('eCademy Toolkit', 'ecademy'),
				'slug'               => 'ecademy-toolkit',
				'source'             => get_stylesheet_directory() . '/lib/plugins/ecademy-toolkit.zip', 
				'required'           => true,
			),
			
			array(
				'name'               => esc_html__('Elementor Page Builder', 'ecademy'),
				'slug'               => 'elementor',
				'required'           => true,
			),

			array(
				'name'               => esc_html__('Advanced Custom Fields Pro', 'ecademy'),
				'slug'               => 'advanced-custom-fields-pro',
				'source'             => get_stylesheet_directory() . '/lib/plugins/advanced-custom-fields-pro.zip', 
				'required'           => true,
			),

			array(
				'name'      => esc_html__('LearnPress', 'ecademy'),
				'slug'      => 'learnpress',
				'required'  => false,
			),

			array(
				'name'      => esc_html__('LearnPress – Course Review', 'ecademy'),
				'slug'      => 'learnpress-course-review',
				'required'  => false,
			),

			array(
				'name'      => esc_html__('WooCommerce', 'ecademy'),
				'slug'      => 'woocommerce',
				'required'  => false,
			),

			array(
				'name'      => esc_html__('WP Events Manager', 'ecademy'),
				'slug'      => 'wp-events-manager',
				'required'  => false,
			),

			
			// eCademy Plugins
			array(
				'name'      => esc_html__('Contact Form 7', 'ecademy'),
				'slug'      => 'contact-form-7',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('Newsletter', 'ecademy'),
				'slug'      => 'newsletter',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('Front End PM', 'ecademy'),
				'slug'      => 'front-end-pm',
				'required'  => false,
			),
			array(
				'name'		 => esc_html__( 'Unyson', 'ecademy' ),
				'slug'		 => 'unyson',
				'required'	 => true,
			),
			array(
				'name'      => esc_html__('Tutor LMS', 'ecademy'),
				'slug'      => 'tutor',
				'source'    => 'https://themes.envytheme.com/ecademy/wp-content/plugins/tutor.zip', 
				'required'  => false,
			),
		);

		$config = array(
			'id'           => 'tgmpa',
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true, 
			'dismissable'  => true, 
			'dismiss_msg'  => '',   
			'is_automatic' => false, 
			'message'      => '',                      
		);
		tgmpa( $plugins, $config );
	}
}