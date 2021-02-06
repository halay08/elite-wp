<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to ecademy/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
        <?php
        /**
         * Hook: woocommerce_before_single_product_summary.
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action( 'woocommerce_before_single_product_summary' );
        ?>
   
        <div class="summary entry-summary products-details">
            <?php
            /**
             * Hook: woocommerce_single_product_summary.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11);
            do_action( 'woocommerce_single_product_summary' );
            woocommerce_template_single_add_to_cart();

            global $ecademy_opt;
            $is_social_share   = !empty($ecademy_opt['enable_product_share']) ? $ecademy_opt['enable_product_share'] : '';
            if( $is_social_share == '1' ):
            $share_url      = get_the_permalink();
            $share_title    = get_the_title();
            $share_desc     = get_the_excerpt();
            ?>
                <div class="products-share">
                    <ul class="social">
                        <?php if( $ecademy_opt['enable_social_share_title'] != '' ): ?>
                            <li><span><?php echo esc_html( $ecademy_opt['enable_social_share_title'] ); ?></span></li>
                        <?php endif; ?>
                        
                        <?php if( $ecademy_opt['enable_product_fb'] == '1' ): ?>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($share_url); ?>" onclick="window.open(this.href, 'facebook-share','width=580,height=296'); return false;" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                        <?php endif; ?>

                        <?php if( $ecademy_opt['enable_product_tw'] == '1' ): ?>
                            <li><a href="https://twitter.com/share?text=<?php echo urlencode($share_title); ?>&url=<?php echo esc_url($share_url); ?>" class="twitter" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                        <?php endif; ?>
                        
                        <?php if( $ecademy_opt['enable_product_ld'] == '1' ): ?>
                            <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($share_url); ?>&amp;title=<?php echo urlencode($share_title); ?>&amp;summary=&amp;source=<?php bloginfo('name'); ?>" onclick="window.open(this.href, 'linkedin','width=580,height=296'); return false;" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                        <?php endif; ?>
                        
                        <?php if( $ecademy_opt['enable_product_wp'] == '1' ): ?>
                            <?php if ( wp_is_mobile() != true ) : ?>
                                <li><a href="https://api.whatsapp.com/send?phone=whatsappphonenumber&text=<?php echo esc_url($share_url); ?>" data-action="share/whatsapp/share" class="whatsapp" target="_blank"><i class='bx bxl-whatsapp'></i></a></li>
                            <?php else : ?>
                                <li><a href="whatsapp://send?text=<?php echo esc_url($share_url); ?>" class="whatsapp" target="_blank"><i class='bx bxl-whatsapp'></i></a></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if( $ecademy_opt['enable_product_email'] == '1' ): ?>
                            <li><a href="mailto:?subject=<?php echo urlencode($share_title); ?> | <?php echo urlencode($share_desc); ?>&body=<?php echo esc_url($share_url); ?>" class="email" target="_blank"><i class='bx bx-mail-send' ></i></a></li>
                        <?php endif; ?>

                        <?php if( $ecademy_opt['enable_product_cp'] == '1' ): ?>
                            <li><a class="copy" href="#" onclick="prompt('Press Ctrl + C, then Enter to copy to clipboard','<?php echo esc_url($share_url); ?>')"><i class='bx bxs-copy' ></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>            
	    </div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
