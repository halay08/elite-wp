<?php

if ( !defined( 'FW' ) ) {
	wp_die(  'Forbidden' );
}

$manifest = array();

$manifest[ 'name' ]			 = esc_html__( 'eCademy', 'ecademy' );
$manifest[ 'uri' ]			 = esc_url( 'https://themes.envytheme.com/ecademy/' );
$manifest[ 'description' ]	 = esc_html__( 'Elementor LMS & Online Courses Theme', 'ecademy' );
$manifest[ 'version' ]		 = '4.3';
$manifest[ 'author' ]		 = 'EnvyTheme';
$manifest[ 'author_uri' ]	 = esc_url( 'https://themes.envytheme.com/ecademy/' );
$manifest[ 'requirements' ]	 = array(
	'wordpress' => array(
		'min_version' => '4.3',
	),
);

$manifest[ 'id' ] = 'scratch';

$manifest[ 'supported_extensions' ] = array(
	'backups'		 => array(),
);

?>
