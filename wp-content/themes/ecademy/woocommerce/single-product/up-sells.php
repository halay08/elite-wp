<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to ecademy/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

	<section class="up-sells upsells products">

		<h2><?php esc_html_e( 'You may also like&hellip;', 'ecademy' ); ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php
					$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>

<?php endif;

wp_reset_postdata();

if ( $upsells ) : ?>
		<?php woocommerce_product_loop_start(); ?>
            <?php foreach ( $upsells as $upsell ) : 
            $post_object = get_post( $upsell->get_id() );?>
            <div class="modal fade productsQuickView" id="productsModalCenter<?php echo esc_attr($post_object->ID,'ecademy');?>" tabindex="-1" role="dialog" aria-labelledby="productsModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="products-image">
                                    <?php woocommerce_template_loop_product_thumbnail(); ?>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="products-content">
                                    <h3><?php the_title(); ?></h3>
                                    <?php woocommerce_template_loop_price(); ?>
                                    <?php woocommerce_template_loop_rating(); ?>
                                    <?php woocommerce_template_single_excerpt(); ?>
                                    <?php  woocommerce_template_single_add_to_cart(); ?>
                                    <div class="product-meta">
                                        <?php woocommerce_template_single_meta(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php endforeach; ?>
		<?php woocommerce_product_loop_end(); ?>
<?php endif;
wp_reset_postdata();