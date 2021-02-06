<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package eCademy
 */

global $ecademy_opt;

if( isset( $ecademy_opt['enable_lazyloader'] ) ):
	$is_lazyloader = $ecademy_opt['enable_lazyloader'];
else:
	$is_lazyloader = true;
endif;

get_header();

if ( isset( $ecademy_opt['title_not_found'] ) ):
	$image 				= $ecademy_opt['not_found_image']['url'];
	$title 				= $ecademy_opt['title_not_found'];
	$content 			= $ecademy_opt['content_not_found'];
	$button_text 		= $ecademy_opt['button_not_found'];
	$go_back_button		= $ecademy_opt['button_two_not_found'];
else:
	$image 				= '';
	$title 				= esc_html__('Error 404 : Page Not Found', 'ecademy');
	$content 			= esc_html__('The page you are looking for might have been removed had its name changed or is temporarily unavailable.', 'ecademy');
	$button_text 		= esc_html__('Homepage', 'ecademy');
	$go_back_button 	= esc_html__('Go Back', 'ecademy');
endif;
?>
	<div class="error-area">
		<div class="d-table">
			<div class="d-table-cell">
				<div class="container">
					<div class="error-content">
						<?php if( $image != '' ): ?>
                            <?php if( $is_lazyloader == true ): ?>
								<img sm-src="<?php echo esc_url( $image ); ?>" alt="<?php esc_attr_e('404 Image', 'ecademy'); ?>">
                            <?php else: ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php esc_attr_e('404 Image', 'ecademy'); ?>">
                            <?php endif; ?>
						<?php else: ?>
                            <?php if( $is_lazyloader == true ): ?>
								<img sm-src="<?php echo esc_url( ECADEMY_IMG .'/error.png' ); ?>" alt="<?php esc_attr_e('404 Image', 'ecademy'); ?>">
                            <?php else: ?>
								<img src="<?php echo esc_url( ECADEMY_IMG .'/error.png' ); ?>" alt="<?php esc_attr_e('404 Image', 'ecademy'); ?>">
                            <?php endif; ?>
						<?php endif; ?>
						<h3><?php echo esc_html( $title ); ?></h3>
						<p><?php echo esc_html( $content ); ?></p>
						<div class="btn-box">
							<?php if( $go_back_button != '' ): ?>
								<a href="javascript:history.back()" class="default-btn"><i class="flaticon-history"></i><?php echo esc_html( $go_back_button ); ?><span></span></a>
							<?php endif; ?>

							<?php if( $button_text != '' ): ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="default-btn"><i class="flaticon-home"></i><?php echo esc_html( $button_text ); ?><span></span></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer();