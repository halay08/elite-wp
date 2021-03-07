<?php
namespace TUTOR_ASSIGNMENTS;

if ( ! defined( 'ABSPATH' ) )
	exit;

if (! class_exists('Tutor_List_Table')){
	include_once tutor()->path.'classes/Tutor_List_Table.php';
}

class Assignments_List extends \Tutor_List_Table {

	function __construct(){
		global $status, $page;

		//Set parent defaults
		parent::__construct( array(
			'singular'  => 'assignment',     //singular name of the listed records
			'plural'    => 'assignments',    //plural name of the listed records
			'ajax'      => false        //does this table support ajax?
		) );

		$this->delete_assignment();
	}

	public function delete_assignment(){
		$assignment_id = (int) tutils()->array_get('delete_assignment', $_GET);
		
		if ($assignment_id){
			global $wpdb;
			
			if(!tutils()->can_user_manage('assignment', $assignment_id)) {
				wp_send_json_error( array('message'=>'Access Denied') );
			}

			$assignment = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->comments} WHERE comment_ID = %d", $assignment_id));
			if ($assignment){
				$wpdb->delete($wpdb->comments, array('comment_ID' => $assignment_id ));
				$wpdb->delete($wpdb->commentmeta, array('comment_id' => $assignment_id ));
			}

			tutor_redirect_back(remove_query_arg('delete_assignment'));
		}
	}

	function column_default($item, $column_name){
		switch($column_name){
			case 'user_email':
				return $item->$column_name;
			default:
				return print_r($item,true); //Show the whole array for troubleshooting purposes
		}
	}

	function column_mark($item){
		echo tutor_utils()->get_assignment_option($item->comment_post_ID, 'total_mark');
	}
	function column_passing_mark($item){
		echo tutor_utils()->get_assignment_option($item->comment_post_ID, 'pass_mark');
	}
	function column_student($item){
		echo $item->comment_author;
	}
	function column_title($item){
		echo '<a href="'.get_the_permalink($item->comment_post_ID).'" target="_blank">'.get_the_title($item->comment_post_ID).'</a>';
	}
	function column_duration($item){
		echo tutor_utils()->get_assignment_option($item->comment_post_ID, 'time_duration.value').' '.tutor_utils()->get_assignment_option
			($item->comment_post_ID, 'time_duration.time');
	}
	function column_date($item){
		echo '<p>';
		echo __('Started', 'tutor-pro').' : ';
		echo date(get_option('date_format').' '.get_option('time_format'), strtotime($item->comment_date_gmt)); //Submit Finished
		echo '</p>';

		echo '<p>';
		echo __('Finished', 'tutor-pro').' : ';
		echo date(get_option('date_format').' '.get_option('time_format'), strtotime($item->comment_date)); //Submit Finished
		echo '</p>';
	}

	function column_action($item){
		echo "<a href='".admin_url('admin.php?page=tutor-assignments&view_assignment='.$item->comment_ID)."' class='tutor-button tutor-button-small tutor-button-primary' style='margin-bottom: 5px;'> <i class='dashicons dashicons-visibility'></i> ".__('View ', 'tutor-pro')."</a> ";

		echo " <a href='".admin_url('admin.php?page=tutor-assignments&delete_assignment='.$item->comment_ID)."' class='tutor-button tutor-button-small tutor-danger' onclick='return confirm(\"".__('Are you sure?', 'tutor-pro')."\")' > <i class='tutor-icon-garbage'></i> ".__(' Delete', 'tutor-pro')."</a>";
	}

	/**
	 * @param $item
	 *
	 * Completed Course by User
	 */
	function column_course($item){
		echo '<a href="'.get_the_permalink($item->comment_parent).'" target="_blank">'.get_the_title($item->comment_parent).'</a>';
	}

	function column_evaluated($item){
		$not_checked = get_comment_meta($item->comment_ID, 'assignment_mark', true)==='';
		echo $not_checked ? _e('No', 'tutor-pro') :  _e('Yes', 'tutor-pro');
	}

	function column_cb($item){
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("assignment")
			/*$2%s*/ $item->comment_ID                //The value of the checkbox should be the record's id
		);
	}

	function get_columns(){
		$columns = array(
			//'cb'                => '<input type="checkbox" />', //Render a checkbox instead of text
			'title'      => __('Title', 'tutor-pro'),
			'student'        => __('Student', 'tutor-pro'),
			'course'  => __('Course', 'tutor-pro'),
			'mark'  => __('Total Points', 'tutor-pro'),
			'passing_mark'  => __('Minumum Pass Points', 'tutor-pro'),
			'duration'  => __('Duration', 'tutor-pro'),
			'date'  => __('Date', 'tutor-pro'),
			'action'  => __('Actions', 'tutor-pro'),
			'evaluated'  => __('Evaluated', 'tutor-pro'),
		);
		return $columns;
	}

	function prepare_items() {
		global $wpdb;

		$per_page = 20;

		$search_term = '';
		if (isset($_REQUEST['s'])){
			$search_key = sanitize_text_field($_REQUEST['s']);
			$is_valid_key = $search_key!=='';

			$is_valid_key ? $search_term=" AND {$wpdb->posts}.post_title LIKE '%{$search_key}%' " : 0;
		}

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array($columns, $hidden, $sortable);
		//$this->process_bulk_action();

		$current_page = $this->get_pagenum();
		$start = ($current_page-1)*$per_page;
		$total_items = 0;

		// Is current user instructor
		$is_instructor = !current_user_can('administrator') && current_user_can(tutor()->instructor_role);

		// Prepare course ID to show only own assignments to insrtuctor
		$courses_ids = $is_instructor ? tutor_utils()->get_assigned_courses_ids_by_instructors() : [];
		$in_courses_ids = tutor_utils()->count($courses_ids) ? "'".implode("','", $courses_ids)."'" : '';
		
		// Create base query including specific course ID if necessary
		$where_instructor = $is_instructor ? " AND {$wpdb->comments}.comment_parent IN({$in_courses_ids}) " : '';		
		$from_base_query = " FROM {$wpdb->comments} LEFT JOIN {$wpdb->posts} ON {$wpdb->comments}.comment_post_ID={$wpdb->posts}.ID WHERE {$wpdb->comments}.comment_type = 'tutor_assignment' AND {$wpdb->comments}.comment_approved = 'submitted' {$where_instructor} {$search_term} ORDER BY {$wpdb->comments}.comment_ID DESC ";

		// Get total count
		$total_items = $wpdb->get_var("SELECT COUNT({$wpdb->comments}.comment_ID) {$from_base_query}");

		// Get submitted assignment
		$this->items = $wpdb->get_results("SELECT {$wpdb->comments}.* {$from_base_query} LIMIT {$start}, {$per_page} ");

		$this->set_pagination_args( array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
		) );
	}
}