<?php
/**
 * Template for displaying course rate.
 *
 * This template can be overridden by copying it to ecademy/learnpress/addons/course-review/course-rate.php.
 *
 * @author EnvyTheme
 * @package LearnPress/Course-Review/Templates
 * version  3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

$course_id       = get_the_ID();
$course_rate_res = learn_press_get_course_rate( $course_id, false );
$course_rate     = $course_rate_res['rated'];
$total           = $course_rate_res['total'];
?>

<div class="courses-reviews">
    <h3><?php esc_html_e( 'Course Rating', 'ecademy' ); ?></h3>
	<?php
	learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
	?>
    <p class="review-number">
		<?php do_action( 'learn_press_before_total_review_number' ); ?>
		<?php printf( __( ' %1.2f average based on ', 'ecademy' ), $course_rate ); ?>
		<?php printf( _n( ' %d rating', '%d ratings', $total, 'ecademy' ), $total ); ?>
		<?php do_action( 'learn_press_after_total_review_number' ); ?>
    </p>
    <div>
		<?php
		if ( isset( $course_rate_res['items'] ) && ! empty( $course_rate_res['items'] ) ):
			foreach ( $course_rate_res['items'] as $item ):
				?>
                <div class="course-rate">
                    <span><?php esc_html( $item['rated'] ); ?><?php esc_html_e( ' Star', 'ecademy' ); ?></span>
                    <div class="review-bar">
                        <div class="rating" style="width:<?php echo esc_attr( $item['percent'] ); ?>% "></div>
                    </div>
                    <span><?php echo esc_html( $item['percent'] ); ?>%</span>
                </div>
			<?php
			endforeach;
		endif;
		?>
    </div>
</div>
