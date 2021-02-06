<?php
/**
 * Template for displaying order details tab in user profile page.
 *
 * This template can be overridden by copying it to ecademy/learnpress/tabs/order-details.php.
 *
 * @author   EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Profile::instance();

do_action( 'learn-press/profile/order-details' );