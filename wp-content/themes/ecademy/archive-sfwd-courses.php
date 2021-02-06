<?php
/**
 * the template for displaying all posts.
 */

get_header();

if ( is_active_sidebar( 'course-sidebar' ) ):
    $grid_class = 'col-lg-6 col-md-6';
    $ld_column  = 'col-lg-8 col-md-12';
else: 
    $grid_class = 'col-lg-4 col-md-6';
    $ld_column  = 'col-lg-12 col-md-12';
endif;

global $ecademy_opt;

if( isset( $ecademy_opt['enable_lazyloader'] ) ):
	$is_lazyloader = $ecademy_opt['enable_lazyloader'];
else:
	$is_lazyloader = true;
endif;

$ld_enroll_btn = !empty($ecademy_opt['ld_enroll_title']) ? $ecademy_opt['ld_enroll_title'] : '';
$ld_free_title = !empty($ecademy_opt['ld_free_title']) ? $ecademy_opt['ld_free_title'] : '';


get_template_part('template-parts/banner');
?>
    <section class="courses-area courses-section pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr( $ld_column ); ?>">
                    <div class="row">
                        <?php
                        if ( have_posts() ) :
                            while ( have_posts() ) :
                                the_post();

                                global $post; $post_id = $post->ID;
                                $course_id = $post_id;
                                $user_id   = get_current_user_id();
                                $current_id = $post->ID;

                                $options = get_option('sfwd_cpt_options');

                                $currency = null;

                                if ( ! is_null( $options ) ) {
                                    if ( isset($options['modules'] ) && isset( $options['modules']['sfwd-courses_options'] ) && isset( $options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'] ) )
                                        $currency = $options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'];

                                }

                                if( is_null( $currency ) )
                                    $currency = 'USD';

                                $course_options = get_post_meta($post_id, "_sfwd-courses", true);


                                $price = $course_options && isset($course_options['sfwd-courses_course_price']) ? $course_options['sfwd-courses_course_price'] : esc_html( $ld_free_title );

                                $has_access   = sfwd_lms_has_access( $course_id, $user_id );
                                $is_completed = learndash_course_completed( $user_id, $course_id );

                                if( $price == '' )
                                    $price .= esc_html( $ld_free_title );

                                if ( is_numeric( $price ) ) {
                                    if ( $currency == "USD" )
                                        $price = '$' . $price;
                                    else
                                        $price .= ' ' . $currency;
                                }

                                $class       = '';
                                $ribbon_text = '';

                                if ( $has_access && ! $is_completed ) {
                                    $class = 'ld_course_grid_price ribbon-enrolled';
                                    $ribbon_text = esc_html__( 'Enrolled', 'ecademy' );
                                    $ld_enroll_btn = !empty($ecademy_opt['ld_enrolled_title']) ? $ecademy_opt['ld_enrolled_title'] : '';
                                } elseif ( $has_access && $is_completed ) {
                                    $class = 'ld_course_grid_price';
                                    $ribbon_text = esc_html__( 'Completed', 'ecademy' );
                                    $ld_enroll_btn = !empty($ecademy_opt['ld_enrolled_title']) ? $ecademy_opt['ld_enrolled_title'] : '';
                                } else {
                                    $class = ! empty( $course_options['sfwd-courses_course_price'] ) ? 'ld_course_grid_price price_' . $currency : 'ld_course_grid_price free';
                                    $ribbon_text = $price;
                                }
                                ?>
                                <div id="post-<?php the_ID(); ?>" class="<?php echo esc_attr( $grid_class ); ?> <?php post_class(); ?>">
                                    <div class="single-courses-box ld-single-courses-box">
                                        <div class="courses-image">
                                            <a href="<?php the_permalink(); ?>" class="d-block image">
                                                <?php if( has_post_thumbnail() ): ?>
                                                    <?php if( $is_lazyloader == true ): ?>
                                                        <img sm-src="<?php the_post_thumbnail_url('ecademy_courses_gallery_thumb'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                                    <?php else: ?>
                                                        <img src="<?php the_post_thumbnail_url('ecademy_courses_gallery_thumb'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php if( $is_lazyloader == true ): ?>
                                                        <img sm-src="<?php echo esc_url(get_template_directory_uri() .'/assets/img/no-image'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                                    <?php else: ?>
                                                        <img src="<?php echo esc_url(get_template_directory_uri() .'/assets/img/no-image'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </a>
                                            <div class="price shadow"><?php echo esc_html($ribbon_text); ?></div>
                                        </div>
                                        <div class="courses-content">
                                            <div class="course-author d-flex align-items-center">
                                                <?php 
                                                    global $post;
                                                    $a_id=$post->post_author;
                                                    $user       = get_the_author_meta('ID');
                                                    $user_image = get_avatar_url($user, ['size' => '51']);
                                                ?>
                                                <img src="<?php echo esc_url( $user_image ); ?>" class="rounded-circle" alt="<?php the_author_meta( 'display_name', $a_id );  ?>">
                                                <span><?php the_author_meta( 'display_name', $a_id );  ?></span>
                                            </div>
                                            <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h3>
                                            <p><?php echo substr(get_the_excerpt(), 0,119); ?></p>
                                            <a class="ld-enroll-btn" href="<?php the_permalink(); ?>"><?php echo esc_attr($ld_enroll_btn); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            get_template_part( 'template-parts/content', 'none' );
                        endif;
                        ?>
                    </div>

                    <!-- Stat Pagination -->
                    <div class="pagination-area text-center">
                        <nav aria-label="navigation">
                        <?php echo paginate_links( array(
                            'format' => '?paged=%#%',
                            'prev_text' => '<i class="bx bx-chevrons-left"></i>',
                            'next_text' => '<i class="bx bx-chevrons-right"></i>',
                                )
                            ) ?>
                        </nav>
                    </div>
                    <!-- End Pagination -->
                </div>
                
                <?php if ( is_active_sidebar( 'course-sidebar' ) ): ?>
                    <div class="col-lg-4 col-md-12">
                        <div class="sidebar">
                            <?php dynamic_sidebar('course-sidebar'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            </div>
        </div>
    </section>
<?php
get_footer();