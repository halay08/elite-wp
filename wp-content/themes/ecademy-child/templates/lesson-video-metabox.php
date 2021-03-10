<?php
/**
 * Don't change it, it's supporting modal in other place
 * if get_the_ID() empty, then it's means we are passing $post variable from another place
 */
if (get_the_ID())
	global $post;

$room      = get_post_meta($post->ID, '_room', true);
$room_url  = isset( $room['url'] ) ? $room['url'] : '';
$room_date = isset( $room['date'] ) ? $room['date'] : '';
$room_time = isset( $room['time'] ) ? $room['time'] : '';
?>

<div class="tutor-option-field-row">
    <div class="tutor-option-field-label">
        <label for="">
            <?php _e('Room URL', 'tutor'); ?>
        </label>
    </div>

    <div class="tutor-option-field tutor-video-upload-wrap">

		<button type="button" class="tutor-btn generateRoomURL bordered-btn" style="margin-bottom: 15px;"><?php _e('Generate Room URL', 'tutor'); ?></button>

		<input id="room-url-input" type="text" name="_room[url]" value="<?php echo $room_url; ?>" placeholder="<?php _e('Enter Room URL or click button above to generate Room URL automatically', 'tutor'); ?>">

    </div>
</div>
<div class="tutor-option-field-row">
    <div class="tutor-option-field-label">
        <label for=""><?php _e('Lesson start time', 'tutor'); ?></label>
    </div>
    <div class="tutor-option-field">
        <div class="tutor-option-gorup-fields-wrap">
            <div class="tutor-lesson-video-runtime">
                <div class="tutor-option-group-field">
                    <input type="date" value="<?php echo $room_date; ?>" name="_room[date]">
                    <p class="desc" style="margin: 0;"><?php _e('Date', 'tutor'); ?></p>
                </div>

                <div class="tutor-option-group-field">
                    <input type="time" class="tutor-number-validation" value="<?php echo $room_time; ?>" name="_room[time]">
                    <p class="desc" style="margin: 0;"><?php _e('Time', 'tutor'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>