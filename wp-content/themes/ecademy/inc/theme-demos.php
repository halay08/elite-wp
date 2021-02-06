<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Initializing online demo contents
function _filter_ecademy_fw_ext_backups_demos( $demos ) {
	$demos_array			 = array(
		'learnpress-demo'	=> array(
			'title'			 => esc_html__( 'LearnPress Demo', 'ecademy' ),
			'screenshot'	 => esc_url( get_template_directory_uri() ) . '/assets/img/demos/lp.png',
			'preview_link'	 => esc_url( 'https://themes.envytheme.com/ecademy/' ),
		),		
		'tutor-demo'		=> array(
			'title'			 => esc_html__( 'Tutor LMS Demo', 'ecademy' ),
			'screenshot'	 => esc_url( get_template_directory_uri() ) . '/assets/img/demos/tutor.png',
			'preview_link'	 => esc_url( 'https://themes.envytheme.com/ecademy-tutor/' ),
		),		
		'learndash-demo'		=> array(
			'title'			 => esc_html__( 'LearnDash Demo', 'ecademy' ),
			'screenshot'	 => esc_url( get_template_directory_uri() ) . '/assets/img/demos/ld.png',
			'preview_link'	 => esc_url( 'https://themes.envytheme.com/ecademy/' ),
		),		
	);
	
	$download_url	 = 'https://themes.jibdara.com/ecademy/wp-content/demo-content/';

	foreach ( $demos_array as $id => $data ) {
		$demo			 = new FW_Ext_Backups_Demo( $id, 'piecemeal', array(
			'url'		 => $download_url,
			'file_id'	 => $id,
		) );
		$demo->set_title( $data[ 'title' ] );
		$demo->set_screenshot( $data[ 'screenshot' ] );
		$demo->set_preview_link( $data[ 'preview_link' ] );
		$demos[ $demo->get_id() ]	 = $demo;
		unset( $demo );
	}
	return $demos;
}
add_filter( 'fw:ext:backups-demo:demos', '_filter_ecademy_fw_ext_backups_demos' );