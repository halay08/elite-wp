<?php

namespace TUTOR_PRO;

if (!defined('ABSPATH'))
    exit;

class Course_Duplicator {
    private $necessary_post_columns = [
        'post_author',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'post_content_filtered',
        'menu_order',
        'post_type',
        'post_mime_type'
    ];

    private $necessary_child_types = [
        'topics',
        'lesson',
        'tutor_quiz',
        'tutor_announcements',
        'tutor_assignments'
    ];

    private $allowed_user_role = [
        'administrator',
        'editor',
        'tutor_instructor'
    ];

    // Store duplicated IDs here to avoid accidental inifinity recursion.
    private $duplicated_post_ids = [];

    function __construct() {
        add_action('wp_loaded', array($this, 'init_duplicator'));
        add_filter('post_row_actions', array($this, 'register_duplicate_button'), 10, 2);
        add_action('tutor_course_dashboard_actions_after', array($this, 'duplicate_button_in_dashboard'));
    }

    private function get_duplicator_html($course_id, bool $is_wp_admin, $class = '') {
        return '<a class="' . $class . '" href="?tutor_action=duplicate_course&is_wp_admin=' . ($is_wp_admin ? 'yes' : 'no') . '&course_id=' . $course_id . '" aria-label="'.__('Duplicate', 'tutor-pro').'">
                '.__('Duplicate', 'tutor-pro').'
            </a>';
    }

    private function get_course_edit_link($course_id, bool $is_admin) {
        return $is_admin ? get_edit_post_link($course_id, null) : tutor_utils()->get_tutor_dashboard_page_permalink('create-course/?course_ID=' . $course_id);
    }

    public function duplicate_button_in_dashboard($course_id) {

        echo $this->get_duplicator_html($course_id, false, 'tutor-mycourse-edit');
    }

    public function register_duplicate_button($actions, $post) {
        if ($post->post_type == tutor()->course_post_type) {
            $actions[] = $this->get_duplicator_html($post->ID, true);
        }

        return $actions;
    }

    public function init_duplicator() {
        $action = $_GET['tutor_action'] ?? '';
        $id = $_GET['course_id'] ?? '';

        if ($action !== 'duplicate_course' || !is_numeric($id) || $id == 0) {
            // This request is for something else or invalid
            return;
        }

        if ($this->is_valid_user_role()) {
            // Duplicate the post
            $new_post_id = $this->duplicate_post($id);

            if ($new_post_id) {
                $is_admin = ($_GET['is_wp_admin'] ?? 'yes') == 'yes';
                $edit_link = $this->get_course_edit_link($new_post_id, $is_admin);
                header('Location: ' . $edit_link);
                exit;
            }
        }

        exit('You are not allowed for this action.');
    }

    private function is_valid_user_role() {
        $current_user = wp_get_current_user();

        if (is_object($current_user) && property_exists($current_user, 'roles')) {
            $roles = (array)$current_user->roles;
            $different = array_diff($this->allowed_user_role, $roles);
            $exist_in_allowed = count($different) < count($this->allowed_user_role);

            return $exist_in_allowed;
        }
    }

    private function duplicate_post($post_id, $absolute_course_id = null, $new_parent_id = 0) {

        $post = get_post($post_id);
        $post = is_object($post) ? (array)$post : null;

        if (!$post) {
            // Return right from here
            return false;
        }

        // Create new post using the old values
        $post = $this->strip_unnecessary_columns($post);
        $post['post_parent'] = $new_parent_id;
        $post['post_status'] = $new_parent_id>0 ? 'publish' : 'draft';
        $new_id = wp_insert_post($post);

        // Duplicate post meta
        $this->duplicate_post_meta($post_id, $new_id, $absolute_course_id);

        // Assign taxonomy
        $this->assign_post_taxonomy($post_id, $new_id, 'course-category');
        $this->assign_post_taxonomy($post_id, $new_id, 'course-tag');

        // Duplicate quiz question if it is quiz post type
        $post['post_type'] == 'tutor_quiz' ? $this->duplicate_quiz_dependency($post_id, $new_id, false) : 0;

        // Set it as done
        $this->duplicated_post_ids[] = (int)$post_id;

        // Now duplicate childs like topic, lesson, etc.
        $childs = $this->get_child_post_ids($post_id);

        foreach ($childs as $child_id) {
            if (in_array((int)$child_id, $this->duplicated_post_ids)) {
                // Avoid accidental infinity recursion
                continue;
            }

            $this->duplicate_post($child_id, ($absolute_course_id ?? $new_id), $new_id);
        }

        return $new_id;
    }

    private function duplicate_post_meta($old_id, $new_id, $absolute_course_id) {

        // Get existing meta from old post
        $meta_array = get_post_meta($old_id);
        !is_array($meta_array) ? $meta_array = [] : 0;

        // Add these meta to newly created post
        foreach ($meta_array as $name => $value) {

            // Convert to singular value from second level array
            $value = is_array($value) ? ($value[0] ?? '') : '';
            $value = is_serialized($value) ? unserialize($value) : $value;
            
            // Replace old course ID meta with new one
            $name == '_tutor_course_id_for_lesson' ? $value = $absolute_course_id : 0;
            $name == '_tutor_course_price_type' ? $value = 'free' : 0;
            
            if($name == '_tutor_course_product_id'){
                continue;
            } 

            update_post_meta($new_id, $name, $value);
        }
    }

    private function assign_post_taxonomy($old_id, $new_id, $taxonomy) {
        $old_terms = get_the_terms($old_id, $taxonomy);
        !is_array($old_terms) ? $old_terms = [] : 0;

        // Extract terms IDs
        $term_ids = [];
        foreach ($old_terms as $term) {
            $term_ids[] = $term->term_id;
        }

        // Assign the terms
        count($term_ids) > 0 ? wp_set_post_terms($new_id, $term_ids, $taxonomy) : 0;
    }

    private function duplicate_quiz_dependency($old_context_id, $new_context_id, bool $is_answer) {

        $table_name = $is_answer ? 'tutor_quiz_question_answers' : 'tutor_quiz_questions';
        $rel_id_column = $is_answer ? 'belongs_question_id' : 'quiz_id';
        $base_id_column = $is_answer ? 'answer_id' : 'question_id';

        global $wpdb, $table_prefix;
        $context_table = $table_prefix . $table_name;

        // Get quiz quesions by quiz post ID
        $query = 'SELECT * FROM ' . $context_table . ' WHERE ' . $rel_id_column . '=' . $old_context_id;
        $result = $wpdb->get_results($query);

        if (is_array($result) && !empty($result)) {

            // Loop through every question and duplicate
            foreach ($result as $context) {
                $context = (array)$context;

                $old_stuff_id = $context[$base_id_column];

                unset($context[$base_id_column]);
                $context[$rel_id_column] = $new_context_id;

                // Insert new row
                $wpdb->insert($context_table, $context);

                // Now copy quiz question answers
                !$is_answer ? $this->duplicate_quiz_dependency($old_stuff_id, $wpdb->insert_id, true) : 0;
            }
        }
    }


    private function get_child_post_ids($parent_id) {
        $children = get_children(['post_parent' => $parent_id, 'post_type' => $this->necessary_child_types, 'posts_per_page'=>-1]);
        !is_array($children) ? $children = [] : 0;

        $child_ids = [];
        foreach ($children as $child_post) {
            is_object($child_post) ? $child_ids[] = (int)$child_post->ID : 0;
        }

        return $child_ids;
    }

    private function strip_unnecessary_columns(array $post) {
        $new_array = [];

        foreach ($post as $column => $value) {
            if (in_array($column, $this->necessary_post_columns)) {
                // Kepp only if it exist in ncessary column list
                $new_array[$column] = $value;
            }
        }

        return $new_array;
    }
}
