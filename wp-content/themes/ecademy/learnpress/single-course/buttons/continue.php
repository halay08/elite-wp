<?php
/**
 * Template for displaying Continue button in single course.
 *
 * This template can be overridden by copying it to ecademy/learnpress/single-course/buttons/continue.php.
 *
 * @author  EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$user = LP_Global::user();
?>

<form name="continue-course" class="continue-course form-button lp-form" method="post"
      action="<?php echo wp_kses_post( $user->get_current_item( get_the_ID(), true ) ); ?>">

    <button type="submit" class="default-btn"><i class="flaticon-right"></i><?php esc_html_e( 'Continue', 'ecademy' ); ?><span></span></button>

</form>
