<?php
/**
 * The template for displaying comments
 *
 * @package eCademy
 */

// If the current post is protected by a password and
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$ecademy_comment_count = get_comments_number();
			if ( '1' === $ecademy_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( '1 Comment', 'ecademy' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s Comments', '%1$s Comments', $ecademy_comment_count, 'comments title', 'ecademy' ) ),
					number_format_i18n( $ecademy_comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size' => 85,
			) );
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'ecademy' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	$defaults = array(
		'label_submit' => esc_html__('Post a Comment', 'ecademy') 
	);
	comment_form( $defaults );
	?>

</div><!-- #comments -->