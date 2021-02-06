<?php
if ( !defined( 'ABSPATH' ) )
	wp_die(  'Direct access forbidden.' );



if ( !function_exists( 'ecademy_resize' ) ) {

	function ecademy_resize( $url, $width = false, $height = false, $crop = false ) {
		if ( function_exists( 'fw_resize' ) ) {
			$fw_resize	 = FW_Resize::getInstance();
			$response	 = $fw_resize->process( $url, $width, $height, $crop );
			return (!is_wp_error( $response ) && !empty( $response[ 'src' ] ) ) ? $response[ 'src' ] : $url;
		} else {
			if ( !empty( $url ) ) {
				return $url;
			}
		}
	}

}
// Gets unyson image url from option data in a much simple way
if ( !function_exists( 'ecademy_get_image' ) ) {

	function ecademy_get_image( $k, $v = '', $d = false ) {

		if ( $d == true ) {
			$attachment = $k;
		} else {
			$attachment = ecademy_get_option( $k );
		}

		if ( isset( $attachment[ 'url' ] ) && !empty( $attachment ) ) {
			$v = $attachment[ 'url' ];
		}

		return $v;
	}

}
/* Gets unyson image url from variable
 * ecademy_image($img, $alt )
 */

if ( !function_exists( 'ecademy_image' ) ) {

	function ecademy_image( $img, $alt, $v = '' ) {

		if ( isset( $img[ 'url' ] ) && !empty( $img ) ) {
			$i	 = $img[ 'url' ];
			$v	 = "<img src=" . $i . " alt=" . $alt . " />";
		}

		return $v;
	}

}