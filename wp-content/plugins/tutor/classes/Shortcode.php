<?php
/**
 * Class Shortcode
 * @package TUTOR
 *
 * @since v.1.0.0
 */

namespace TUTOR;

if (!defined('ABSPATH'))
	exit;

class Shortcode {

	private $instructor_layout = array(
        'pp-top-full',
        'pp-cp',
        'pp-top-left',
        'pp-left-middle',
        'pp-left-full'
	);
	
	public function __construct() {
		add_shortcode('tutor_student_registration_form', array($this, 'student_registration_form'));
		add_shortcode('tutor_dashboard', array($this, 'tutor_dashboard'));
		add_shortcode('tutor_instructor_registration_form', array($this, 'instructor_registration_form'));
		add_shortcode('tutor_course', array($this, 'tutor_course'));

		add_shortcode('tutor_instructor_list', array($this, 'tutor_instructor_list'));
		add_action('tutor_options_after_instructors', array($this, 'tutor_instructor_layout'));
	}

	/**
	 * @return mixed
	 *
	 * Instructor Registration Shortcode
	 *
	 * @since v.1.0.0
	 */
	public function student_registration_form() {
		ob_start();
		if (is_user_logged_in()) {
			tutor_load_template('dashboard.logged-in');
		} else {
			tutor_load_template('dashboard.registration');
		}
		return apply_filters('tutor/student/register', ob_get_clean());
	}

	/**
	 * @return mixed
	 *
	 * Tutor Dashboard for students
	 *
	 * @since v.1.0.0
	 */
	public function tutor_dashboard() {
		global $wp_query;

		ob_start();
		if (is_user_logged_in()) {
			/**
			 * Added isset() Condition to avoid infinite loop since v.1.5.4
			 * This has cause error by others plugin, Such AS SEO
			 */

			if (!isset($wp_query->query_vars['tutor_dashboard_page'])) {
				tutor_load_template('dashboard.index');
			}
		} else {
			tutor_load_template('global.login');
		}
		return apply_filters('tutor_dashboard/index', ob_get_clean());
	}

	/**
	 * @return mixed
	 *
	 * Instructor Registration Shortcode
	 *
	 * @since v.1.0.0
	 */
	public function instructor_registration_form() {
		ob_start();
		if (is_user_logged_in()) {
			tutor_load_template('dashboard.instructor.logged-in');
		} else {
			tutor_load_template('dashboard.instructor.registration');
		}
		return apply_filters('tutor_dashboard/student/index', ob_get_clean());
	}

	/**
	 * @param $atts
	 *
	 * @return string
	 *
	 * Shortcode for getting course
	 */
	public function tutor_course($atts) {
		$course_post_type = tutor()->course_post_type;

		$a = shortcode_atts(array(
			'post_type' 	=> $course_post_type,
			'post_status'   => 'publish',

			'id'       		=> '',
			'exclude_ids'   => '',
			'category'     	=> '',

			'orderby'       => 'ID',
			'order'         => 'DESC',
			'count'     	=> 6,
		), $atts);

		if (!empty($a['id'])) {
			$ids = (array) explode(',', $a['id']);
			$a['post__in'] = $ids;
		}

		if (!empty($a['exclude_ids'])) {
			$exclude_ids = (array) explode(',', $a['exclude_ids']);
			$a['post__not_in'] = $exclude_ids;
		}
		if (!empty($a['category'])) {
			$category = (array) explode(',', $a['category']);

			$a['tax_query'] = array(
				array(
					'taxonomy' => 'course-category',
					'field'    => 'term_id',
					'terms'    => $category,
					'operator' => 'IN',
				),
			);
		}
		$a['posts_per_page'] = (int) $a['count'];

		wp_reset_query();
		query_posts($a);
		ob_start();

		$GLOBALS['tutor_shortcode_arg'] = array(
			'include_course_filter' => isset($atts['course_filter']) ? $atts['course_filter'] === 'on' : null,
			'column_per_row' => isset($atts['column_per_row']) ? $atts['column_per_row'] : null,
			'course_per_page' => $a['posts_per_page']
		);

		tutor_load_template('shortcode.tutor-course');
		$output = ob_get_clean();
		wp_reset_query();

		return $output;
	}

	
	/**
	 * @param $atts
	 *
	 * @return string
	 *
	 * Shortcode for getting instructors
	 */
	public function tutor_instructor_list($atts){
		$limit = isset($atts['count']) ? $atts['count'] : 9;
		$current_page = (isset($_GET['instructor-page']) && is_numeric($_GET['instructor-page']) && $_GET['instructor-page']>=1) ? $_GET['instructor-page'] : 1;
		$page = $current_page-1;
		
		// Get instructor list to sow
		$instructors = tutor_utils()->get_instructors($limit*$page, $limit, '', 'approved');
		$next_instructors = tutor_utils()->get_instructors($limit*$current_page, $limit, '', 'approved');

		$previous_page = $page>0 ? '?'.http_build_query(array_merge($_GET, array('instructor-page'=>$current_page-1))) : null;
		$next_page = (is_array($next_instructors) && count($next_instructors)>0) ? '?'.http_build_query(array_merge($_GET, array('instructor-page'=>$current_page+1))) : null;
		
		$layout = (isset($atts['layout']) && in_array($atts['layout'], $this->instructor_layout)) ? $atts['layout'] : null;
		$layout = $layout ? $layout : tutor_utils()->get_option('instructor_list_layout', $this->instructor_layout[0]);

		$payload=array(
			'instructors' => is_array($instructors) ? $instructors : array(), 
			'next_page' => $next_page, 
			'previous_page' => $previous_page,
			'column_count' => isset($atts['column_per_row']) ? $atts['column_per_row'] : 3,
			'layout' => $layout
		);

		ob_start();
		tutor_load_template('shortcode.tutor-instructor', $payload);
		return ob_get_clean();
	}

	
	/**
	 * Show layout selection dashboard in instructor setting
	 */
	public function tutor_instructor_layout(){
		tutor_load_template('instructor-setting', array('templates'=>$this->instructor_layout));
	}
}
