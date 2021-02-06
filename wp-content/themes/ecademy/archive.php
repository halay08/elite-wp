<?php
/**
 * The archive file
 * @package eCademy
 */
get_header();

// Blog Sidebar
if(isset($ecademy_opt['ecademy_blog_sidebar'])) {
    if( $ecademy_opt['ecademy_blog_sidebar'] == 'ecademy_without_sidebar_center' ):
        $sidebar = 'col-lg-8 col-md-12 offset-lg-2';
    elseif( $ecademy_opt['ecademy_blog_sidebar'] == 'ecademy_without_sidebar' ):
        $sidebar = 'col-lg-12 col-md-12';
    else:
        if( is_active_sidebar( 'sidebar-1' ) ):
            $sidebar = 'col-lg-8 col-md-12';
        else:
            $sidebar = 'col-lg-8 col-md-12 offset-lg-2';
        endif;
    endif;
    $ecademy_sidebar_hide = $ecademy_opt['ecademy_blog_sidebar'];
} else {
    if( is_active_sidebar( 'sidebar-1' ) ):
        $sidebar = 'col-lg-8 col-md-12';
        $ecademy_sidebar_hide = 'ecademy_with_sidebar';
    else:
        $sidebar = 'col-lg-8 col-md-12 offset-lg-2';
        $ecademy_sidebar_hide = 'ecademy_without_sidebar';
    endif;
}

if ( !empty($_GET['ecademy_sidebar_hide']) ) {
    $ecademy_sidebar_hide = $_GET['ecademy_sidebar_hide'];
}

if ( !empty($_GET['ecademy_blog_sidebar']) ) {
    $sidebar = $_GET['ecademy_blog_sidebar'];
}

$ecademy_blog_layout = !empty($ecademy_opt['ecademy_blog_layout']) ? $ecademy_opt['ecademy_blog_layout'] : 'container';
if ( !empty($_GET['ecademy_blog_layout']) ) {
    $ecademy_blog_layout = $_GET['ecademy_blog_layout'];
}
?>

    <!-- Start Blog Area -->
    <div class="blog-area ptb-100">
        <div class="container">
            <div class="row">
                <!-- Start Blog Content -->
                <div class="<?php echo esc_attr( $sidebar ); ?>">
                    <div class="row">
                        <?php
                        if ( have_posts() ) :
                            while ( have_posts() ) :
                                the_post();
                                get_template_part( 'template-parts/content', get_post_format());
                            endwhile;
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
                <!-- End Blog Content -->
                
                <?php if( $ecademy_sidebar_hide == 'ecademy_with_sidebar' ): ?>
                    <?php get_sidebar(); ?>
                <?php endif; ?>
            </div>   
        </div>
    </div>
    <!-- End Blog Area -->
<?php get_footer();