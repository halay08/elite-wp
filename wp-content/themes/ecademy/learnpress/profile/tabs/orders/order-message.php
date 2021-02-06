<?php
/**
 * @author  EnvyTheme
 * @package LearnPress/Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) or exit();

if ( ! isset( $order ) ) {
	return;
}

$profile = LP_Profile::instance();
?>

<?php if ( $order->get_user_id() != get_current_user_id() ) { ?>

    <p><?php printf( __( 'This order is paid for %s', 'ecademy' ), $order->get_user_email() ); ?></p>

<?php } else { ?>

	<?php if ( ( $checkout_email = $order->get_checkout_email() ) && $checkout_email != $profile->get_user()->get_email() ) { ?>

        <p><?php printf( __( 'This order is paid by %s', 'ecademy' ), $order->get_checkout_email() ); ?></p>

		<?php
	}
}