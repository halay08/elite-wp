<?php 
/**
 * eCademy post content
 */

global $ecademy_opt;

if( isset( $ecademy_opt['enable_lazyloader'] ) ):
	$is_lazyloader = $ecademy_opt['enable_lazyloader'];
else:
	$is_lazyloader = true;
endif;

// Post thumb size
if(isset ($ecademy_opt['ecademy_blog_sidebar'] ) ) {
   if( $ecademy_opt['ecademy_blog_sidebar'] == 'ecademy_without_sidebar' ):
        $thumb_size = 'full';
   else:
        $thumb_size = 'ecademy_blog_thumb';
   endif;
}else {
    $thumb_size = 'ecademy_blog_thumb';
}

// Blog Column
$ecademy_blog_grid = !empty($ecademy_opt['ecademy_blog_grid']) ? $ecademy_opt['ecademy_blog_grid'] : 'col-lg-12 col-md-12';
if ( !empty($_GET['ecademy_blog_grid']) ) {
    $ecademy_blog_grid = $_GET['ecademy_blog_grid'];
}

$hide_post_meta = !empty($ecademy_opt['hide_post_meta']) ? $ecademy_opt['hide_post_meta'] : '';

// Author id
$get_author_id = get_the_author_meta('ID');

?>

<div <?php post_class( $ecademy_blog_grid ); ?>>
    <div class="single-blog-post main-blog-post">
        <?php if(has_post_thumbnail()) { ?>
            <div class="post-image">
                <a href="<?php the_permalink() ?>" class="d-block">
                    <?php if( $is_lazyloader == true ): ?>
                        <img sm-src="<?php the_post_thumbnail_url( $thumb_size ); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                    <?php else: ?>
                        <img src="<?php the_post_thumbnail_url( $thumb_size ); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                    <?php endif; ?>
                </a>
            </div>
        <?php } ?>

        <div class="post-content">
            <?php
            $post_tags  = get_the_tags();
            $count      = 0; 
            $sep        = '';
            if ( $post_tags ) {
                foreach( $post_tags as $tag ) {
                    $count++;
                    ?>
                        <a class="category" href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
                    <?php
                    if( $count > 0 ) break;
                }
            }
            ?>
            <?php if( get_the_title() != '' ): ?>
                <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
            <?php endif; ?>

            <?php the_excerpt(); ?>

            <?php if( $hide_post_meta != '1' ){ ?>
                <ul class="post-content-footer d-flex align-items-center">
                    <li>
                        <?php 
                            $user       = get_the_author_meta('ID');
                            $user_image = get_avatar_url($user, ['size' => '51']); 
                        ?>
                        <div class="post-author d-flex align-items-center">
                            <img src="<?php echo esc_url( $user_image ); ?>" class="rounded-circle" alt="<?php echo esc_attr( get_the_author() ); ?>">
                            <span><?php echo esc_html( get_the_author() ); ?></span>
                        </div>
                    </li>
                    <li><i class="flaticon-calendar"></i><a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_date() ); ?></a></li>
                </ul>
            <?php } ?>
        </div>
    </div>
</div> 