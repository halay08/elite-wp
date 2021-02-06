<?php

/**
 * A single course loop
 *
 * @since v.1.0.0
 * @author envytheme
 * @url https://envytheme.com
 *
 * @package eCademy/Templates
 * @version 1.4.3
 */
global $ecademy_opt;

$lessons_title  = !empty($ecademy_opt['lessons_title']) ? $ecademy_opt['lessons_title'] : 'Lessons';
$students_title = !empty($ecademy_opt['students_title']) ? $ecademy_opt['students_title'] : 'Students';

$course_id          = get_the_ID();
$tutor_lesson_count = tutor_utils()->get_lesson_count_by_course($course_id);

do_action('tutor_course/loop/before_content');

do_action('tutor_course/loop/badge');


do_action('tutor_course/loop/before_header');
do_action('tutor_course/loop/header');
do_action('tutor_course/loop/after_header');


do_action('tutor_course/loop/start_content_wrap');

do_action('tutor_course/loop/before_rating');
do_action('tutor_course/loop/rating');
do_action('tutor_course/loop/after_rating');

do_action('tutor_course/loop/before_title');
do_action('tutor_course/loop/title');
do_action('tutor_course/loop/after_title');
?>
<?php the_excerpt(); ?>
<ul class="courses-box-footer d-flex justify-content-between align-items-center">
    <li>
        <i class="flaticon-agenda"></i> <?php echo $tutor_lesson_count; ?> <?php echo esc_html( $lessons_title ); ?></li>
    <li>
        <i class="flaticon-people"></i> <?php echo (int) tutor_utils()->count_enrolled_users_by_course(); ?>  <?php echo esc_html( $students_title ); ?></li>
</ul>

<?php
// do_action('tutor_course/loop/before_meta');
// do_action('tutor_course/loop/meta');
// do_action('tutor_course/loop/after_meta');


// do_action('tutor_course/loop/before_excerpt');
// do_action('tutor_course/loop/excerpt');
// do_action('tutor_course/loop/after_excerpt');

do_action('tutor_course/loop/end_content_wrap');

// do_action('tutor_course/loop/before_footer');
// do_action('tutor_course/loop/footer');
// do_action('tutor_course/loop/after_footer');

do_action('tutor_course/loop/after_content');

?>