<?php
/**
 * The template for displaying the footer
 * @package eCademy
 */

	/**
	 * Footer optional data
	 */
	global $ecademy_opt;

	if( isset( $ecademy_opt['enable_lazyloader'] ) ):
		$is_lazyloader = $ecademy_opt['enable_lazyloader'];
	else:
		$is_lazyloader = true;
	endif;

	if( isset( $ecademy_opt['copyright_text'] )):
		$copyright_text 		= $ecademy_opt['copyright_text'];
		$footer_desc 			= $ecademy_opt['footer_desc'];
		$enable_back_to_top 	= $ecademy_opt['enable_back_to_top'];
		$enable_footer_social 	= $ecademy_opt['enable_footer_social'];
		$enable_footer_line 	= $ecademy_opt['enable_footer_line'];
		$logo 					= $ecademy_opt['footer_main_logo']['url'];
	else:
		$copyright_text 		= '';
		$enable_back_to_top 	= true;
		$logo					= '';
		$footer_desc			= '';
		$enable_footer_social	= false;
		$enable_footer_line		= false;
	endif;
	
	$is_cursor = !empty($ecademy_opt['is_cursor']) ? $ecademy_opt['is_cursor'] : '';
	$footer_visibility 		= function_exists( 'get_field' ) ? get_field( 'footer_visibility' ) : '1';
	$footer_visibility 		= isset($footer_visibility) ? $footer_visibility : '1';
	if( is_home() ) {
		$post_page_id = get_option( 'page_for_posts' );
		$footer_visibility 		= function_exists( 'get_field' ) ? get_field( 'footer_visibility', $post_page_id ) : '1';
		$footer_visibility 		= isset($footer_visibility) ? $footer_visibility : '1';
	}

	// Footer Class
	if( is_active_sidebar( 'footer_widgets' ) ):
		$footer_class = 'footer-area';
	else:
		$footer_class = 'footer-area pt-40';
	endif;

	
	$is_popup_massage 	= !empty($ecademy_opt['enable_popup_massage']) ? $ecademy_opt['enable_popup_massage'] : '';
	$newsletter_type 	= !empty($ecademy_opt['ecademy_newsletter_type']) ? $ecademy_opt['ecademy_newsletter_type'] : '';

?>
	<?php if( $is_popup_massage == '1' ): ?>
		
		<!-- Start Newsletter Modal -->
		<div id="newsletter-modal" class="newsletter-modal modal">
			<div class="newsletter-modal-content">
				<div class="row align-items-center m-0">
					<div class="col-lg-5 col-md-12 p-0">
						<?php if( $ecademy_opt['popup_image']['url'] != '' ): ?>
							<div class="modal-image text-center">
								<img src="<?php echo esc_url( $ecademy_opt['popup_image']['url'] ); ?>" alt="<?php echo esc_attr($ecademy_opt['popup_title']); ?>">
							</div>
						<?php endif; ?>
					</div>

					<div class="col-lg-7 col-md-12 p-0">
						<div class="modal-inner-content text-center">
							<h2><?php echo esc_html( $ecademy_opt['popup_title'] ); ?></h2>
							<span class="sub-text"><?php echo esc_html( $ecademy_opt['popup_desc'] ); ?></span>
							<?php if( $newsletter_type == 'mailchimp' ): ?>
                   				<form class="newsletter-form mailchimp" method="post">
                        			<div class="input-group subcribes">
										<input type="email" name="EMAIL" class="input-newsletter" placeholder="<?php echo esc_attr( $ecademy_opt['popup_place'] ); ?>" required autocomplete="off">

										<?php if( $ecademy_opt['popup_button_text'] != '' ): ?>
											<button type="submit"><?php echo esc_html( $ecademy_opt['popup_button_text'] ); ?><span></span></button>
										<?php endif; ?>
                        			</div>
									<p class="mchimp-errmessage" style="display: none;"></p>
									<p class="mchimp-sucmessage" style="display: none;"></p>
								</form>
								<?php if( isset( $ecademy_opt['action_url'] ) ): ?>
									<script>
										;(function($){
											"use strict";
											$(document).ready(function () {
												// MAILCHIMP
												if ($(".mailchimp").length > 0) {
													$(".mailchimp").ajaxChimp({
														callback: mailchimpCallback,
														url: "<?php echo esc_js($ecademy_opt['action_url']) ?>"
													});
												}
												if ($(".mailchimp_two").length > 0) {
													$(".mailchimp_two").ajaxChimp({
														callback: mailchimpCallback,
														url: "<?php echo esc_js($ecademy_opt['action_url']) ?>" //Replace this with your own mailchimp post URL. Don't remove the "". Just paste the url inside "".
													});
												}
												$(".memail").on("focus", function () {
													$(".mchimp-errmessage").fadeOut();
													$(".mchimp-sucmessage").fadeOut();
												});
												$(".memail").on("keydown", function () {
													$(".mchimp-errmessage").fadeOut();
													$(".mchimp-sucmessage").fadeOut();
												});
												$(".memail").on("click", function () {
													$(".memail").val("");
												});

												function mailchimpCallback(resp) {
													if (resp.result === "success") {
														$(".mchimp-errmessage").html(resp.msg).fadeIn(1000);
														$(".mchimp-sucmessage").fadeOut(500);
													} else if (resp.result === "error") {
														$(".mchimp-errmessage").html(resp.msg).fadeIn(1000);
													}
												}
											});
										})(jQuery)
									</script>
								<?php endif; ?>
							<?php else: ?>
								<form class="newsletter-form" method="post" action="<?php echo home_url(); ?>/?na=s" onsubmit="return newsletter_check(this)">
									<input type="email" name="ne" class="input-newsletter" placeholder="<?php echo esc_attr( $ecademy_opt['popup_place'] ); ?>" required autocomplete="off">

									<?php if( $ecademy_opt['popup_button_text'] != '' ): ?>
										<button type="submit"><?php echo esc_html( $ecademy_opt['popup_button_text'] ); ?><span></span></button>
									<?php endif; ?>
								</form>
							<?php endif ?>
							<p><i class="flaticon-password"></i> <?php echo esc_html( $ecademy_opt['popup_bottom_desc'] ); ?></p>
						</div>
					</div>
				</div>

				<div class="close-btn btn-yes"><i class="flaticon-cancel"></i></div>
			</div>
		</div>
		<!-- End Newsletter Modal -->
	<?php endif; ?>

	<?php
	$footer_style = '';
	if ( !empty( $ecademy_opt['footer_style'] ) ) {
		$footer_style = new WP_Query ( array (
			'post_type'         => 'footer',
			'posts_per_page'    => -1,
			'p'                 => $ecademy_opt['footer_style'],
		));
	}
	if ( $footer_visibility == '1' ):
		if ( !empty( $footer_style ) ):
			if ( $footer_style->have_posts() ):
				while ( $footer_style->have_posts() ) : $footer_style->the_post();
					the_content();
				endwhile;
				wp_reset_postdata();
			endif;
		else: ?>		
			<footer class="<?php echo esc_attr( $footer_class ); ?>">
				<div class="container">
					<div class="row">
						<?php $footer_column = !empty($ecademy_opt['footer_column']) ? $ecademy_opt['footer_column'] : ''; ?>
						<?php if( $footer_desc != '' || $enable_footer_social == true  ): ?>
							<div class="col-lg-<?php echo esc_attr($footer_column); ?> col-md-<?php echo esc_attr($footer_column); ?>">
								<div class="single-footer-widget">
							
									<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
										<?php if( $logo != '' ): ?>
											<?php if( $is_lazyloader == true ): ?>
												<img sm-src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
											<?php else: ?>
												<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
											<?php endif; ?>
										<?php else: ?>
											<h2><?php bloginfo( 'name' ); ?></h2>
										<?php endif; ?>
									</a>
									<?php if( $footer_desc != '' ): ?>
										<p><?php echo esc_html( $footer_desc ); ?></p>
									<?php endif; ?>
									<?php if( $enable_footer_social == true ): ?>
										<?php ecademy_social_link();  ?>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( is_active_sidebar( 'footer_widgets') ) : ?>
							<?php dynamic_sidebar( 'footer_widgets' ); ?>
						<?php endif; ?>
					</div>

					<?php if( has_nav_menu('footer-menu') ){ ?>
						<div class="footer-bottom-area">
							<div class="row align-items-center">
								<div class="col-lg-6 col-md-6">
									<?php if( $copyright_text != '' ){ ?>
										<p><?php echo wp_kses_post( $copyright_text ); ?></p>
									<?php } ?>
								</div>

								<div class="col-lg-6 col-md-6">
									<?php
									if( has_nav_menu('footer-menu') ){
										$args = array(
											'theme_location' 	=> 'footer-menu',
											'menu'            	=> 'footer-menu',
											'container'       	=> 'ul',
											'fallback_cb'  		=> false,
											'menu_class'      	=> 'menu',
											'depth'           	=> 1,
										);
										wp_nav_menu( $args );
									}
									?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>

				<?php if( $enable_footer_line == true ): ?>
					<div class="lines">
						<div class="line"></div>
						<div class="line"></div>
						<div class="line"></div>
					</div>
				<?php endif; ?>
			</footer>
		<?php endif; ?>
	<?php endif; ?>
	<!-- End Footer Area -->

	<?php if( $enable_back_to_top == true ): ?>
    	<div class="go-top"><i class='bx bx-chevron-up'></i></div>
	<?php endif; ?>

	<?php if( $is_cursor == '1' ): ?>
		<div class="container">
			<div class="ecademy-cursor"></div>
			<div class="ecademy-cursor2"></div>
		</div>
	<?php endif; ?>
	<?php 
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if ( strpos($actual_link, 'themes.envytheme.com/ecademy') != false ): ?>
		<div class="et-demo-options-toolbar">
			<?php
			global $wp;
			$current_url = home_url(add_query_arg(array(), $wp->request));
			$home_url = home_url();
			
			?>
			<?php if( ecademy_rtl() == true ): ?>
				<a href="<?php echo esc_url( $current_url ); ?>" class="hint--bounce hint--left hint--black" id="toggle-quick-options" aria-label="LTR Demo">
					<i class='bx bx-left-indent'></i>
				</a>
			<?php else: ?>
				<a href="<?php echo esc_url( $current_url ); ?>/?rtl=enable" class="hint--bounce hint--left hint--black" id="toggle-quick-options" aria-label="RTL Demo">
					<i class='bx bx-right-indent'></i>
				</a>
			<?php endif; ?>

			<?php if( $home_url == 'https://themes.envytheme.com/ecademy' ): ?>
				<a href="<?php echo esc_url( 'https://themes.envytheme.com/ecademy-tutor/' ); ?>" class="hint--bounce hint--left hint--black" id="toggle-quick-options" aria-label="Tutor LMS Demo">
					<i class='bx bx-book-bookmark'></i>
				</a>
			<?php elseif( $home_url == 'https://themes.envytheme.com/ecademy-tutor' ): ?>
				<a href="<?php echo esc_url( 'https://themes.envytheme.com/ecademy/' ); ?>" class="hint--bounce hint--left hint--black" id="toggle-quick-options" aria-label="LearnPress Demo">
					<i class='bx bx-book-bookmark'></i>
				</a>
			<?php endif; ?>
			<a href="mailto:hello@envytheme.com" target="_blank" rel="nofollow" class="hint--bounce hint--left hint--black" aria-label="Reach Us">
				<i class='bx bx-support' ></i>
			</a>
			<a href="https://docs.envytheme.com/docs/ecademy-theme-documentation/" target="_blank" rel="nofollow" class="hint--bounce hint--left hint--black" aria-label="Documentation">
				<i class='bx bx-book-alt' ></i>
			</a>
			<a href="https://1.envato.market/KM13e" target="_blank" rel="nofollow" class="hint--bounce hint--left hint--black" aria-label="Purchase eCademy">
				<i class='bx bx-cart-alt bx-flashing' ></i>
			</a>
		</div>
	<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>