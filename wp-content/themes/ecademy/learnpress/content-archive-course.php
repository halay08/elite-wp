<?php
/**
 * Template for displaying archive course content.
 *
 * This template can be overridden by copying it to ecademy/learnpress/content-archive-course.php
 *
 * @author  EnvyTheme
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $post, $wp_query, $lp_tax_query, $wp_query;

$total = $wp_query->found_posts;

if ( $total == 0 ) {
	$message = '<p class="message message-error">' . esc_html__( 'No courses found!', 'ecademy' ) . '</p>';
	$index   = esc_html__( 'There are no available courses!', 'ecademy' );
} elseif ( $total == 1 ) {
	$index = esc_html__( 'Showing only one result', 'ecademy' );
} else {
	$courses_per_page = absint( LP()->settings->get( 'archive_course_limit' ) );
	$paged            = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

	$from = 1 + ( $paged - 1 ) * $courses_per_page;
	$to   = ( $paged * $courses_per_page > $total ) ? $total : $paged * $courses_per_page;

	if ( $from == $to ) {
		$index = sprintf(
			esc_html__( 'Showing last course of %s results', 'ecademy' ),
			$total
		);
	} else {
		$index = sprintf(
			esc_html__( 'Showing %s-%s of %s results', 'ecademy' ),
			$from,
			$to,
			$total
		);
	}
}

?>
<?php
	if ( LP()->wp_query->have_posts() ) :

		/**
		 * @deprecated
		 */
		do_action( 'learn_press_before_courses_loop' );

		/**
		 * @since 3.0.0
		 */
		do_action( 'learn-press/before-courses-loop' );
		?>
		<div class="row">
			<?php if ( is_active_sidebar( 'course-sidebar' ) ): ?>
				<div class="col-lg-8 col-md-12">
			<?php else: ?>
				<div class="col-lg-12 col-md-12">
			<?php endif; ?>
			<div class="ecademy-grid-sorting row align-items-center">
				<div class="col-lg-6 col-md-6 result-count">
					<p><?php echo wp_kses_post( $index ); ?></p>
				</div>

				<div class="col-lg-6 col-md-6 ordering">
					<div class="topbar-search">
						<form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>">
							<label><i class="bx bx-search"></i></label>
							<input type="text" value="" name="s" placeholder="<?php esc_attr_e( 'Search our courses', 'ecademy' ) ?>" class="input-search" autocomplete="off" />
							<input type="hidden" value="course" name="ref" />
							<input type="hidden" name="post_type" value="lp_course">
						</form>
					</div>
				</div>
			</div>
				<div class="row">
					<?php
					while ( LP()->wp_query->have_posts() ) : LP()->wp_query->the_post();

						learn_press_get_template_part( 'content', 'course' );

					endwhile;
					?>
				</div>
				<?php
					/**
					 * @since 3.0.0
					 */
					do_action( 'learn_press_after_courses_loop' );

					/**
					 * @deprecated
					 */
					do_action( 'learn-press/after-courses-loop' );

					wp_reset_postdata();
				?>
			</div>
			
			<?php if ( is_active_sidebar( 'course-sidebar' ) ): ?>
				<div class="col-lg-4 col-md-12">
					<div id="secondary" class="sidebar">
						<?php dynamic_sidebar('course-sidebar'); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<?php
	else:
		learn_press_display_message( __( 'No course found.', 'ecademy' ), 'error' );
	endif;
?>