<?php
if ( ! defined( 'ABSPATH' ) )
exit;

global $wpdb;
// Pagination
$per_page = 10;
$current_page = isset( $_GET['paged'] ) ? $_GET['paged'] : 0;
$paged =  max( 0,($current_page-1)*$per_page );

// Search Filter
$_search    = isset($_GET['search']) ? $_GET['search'] : '';
$_course    = isset($_GET['course']) ? $_GET['course'] : '';
$_date      = isset($_GET['date']) ? $_GET['date'] : '';
$_filter    = isset($_GET['filter']) ? $_GET['filter'] : 'upcoming';

$user_id = get_current_user_id();
$has_items = count(get_tutor_zoom_meetings(array(
    'author'    =>  $user_id,
)));
$total_items = count(get_tutor_zoom_meetings(array(
    'author'    => $user_id,
    'search'    => $_search,
    'course_id' => $_course,
    'date'      => $_date,
    'filter'    => $_filter,
)));

$meetings = get_tutor_zoom_meetings(array(
    'author'    => $user_id,
    'paged'     => $paged,
    'per_page'  => $per_page,
    'search'    => $_search,
    'course_id' => $_course,
    'date'      => $_date,
    'filter'    => $_filter,
));

$courses = get_posts(array(
    'author'        => $user_id,
    'numberposts'   => -1,
    'post_type'     => tutor()->course_post_type,
    'post_status'   => 'publish'
));

if ($has_items > 0) { ?>
    <div class="tutor-zoom-page-title">
        <h3><?php _e('Meeting List', 'tutor-pro') ?></h3>
    </div>
    <div class="tutor-admin-search-box-container">
        <div> 
            <div class="menu-label"><?php _e('Search', 'tutor-pro'); ?></div>
            <div>
                <input type="text" class="tutor-report-search" value="<?php echo $_search; ?>" autocomplete="off" placeholder="<?php _e('Search in here.', 'tutor-pro'); ?>" />
                <button class="tutor-zoom-search-action tutor-report-search-btn"><i class="tutor-icon-magnifying-glass-1"></i></button>
            </div>
        </div>

        <div>
            <div class="menu-label"><?php _e('Course', 'tutor-pro'); ?></div>
            <div>
                <select class="tutor-zoom-course">
                    <option value=""><?php _e('All', 'tutor-pro'); ?></option>
                    <?php
                    if (!empty($courses)) {
                        foreach ($courses as $key => $course) {
                            echo '<option '.($_course == $course->ID ? "selected" : "").' value="'.$course->ID.'">'.$course->post_title.'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div>
            <div class="menu-label"><?php _e('Date', 'tutor-pro'); ?></div>
            <div class="date-range-input">
                <input type="text" class="tutor_zoom_datepicker tutor-zoom-date" value="<?php echo $_date; ?>" autocomplete="off" placeholder="<?php echo date("Y-m-d"); ?>" />
                <i class="tutor-icon-calendar"></i>
            </div>
        </div>

        <div>
            <div class="menu-label"><?php _e('Filter', 'tutor-pro'); ?></div>
            <div>
                <select class="tutor-zoom-filter">
                    <option value="upcoming" <?php selected( $_filter, 'upcoming' ); ?>><?php _e('Upcoming'); ?></option>
                    <option value="previous" <?php selected( $_filter, 'previous' ); ?>><?php _e('Previous'); ?></option>
                </select>
            </div>
        </div>
    </div>

    <div class="tutor-list-wrap tutor-zoom-meeting-list">
        <?php 
        if (!empty($meetings)) { ?>
            <table class="tutor-list-table">
                <thead>
                    <tr>
                        <th><?php _e('Start Time', 'tutor-pro'); ?></th>
                        <th><?php _e('Meeting Name', 'tutor-pro'); ?></th>
                        <th><?php _e('Meeting ID', 'tutor-pro'); ?></th>
                        <th><?php _e('Password', 'tutor-pro'); ?></th>
                        <th><?php _e('Host Email', 'tutor-pro'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($meetings as $key => $meeting) { 
                        $tzm_start      = get_post_meta($meeting->ID, '_tutor_zm_start_datetime', true);
                        $meeting_data   = get_post_meta($meeting->ID, $this->zoom_meeting_post_meta, true);
                        $meeting_data   = json_decode($meeting_data, true);
                        $input_date     = \DateTime::createFromFormat('Y-m-d H:i:s', $tzm_start);
                        $start_date     = $input_date->format('j M, Y,<\b\r>h:i A');
                        $course_id      = get_post_meta($meeting->ID, '_tutor_zm_for_course', true);
                        $topic_id       = get_post_meta($meeting->ID, '_tutor_zm_for_topic', true);
                        ?>
                        <tr class="tutor-zoom-meeting-item">
                            <td>
                                <?php echo $start_date; ?> 
                            </td>
                            <td>
                                <span><?php echo $meeting->post_title; ?></span>
                                <p><?php echo __('Course:', 'tutor-pro').' '.get_the_title($course_id); ?></p>
                            </td>
                            <td><?php echo $meeting_data['id']; ?></td>
                            <td><?php echo $meeting_data['password']; ?></td>
                            <td><?php echo $meeting_data['host_email']; ?></td>
                            <td class="col-action">
                                <div class="details-button">
                                    <a href="<?php echo $meeting_data['start_url']; ?>" class="tutor-btn bordered-btn" target="_blank"><img src="<?php echo TUTOR_ZOOM()->url . 'assets/images/zoom-icon.svg'; ?>" alt="Zoom" /> <?php _e('Start Meeting', 'tutor-pro'); ?></a>
                                    <a href="javascript:void(0);" class="tutor-zoom-meeting-modal-open-btn edit" data-meeting-id="<?php echo $meeting->ID; ?>" data-topic-id="<?php echo $topic_id; ?>" data-course-id="<?php echo $course_id; ?>" data-click-form="0"><i class="tutor-icon-pencil"></i></a>
                                    <a href="javascript:void(0);" class="tutor-zoom-meeting-delete-btn delete" data-meeting-id="<?php echo $meeting->ID; ?>"><i class="tutor-icon-garbage"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php 
        } else { ?>
            <div class="no-data-found">
                <img src="<?php echo tutor_pro()->url."addons/tutor-report/assets/images/empty-data.svg"?>" alt="">
                <span><?php _e('No Zoom meetings found', 'tutor-pro'); ?></span>
            </div>
        <?php
        } ?>
        <div class="tutor-list-footer">
            <div class="tutor-report-count">
                <?php 
                    if($total_items > 0){
                        printf( __('Items <strong> %s </strong> of <strong> %s </strong> total'), $per_page,  $total_items );
                    }
                ?>
            </div>
            <div class="tutor-pagination">
                <?php
                echo paginate_links( array(
                    'base' => str_replace( 1, '%#%', "admin.php?page=tutor_zoom&sub_page=meetings&paged=%#%" ),
                    'current' => max( 1, $current_page ),
                    'total' => ceil($total_items/$per_page)
                ) );
                ?>
            </div>
        </div>
    </div>
<?php 
} else { ?>
    <div class='tutor-alert tutor-alert-info'>
        <?php _e('To add a new meeting, please open a course in editing mode.', 'tutor-pro'); ?>
    </div>
    <div class="tutor-zoom-data-found">
        <img src="<?php echo TUTOR_ZOOM()->url.'assets/images/empty-meeting.png'; ?>" alt="" />
        <p><?php _e('No Zoom meetings have been added yet', 'tutor-pro'); ?></p>
    </div>
<?php 
} ?>

<div class="tutor-modal-wrap tutor-zoom-meeting-modal-wrap">
    <div class="tutor-modal-content">
        <div class="modal-header">
            <div class="modal-title">
                <h1><?php _e('Zoom Meeting', 'tutor-pro'); ?></h1>
            </div>
            <div class="modal-close-wrap">
                <a href="javascript:;" class="modal-close-btn"><i class="tutor-icon-line-cross"></i> </a>
            </div>
        </div>
        <div class="modal-container"></div>
    </div>
</div>