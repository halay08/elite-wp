<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to ecademy/learnpress/content-single-course.php
 *
 * @author  EnvyTheme
 * @package LearnPress/Templates
 * @version 3.0.0
 */
$course         = LP()->global['course'];
$user           = LP_Global::user();
$course_id      = get_the_ID();
$user_id        = get_current_user_id();

$duration       = get_field( 'course_duration' );
$course_access  = get_field( 'course_access' );
$hide_banner    = get_field( 'hide_course_page_banner' );
$is_rating      = get_field( 'hide_course_banner_rating' );
$is_breadcrumb  = get_field( 'hide_course_banner_breadcrumb' );

$is_shape_image     = isset( $ecademy_opt['enable_shape_images']) ? $ecademy_opt['enable_shape_images'] : '1';

global $ecademy_opt;

if( isset( $ecademy_opt['enable_lazyloader'] ) ):
	$is_lazyloader = $ecademy_opt['enable_lazyloader'];
else:
	$is_lazyloader = true;
endif;
if( isset( $ecademy_opt['course_instructor_title'] ) ):
    $instructor_title           = $ecademy_opt['course_instructor_title'];
    $rating_title               = $ecademy_opt['rating_title'];
    $student_label              = $ecademy_opt['student_label'];
    $duration_label             = $ecademy_opt['duration_label'];
    $lessons_label              = $ecademy_opt['lessons_label'];
    $access_label               = $ecademy_opt['access_label'];
    $enrolled_label             = $ecademy_opt['enrolled_label'];
    $buy_course_title           = $ecademy_opt['buy_course_title'];
    $share_course_title         = $ecademy_opt['share_course_title'];
    $price_title                = $ecademy_opt['price_title'];
    $is_buy_btn_tab             = $ecademy_opt['enable_buy_now_btn_tab'];
else:
    $instructor_title           = esc_html__('Instructor', 'ecademy');
    $enrolled_label             = esc_html__('Enrolled', 'ecademy');
    $rating_title               = esc_html__('Rating', 'ecademy');
    $student_label              = esc_html__('Students', 'ecademy');
    $duration_label             = esc_html__('Duration', 'ecademy');
    $lessons_label              = esc_html__('Lessons', 'ecademy');
    $access_label               = esc_html__('Access', 'ecademy');
    $buy_course_title           = esc_html__('Buy Course', 'ecademy');
    $share_course_title         = esc_html__('Share This Course', 'ecademy');
    $price_title                = esc_html__('Price', 'ecademy');
    $is_buy_btn_tab             = '1';
endif;

if( get_field( 'course_buy_now_title' ) != '' ):
    $buy_course_title           = get_field( 'course_buy_now_title' );
endif;

$course_time  = get_field( 'course_time' );

?>
    <?php if( $hide_banner != true ): ?>
    <div class="page-title-area <?php if( $is_rating == true && $is_breadcrumb == true ): ?>ptb-50<?php endif; ?>">
            <div class="container">
                <div class="page-title-content">
                    <h2><?php the_title(); ?></h2>
                    <?php if($is_breadcrumb != true): ?>
						<?php
							if ( function_exists('yoast_breadcrumb') ) {
							    yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
							}else{ ?>
                                <?php do_action( 'learn-press/before-main-content' ); ?>
                                <?php do_action( 'learn-press/after-main-content' ); ?>
							<?php 
							}
						?>
                    <?php endif; ?>
                    <?php if( $is_rating != true ): ?>
                        <?php if( $rating_title ): ?>
                            <div class="courses-rating rating">
                                <?php ecademy_course_ratings(); ?>
                                <div class="reviews-total d-inline-block">
                                    ( <?php ecademy_course_ratings_count(); ?> <?php echo esc_html( $rating_title ); ?> )
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
    <?php endif; ?>
    <div class="courses-details-area pb-100">
        <?php if( get_field('course_single_background_image') != '' ): ?>
            <div class="courses-details-image">
                <?php if( $is_lazyloader == true ): ?>
                    <img sm-src="<?php echo esc_url( get_field('course_single_background_image') ); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                <?php else: ?>
                    <img src="<?php echo esc_url( get_field('course_single_background_image') ); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="courses-details-desc">
                        <?php
                        /**
                         * Prevent loading this file directly
                         */
                        defined( 'ABSPATH' ) || exit();

                        if ( post_password_required() ) {
                            echo get_the_password_form();

                            return;
                        }

                        /**
                         * @deprecated
                         */
                        do_action( 'learn_press_before_main_content' );
                        do_action( 'learn_press_before_single_course' );
                        do_action( 'learn_press_before_single_course_summary' );

                        /**
                         * @since 3.0.0
                         */
                        do_action( 'learn-press/before-single-course' );

                        ?>
                        <div id="learn-press-course" class="course-summary">
                            <?php
                            /**
                             * @since 3.0.0
                             *
                             * @see learn_press_single_course_summary()
                             */
                            do_action( 'learn-press/single-course-summary' );
                            ?>
                        </div>
                        <?php

                        /**
                         * @since 3.0.0
                         */
                        do_action( 'learn-press/after-single-course' );

                        /**
                         * @deprecated
                         */
                        do_action( 'learn_press_after_single_course_summary' );
                        do_action( 'learn_press_after_single_course' );
                        do_action( 'learn_press_after_main_content' );
                        ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="courses-details-info">
                        <?php if( get_field('course_preview_title') != '' || get_field('course_preview_video_link') != ''): ?>
                            <?php if( get_field('course_preview_style') != 'without_popup' ): ?>
                                <div class="image">
                                    <?php if( get_field('course_preview_image') != '' ): ?>
                                        <?php if( $is_lazyloader == true ): ?>
                                            <img sm-src="<?php echo esc_url( get_field('course_preview_image') ); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo esc_url( get_field('course_preview_image') ); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if( $is_lazyloader == true ): ?>
                                            <img sm-src="<?php echo esc_url(get_template_directory_uri() .'/assets/img/no-image.jpg'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo esc_url(get_template_directory_uri() .'/assets/img/no-image.jpg'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo esc_url( get_field('course_preview_video_link') ); ?>" class="link-btn popup-youtube"></a>
                                    <div class="content">
                                        <i class="flaticon-play"></i>
                                        <span><?php echo esc_html( get_field('course_preview_title') ); ?></span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="image no-before">
                                    <?php
                                    if( get_field('video_auto_play') == true ):
                                        $auto_play = 'autoplay';
                                    else:
                                        $auto_play = '';
                                    endif;

                                    ?>
                                    <video id="my-video" class="video-js"<?php echo $auto_play; ?> controls poster="<?php echo esc_url( get_field('course_preview_image') ); ?>" data-setup="{}" >
                                        <source src="<?php echo esc_url( get_field('course_preview_video_link') ); ?>" type="video/mp4" />
                                    </video>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <ul class="info">
                            <li class="price">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="flaticon-tag"></i> <?php echo esc_html( $price_title ); ?></span>
                                    <?php learn_press_courses_loop_item_price(); ?>
                                </div>
                            </li>
                            <?php if( $instructor_title != '' ): ?>
                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="flaticon-teacher"></i> <?php echo esc_html( $instructor_title ); ?></span>
                                        <a href="<?php echo esc_url( home_url('/profile') ); ?>/<?php echo get_the_author_meta( 'user_nicename' ); ?>" class="d-inline-block"><?php echo esc_html(get_the_author()); ?></a>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if( $duration != '' && $duration_label != '' ): ?>
                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="flaticon-time"></i> <?php echo esc_html( $duration_label ); ?></span>
                                        <?php echo esc_html( $duration ); ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if( $lessons_label != '' ): ?>
                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="flaticon-distance-learning"></i> <?php echo esc_html( $lessons_label ); ?></span>
                                        <?php echo wp_kses_post( $course->get_curriculum_items( 'lp_lesson' ) ? count( $course->get_curriculum_items( 'lp_lesson' ) ) : 0 ); ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            
                            <?php if( $enrolled_label != '' ): ?>
                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <?php $user_count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0; ?>
                                        <span><i class="flaticon-web"></i> <?php echo esc_html( $enrolled_label ); ?></span>
                                        <?php echo esc_html( $user_count ); ?> <?php echo esc_html( $student_label ); ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if( $course_access != '' && $access_label != '' ): ?>
                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="flaticon-lock"></i> <?php echo esc_html( $access_label ); ?></span>
                                        <?php echo esc_html( $course_access ); ?>
                                    </div>
                            </li>
                            <?php endif; ?>
                        </ul>

                        <div class="btn-box">
                            <?php if( $course->get_external_link() == '' ): ?>
                                <?php
                                    $course = LP_Global::course();
                                    $price_html = $course->get_price_html();
                                ?>
                                <?php if( $price_html == 'Free' && $is_buy_btn_tab == '1' ): ?>
                                    <?php if(  $buy_course_title  != '' ): ?>
                                        <a class="default-btn nav-link course-nav course-nav-tab-curriculum default" id="tab-curriculum-tab" data-toggle="tab" href="#tab-curriculum" role="tab" aria-controls="tab-curriculum" aria-selected="false"><i class="flaticon-tag"></i><?php echo esc_html( $buy_course_title ); ?><span></span></a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if( learn_press_is_enrolled_course( $course_id, $user_id ) == false ): ?>
                                        <?php do_action( 'learn-press/before-enroll-form' ); ?>
                                            <form name="enroll-course" class="enroll-course" method="post" enctype="multipart/form-data">

                                                <?php do_action( 'learn-press/before-enroll-button' ); ?>

                                                <input type="hidden" name="enroll-course" value="<?php echo esc_attr( $course->get_id() ); ?>"/>
                                                <input type="hidden" name="enroll-course-nonce"
                                                    value="<?php echo esc_attr( LP_Nonce_Helper::create_course( 'enroll' ) ); ?>"/>

                                                <?php if(  $buy_course_title  != '' ): ?>
                                                    <button class="default-btn">
                                                        <i class="flaticon-tag"></i>
                                                        <span class="label"><?php echo esc_html( $buy_course_title ); ?></span>
                                                    </button>
                                                <?php endif; ?>

                                                <?php do_action( 'learn-press/after-enroll-button' ); ?>

                                            </form>
                                        <?php do_action( 'learn-press/after-enroll-form' ); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <form name="course-external-link" class="course-external-link form-button lp-form" method="post">
                                    <input type="hidden" name="lp-ajax" value="external-link">
                                    <input type="hidden" name="id" value="<?php echo $course->get_id(); ?>">
                                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'external-link-' . $course->get_external_link() ); ?>">
                                    <?php if(  $buy_course_title  != '' ): ?>
                                        <button type="submit" class="default-btn lp-button button"><i class="flaticon-tag"></i><?php echo esc_html( $buy_course_title ); ?></button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
                            
                            <?php
                            if ( et_plugin_active( 'paid-memberships-pro/paid-memberships-pro.php' ) && class_exists( 'LP_Addon_Paid_Memberships_Pro' ) ) {
                                $instance_addon = LP_Addon_Paid_Memberships_Pro::instance();
                                do_action( 'learn-press/before-course-buttons', array(
                                    $instance_addon,
                                    'add_buy_membership_button'
                                ), 10 );
                            } ?>
                        </div>
                        
                        <?php if( $share_course_title != '' ): ?>
                            <div class="courses-share">
                                <div class="share-info">
                                    <span><?php echo esc_html( $share_course_title ); ?> <i class="flaticon-share"></i></span>

                                    <ul class="social-link">
                                        <li><a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" class="d-block" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                                        <li><a href="https://twitter.com/share?url='<?php echo urlencode( get_permalink() ); ?>&amp;text=<?php echo rawurlencode( esc_attr( get_the_title() ) ); ?>" class="d-block" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                                        <li><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink() );?> &amp;description=<?php rawurlencode( esc_attr( get_the_excerpt() ) ); ?>&amp;media=<?php echo urlencode( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>" onclick="window.open(this.href); return false;" class="d-block" target="_blank"><i class="bx bxl-pinterest"></i></a></li>
                                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( get_permalink() ); ?>" class="d-block" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="single-course-sidebar">
                        <?php if ( is_active_sidebar( 'course-sidebar' ) ): ?>
                            <?php dynamic_sidebar('course-sidebar'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Related Area -->
    <?php
    $related_courses_title = !empty($ecademy_opt['related_courses_title']) ? $ecademy_opt['related_courses_title'] : 'More Courses You Might Like';
    $lessons_title      = !empty($ecademy_opt['lessons_title']) ? $ecademy_opt['lessons_title'] : 'Lessons';
    $students_title     = !empty($ecademy_opt['students_title']) ? $ecademy_opt['students_title'] : 'Students';
    $related_post_count = !empty($ecademy_opt['related_post_count']) ? $ecademy_opt['related_post_count'] : '3';
    $is_related_courses = !empty($ecademy_opt['is_related_courses']) ? $ecademy_opt['is_related_courses'] : '';

    $course_terms = get_the_terms( get_the_ID(), 'course_category'  );
    if( $is_related_courses == '1' ){
        if( $course_terms ) {
            $course_term_names[] = 0;
            foreach( $course_terms as $course_term ) {  
                $course_term_names[] = $course_term->name;            
            }                        
            // set up the query arguments
            $args = array (
                'post_type' => 'lp_course',
                'posts_per_page' => $related_post_count,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'course_category',
                        'field'    => 'slug',
                        'terms'    => $course_term_names,
                    ),
                ),
            );

            $query = new WP_Query( $args ); 

            if( $query->have_posts() ) { ?>
                <section class="courses-area bg-f8f9f8 pt-100 pb-70">
                    <div class="container">
                        <?php if( $related_courses_title != '' ): ?>
                            <div class="section-title">
                                <h2><?php echo esc_html($related_courses_title); ?></h2>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <?php while ( $query->have_posts() ) : $query->the_post(); $course  = LP()->global['course']; ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-courses-box">
                                        <div class="courses-image">
                                            <a href="<?php the_permalink(); ?>" class="d-block image">
                                            <?php if( $is_lazyloader == true ): ?>
                                                <img sm-src="<?php the_post_thumbnail_url('ecademy_default_thumb'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                            <?php else: ?>
                                                <img src="<?php the_post_thumbnail_url('ecademy_default_thumb'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                            <?php endif; ?>
                                            </a>

                                            <?php learn_press_courses_loop_item_price(); ?>
                                        </div>
                                        <div class="courses-content">
                                            <div class="course-author d-flex align-items-center">
                                                <?php echo $course->get_instructor()->get_profile_picture(); ?>
                                                <span><?php echo $course->get_instructor_html(); ?></span>
                                            </div>
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <p><?php the_excerpt(); ?></p>
                                            <ul class="courses-box-footer d-flex justify-content-between align-items-center">
                                                <li>
                                                    <i class='flaticon-agenda'></i> 
                                                        <?php echo $course->get_curriculum_items( 'lp_lesson' ) ? count( $course->get_curriculum_items( 'lp_lesson' ) ) : 0; ?> <?php echo esc_html( $lessons_title ); ?>
                                                </li>

                                                <li>
                                                <?php $user_count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0; ?>
                                                    <i class='flaticon-people'></i> <?php echo esc_html( $user_count ); ?>  <?php echo esc_html( $students_title ); ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>  
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                </section>
            <?php
        }
    }
} ?>
    <!-- End Related Courses Area -->