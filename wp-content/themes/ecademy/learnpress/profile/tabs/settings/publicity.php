<?php
/**
 * Template for displaying change password form in profile page.
 *
 * This template can be overridden by copying it to ecademy/learnpress/settings/tabs/change-password.php.
 *
 * @author   EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Profile::instance();
?>

<form method="post" name="profile-publicity" enctype="multipart/form-data" class="learn-press-form">

	<?php
	/**
	 * @since 3.0.0
	 */
	do_action( 'learn-press/before-profile-publicity-fields', $profile ); ?>

    <ul class="form-fields">

		<?php
		/**
		 * @since 3.0.0
		 */
		do_action( 'learn-press/begin-profile-publicity-fields', $profile );
		?>

        <li class="form-field">
            <label for="my-dashboard"><?php esc_html_e( 'My dashboard', 'ecademy' ); ?></label>
            <div class="form-field-input">
                <input type="checkbox" id="my-dashboard" name="publicity[my-dashboard]"
                       value="yes" <?php checked( $profile->get_publicity( 'my-dashboard' ), 'yes' ); ?>/>
                <p class="description">
                    <?php esc_html_e( 'Public user profile content, if this option is turn off then other sections in profile also become invisible.', 'ecademy' ); ?>
                </p>
            </div>
        </li>

		<?php if ( LP()->settings()->get( 'profile_publicity.courses' ) === 'yes' ) { ?>
            <li class="form-field">
                <label for="my-courses"><?php esc_html_e( 'My courses', 'ecademy' ); ?></label>
                <div class="form-field-input">
                    <input type="checkbox" name="publicity[courses]" value="yes"
                           id="my-courses" <?php checked( $profile->get_publicity( 'courses' ), 'yes' ); ?>/>
                    <p class="description"><?php esc_html_e( 'Public your profile courses', 'ecademy' ); ?></p>
                </div>
            </li>
		<?php } ?>

		<?php if ( LP()->settings()->get( 'profile_publicity.quizzes' ) === 'yes' ) { ?>
            <li class="form-field">
                <label for="my-quizzes"><?php esc_html_e( 'My quizzes', 'ecademy' ); ?></label>
                <div class="form-field-input">
                    <input name="publicity[quizzes]" value="yes" type="checkbox"
                           id="my-quizzes" <?php checked( $profile->get_publicity( 'quizzes' ), 'yes' ); ?>/>
                    <p class="description"><?php esc_html_e( 'Public your profile quizzes', 'ecademy' ); ?></p>
                </div>
            </li>
		<?php } ?>

		<?php
		/**
		 * @since 3.0.0
		 */
		do_action( 'learn-press/end-profile-publicity-fields', $profile );

		?>

    </ul>
    <input type="hidden" name="save-profile-publicity"
           value="<?php echo wp_create_nonce( 'learn-press-save-profile-publicity' ); ?>"/>
	<?php
	/**
	 * @since 3.0.0
	 */
	do_action( 'learn-press/after-profile-publicity-fields', $profile );
	?>

    <button type="submit" name="submit" id="submit"><?php esc_html_e( 'Save changes', 'ecademy' ); ?></button>

</form>