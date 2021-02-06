<?php
/**
 * Template for displaying instructor of single course.
 *
 * This template can be overridden by copying it to ecademy/learnpress/single-course/instructor.php.
 *
 * @author   EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();

$image  = get_field('user_image', 'user_' .get_the_author_meta('ID'));
$size    = 'ecademy_advisor_thumb_one';

?>

<div class="courses-instructor">
    <div class="single-advisor-box">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-4">
                <div class="advisor-image">
                    <?php if( $image ) { echo wp_get_attachment_image( $image, $size ); } ?>
                </div>
            </div>

            <div class="col-lg-8 col-md-8">
                <div class="advisor-content">
                    <h3><a href="<?php echo home_url( '/profile/' ); echo get_the_author_meta('nickname'); ?>"><?php echo esc_html(get_the_author()); ?></a></h3>
                    <span class="sub-title"><p><?php the_field('designation_name', 'user_' .get_the_author_meta('ID') ); ?></p></span>
                    
                    <p><?php echo esc_html( get_the_author_meta('description') ); ?></p>
                    <ul class="social-link">
                        <?php
                        if( have_rows('user_social_links', 'user_'. get_the_author_meta('ID') ) ):
                            while ( have_rows('user_social_links', 'user_'. get_the_author_meta('ID') ) ) : the_row();
                            ?>
                                <li><a href="<?php echo esc_url( the_sub_field('user_social_link')); ?>" class="d-block" target="_blank"><i class="<?php echo esc_attr( the_sub_field('user_select_social_icon') ); ?>"></i></a></li>
                            <?php
                            endwhile;                                    
                        endif;
                        ?>
                    </ul> 
                </div>
            </div>
        </div>
    </div>
</div>