<?php

/**
 * Display single course add to cart
 *
 * @since v.1.0.0
 * @author envytheme
 * @url https://envytheme.com
 *
 * @package eCademy/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) )
	exit;
$isLoggedIn = is_user_logged_in();

$monetize_by = tutils()->get_option('monetize_by');
$enable_guest_course_cart = tutor_utils()->get_option('enable_guest_course_cart');

$is_purchasable = tutor_utils()->is_course_purchasable();

global $ecademy_opt;

$external_link = get_field( 'tutor_external_link' );

if( isset( $ecademy_opt['buy_course_title'] ) ):
    $buy_course_title   = $ecademy_opt['buy_course_title'];
else:
    $buy_course_title   = esc_html__('Buy Course', 'ecademy');
endif;

if( get_field( 'tutor_course_buy_now_title' ) != '' ):
    $buy_course_title           = get_field( 'tutor_course_buy_now_title' );
endif;

$required_loggedin_class = '';
if ( ! $isLoggedIn){
	$required_loggedin_class = apply_filters('tutor_enroll_required_login_class', 'cart-required-login');
}
if ($is_purchasable && $monetize_by === 'wc' && $enable_guest_course_cart){
	$required_loggedin_class = '';
}

$tutor_form_class = apply_filters( 'tutor_enroll_form_classes', array(
	'tutor-enroll-form',
) );

$tutor_course_sell_by = apply_filters('tutor_course_sell_by', null);

do_action('tutor_course/single/add-to-cart/before');
?>

    <?php if( $external_link == '' ){ ?>
        <div class="tutor-single-add-to-cart-box <?php echo $required_loggedin_class; ?> ">
            <?php
            if ($is_purchasable && $tutor_course_sell_by){
                tutor_load_template('single.course.add-to-cart-'.$tutor_course_sell_by);
            }else{
                ?>
                <form class="<?php echo implode( ' ', $tutor_form_class ); ?>" method="post">
                    <?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
                    <input type="hidden" name="tutor_course_id" value="<?php echo get_the_ID(); ?>">
                    <input type="hidden" name="tutor_course_action" value="_tutor_course_enroll_now">

                    <div class=" tutor-course-enroll-wrap">
                        <button type="submit" class="tutor-btn-enroll tutor-btn tutor-course-purchase-btn">
                            <?php echo esc_html( $buy_course_title ); ?>
                        </button>
                    </div>
                </form>
            <?php } ?>
        </div>
    <?php }else{ ?>
        <div class="tutor-single-add-to-cart-box">
            <form method="post">
                <div class=" tutor-course-enroll-wrap">
                    <a href="<?php echo esc_url( $external_link ); ?>" target="_blank" class="tutor-btn-enroll tutor-btn tutor-course-purchase-btn">
                        <?php echo esc_html( $buy_course_title ); ?>
                    </a>
                </div>
            </form>
        </div>
    <?php } ?>

<?php do_action('tutor_course/single/add-to-cart/after'); ?>
