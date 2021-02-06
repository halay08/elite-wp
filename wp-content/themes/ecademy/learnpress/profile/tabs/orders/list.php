<?php
/**
 * Template for displaying list orders in orders tab of user profile page.
 *
 * This template can be overridden by copying it to ecademy/learnpress/orders/list.php.
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

$query_orders = $profile->query_orders( array( 'fields' => 'ids' ) );
if ( ! $query_orders['items'] ) {
	learn_press_display_message( __( 'No orders!', 'ecademy' ) );

	return;
} ?>

<h3 class="profile-heading"><?php esc_html_e( 'My Orders', 'ecademy' ); ?></h3>

<div class="table-responsive">
	<table class="lp-list-table profile-list-orders profile-list-table">
		<thead>
			<tr class="order-row">
				<th class="column-order-number"><?php esc_html_e( 'Order', 'ecademy' ); ?></th>
				<th class="column-order-date"><?php esc_html_e( 'Date', 'ecademy' ); ?></th>
				<th class="column-order-status"><?php esc_html_e( 'Status', 'ecademy' ); ?></th>
				<th class="column-order-total"><?php esc_html_e( 'Total', 'ecademy' ); ?></th>
				<th class="column-order-action"><?php esc_html_e( 'Action', 'ecademy' ); ?></th>
			</tr>
		</thead>

		<tbody>
		<?php foreach ( $query_orders['items'] as $order_id ) {
			$order = learn_press_get_order( $order_id ); ?>
			<tr class="order-row">
				<td class="column-order-number"><?php echo wp_kses_post( $order->get_order_number() ); ?></td>
				<td class="column-order-date"><?php echo wp_kses_post( $order->get_order_date() ); ?></td>
				<td class="column-order-status">
					<span class="lp-label label-<?php echo esc_attr( $order->get_status() ); ?>"><?php echo wp_kses_post( $order->get_order_status_html() ); ?></span>
				</td>
				<td class="column-order-total"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
				<td class="column-order-action">
					<?php
					if ( $actions = $order->get_profile_order_actions() ) {
						foreach ( $actions as $action ) {
							printf( '<a href="%s">%s</a>', $action['url'], $action['text'] );
						}
					}
					?>
				</td>
			</tr>
		<?php } ?>
		</tbody>

		<tfoot>
		<tr class="list-table-nav">
			<td colspan="2" class="nav-text"><?php echo wp_kses_post( $query_orders->get_offset_text() ); ?></td>
			<td colspan="3" class="nav-pages"><?php $query_orders->get_nav_numbers( true ); ?></td>
		</tr>
		</tfoot>

	</table>
</div>