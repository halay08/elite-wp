<?php
/**
 * The template for displaying all pages
 */

get_header();
	if( !ecademy_is_elementor() && 'lp_course' != get_post_type() ): ?><div class="page-main-content"><?php endif; ?>
		<div class="page-area">
			<?php if( !ecademy_is_elementor() && 'lp_course' != get_post_type() ): ?><div class="container"><?php endif; ?>
				<?php if ( is_active_sidebar( 'bbpress-sidebar' ) && class_exists( 'bbPress' ) && is_bbpress() ) : ?>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<?php endif; ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php $thecontent = get_the_content(); // If no content ?>
						<?php if(empty($thecontent)){ ?> <div class="ecademy-single-blank-page"></div><?php } ?>
						<?php get_template_part( 'template-parts/content', 'page' ); ?>

						<?php if( 'lp_course' != get_post_type() ): ?>
							<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
						<?php endif; ?>

					<?php endwhile; // End of the loop. ?>
					<?php if ( is_active_sidebar( 'bbpress-sidebar' ) && class_exists( 'bbPress' ) && is_bbpress() ) : ?>
						</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="right-sidebar">
							<?php dynamic_sidebar( 'bbpress-sidebar' ); ?>
						</div>
					</div>
				</div>
			  <?php endif; ?>

		<?php if( !ecademy_is_elementor() && 'lp_course' != get_post_type() ): ?></div><?php endif; ?>
		</div>
	<?php if( !ecademy_is_elementor() && 'lp_course' != get_post_type() ): ?></div><?php endif; ?>
<?php get_footer();