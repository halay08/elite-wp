<?php
/**
 * The Template for displaying content single event.
 *
 * Override this template by copying it to eCademy/wp-events-manager/content-single-event.php
 *
 * @author        EnvyTheme
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if( function_exists('acf_add_options_page') ) {
    $bg_image   = get_field( 'event_single_page_banner_background_image' );
}else {
    $bg_image   = '';
}

global $ecademy_opt;
if( isset( $ecademy_opt['enable_lazyloader'] ) ):
	$is_lazyloader = $ecademy_opt['enable_lazyloader'];
else:
	$is_lazyloader = true;
endif;
?>

<article id="tp_event-<?php the_ID(); ?>" <?php post_class( 'events-details-area pb-100' ); ?>>
    <div class="events-details-image">
        <?php if( $bg_image != '' ): ?>
            <?php if( $is_lazyloader == true ): ?>
                <img sm-src="<?php echo esc_url( $bg_image ); ?>" alt="<?php esc_attr_e( 'Events Details Image', 'ecademy' ) ?>">
            <?php else: ?>
                <img src="<?php echo esc_url( $bg_image ); ?>" alt="<?php esc_attr_e( 'Events Details Image', 'ecademy' ) ?>">
            <?php endif; ?>

            <div id="timer" class="flex-wrap d-flex justify-content-center">
                <?php
                    /**
                     * tp_event_loop_event_countdown hook
                     */
                    do_action( 'tp_event_loop_event_countdown' );
                ?>
            </div>
        <?php endif; ?>
    </div>
            
    <div class="container">
        <?php
        /**
         * tp_event_before_single_event hook
         *
         */
        do_action( 'tp_event_before_single_event' );
        ?>

        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="events-details-header">
                    <ul>
                    <?php
                        $date_start = get_post_meta( get_the_ID(), 'tp_event_date_start', true ) ? strtotime( get_post_meta( get_the_ID(), 'tp_event_date_start', true ) ) : time();
                        $date_end   = get_post_meta( get_the_ID(), 'tp_event_date_end', true ) ? strtotime( get_post_meta( get_the_ID(), 'tp_event_date_end', true ) ) : time();
                        $time_start = wpems_event_start( get_option( 'time_format' ) );
                        $time_end   = wpems_event_end( get_option( 'time_format' ) );

                        $date_string = '';
                        if ( $date_start === $date_end ) {
                            $date_string = date_i18n( get_option( 'date_format' ), $date_start );
                        } else {
                            $date_string = date_i18n( get_option( 'date_format' ), $date_start ) . ' - ' . date_i18n( get_option( 'date_format' ), $date_end );
                        }
                    ?>
                
                        <li><i class='bx bx-calendar'></i><?php echo esc_html( $date_string ); ?></li>
                        <li><i class='bx bx-map'></i><?php echo esc_html( get_field( 'event_location' ) ); ?></li>
                        <li><i class='bx bx-time' ></i><?php echo esc_html( $time_start . ' - ' . $time_end ); ?></li>
                        
                    </ul>
                </div>
                <?php
                /**
                 * tp_event_loop_event_location hook
                 */
                do_action( 'tp_event_loop_event_location' );
                ?>
                <?php the_content(); ?>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="events-details-info">
                    <?php
                    /**
                     * tp_event_after_single_event hook
                     *
                     * @hooked tp_event_after_single_event - 10
                     */
                    do_action( 'tp_event_after_single_event' );
                    ?>
                </div>
            </div>
            
        </div>
    </div>

</article><!-- #product-<?php the_ID(); ?> -->