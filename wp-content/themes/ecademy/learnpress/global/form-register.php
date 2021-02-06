<?php
/**
 * Template for displaying global login form.
 *
 * This template can be overridden by copying it to ecademy/learnpress/global/form-register.php.
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
$fields  = $profile->get_register_fields();
?>

<div class="col-lg-6">
    <div class="learn-press-form-register learn-press-form">

        <h3><?php echo _x( 'Register', 'register-heading', 'ecademy' ); ?></h3>

        <?php do_action( 'learn-press/before-form-register' ); ?>

        <form name="learn-press-register" method="post" action="">

            <?php do_action( 'learn-press/before-form-register-fields' ); ?>

            <ul class="form-fields">
                <?php foreach ( $fields as $field ) { ?>
                    <li class="form-field">
                        <?php LP_Meta_Box_Helper::show_field( $field ); ?>
                    </li>
                <?php } ?>
            </ul>

            <?php do_action( 'learn-press/after-form-register-fields' ); ?>
            
            <?php do_action( 'register_form' ); ?>

            <p>
                <?php wp_nonce_field( 'learn-press-register', 'learn-press-register-nonce' ); ?>
                <button type="submit"><?php esc_html_e( 'Register', 'ecademy' ); ?></button>
            </p>

        </form>

        <?php do_action( 'learn-press/after-form-register' ); ?>

    </div>
</div>
