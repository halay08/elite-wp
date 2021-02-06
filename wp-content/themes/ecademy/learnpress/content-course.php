<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to ecademy/learnpress/content-course.php
 *
 * @author  EnvyTheme
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course  = LP()->global['course'];
$user = LP_Global::user();

if ( is_active_sidebar( 'course-sidebar' ) ):
    $grid_class = 'col-lg-6 col-md-6';
else: 
    $grid_class = 'col-lg-4 col-md-6';
endif;

global $ecademy_opt;

if( isset( $ecademy_opt['enable_lazyloader'] ) ):
	$is_lazyloader = $ecademy_opt['enable_lazyloader'];
else:
	$is_lazyloader = true;
endif;

$lessons_title  = !empty($ecademy_opt['lessons_title']) ? $ecademy_opt['lessons_title'] : 'Lessons';
$students_title = !empty($ecademy_opt['students_title']) ? $ecademy_opt['students_title'] : 'Students';

?>

<div id="post-<?php the_ID(); ?>" class="<?php echo esc_attr( $grid_class ); ?> <?php post_class(); ?>">
    <div class="single-courses-box">
        <div class="courses-image">
            <a href="<?php the_permalink(); ?>" class="d-block image">
                <?php if( has_post_thumbnail() ): ?>
                    <?php if( $is_lazyloader == true ): ?>
                        <img sm-src="<?php the_post_thumbnail_url('ecademy_courses_gallery_thumb'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                    <?php else: ?>
                        <img src="<?php the_post_thumbnail_url('ecademy_courses_gallery_thumb'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                    <?php endif; ?>
                <?php else: ?>
                    <?php if( $is_lazyloader == true ): ?>
                        <img sm-src="<?php echo esc_url(get_template_directory_uri() .'/assets/img/no-image'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                    <?php else: ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() .'/assets/img/no-image'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                    <?php endif; ?>
                <?php endif; ?>
            </a>
            <?php learn_press_courses_loop_item_price(); ?>
        </div>
        <div class="courses-content">
            <div class="course-author d-flex align-items-center">
                <?php echo wp_kses_post ($course->get_instructor()->get_profile_picture() ); ?>
                <span><?php echo wp_kses_post( $course->get_instructor_html() ); ?></span>
            </div>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p><?php the_excerpt(); ?></p>
            <ul class="courses-box-footer d-flex justify-content-between align-items-center">
                <?php $user_count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0; ?>

                <li>
                    <i class="flaticon-agenda"></i> <?php echo wp_kses_post( $course->get_curriculum_items( 'lp_lesson' ) ? count( $course->get_curriculum_items( 'lp_lesson' ) ) : 0 ); ?> <?php echo esc_html( $lessons_title ); ?>
                </li>
                <li>
                    <i class="flaticon-people"></i> <?php echo esc_html( $user_count ); ?> <?php echo esc_html( $students_title ); ?>
                </li>
            </ul>
        </div>
    </div>
</div>