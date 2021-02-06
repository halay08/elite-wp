<?php
/**
 * Template for displaying quizzes tab in user profile page.
 *
 * This template can be overridden by copying it to ecademy/learnpress/tabs/quizzes.php.
 *
 * @author   EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile       = learn_press_get_profile();
$filter_status = LP_Request::get_string( 'filter-status' );
$query         = $profile->query_quizzes( array( 'status' => $filter_status ) );
?>

<div class="learn-press-subtab-content">
    <h3 class="profile-heading"><?php esc_html_e( 'My Quizzes', 'ecademy' ); ?></h3>

	<?php if ( $filters = $profile->get_quizzes_filters( $filter_status ) ) { ?>
        <ul class="lp-sub-menu">
			<?php foreach ( $filters as $class => $link ) { ?>
                <li class="<?php echo esc_attr( $class ); ?>"><?php echo wp_kses_post( $link, 'ecademy' ); ?></li>
			<?php } ?>
        </ul>
	<?php } ?>

	<?php if ( $query['items'] ) { ?>
        <div class="table-responsive">
            <table class="lp-list-table profile-list-quizzes profile-list-table">
                <thead>
                    <tr>
                        <th class="column-course"><?php esc_html_e( 'Course', 'ecademy' ); ?></th>
                        <th class="column-quiz"><?php esc_html_e( 'Quiz', 'ecademy' ); ?></th>
                        <th class="column-date"><?php esc_html_e( 'Date', 'ecademy' ); ?></th>
                        <th class="column-status"><?php esc_html_e( 'Progress', 'ecademy' ); ?></th>
                        <th class="column-time-interval"><?php esc_html_e( 'Interval', 'ecademy' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ( $query['items'] as $user_quiz ) { ?>
                    <?php $quiz = learn_press_get_quiz( $user_quiz->get_id() );
                    $courses    = learn_press_get_item_courses( array( $user_quiz->get_id() ) ); ?>
                    <tr>
                        <td class="column-course">
                            <?php if ( $courses ) {
                                foreach ( $courses as $course ) {
                                    $course = LP_Course::get_course( $course->ID ); ?>
                                    <a href="<?php echo esc_url( $course->get_permalink() ); ?>">
                                        <?php echo wp_kses_post( $course->get_title( 'display' ) ); ?>
                                    </a>
                                <?php }
                            } ?>
                        </td>
                        <td class="column-quiz column-quiz-<?php echo esc_attr( $user_quiz->get_id() );?>">
                            <?php if ( $courses ) {
                                foreach ( $courses as $course ) {
                                    $course = LP_Course::get_course( $course->ID ); ?>
                                    <a href="<?php echo esc_url( $course->get_item_link( $user_quiz->get_id() ) ); ?>">
                                        <?php echo wp_kses_post( $quiz->get_title( 'display' ) ); ?>
                                    </a>
                                <?php }
                            } ?>
                        </td>
                        <td class="column-date"><?php
                            echo wp_kses_post( $user_quiz->get_start_time( 'i18n' ) ); ?></td>
                        <td class="column-status">
                            <span class="result-percent"><?php echo wp_kses_post( $user_quiz->get_percent_result() ); ?></span>
                            <span class="lp-label label-<?php echo esc_attr( $user_quiz->get_results( 'status' ) ); ?>">
                            <?php echo wp_kses_post( $user_quiz->get_status_label() ); ?>
                        </span>
                        </td>
                        <td class="column-time-interval">
                            <?php echo wp_kses_post( $user_quiz->get_time_interval( 'display' ) ); ?>
                        </td>
                    </tr>

                <?php } ?>
                </tbody>
                <tfoot>
                <tr class="list-table-nav">
                    <td colspan="3" class="nav-text">
                        <?php echo wp_kses_post( $query->get_offset_text() ); ?>
                    </td>
                    <td colspan="2" class="nav-pages">
                        <?php $query->get_nav_numbers( true ); ?>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
	<?php } else { ?>
		<?php learn_press_display_message( __( 'No quizzes!', 'ecademy' ) ); ?>
	<?php } ?>
</div>
