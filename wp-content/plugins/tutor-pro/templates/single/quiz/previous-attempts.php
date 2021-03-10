<?php
$passing_grade = tutor_utils()->get_quiz_option($quiz_id, 'passing_grade', 0);
?>

<h4 class="tutor-quiz-attempt-history-title"><?php _e('Previous attempts', 'tutor-pro'); ?></h4>
<div class="tutor-quiz-attempt-history single-quiz-page">
	<table class="tutor-table">
		<thead>
        <tr>
            <th>#</th>
            <th><?php _e('Time', 'tutor-pro'); ?></th>
            <th><?php _e('Questions', 'tutor-pro'); ?></th>
            <th><?php _e('Total Marks', 'tutor-pro'); ?></th>
            <th><?php _e('Earned Marks', 'tutor-pro'); ?></th>
            <th><?php _e('Pass Mark', 'tutor-pro'); ?></th>
            <th><?php _e('Grade', 'tutor-pro'); ?></th>
            <th><?php _e('Result', 'tutor-pro'); ?></th>
			<?php do_action('tutor_quiz/previous_attempts/table/thead/col'); ?>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ( $previous_attempts as $attempt){
	        ?>
            <tr>
                <td><?php echo $attempt->attempt_id; ?></td>
                <td title="<?php _e('Time', 'tutor-pro'); ?>">
			        <?php
			        echo date_i18n(get_option('date_format'), strtotime($attempt->attempt_started_at)).' '.date_i18n(get_option('time_format'), strtotime($attempt->attempt_started_at));

			        if ($attempt->is_manually_reviewed){
				        ?>
                        <p class="attempt-reviewed-text">
					        <?php
					        echo __('Manually reviewed at', 'tutor-pro').date_i18n(get_option('date_format', strtotime($attempt->manually_reviewed_at))).' '.date_i18n(get_option('time_format', strtotime($attempt->manually_reviewed_at)));
					        ?>
                        </p>
				        <?php
			        }
			        ?>
                </td>
                <td  title="<?php _e('Questions', 'tutor-pro'); ?>">
			        <?php echo $attempt->total_questions; ?>
                </td>

                <td title="<?php _e('Total Marks', 'tutor-pro'); ?>">
			        <?php echo $attempt->total_marks; ?>
                </td>

                <td title="<?php _e('Earned Marks', 'tutor-pro'); ?>">
			        <?php
			        $earned_percentage = $attempt->earned_marks > 0 ? ( number_format(($attempt->earned_marks * 100) / $attempt->total_marks)) : 0;
			        echo $attempt->earned_marks."({$earned_percentage}%)";
			        ?>
                </td>

                <td title="<?php _e('Pass Mark', 'tutor-pro'); ?>">
			        <?php
                    if ($passing_grade > 0){
	                    $pass_marks = ($attempt->total_marks * $passing_grade) / 100;
                    }else{
	                    $pass_marks = 0;
                    }
			        if ($pass_marks > 0){
				        echo number_format_i18n($pass_marks, 2);
			        }else{
                        echo 0;
                    }
			        if ($passing_grade > 0){
				        echo "({$passing_grade}%)";
			        }else{
				        echo "(0%)";
                    }
			        ?>
                </td>

                <td>
			        <?php
			        $grade = get_gradebook_by_percent($earned_percentage);
			        echo tutor_generate_grade_html($grade);
			        ?>
                </td>

                <td title="<?php _e('Result', 'tutor-pro'); ?>">
			        <?php
                    if ($attempt->attempt_status === 'review_required'){
                        echo '<span class="result-review-required">' . __('Under Review', 'tutor-pro') . '</span>';
                    }else {
                        if ($earned_percentage >= $passing_grade) {
                            echo '<span class="result-pass">' . __('Pass', 'tutor-pro') . '</span>';
                        } else {
                            echo '<span class="result-fail">' . __('Fail', 'tutor-pro') . '</span>';
                        }
                    }
			        ?>
                </td>

	            <?php do_action('tutor_quiz/previous_attempts/table/tbody/col', $attempt); ?>
            </tr>
	        <?php
        }
        ?>
        </tbody>

	</table>
</div>
