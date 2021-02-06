<?php
/**
 * the template for displaying all posts.
 */
get_header(); 

if ( is_active_sidebar( 'course-sidebar' ) ):
    $ld_column  = 'col-lg-8 col-md-12';
else: 
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

ecademy_ld_single_banner();
?>
    <div class="courses-details-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr( $ld_column ); ?>">
                    <div class="ld-courses-details-desc">
                    <?php
                        global $post; $post_id = $post->ID;
                        $course_id = $post_id;
                        $user_id   = get_current_user_id();
                        $current_id = $post->ID;

                        $enable_video = get_post_meta( $post->ID, '_learndash_course_grid_enable_video_preview', true );
                        $embed_code   = get_post_meta( $post->ID, '_learndash_course_grid_video_embed_code', true );

                        // Retrive oembed HTML if URL provided
                        if ( preg_match( '/^http/', $embed_code ) ) {
                            $embed_code = wp_oembed_get( $embed_code, array( 'height' => 600, 'width' => 400 ) );
                        }

                        $options = get_option('sfwd_cpt_options');
                        $currency = null;

                        if ( ! is_null( $options ) ) {
                            if ( isset($options['modules'] ) && isset( $options['modules']['sfwd-courses_options'] ) && isset( $options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'] ) )
                            $currency = $options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'];
                        }

                        if( is_null( $currency ) )
                            $currency = 'USD';

                        $course_options = get_post_meta($post_id, "_sfwd-courses", true);
                        $price = $course_options && isset($course_options['sfwd-courses_course_price']) ? $course_options['sfwd-courses_course_price'] : esc_html__( 'Free', 'turitor' );

                        $has_access   = sfwd_lms_has_access( $course_id, $user_id );
                        $is_completed = learndash_course_completed( $user_id, $course_id );

                        if( $price == '' )
                            $price .= esc_html__( 'Free', 'turitor' );

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
                            $ribbon_text = esc_html__( 'Enrolled', 'turitor' );
                            $ld_enroll_btn = !empty($ecademy_opt['ld_enrolled_title']) ? $ecademy_opt['ld_enrolled_title'] : '';
                        } elseif ( $has_access && $is_completed ) {
                            $class = 'ld_course_grid_price';
                            $ribbon_text = esc_html__( 'Completed', 'turitor' );
                        } else {
                            $class = ! empty( $course_options['sfwd-courses_course_price'] ) ? 'ld_course_grid_price price_' . $currency : 'ld_course_grid_price free';
                            $ribbon_text = $price;
                        }
                    ?>

                    <?php while ( have_posts() ) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-thumbnail text-center">
                                    <?php the_post_thumbnail( 'large' ); ?>
                                </div>
                            <?php endif; ?>
                            <div class="post-wrapper">
                                <div class="entry-content pt-70">
                                    <?php
                                    the_content( sprintf(
                                        esc_html__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'turitor' ),
                                        get_the_title()
                                    ) );
                                    ?>
                                </div><!-- .entry-content -->

                            </div>
                        </article>
				    <?php endwhile; ?>
                    </div>
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

    <!-- Start Related Area -->
        <?php
        $related_courses_title = !empty($ecademy_opt['ld_related_courses_title']) ? $ecademy_opt['ld_related_courses_title'] : 'More Courses You Might Like';
        $related_post_count = !empty($ecademy_opt['ld_related_post_count']) ? $ecademy_opt['ld_related_post_count'] : '3';
        $is_related_courses = !empty($ecademy_opt['ld_is_related_courses']) ? $ecademy_opt['ld_is_related_courses'] : '';

        $course_terms = get_the_terms( get_the_ID(), 'course_category'  );
        if( $is_related_courses == '1' ){    
            $tags = wp_get_post_terms( get_queried_object_id(), 'ld_course_tag', ['fields' => 'ids'] );
            $args = [
                'post__not_in'        => array( get_queried_object_id() ),
                'posts_per_page'      => $related_post_count,
                'post_type'        => 'sfwd-courses',
                'ignore_sticky_posts' => 1,
                'orderby'             => 'rand',
                'tax_query' => [
                    [
                        'taxonomy' => 'ld_course_tag',
                        'terms'    => $tags
                    ]
                ]
            ];

            $ld_query = new wp_query( $args );
                if( $ld_query->have_posts() ) { ?>
                    <section class="courses-area bg-f8f9f8 pt-100 pb-70">
                        <div class="container">
                            <?php if( $related_courses_title != '' ): ?>
                                <div class="section-title">
                                    <h2><?php echo esc_html($related_courses_title); ?></h2>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <?php while ( $ld_query->have_posts() ) : $ld_query->the_post(); 
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
                                    } else {
                                        $class = ! empty( $course_options['sfwd-courses_course_price'] ) ? 'ld_course_grid_price price_' . $currency : 'ld_course_grid_price free';
                                        $ribbon_text = $price;
                                    }
                                    ?>
                                    <div class="col-lg-4 col-md-6">
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
                                                    <img src="<?php echo esc_url( $user_image ); ?>" class="rounded-circle" alt="<?php the_author_meta( 'user_nicename', $a_id );  ?>">
                                                    <span><?php the_author_meta( 'user_nicename', $a_id );  ?></span>
                                                </div>
                                                <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h3>
                                                <div class="expert"><?php echo substr(get_the_content(), 0, 200); ?></div>
                                                <a class="ld-enroll-btn" href="<?php the_permalink(); ?>"><?php echo esc_attr($ld_enroll_btn); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>  
                                <?php wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </section>
                <?php
            }
        }
        ?>
    <!-- End Related Courses Area -->

<?php
get_footer();