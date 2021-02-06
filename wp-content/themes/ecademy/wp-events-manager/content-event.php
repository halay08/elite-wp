<?php
/**
 * The Template for displaying content events.
 *
 * Override this template by copying it to ecademy/wp-events-manager/content-event.php
 *
 * @author        EnvyTheme
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php
	/**
	 * tp_event_before_loop_event hook
	 *
	 */
	 do_action( 'tp_event_before_loop_event' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div id="event-<?php the_ID(); ?>" <?php post_class('col-lg-4 col-sm-6 col-md-6'); ?>>

	<?php
		/**
		 * tp_event_before_loop_event_summary hook
		 *
		 * @hooked tp_event_show_event_sale_flash - 10
		 * @hooked tp_event_show_event_images - 20
		 */
		do_action( 'tp_event_before_loop_event_item' );
	?>

	<div class="single-events-box">
        <div class="image">
            <a href="<?php the_permalink(); ?>" class="d-block">
                <?php the_post_thumbnail( 'ecademy_default_thumb' ); ?>
            </a>
            <span class="date">
				<?php $time_from = get_post_meta( get_the_ID(), 'tp_event_date_start', true ) ? strtotime( get_post_meta( get_the_ID(), 'tp_event_date_start', true ) ) : time(); ?>
				<?php echo date_i18n( get_option( 'date_format' ), $time_from ); ?>
            </span>
        </div>

        <div class="content">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <span class="location"><i class="bx bx-map"></i><?php echo esc_html( get_field( 'event_location' ) ); ?></span>
        </div>
	</div><!-- .summary -->

	<?php
		/**
		 * tp_event_after_loop_event_item hook
		 *
		 * @hooked tp_event_show_event_sale_flash - 10
		 * @hooked tp_event_show_event_images - 20
		 */
		do_action( 'tp_event_after_loop_event_item' );
	?>

</div>

<?php do_action( 'tp_event_after_loop_event' ); ?>
