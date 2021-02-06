<?php
/**
 * Template for displaying main user profile page.
 *
 * This template can be overridden by copying it to ecademy/learnpress/profile/profile.php.
 *
 * @author   EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Global::profile();

if ( $profile->is_public() ) {
	?>

    <div id="learn-press-user-profile"<?php $profile->main_class(); ?>>
		<?php if( !is_user_logged_in() ): ?> <div class="row"> <?php endif; ?>
			<?php

			/**
			 * @since 3.0.0
			 */
			do_action( 'learn-press/before-user-profile', $profile );

			/**
			 * @since 3.0.0
			 */
			do_action( 'learn-press/user-profile', $profile );

			/**
			 * @since 3.0.0
			 */
			do_action( 'learn-press/after-user-profile', $profile );

			?>
		<?php if( !is_user_logged_in() ): ?> </div> <?php endif; ?>
	</div>

<?php } else {
	esc_html_e( 'This user does not public their profile.', 'ecademy' );
}