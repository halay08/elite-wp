<?php
/**
 * Template for displaying form allow user get back their order by the key in user profile page.
 *
 * This template can be overridden by copying it to ecademy/learnpress/orders/recover-my-order.php.
 *
 * @author  EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php if ( isset( $order ) && is_a( $order, 'LP_Order' ) ) { ?>

	<?php if ( $order->is_guest() ) { ?>

        <div class="profile-recover-order">
            <p><?php esc_html_e( 'This order was checked out by you but there is no user was assigned to.', 'ecademy' ); ?></p>
            <p><?php esc_html_e( 'If the order is made for another one, you can send the code below to them.', 'ecademy' ); ?></p>
            <p><?php esc_html_e( 'If the order is made for yourself, you can assign it to you here.', 'ecademy' ); ?></p>
			<?php learn_press_get_template( 'order/recover-form.php', array( 'order' => $order ) ); ?>
        </div>

	<?php }
}

