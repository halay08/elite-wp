<?php
/**
 * Template for displaying message in profile dashboard if user is logged in.
 *
 * This template can be overridden by copying it to ecademy/learnpress/profile/not-logged-in.php.
 *
 * @author  EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Global::profile();

learn_press_display_message( sprintf( __( 'Please <a href="%s">login</a> to see your profile content', 'ecademy' ), $profile->get_login_url() ) );