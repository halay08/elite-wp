<?php
/**
 * Template for displaying tab nav of single course.
 *
 * This template can be overridden by copying it to ecademy/learnpress/single-course/tabs/tabs.php.
 *
 * @author  EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php $tabs = learn_press_get_course_tabs(); ?>

<?php if ( empty( $tabs ) ) {
	return;
} ?>

<div id="learn-press-course-tabs" class="course-tabs">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
    
        <?php foreach ( $tabs as $key => $tab ) { ?>

            <?php $classes = array( 'nav-link course-nav course-nav-tab-' . esc_attr( $key ) );
			if ( ! empty( $tab['active'] ) && $tab['active'] ) {
				$classes[] = 'active default';
            } ?>

            <li class="nav-item"><a class="<?php echo join( ' ', $classes ); ?>" id="<?php echo esc_attr( $tab['id'] ); ?>-tab" data-toggle="tab" href="#<?php echo esc_attr( $tab['id'] ); ?>" role="tab" aria-controls="<?php echo esc_attr( $tab['id'] ); ?>"><?php echo esc_html( $tab['title'] ); ?></a></li>
        <?php } ?>
        
    </ul>

    <div class="tab-content" id="myTabContent">

        <?php foreach ( $tabs as $key => $tab ) { ?>

            <?php $classes = array( 'tab-pane fade course-nav course-nav-tab-' . esc_attr( $key ) );
			if ( ! empty( $tab['active'] ) && $tab['active'] ) {
				$classes[] = 'show active';
            } ?>

            <div class="<?php echo join( ' ', $classes ); ?>" id="<?php echo esc_attr( $tab['id'] ); ?>" role="tabpanel">
                <?php
                    if ( apply_filters( 'learn_press_allow_display_tab_section', true, $key, $tab ) ) {
                        if ( is_callable( $tab['callback'] ) ) {
                            call_user_func( $tab['callback'], $key, $tab );
                        } else {
                            /**
                             * @since 3.0.0
                             */
                            do_action( 'learn-press/course-tab-content', $key, $tab );
                        }
                    }
                ?>
            </div>

        <?php } ?>
    </div>





</div>