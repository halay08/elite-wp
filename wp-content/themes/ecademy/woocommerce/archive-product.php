<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to ecademy/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

global $ecademy_opt;

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

do_action( 'woocommerce_before_main_content' );

if ( isset( $ecademy_opt['enable_shop_pages_banner'] ) ): 
    $hide_banner        = $ecademy_opt['enable_shop_pages_banner'];
else:
    $hide_banner        = false;
endif;

if( $hide_banner == true ):
    $pt_165   = '';
else:
    $pt_165   = 'pt-165';
endif;
?>
  
<div class="products-area ptb-100 <?php echo esc_attr( $pt_165 ); ?>">
    <div class="container">
        <div class="row">
            <?php if ( is_active_sidebar( 'shop' ) ): ?>
                 <?php if ( isset( $_GET['shop-sidebar'] ) ): ?>
                    <?php  $ecademy_shop_cat_sidebar = $_GET['shop-sidebar']; ?>
                    <?php if ( $ecademy_shop_cat_sidebar == 'none' ): ?>
                        <div class="col-lg-12 col-md-12">
                    <?php elseif ( $ecademy_shop_cat_sidebar == 'left' ): ?>
                        <?php do_action( 'woocommerce_sidebar' ); ?>
                        <div class="col-lg-8 col-md-12">
                    <?php elseif ( $ecademy_shop_cat_sidebar == 'right' ): ?>
                        <div class="col-lg-8 col-md-12">
                    <?php endif; ?>
                <?php else: ?>
                    <?php if( $ecademy_opt['ecademy_product_sidebar'] == 'ecademy_product_left_sidebar' ): ?>
                        <?php do_action( 'woocommerce_sidebar' ); ?>
                        <div class="col-lg-8 col-md-12">
                    <?php elseif ( $ecademy_opt['ecademy_product_sidebar'] == 'ecademy_product_right_sidebar' ): ?>
                        <div class="col-lg-8 col-md-12">
                    <?php else: ?>
                        <div class="col-lg-12 col-md-12">
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
                <div class="col-lg-12 col-md-12">
            <?php endif; ?>
                <?php
                if ( woocommerce_product_loop() ) {

                    /**
                     * Hook: woocommerce_before_shop_loop.
                     *
                     * @hooked woocommerce_output_all_notices - 10
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */

                    ?>
                    <div class="woocommerce-topbar">
                        <?php do_action( 'woocommerce_before_shop_loop' ); ?>
                    </div>
                    <?Php

                    woocommerce_product_loop_start();

                    if ( wc_get_loop_prop( 'total' ) ) {
                        while ( have_posts() ) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             *
                             * @hooked WC_Structured_Data::generate_product_data() - 10
                             */
                            do_action( 'woocommerce_shop_loop' );

                            wc_get_template_part( 'content', 'product' );
                        }
                    }

                    woocommerce_product_loop_end();

                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action( 'woocommerce_after_shop_loop' );
                } else {
                    /**
                     * Hook: woocommerce_no_products_found.
                     *
                     * @hooked wc_no_products_found - 10
                     */
                    do_action( 'woocommerce_no_products_found' );
                }
                ?>
            </div> <!-- end clo-8 -->
            
            <?php 
            if ( isset( $_GET['shop-sidebar'] ) ):
                if ( $ecademy_shop_cat_sidebar == 'right' ) :
                    do_action( 'woocommerce_sidebar' );
                endif; 
            else:
                if ( $ecademy_opt['ecademy_product_sidebar'] == 'ecademy_product_right_sidebar' ):
                    do_action( 'woocommerce_sidebar' );
                endif; 
            endif; 
            ?>
        </div>
            <?php
            /**
             * Hook: woocommerce_after_main_content.
             *
             * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
             */
            do_action( 'woocommerce_after_main_content' );

            /**
             * Hook: woocommerce_sidebar.
             *
             * @hooked woocommerce_get_sidebar - 10
             */

            get_footer( 'shop' );

            ?>
        </div>
    </div>
</div>
