<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package eCademy
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content ecademy-<?php the_title(); ?>-un">
		<?php
		
		if ( 'lp_course' != get_post_type() ):
			ecademy_post_thumbnail();
		endif;
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ecademy' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer text-center">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'ecademy' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</div><!-- #post-<?php the_ID(); ?> -->
