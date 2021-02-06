<?php
$submitted_assignment = tutor_utils()->get_assignment_submit_info($assignment_submitted_id);
$max_mark = tutor_utils()->get_assignment_option($submitted_assignment->comment_post_ID, 'total_mark');

$given_mark = get_comment_meta($assignment_submitted_id, 'assignment_mark', true);
$instructor_note = get_comment_meta($assignment_submitted_id, 'instructor_note', true);
?>

<div class="wrap">
	<h2><?php _e('Submitted Assignment', 'tutor-pro'); ?></h2>

    <div class="submitted-assignment-wrap">


        <p>
            <?php _e('Course' , 'tutor-pro'); ?> :
            <a href="<?php echo get_the_permalink($submitted_assignment->comment_parent); ?>" target="_blank">
                <?php echo get_the_title($submitted_assignment->comment_parent); ?>
            </a>
        </p>

        <p>
            <?php _e('Assignment' , 'tutor-pro'); ?> :
            <a href="<?php echo get_the_permalink($submitted_assignment->comment_post_ID); ?>" target="_blank">
	            <?php echo get_the_title($submitted_assignment->comment_post_ID); ?>
            </a>
        </p>


        <h2><?php _e('Answers', 'tutor-pro'); ?></h2>

		<?php echo nl2br(stripslashes($submitted_assignment->comment_content));

		$attached_files = get_comment_meta($submitted_assignment->comment_ID, 'uploaded_attachments', true);
		if ($attached_files){
			$attached_files = json_decode($attached_files, true);

			if (tutor_utils()->count($attached_files)){
				?>
                <h2><?php _e('Uploaded file(s)', 'tutor-pro'); ?></h2>

				<?php
				$upload_dir = wp_get_upload_dir();
				$upload_baseurl = trailingslashit(tutor_utils()->array_get('baseurl', $upload_dir));
				foreach ($attached_files as $attached_file){
					?>
                    <div class="uploaded-files">
                        <a href="<?php echo $upload_baseurl.tutor_utils()->array_get('uploaded_path', $attached_file) ?>" target="_blank"><?php echo tutor_utils()->array_get('name', $attached_file); ?></a>
                    </div>
					<?php
				}
			}
		}
		?>



        <h2><?php _e('Evaluation', 'tutor-pro'); ?></h2>
        <p class="text-muted"><?php _e('Your evaluation about this submission', 'tutor-pro'); ?></p>


        <div class="tutor-assignment-evaluate-wraps">

            <form action="" method="post">

	            <?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
                <input type="hidden" value="tutor_evaluate_assignment_submission" name="tutor_action"/>
                <input type="hidden" value="<?php echo $assignment_submitted_id; ?>" name="assignment_submitted_id"/>

                <div class="tutor-option-field-row">
                    <div class="tutor-option-field-label">
                        <label for=""><?php _e('Your Mark', 'tutor-pro'); ?></label>
                    </div>
                    <div class="tutor-option-field">
                        <input type="number" name="evaluate_assignment[assignment_mark]" value="<?php echo $given_mark ? $given_mark : 0; ?>">
                        <p class="desc"><?php echo sprintf(__('Mark this assignment out of %s', 'tutor-pro'), "<code>{$max_mark}</code>" ); ?></p>
                    </div>
                </div>


                <div class="tutor-option-field-row">
                    <div class="tutor-option-field-label">
                        <label for=""><?php _e('Write a note', 'tutor-pro'); ?></label>
                    </div>
                    <div class="tutor-option-field">
                        <textarea name="evaluate_assignment[instructor_note]"><?php echo $instructor_note; ?></textarea>
                        <p class="desc"><?php _e('Write a note to students about this submission', 'tutor-pro'); ?></p>
                    </div>
                </div>


                <div class="tutor-option-field-row">
                    <div class="tutor-option-field-label"></div>
                    <div class="tutor-option-field">
                        <button type="submit" class="tutor-button tutor-button-primary"><?php _e('Evaluate this submission', 'tutor-pro'); ?></button>
                    </div>
                </div>


            </form>

        </div>




    </div>







</div>