<?php
if ( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class eCademy_admin_dashboard extends eCademy_admin_page {

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {

		$this->id = 'ecademy';
		$this->page_title = esc_html__( 'eCademy Dashboard', 'ecademy' );
		$this->menu_title = esc_html__( 'Register eCademy', 'ecademy' );
		$this->position = '50';

		parent::__construct();
	}

	/**
	 * [display description]
	 * @method display
	 * @return [type]  [description]
	 */
	public function display() {
		include_once( get_template_directory() . '/inc/admin/dashboard/dashboard.php' );
	}

	/**
	 * [save description]
	 * @method save
	 * @return [type] [description]
	 */
	public function save() {

	}
}
new eCademy_admin_dashboard;
