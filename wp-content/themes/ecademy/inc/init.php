<?php

if ( !defined( 'ABSPATH' ) )
	wp_die(  'Direct access forbidden.' );

class Ecademy_Theme_Includes {

	private static $rel_path	 = null;
	private static $initialized	 = false;

	public static function init() {


		if ( class_exists( 'XsCustomPost\Xs_CustomPost' ) ) {
	
			$tab = new XsCustomPost\Xs_CustomPost( 'ecademy' );
	
		}

		if ( self::$initialized ) {
			return;
		} else {
			self::$initialized = true;
		}

		/**
		 * Both frontend and backend
		 */ {
			self::include_child_first( '/helpers.php' );
		}

	}
	private static function get_rel_path( $append = '' ) {
		if ( self::$rel_path === null ) {
			self::$rel_path = '/inc';
		}

		return self::$rel_path . $append;
	}

	public static function get_parent_path( $rel_path ) {
		return get_template_directory() . self::get_rel_path( $rel_path );
	}

	public static function get_child_path( $rel_path ) {
		if ( !is_child_theme() ) {
			return null;
		}

		return get_stylesheet_directory() . self::get_rel_path( $rel_path );
	}

	public static function include_isolated( $path ) {
        include $path;
	}

	public static function include_child_first( $rel_path ) {
		if ( is_child_theme() ) {
			$path = self::get_child_path( $rel_path );

			if ( file_exists( $path ) ) {
				self::include_isolated( $path );
			}
		} {
			$path = self::get_parent_path( $rel_path );

			if ( file_exists( $path ) ) {
				self::include_isolated( $path );
			}
		}
	}
}

Ecademy_Theme_Includes::init();