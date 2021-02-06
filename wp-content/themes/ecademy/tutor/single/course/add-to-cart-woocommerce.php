<?php
/**
 * @package eCademy/Templates
 * @version 1.4.3
 */

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

$product_id = tutor_utils()->get_course_product_id();
$product = wc_get_product( $product_id );
if ($product) {
	?>

    <?php if( $external_link == '' ){ ?>
        <div class="tutor-course-purchase-box">

            <form class="cart"
                action="<?php echo esc_url( apply_filters( 'tutor_course_add_to_cart_form_action', get_permalink( get_the_ID() ) ) ); ?>"
                method="post" enctype='multipart/form-data'>

                <?php do_action( 'tutor_before_add_to_cart_button' ); ?>

                <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button tutor-button alt"> <i class="tutor-icon-shopping-cart"></i> <?php echo esc_html( $buy_course_title ); ?>
                </button>

                <?php do_action( 'tutor_after_add_to_cart_button' ); ?>
            </form>
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

	<?php
}else{
	?>
    <p class="tutor-alert-warning">
		<?php _e('Please make sure that your product exists and valid for this course', 'ecademy'); ?>
    </p>
	<?php
}