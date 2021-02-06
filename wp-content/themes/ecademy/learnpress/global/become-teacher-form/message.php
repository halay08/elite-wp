<?php
/**
 * Template for displaying message in become teacher form.
 *
 * This template can be overridden by copying it to ecademy/learnpress/global/become-teacher-form/message.php.
 *
 * @author  EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
$user = learn_press_get_current_user( false );
?>

<?php if ( ! isset( $messages ) ) {
	return;
} ?>

<?php
if( $user && ! $user instanceof LP_User_Guest ) {
    foreach ( $messages as $code => $message ) {
        learn_press_display_message( $message );
    }
}
