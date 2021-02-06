<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to ecademy/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related products">

		<h2><?php esc_html_e( 'Related products', 'ecademy' ); ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

				<?php
				 	$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

        <?php woocommerce_product_loop_end(); ?>
        
        <?php if ( $related_products ) :
            woocommerce_product_loop_start();
                foreach ( $related_products as $related_product ) : ?>
                    <?php
                        $post_object = get_post( $related_product->get_id() );

                        // setup_postdata( $GLOBALS['post'] =& $post_object );

                        $args = array(
                            'post_type'           => 'product',
                            'post_status'         => 'publish',
                            'posts_per_page'      => '-1',
                        );
                        // Hide hidden items
                        $args['meta_query'][] = WC()->query->visibility_meta_query();
            
                        $products = new WP_Query( $args );
            
                        if ( $products->have_posts() ) : ?>
            
                            <?php
                            while ( $products->have_posts() ) :
                                $products->the_post();
                                ?>
                                <div class="modal productsQuickView fade" id="productsModalCenter<?php echo esc_attr(get_the_ID(),'ecademy');?>" tabindex="-1" role="dialog" aria-labelledby="productsModalCenterTitle" aria-hidden="true">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            endwhile; 
                        endif;
                        wp_reset_query(); ?>

                <?php 
                endforeach;  
            woocommerce_product_loop_end();
        endif;
        ?>

	</section>

   

<?php endif;

wp_reset_postdata();