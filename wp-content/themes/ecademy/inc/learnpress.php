<?php
/**
 * Custom functions for LearnPress
 */

remove_action( 'learn-press/before-become-teacher-form', 'learn_press_become_teacher_heading', 10 );
remove_action( 'learn-press/become-teacher-form', 'learn_press_become_teacher_form_fields', 5 );
add_action( 'learn-press/become-teacher-form', 'ecademy_become_teacher_form_fields', 5 );
if ( ! function_exists( 'ecademy_become_teacher_form_fields' ) ) {
	function ecademy_become_teacher_form_fields() {
		include_once LP_PLUGIN_PATH . 'inc/admin/meta-box/class-lp-meta-box-helper.php';
		learn_press_get_template( 'global/become-teacher-form/form-fields.php', array( 'fields' => learn_press_get_become_a_teacher_form_fields() ) );
	}
}
remove_action( 'learn-press/after-become-teacher-form', 'learn_press_become_teacher_button', 10 );
add_action( 'learn-press/after-become-teacher-form', 'ecademy_become_teacher_button', 10 );
if ( ! function_exists( 'ecademy_become_teacher_button' ) ) {
	function ecademy_become_teacher_button() {
		learn_press_get_template( 'global/become-teacher-form/button.php' );
	}
}