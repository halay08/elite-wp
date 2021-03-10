<?php

function ecademy_enqueue_style() {
    wp_enqueue_style( "parent-style" , get_parent_theme_file_uri( "/style.css" ) );
}
add_action( 'wp_enqueue_scripts', 'ecademy_enqueue_style' );

date_default_timezone_set('Asia/Saigon');

function enqueue_custom_scripts() {
    $screen = get_current_screen();
    if ( $screen->base == 'post' ) {
	    wp_enqueue_script( 'generate-room-url', get_stylesheet_directory_uri() . '/assets/js/generateRoomURL.js', array( 'jquery', 'jquery-ui-datepicker' ), 1.0, true );
        wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
        wp_enqueue_style('jquery-ui');
    }
}
add_action( 'admin_enqueue_scripts', 'enqueue_custom_scripts' );

function update_room_metadata( $lesson_id ) {
	$room = isset( $_POST['_room'] ) && is_array( $_POST['_room'] ) ? $_POST['_room'] : [];
    error_log( json_encode( $room ) );
    if( ! empty( $room ) ) {
        update_post_meta($lesson_id, '_room', $room);
    } else {
        delete_post_meta($lesson_id, '_room');
    }
}
add_action('save_post_lesson', 'update_room_metadata', 10, 1 );

function add_room_information_into_lesson_detail() {
    $lesson_id = get_the_ID();
    $room      = get_post_meta( $lesson_id, '_room', true );
    if( !empty( $room ) ) {
        $date           = new DateTime( $room['date'] . ' ' . $room['time'] );
        $date_formatted = $date->format('j-M-Y H:i');
    ?>
    <div class="tutor-page-segment tutor-attachments-wrap">
        <h3><?php _e('Room information', 'tutor'); ?></h3>
        <div class="tutor-single-course-meta tutor-lead-meta">
            <ul>
                <li>
                    <span>Room link</span>
                    <a target="_blank" rel="noopener noreferrer" href="<?php echo $room['url'] ?>"><?php echo $room['url'] ?></a>
                </li>
                <li>
                    <span>Start time</span>
                    <p><?php echo $date_formatted; ?></p>
                </li>
            </ul>
        </div>
    </div>
    <?php
    }
}
add_action( 'tutor_global/after/attachments', 'add_room_information_into_lesson_detail' );

function add_time_into_lesson_preview( $title, $lesson_id ) {
    $room           = get_post_meta( $lesson_id, '_room', true );
    if( !isset( $room['date'] ) ) return $title;

    $date           = new DateTime( $room['date'] . ' ' . $room['time'] );
    $date_formatted = $date->format('j-M-Y H:i');
    $available      = (new DateTime())->getTimestamp() >= $date->getTimestamp() ? '#4BD863' : '#fe4a55';
    $permalink      = get_the_permalink();

    $title .= "<a href='${permalink}' style='margin-left: auto; color: ${available};'>${date_formatted}</a>";
    return $title;
}

add_filter('tutor_course/contents/lesson/title', 'add_time_into_lesson_preview', 10, 2);