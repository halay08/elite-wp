<?php
/**
 * Template for displaying template of login form.
 *
 * This template can be overridden by copying it to ecademy/learnpress/global/form-login.php.
 *
 * @author  EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Global::profile();
$fields  = $profile->get_login_fields();
?>

<div class="col-lg-6">
    <div class="learn-press-form-login learn-press-form">

        <h3><?php echo _x( 'Login', 'login-heading', 'ecademy' ); ?></h3>

        <?php do_action( 'learn-press/before-form-login' ); ?>

        <form name="learn-press-login" method="post" action="">

            <?php do_action( 'learn-press/before-form-login-fields' ); ?>

            <ul class="form-fields">
                <?php foreach ( $fields as $field ) { ?>
                    <li class="form-field">
                        <?php LP_Meta_Box_Helper::show_field( $field ); ?>
                    </li>
                <?php } ?>
            </ul>

            <?php do_action( 'learn-press/after-form-login-fields' ); ?>

            <?php do_action( 'login_form' ); ?>
            
            <p>
                <label>
                    <input type="checkbox" name="rememberme"/>
                    <?php esc_html_e( 'Remember me', 'ecademy' ); ?>
                </label>
            </p>
            <p>
                <input type="hidden" name="learn-press-login-nonce"
                    value="<?php echo wp_create_nonce( 'learn-press-login' ); ?>">
                <button type="submit"><?php esc_html_e( 'Login', 'ecademy' ); ?></button>
            </p>
            <div class="row">
                <div class="col-lg-5 col-md-5">
                    <a href="<?php echo wp_lostpassword_url(); ?>"><?php esc_html_e( 'Lost your password?', 'ecademy' ); ?></a>
                </div>
                <div class="col-lg-7 col-md-7">
                    <?php esc_html_e( 'Not a member yet?', 'ecademy' ); ?> <a href="<?php echo home_url('/profile'); ?>"><?php esc_html_e('Register now', 'ecademy'); ?></a>
                </div>
            </div>
        </form>

        <?php do_action( 'learn-press/after-form-login' ); ?>

    </div>
</div>
