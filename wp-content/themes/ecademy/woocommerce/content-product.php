<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to ecademy/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?> >
    <div class="single-products single-products-box">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action( 'woocommerce_before_shop_loop_item' );

        /**
         * Hook: woocommerce_before_shop_loop_item_title.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */

        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
         ?>
        

        <div class="products-image">
            <?php woocommerce_template_loop_product_thumbnail(); ?>
            <ul class="product-btn-hover">
                <li class="product-link">
                    <a href="#" data-toggle="modal" data-target="#productsModalCenter<?php echo esc_attr(get_the_ID(),'ecademy');?>">
                        <i class="fa fa-eye"></i>
                    </a>
                </li>
                <li><a href="<?php the_permalink(); ?>"><i class="fa fa-link" aria-hidden="true"></i></a></li>
            </ul>
        </div>

        <div class="products-content">
            <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
            <?php woocommerce_template_loop_price(); ?>
            <?php 
            $rating_count = $product->get_rating_count();
            if($product->get_rating_count() == 0){
            ?>
            <ul>
                <li><i class="fa fa-star-o"></i></li>
                <li><i class="fa fa-star-o"></i></li>
                <li><i class="fa fa-star-o"></i></li>
                <li><i class="fa fa-star-o"></i></li>
                <li><i class="fa fa-star-o"></i></li>
            </ul>
            <?php
            }else{
                woocommerce_template_loop_rating(); 
            }
            ?>
            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>
        <?php woocommerce_show_product_sale_flash(); ?>
        <?php
        do_action( 'woocommerce_before_shop_loop_item_title' );

        /**
         * Hook: woocommerce_shop_loop_item_title.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        

        do_action( 'woocommerce_shop_loop_item_title' );

        /**
         * Hook: woocommerce_after_shop_loop_item_title.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action( 'woocommerce_after_shop_loop_item_title' );

        /**
         * Hook: woocommerce_after_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */

        do_action( 'woocommerce_after_shop_loop_item' );
        ?>
    </div>

    <!-- Start Products Modal -->
        <div class="modal productsQuickView fade" id="productsModalCenter<?php echo esc_attr(get_the_ID(),'ecademy');?>" tabindex="-1" role="dialog" aria-labelledby="productsModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="products-image">
                            <?php the_post_thumbnail( 'full' ); ?>
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
    <!-- End Products Modal -->
</li>