<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 * @package eCademy
 */

/**
 * Adds custom classes to the array of body classes.
 */
if ( ! function_exists( 'ecademy_body_classes' ) ) {
	function ecademy_body_classes( $classes ) {
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Adds a class of no-sidebar when there is no sidebar present.
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			$classes[] = 'no-sidebar';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'ecademy_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
if ( ! function_exists( 'ecademy_pingback_header' ) ) {
	function ecademy_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
}
add_action( 'wp_head', 'ecademy_pingback_header' );

/**
 * eCademy header area
 */
if ( ! function_exists( 'ecademy_header_area' ) ) {
	function ecademy_header_area(){
		global $ecademy_opt;

		if( isset( $ecademy_opt['enable_lazyloader'] ) ):
			$is_lazyloader = $ecademy_opt['enable_lazyloader'];
		else:
			$is_lazyloader = true;
		endif;

		// Main site logo
		if(isset($ecademy_opt['main_logo']['url'])):
			$logo 	= $ecademy_opt['main_logo']['url'];
		else:
			$logo	= '';	
		endif;
	
		// Logo for mobile device
		if(isset( $ecademy_opt['mobile_logo']['url'] ) ):
			$mobile_logo 	= $ecademy_opt['mobile_logo']['url'];
		else:
			$mobile_logo	= '';	
		endif;

		// Search bar
		if( isset( $ecademy_opt['search_placeholder_text'] ) ):
			$enable_search_bar       	= $ecademy_opt['enable_search_bar'];
			$search_placeholder_text 	= $ecademy_opt['search_placeholder_text'];
			$login_register_title 		= $ecademy_opt['login_register_title'];
			$login_register_link_type 	= $ecademy_opt['login_register_link_type'];
			$profile_text 				= $ecademy_opt['profile_text'];
			$profile_link 				= $ecademy_opt['profile_link'];
			// Page link
			$login_register_link 		= get_page_link($login_register_link_type); 
			$profile_page_link 			= get_page_link($profile_link); 
		else:
			$search_placeholder_text 	= '';
			$enable_search_bar			= false;
			$login_register_title 		= '';
			$login_register_link_type 	= '';
			$profile_text 				= '';
			$profile_link 				= '';
		endif;

		$page_header_layout = function_exists( 'get_field' ) ? get_field( 'header_layout' ) : '';

		if ( !empty($page_header_layout) && $page_header_layout != 'default' ) {
			$nav_layout = $page_header_layout;
		} elseif ( !empty($_GET['menu']) ) {
			$nav_layout = $_GET['menu'];
		} else {
			$nav_layout = !empty($ecademy_opt['nav_layout']) ? $ecademy_opt['nav_layout'] : 'container-fluid';
		}
		$menu_alignment = !empty($ecademy_opt['menu_alignment']) ? $ecademy_opt['menu_alignment'] : 'menu_right';
		switch ( $menu_alignment ) {
            case 'menu_right':
                $ul_class = 'navbar-nav ml-auto';
                break;
            case 'menu_left':
                $ul_class = 'navbar-nav mr-auto left';
                break;
            case 'menu_center':
                $ul_class = 'navbar-nav ml-auto mr-auto';
                break;
		}
		
		$hide_adminbar = 'hide-adminbar';

		?>
		<div class="navbar-area <?php if ( current_user_can('administrator') ) { echo esc_attr( $hide_adminbar ); } ?>">
            <div class="ecademy-responsive-nav">
                <div class="container">
                    <div class="ecademy-responsive-menu">
                        <div class="logo">
							<a href="<?php echo esc_url( home_url( '/' ) );?>">
								<?php if( $mobile_logo != '' ): ?>
									<img src="<?php echo esc_url( $mobile_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
								<?php elseif( $logo != '' ): ?>
									<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
								<?php else: ?>
									<h2><?php bloginfo( 'name' ); ?></h2>
								<?php endif; ?>
							</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ecademy-nav">
                <div class="<?php echo esc_attr( $nav_layout ); ?>">
                    <nav class="navbar navbar-expand-md navbar-light">
						<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if( $logo != '' ): ?>
								<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
							<?php else: ?>
								<h2><?php bloginfo( 'name' ); ?></h2>
							<?php endif; ?>
						</a>

                        <div class="collapse navbar-collapse mean-menu">
							<?php if( $enable_search_bar == true ): ?>								
								<form class="search-box" method="get" action="<?php echo site_url( '/' ); ?>">
									<?php
									if ( class_exists( 'LearnPress' ) ) {
										$value  = 'lp_course';
									}
									if ( class_exists( 'SFWD_LMS' ) ) {
										$value  = 'sfwd-courses';
									}
									if ( class_exists('Tutor')){
										$value  = 'courses';
									}
									?>
									<input type="text" value="" name="s" class="input-search" placeholder="<?php echo esc_attr( $search_placeholder_text ); ?>">
									<input type="hidden" value="course" name="ref" />
									<input type="hidden" name="post_type" value="<?php echo esc_attr($value); ?>">
									<button type="submit"><i class="flaticon-search"></i></button>
								</form>
							<?php endif; ?>

                            <?php
                            $primary_nav_arg = [
                                'menu'            => 'primary',
                                'theme_location'  => 'primary',
                                'container'       => null,
                                'menu_class'      => $ul_class,
                                'depth'           => 3,
                                'walker'          => new eCademy_Bootstrap_Navwalker(),
                                'fallback_cb'     => 'eCademy_Bootstrap_Navwalker::fallback',
                            ];
							if(has_nav_menu('primary')){ wp_nav_menu( $primary_nav_arg );  }
							?>

							<div class="others-option d-flex align-items-center">
								<?php if( isset( $ecademy_opt['enable_cart_btn'] ) && $ecademy_opt['enable_cart_btn'] == true ) {
									if ( class_exists( 'WooCommerce' ) ) { ?>
										<div class="option-item">
											<div class="cart-btn">
												<a href="<?php echo esc_url(wc_get_cart_url()) ?>"><i class="flaticon-shopping-cart"></i>
												<span class="mini-cart-count"></span></a>
											</div>
										</div>
										<?php 
									}
								} ?>
								
								<?php if( $login_register_title != '' && $profile_text != ''  ): ?>
									<div class="option-item">
										<?php if( is_user_logged_in() ): ?>
											<a href="<?php echo esc_url( $profile_page_link ); ?>" class="default-btn">
												<i class="flaticon-user"></i>
												<?php echo esc_html( $profile_text ); ?><span></span>
											</a>
										<?php else: ?>
											<a href="<?php echo esc_url( $login_register_link ); ?>" class="default-btn">
												<i class="flaticon-user"></i>
												<?php echo esc_html( $login_register_title ); ?><span></span>
											</a>											
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
                        </div>
                    </nav>
                </div>
            </div>

			<?php if( $enable_search_bar == true || $login_register_title != '' || $profile_text != '' ): ?>
				<div class="others-option-for-responsive">
					<div class="container">
						<div class="dot-menu">
							<div class="inner">
								<div class="circle circle-one"></div>
								<div class="circle circle-two"></div>
								<div class="circle circle-three"></div>
							</div>
						</div>
						<div class="container">
							<div class="option-inner">
								<?php if( $enable_search_bar == true ): ?>								
									<form class="search-box" method="get" action="<?php echo site_url( '/' ); ?>">
										<input type="text" value="" name="s" class="input-search" placeholder="<?php echo esc_attr( $search_placeholder_text ); ?>">
										<input type="hidden" value="course" name="ref" />
										<input type="hidden" name="post_type" value="lp_course">
										<button type="submit"><i class="flaticon-search"></i></button>
									</form>
								<?php endif; ?>

								<?php if( $login_register_title != '' && $profile_text != ''  ): ?>
									<div class="others-option d-flex align-items-center">
										<?php if( isset( $ecademy_opt['enable_cart_btn'] ) && $ecademy_opt['enable_cart_btn'] == true ) {
											if ( class_exists( 'WooCommerce' ) ) { ?>
												<div class="option-item">
													<div class="cart-btn">
														<a href="<?php echo esc_url(wc_get_cart_url()) ?>"><i class="flaticon-shopping-cart"></i>
														<span class="mini-cart-count"></span></a>
													</div>
												</div>
												<?php 
											}
										} ?>
										
										<div class="option-item">
											<?php if( is_user_logged_in() ): ?>
												<a href="<?php echo esc_url( $profile_page_link ); ?>" class="default-btn">
													<i class="flaticon-user"></i>
													<?php echo esc_html( $profile_text ); ?><span></span>
												</a>
											<?php else: ?>
												<a href="<?php echo esc_url( $login_register_link ); ?>" class="default-btn">
													<i class="flaticon-user"></i>
													<?php echo esc_html( $login_register_title ); ?><span></span>
												</a>											
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
        </div>
		<?php
	}
}

/**
 * Ecademy RTL
*/
if( ! function_exists( 'ecademy_rtl' ) ):
	function ecademy_rtl() {
		global $ecademy_opt;

		if(	isset( $ecademy_opt['ecademy_enable_rtl'])  ):
			$ecademy_rtl_opt = $ecademy_opt['ecademy_enable_rtl'];
		else:
			$ecademy_rtl_opt = 'disable';
		endif;

		if ( isset( $_GET['rtl'] ) ) {
			$ecademy_rtl_opt = $_GET['rtl'];
		}

		if ( $ecademy_rtl_opt == 'enable' ) :
			$ecademy_rtl = true;
		else:
			$ecademy_rtl = false;
		endif;
		
		return $ecademy_rtl;
	}
endif;


// Live demo rtl link on function.php
if( ecademy_rtl() == true ):
	function ecademy_menu_anchors($items, $args) {
		foreach ($items as $key => $item) {
			if ($item->object == 'page') {
				$item->url = $item->url.'?rtl=enable';
			}
		}

		return $items;
	}
	add_filter('wp_nav_menu_objects', 'ecademy_menu_anchors', 10, 2);
endif;


/**
 * Register user
 */
if ( ! function_exists( 'register_user_front_end' ) ) {
	function register_user_front_end() {
		$new_user_name = stripcslashes($_POST['new_user_name']);
		$new_user_email = stripcslashes($_POST['new_user_email']);
		$new_user_password = $_POST['new_user_password'];
		$user_nice_name = strtolower($_POST['new_user_email']);
		$user_data = array(
			'user_login' 		=> $new_user_name,
			'user_email' 		=> $new_user_email,
			'user_pass' 		=> $new_user_password,
			'user_nicename' 	=> $user_nice_name,
			'display_name' 		=> $new_user_first_name,
			);
			$user_id = wp_insert_user( $user_data );
			if ( !is_wp_error( $user_id ) ) {
				echo wp_kses_post("<p class='alert alert-success'>Created an account for you.</p>", "ecademy" );
				echo "<script>window.open('".home_url()."/login','_self')</script>";
			} else {
				if (isset( $user_id->errors['empty_user_login'] ) ) {
				$notice_key = esc_html__('Error please fill up the sign up form carefully.', 'ecademy');
				echo $notice_key;
				} elseif (isset( $user_id->errors['existing_user_login'] ) ) {
				echo esc_html__('User name already exist.', 'ecademy');
				} else {
				echo esc_html__('Error please fill up the sign up form carefully.', 'ecademy');
				}
			}
		die;
	}
}
add_action('wp_ajax_register_user_front_end', 'register_user_front_end', 0);
add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end');


/**
 * bbPress
 */
function ecademy_bbpress_css_enqueue(){
	if( function_exists( 'is_bbpress' ) ) {
		// Deregister default bbPress CSS
		wp_deregister_style( 'bbp-default' );

		$file = 'assets/css/bbpress.min.css';

		// Check child theme
		if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $file ) ) {
			$location = trailingslashit( get_stylesheet_directory_uri() );
			$handle   = 'bbp-child-bbpress';

		// Check parent theme
		} elseif ( file_exists( trailingslashit( get_template_directory() ) . $file ) ) {
			$location = trailingslashit( get_template_directory_uri() );
			$handle   = 'bbp-parent-bbpress';
		}

		// Enqueue the bbPress styling
		wp_enqueue_style( $handle, $location . $file, 'screen' );
	}
}
add_action( 'wp_enqueue_scripts', 'ecademy_bbpress_css_enqueue' );


/**
 * Elementor post type support
 */
function ecademy_add_cpt_support() {

    //if exists, assign to $cpt_support var
    $cpt_support = get_option( 'elementor_cpt_support' );

    //check if option DOESN'T exist in db
    if ( ! $cpt_support ) {
        $cpt_support = [ 'page', 'post', 'header', 'footer' ]; //create array of our default supported post types
        update_option( 'elementor_cpt_support', $cpt_support ); //write it to the database
    }
    //if it DOES exist, but header is NOT defined
    elseif ( !in_array( 'header', $cpt_support ) ) {
        $cpt_support[] = 'header'; //append to array
        update_option( 'elementor_cpt_support', $cpt_support ); //update database
    }
    //if it DOES exist, but footer is NOT defined
    elseif ( !in_array( 'footer', $cpt_support ) ) {
        $cpt_support[] = 'footer'; //append to array
        update_option( 'elementor_cpt_support', $cpt_support ); //update database
	}
}
add_action( 'after_switch_theme', 'ecademy_add_cpt_support' );


/**
 * Banner Title
 */
function ecademy_banner_title() {
	global $ecademy_opt;
	$archive_title = get_the_archive_title();
	
	if ( class_exists( 'WooCommerce') ) {

        if ( is_shop() ) {
			echo !empty($ecademy_opt['shop_title']) ? esc_html($ecademy_opt['shop_title']) : esc_html__( 'Shop', 'ecademy' );
		}elseif( is_singular('product') ) {
			the_title();
		}elseif ( is_home() ) {
			$blog_title = !empty( $ecademy_opt['blog_title'] ) ? $ecademy_opt['blog_title'] : esc_html__( 'Blog', 'ecademy' );
			echo esc_html( $blog_title );
		} elseif ( is_page() || is_single() ) {
			while ( have_posts() ) : the_post();
				if( !empty(get_the_title()) ):
					the_title();
				else:
					esc_html_e( 'No Title', 'ecademy' );
				endif;
			endwhile;
		} elseif ( is_category() ) {
			single_cat_title();
		} elseif( get_the_title() == '' && class_exists( 'LearnPress' )) {
			learn_press_page_title();
		} elseif ( is_archive() ) {
			if( get_the_archive_title() == 'Archives: Events' ):
				esc_html_e( 'Events', 'ecademy' );
			elseif ( strpos($archive_title, 'Courses') != false ):
				$tutor_course_title = !empty( $ecademy_opt['tutor_course_title'] ) ? $ecademy_opt['tutor_course_title'] : esc_html__( 'Courses', 'ecademy' );
				echo esc_html( $tutor_course_title );
			else:
				the_archive_title();
			endif;
		} elseif ( is_search() ) {
			esc_html_e( 'Search result for: “', 'ecademy' );
			echo get_search_query() . '”';
		} else {
			the_title();
		}
	}else{
		if ( is_home() ) {
			$blog_title = !empty( $ecademy_opt['blog_title'] ) ? $ecademy_opt['blog_title'] : esc_html__( 'Blog', 'ecademy' );
			echo esc_html( $blog_title );
		} elseif ( is_page() || is_single() ) {
			while ( have_posts() ) : the_post();
				if( !empty(get_the_title()) ):
					the_title();
				else:
					esc_html_e( 'No Title', 'ecademy' );
				endif;
			endwhile;
		} elseif ( is_category() ) {
			single_cat_title();
		} elseif( get_the_title() == '' && class_exists( 'LearnPress' )) {
			learn_press_page_title();
		} elseif ( is_archive() ) {
			the_archive_title();
		} elseif ( is_search() ) {
			esc_html_e( 'Search result for: “', 'ecademy' );
			echo get_search_query() . '”';
		} else {
			the_title();
		}
	}
}

/**
 * Single Tutor banner
 */
if ( ! function_exists( 'ecademy_tutor_single_banner' ) ) :
	function ecademy_tutor_single_banner() {
		$hide_banner    = get_field( 'hide_tutor_course_page_banner' );
		$is_rating      = get_field( 'hide_tutor_course_banner_rating' );
		$is_breadcrumb  = get_field( 'hide_tutor_course_banner_breadcrumb' );
		
		global $ecademy_opt;
		
		if( isset( $ecademy_opt['rating_title'] ) ):
			$rating_title               = $ecademy_opt['rating_title'];
		else:
			$rating_title               = esc_html__('Rating', 'ecademy');
		endif;
		
		$is_shape_image     = isset( $ecademy_opt['enable_shape_images']) ? $ecademy_opt['enable_shape_images'] : '1';
		
		if( isset( $ecademy_opt['enable_lazyloader'] ) ):
			$is_lazyloader = $ecademy_opt['enable_lazyloader'];
		else:
			$is_lazyloader = true;
		endif;
		if( $hide_banner != true ): ?>
			<div class="page-title-area <?php if( $is_rating == true && $is_breadcrumb == true ): ?>ptb-50<?php endif; ?>">
				<div class="container">
					<div class="page-title-content">
						<h2><?php the_title(); ?></h2>
						<?php if($is_breadcrumb != true): ?>
							<?php
								if ( function_exists('yoast_breadcrumb') ) {
									yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
								}else{ ?>
									<ul>
										<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ecademy' ); ?></a></li>
										<li><?php the_title(); ?></li>
									</ul>
								<?php 
								}
							?>
						<?php endif; ?>
						<?php if( $is_rating != true ): ?>
							<?php if( $rating_title ): ?>
								<div class="courses-rating rating">
									<?php 									
									$disable = get_tutor_option('disable_course_review');
									if ( ! $disable):
										do_action('tutor_course/loop/before_rating');
										do_action('tutor_course/loop/rating');
										do_action('tutor_course/loop/after_rating');
									endif;
									?>
									<div class="reviews-total d-inline-block">
										( <?php echo (int) tutor_utils()->count_enrolled_users_by_course(); ?> <?php echo esc_html( $rating_title ); ?> )
									</div>
								</div>
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
		<?php endif;
	}
endif;

/**
 * Single LD banner
 */
if ( ! function_exists( 'ecademy_ld_single_banner' ) ) :
	function ecademy_ld_single_banner() {
		$hide_banner    = get_field( 'hide_ld_course_page_banner' );
		$is_breadcrumb  = get_field( 'hide_ld_course_banner_breadcrumb' );
		
		global $ecademy_opt;
		
		$is_shape_image     = isset( $ecademy_opt['enable_shape_images']) ? $ecademy_opt['enable_shape_images'] : '1';
		
		if( isset( $ecademy_opt['enable_lazyloader'] ) ):
			$is_lazyloader = $ecademy_opt['enable_lazyloader'];
		else:
			$is_lazyloader = true;
		endif;
		if( $hide_banner != true ): ?>
			<div class="page-title-area">
				<div class="container">
					<div class="page-title-content">
						<h2><?php the_title(); ?></h2>
						<?php if($is_breadcrumb != true): ?>
							<?php
								if ( function_exists('yoast_breadcrumb') ) {
									yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
								}else{ ?>
									<ul> 
										<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ecademy' ); ?></a></li>
										<li><?php the_title(); ?></li>
									</ul>
								<?php 
								}
							?>
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
		<?php endif;
	}
endif;

/**
 * eCademy Preloader
*/
if ( ! function_exists( 'ecademy_preloader' ) ) :
	function ecademy_preloader() { 
		global $ecademy_opt;
        $is_preloader       = !empty($ecademy_opt['enable_preloader']) ? $ecademy_opt['enable_preloader'] : '1';
        $preloader_style    = !empty($ecademy_opt['preloader_style']) ? $ecademy_opt['preloader_style'] : 'circle-spin';

        if( $is_preloader == '1' ): 
            if ( defined( 'ELEMENTOR_VERSION' ) ) :
                if (\Elementor\Plugin::$instance->preview->is_preview_mode()) :
                    echo '';
                else:
                    if ( $preloader_style == 'text' ) :
                        if (!empty( $ecademy_opt['loading_text'] ) ) : ?>
                            <div class="preloader">
                                <div class="loader">
                                    <p class="text-center"> <?php echo esc_html( $ecademy_opt['loading_text'] ) ?> </p>
                                </div>
                            </div>
                        <?php endif;
                    elseif( $preloader_style == 'circle-spin' ) : ?>
                        <div class="preloader">
                            <div class="loader">
                                <div class="sbl-half-circle-spin">
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="preloader">
                            <div class="loader">
                            </div>
                        </div>
                    <?php endif;
                endif;
            else:
                if ( $preloader_style == 'text' ) :
                    if (!empty( $ecademy_opt['loading_text'] ) ) : ?>
                        <div class="preloader">
                            <div class="loader">
                                <p class="text-center"> <?php echo esc_html( $ecademy_opt['loading_text'] ) ?> </p>
                            </div>
                        </div>
                    <?php endif;
                elseif( $preloader_style == 'circle-spin' ) :
                    ?>
                    <div class="preloader">
                        <div class="loader">
                            <div class="sbl-half-circle-spin">
                                <div></div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="preloader">
                        <div class="loader">
                        </div>
                    </div>
                    <?php 
                endif;
            endif;
        endif;
	}
endif;

function ecademy_function_pcs() {
	$purchase_code = htmlspecialchars(get_option( 'ecademy_purchase_code' ));
	$purchase_code = str_replace(' ', '', $purchase_code);
	if( $purchase_code != '' ){
		require get_template_directory().'/inc/verify/class.verify-purchase.php';
		$o = EnvatoApi2::verifyPurchase( $purchase_code );

		if ( is_object($o) && strpos($o->item_name, 'eCademy') !== false ) {

			// Check in localhost
			$whitelist = array(
				'127.0.0.1',
				'::1',
				'192.168.1',
				'192.168.0.1',
				'182.168.1.5',
				'192.168.1.4',
				'192.168.1.5',
				'192.168.1.4',
				'192.168',
				'10.0.2.2',
			);

			if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){ // In server
				$url 			= 'https://api.envytheme.com/api/v1/license';
				$purchaseKey 	= $purchase_code;
				$itemName 		= $o->item_name;
				$buyer 			= $o->buyer;
				$purchasedAt 	= $o->created_at;
				$supportUntil 	= $o->supported_until;
				$licenseType 	= $o->licence;
				$domain 		= get_site_url();
				$post_url 		= '';

				$post_url .= $url.'?purchaseKey='.$purchaseKey.'&itemName='.$itemName.'&buyer='.$buyer.'&purchasedAt='.$purchasedAt.'&supportUntil='.$supportUntil.'&licenseType='.$licenseType.'&domain='.$domain.'';

				$post_url = str_replace(' ', '%', $post_url);

				$curl = curl_init();

				curl_setopt_array($curl, array(
					CURLOPT_URL 			=> $post_url,
					CURLOPT_RETURNTRANSFER 	=> true,
					CURLOPT_ENCODING 		=> "",
					CURLOPT_MAXREDIRS		=> 10,
					CURLOPT_TIMEOUT 		=> 30,
					CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST 	=> "POST",
					CURLOPT_HTTPHEADER 		=> array(
						"cache-control: no-cache",
						"content-type: application/x-www-form-urlencoded"
					),
					CURLOPT_SSL_VERIFYPEER => false,
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);
				curl_close($curl);

				if ($err) {
					echo "cURL Error #:" . $err;
				} else {
					$json = json_decode($response);
					$already_registered = $json->message[0]; // Already registered

					$new_response = '';
					$new_response .= 'Congratulations! Updated for this domain '.$domain.'';
					preg_match_all('#https?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $already_registered, $match);
					$url 			= $match[0];
					$protocols 		= array('http://', 'http://www.', 'www.', 'https://', 'https://www.');
					$domain_name 	= str_replace( $protocols, '', $url[0] );	
					$site_url 		= str_replace( $protocols, '', get_site_url() );

					if( $already_registered != '' ){
						if( $already_registered == $new_response ):
							update_option('ecademy_purchase_code_status', 'valid', 'yes');
							update_option('ecademy_purchase_valid_code',  $purchase_code, 'yes');
							update_option('ecademy_valid_url',  $domain, 'yes');
							update_option('valid_url', get_site_url(), 'yes');
							?><script>let date = new Date(Date.now() + 604800);	date = date.toUTCString(); document.cookie = "ECA_LSM_Status=<?php echo $purchase_code; ?>; expires=" + date; </script><?php
						elseif( $domain_name == $site_url ):
							/* Deregister  */
								$url 			= 'https://api.envytheme.com/api/v1/license';
								$purchaseKey 	= $purchase_code;
								$status 		= 'disabled';
								$post_url = '';
								$post_url .= $url.'?purchaseKey='.$purchaseKey.'&status='.$status.'';
								$post_url = str_replace(' ', '%', $post_url);
								$curl = curl_init();
								curl_setopt_array($curl, array(
									CURLOPT_URL 			=> $post_url,
									CURLOPT_RETURNTRANSFER 	=> true,
									CURLOPT_ENCODING 		=> "",
									CURLOPT_MAXREDIRS 		=> 10,
									CURLOPT_TIMEOUT 		=> 30,
									CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST 	=> "PUT",
									CURLOPT_HTTPHEADER 		=> array(
										"cache-control: no-cache",
										"content-type: application/x-www-form-urlencoded"
									),
									CURLOPT_SSL_VERIFYPEER => false,
								));

								$response = curl_exec($curl);
								$err = curl_error($curl);
								curl_close($curl);
							/* Deregister */

							/* Register */
								$url 			= 'https://api.envytheme.com/api/v1/license';
								$purchaseKey 	= $purchase_code;
								$itemName 		= $o->item_name;
								$buyer 			= $o->buyer;
								$purchasedAt 	= $o->created_at;
								$supportUntil 	= $o->supported_until;
								$licenseType 	= $o->licence;
								$domain 		= get_site_url();
								$post_url 		= '';

								$post_url .= $url.'?purchaseKey='.$purchaseKey.'&itemName='.$itemName.'&buyer='.$buyer.'&purchasedAt='.$purchasedAt.'&supportUntil='.$supportUntil.'&licenseType='.$licenseType.'&domain='.$domain.'';
								
								$post_url = str_replace(' ', '%', $post_url);
							
								$curl = curl_init();

								curl_setopt_array($curl, array(
								CURLOPT_URL => $post_url,
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => "",
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 30,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => "POST",
								CURLOPT_HTTPHEADER => array(
									"cache-control: no-cache",
									"content-type: application/x-www-form-urlencoded"
								),
								CURLOPT_SSL_VERIFYPEER => false,
								));

								$response = curl_exec($curl);
								$err = curl_error($curl);
								curl_close($curl);
							/* Register */

							update_option('ecademy_purchase_code_status', 'valid', 'yes');
							update_option('ecademy_purchase_valid_code',  $purchase_code, 'yes');
							update_option('ecademy_valid_url',  $domain, 'yes');
							update_option('valid_url', get_site_url(), 'yes');						
							?><script>let date = new Date(Date.now() + 604800);	date = date.toUTCString(); document.cookie = "ECA_LSM_Status=<?php echo $purchase_code; ?>; expires=" + date; </script><?php
						else:
							$target_site 	= $url[0];
							$src 			= file_get_contents( $target_site );
							preg_match("/\<link rel='stylesheet' id='ecademy-style-css'.*href='(.*?style\.css.*?)'.*\>/i", $src, $matches );

							if( $matches ) { // if theme found
								update_option('ecademy_purchase_code_status', 'already_registered', 'yes');
								update_option('ecademy_already_registered', $already_registered, 'yes');
							}else{
								/* Deregister  */
									$url 			= 'https://api.envytheme.com/api/v1/license';
									$purchaseKey 	= $purchase_code;
									$status 		= 'disabled';
									$post_url = '';
									$post_url .= $url.'?purchaseKey='.$purchaseKey.'&status='.$status.'';
									$post_url = str_replace(' ', '%', $post_url);
									$curl = curl_init();
									curl_setopt_array($curl, array(
										CURLOPT_URL 			=> $post_url,
										CURLOPT_RETURNTRANSFER 	=> true,
										CURLOPT_ENCODING 		=> "",
										CURLOPT_MAXREDIRS 		=> 10,
										CURLOPT_TIMEOUT 		=> 30,
										CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST 	=> "PUT",
										CURLOPT_HTTPHEADER 		=> array(
											"cache-control: no-cache",
											"content-type: application/x-www-form-urlencoded"
										),
										CURLOPT_SSL_VERIFYPEER => false,
									));

									$response = curl_exec($curl);
									$err = curl_error($curl);
									curl_close($curl);
								/* Deregister */

								/* Register */
									$url 			= 'https://api.envytheme.com/api/v1/license';
									$purchaseKey 	= $purchase_code;
									$itemName 		= $o->item_name;
									$buyer 			= $o->buyer;
									$purchasedAt 	= $o->created_at;
									$supportUntil 	= $o->supported_until;
									$licenseType 	= $o->licence;
									$domain 		= get_site_url();
									$post_url 		= '';

									$post_url .= $url.'?purchaseKey='.$purchaseKey.'&itemName='.$itemName.'&buyer='.$buyer.'&purchasedAt='.$purchasedAt.'&supportUntil='.$supportUntil.'&licenseType='.$licenseType.'&domain='.$domain.'';
									
									$post_url = str_replace(' ', '%', $post_url);
								
									$curl = curl_init();

									curl_setopt_array($curl, array(
									CURLOPT_URL => $post_url,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_HTTPHEADER => array(
										"cache-control: no-cache",
										"content-type: application/x-www-form-urlencoded"
									),
									CURLOPT_SSL_VERIFYPEER => false,
									));

									$response = curl_exec($curl);
									$err = curl_error($curl);
									curl_close($curl);
								/* Register */
							}
						endif;
					}else {
						update_option('ecademy_purchase_code_status', 'valid', 'yes');
						update_option('ecademy_purchase_valid_code',  $purchase_code, 'yes');
						update_option('ecademy_valid_url',  $domain, 'yes');
						update_option('valid_url', get_site_url(), 'yes');
						?><script>let date = new Date(Date.now() + 604800);	date = date.toUTCString(); document.cookie = "ECA_LSM_Status=<?php echo $purchase_code; ?>; expires=" + date; </script><?php
					}

				}

			}else{ // In local
				$domain = get_site_url();
				update_option('ecademy_purchase_code_status', 'valid', 'yes');
				update_option('ecademy_purchase_valid_code',  $purchase_code, 'yes');
				update_option('ecademy_valid_url',  $domain, 'yes');
			}
		} elseif( $purchase_code == '' ){
			update_option( 'ecademy_purchase_code_status', '', 'yes' );
			update_option( 'ecademy_purchase_code', '', 'yes' );
		}
	}
}

add_action( 'admin_bar_menu', 'ecademy_header_options', 500 );
function ecademy_header_options ( WP_Admin_Bar $admin_bar ) {
    global $wp;
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if ( strpos($actual_link, 'themes.envytheme.com/ecademy') != false ):
		update_option('ecademy_purchase_code_status', 'valid', 'yes');
	endif;


	if ( $actual_link == home_url('/wp-admin/admin.php?page=ecademy') ){
		return '';
	}else{
		$site_url 	= get_site_url();
		$valid_url 	= get_option( 'valid_url' );
		$purchase_code 	= get_option( 'ecademy_purchase_valid_code' );

		if( current_user_can('administrator') ) {
			if(!isset($_COOKIE['ECA_LSM_Status'])) {
				ecademy_function_pcs();
			}elseif( $site_url !=  $valid_url) {
				ecademy_function_pcs();
			}else{
				?><script>let date = new Date(Date.now() - 604800);	date = date.toUTCString(); document.cookie = "ECA_LSM_Status=<?php echo $purchase_code; ?>; expires=" + date; </script><?php
			}
		}
	}
}