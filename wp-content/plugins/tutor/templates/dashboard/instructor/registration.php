<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>
<?php do_action('tutor_before_instructor_reg_form');?>

<form method="post" enctype="multipart/form-data">

    <?php do_action('tutor_instructor_reg_form_start');?>

	<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
    <input type="hidden" value="tutor_register_instructor" name="tutor_action"/>

    <?php
    $errors = apply_filters('tutor_instructor_register_validation_errors', array());
    if (is_array($errors) && count($errors)){
        echo '<div class="tutor-alert-warning"><ul class="tutor-required-fields">';
        foreach ($errors as $error_key => $error_value){
            echo "<li>{$error_value}</li>";
        }
        echo '</ul></div>';
    }
    ?>

    <div class="tutor-form-row">
        <div class="tutor-form-col-6">
            <div class="tutor-form-group">
                <label>
					<?php _e('First Name', 'tutor'); ?>
                </label>

                <input type="text" name="first_name" value="<?php echo tutor_utils()->input_old('first_name'); ?>" placeholder="<?php _e('First Name', 'tutor'); ?>">
            </div>
        </div>

        <div class="tutor-form-col-6">
            <div class="tutor-form-group">
                <label>
					<?php _e('Last Name', 'tutor'); ?>
                </label>

                <input type="text" name="last_name" value="<?php echo tutor_utils()->input_old('last_name'); ?>" placeholder="<?php _e('Last Name', 'tutor'); ?>">
            </div>
        </div>


    </div>

    <div class="tutor-form-row">

        <div class="tutor-form-col-6">
            <div class="tutor-form-group">
                <label>
				    <?php _e('User Name', 'tutor'); ?>
                </label>

                <input type="text" name="user_login" class="tutor_user_name" value="<?php echo tutor_utils()->input_old('user_login'); ?>" placeholder="<?php _e('User Name', 'tutor'); ?>">
            </div>
        </div>

        <div class="tutor-form-col-6">
            <div class="tutor-form-group">
                <label>
					<?php _e('E-Mail', 'tutor'); ?>
                </label>

                <input type="text" name="email" value="<?php echo tutor_utils()->input_old('email'); ?>" placeholder="<?php _e('E-Mail', 'tutor'); ?>">
            </div>
        </div>

    </div>

    <div class="tutor-form-row">
        <div class="tutor-form-col-6">
            <div class="tutor-form-group">
                <label>
					<?php _e('Password', 'tutor'); ?>
                </label>

                <input type="password" name="password" value="<?php echo tutor_utils()->input_old('password'); ?>" placeholder="<?php _e('Password', 'tutor'); ?>">
            </div>
        </div>

        <div class="tutor-form-col-6">
            <div class="tutor-form-group">
                <label>
					<?php _e('Password confirmation', 'tutor'); ?>
                </label>

                <input type="password" name="password_confirmation" value="<?php echo tutor_utils()->input_old('password_confirmation'); ?>" placeholder="<?php _e('Password Confirmation', 'tutor'); ?>">
            </div>
        </div>
    </div>

    <div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <?php
                    //providing register_form hook
                    do_action('tutor_instructor_reg_form_middle');
                    do_action('register_form');
                ?>
            </div>
        </div>
    </div> 

    <?php do_action('tutor_instructor_reg_form_end');?>

    <div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group tutor-reg-form-btn-wrap">
                <button type="submit" name="tutor_register_instructor_btn" value="register" class="tutor-button"><?php _e('Register as instructor', 'tutor'); ?></button>
            </div>
        </div>
    </div>

</form>

<?php do_action('tutor_after_instructor_reg_form');?>