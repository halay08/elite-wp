<?php
/**
 * The banner for eCademy theme
 * 
 * @package eCademy
 */

global $ecademy_opt;

if( isset( $ecademy_opt['enable_lazyloader'] ) ):
	$is_lazyloader = $ecademy_opt['enable_lazyloader'];
else:
	$is_lazyloader = true;
endif;

// Background Image
$background_type = function_exists('get_field') ? get_field('banner_background_type') : '';
$background_image = '';
if ( $background_type == 'image' ) {
    $background_image = function_exists('get_field') ? get_field('banner_background_image') : '';
    $background_image = !empty( $background_image ) ? "style='background: url( $background_image ); background-size: cover; background-position: center center; background-repeat: no-repeat;'" : '';
} elseif ( $background_type == 'color' ) {
    $background_image = '';
}

$banner_alignment   = function_exists( 'get_field' ) ? get_field( 'banner_alignment' ) : '1';
$banner_alignment   = isset( $banner_alignment ) ? $banner_alignment : '1';
$is_breadcrumb      = isset( $ecademy_opt['is_breadcrumb']) ? $ecademy_opt['is_breadcrumb'] : '1';
$is_shape_image     = isset( $ecademy_opt['enable_shape_images']) ? $ecademy_opt['enable_shape_images'] : '1';

?>


<div class="page-title-area" <?php echo wp_kses_post( $background_image ); ?>>
    <div class="container">
        <div class="page-title-content">
            <h2 <?php if( $banner_alignment != '1' ): ?>class="text-left"<?php endif; ?>><?php ecademy_banner_title(); ?></h2>
            <?php if( $is_breadcrumb == '1' ): ?>
                <?php if( $is_breadcrumb == '1' ): ?>
                    <?php if(class_exists( 'bbPress' ) && is_bbpress()) { ?>
                        <div class="bbpress-breadcrumbs"></div>
                        <?php
                    }elseif ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                    }elseif ( class_exists( 'WooCommerce' ) && is_singular('product') ) { ?>
                        <?php woocommerce_breadcrumb(); ?>
                    <?php if( $banner_alignment != '1' ): ?></div><?php endif; ?>
                    <?php }else{ ?>
                        <ul <?php if( $banner_alignment != '1' ): ?>class="text-left"<?php endif; ?>>
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ecademy' ); ?></a></li>
                            <li><?php ecademy_banner_title(); ?></li>
                        </ul>
                    <?php } ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php if( $is_shape_image == '1' && isset( $ecademy_opt['shape_image1']['url'] )): ?>
        <?php if( $ecademy_opt['shape_image1']['url'] != '' ): ?>
            <div class="shape9">
                <?php if( $is_lazyloader == true ): ?>
                    <img sm-src="<?php echo esc_url( $ecademy_opt['shape_image1']['url'] ); ?>" alt="<?php esc_attr_e( 'Shape Image One', 'ecademy' ); ?>">
                <?php else: ?>
                    <img src="<?php echo esc_url( $ecademy_opt['shape_image1']['url'] ); ?>" alt="<?php esc_attr_e( 'Shape Image One', 'ecademy' ); ?>">
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>