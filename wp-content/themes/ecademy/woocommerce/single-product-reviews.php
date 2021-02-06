<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to ecademy/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews products-reviews">
	<div id="comments">
		<h3 class="woocommerce-Reviews-title">
			<?php
			$count = $product->get_review_count();
			if ( $count && wc_review_ratings_enabled() ) {
				/* translators: 1: reviews count 2: product name */
				$reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'ecademy' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
				echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
			} else {
				esc_html_e( 'Customer Reviews', 'ecademy' );
			}
			?>
		</h3>

		<?php if ( have_comments() ) : ?>
			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'ecademy' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
				$commenter = wp_get_current_commenter();

				$comment_form = array(
					/* translators: %s is product title */
					'title_reply'         => have_comments() ? __( 'Add a review', 'ecademy' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'ecademy' ), get_the_title() ),
					/* translators: %s is product title */
					'title_reply_to'      => __( 'Leave a Reply to %s', 'ecademy' ),
					'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
					'title_reply_after'   => '</span>',
					'comment_notes_after' => '',
					'fields'              => array(
						'author' => '<p class="comment-form-author">' .
									'<input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="'. esc_attr__( 'Name', 'ecademy' ) .'*" size="30" required /></p>',
						'email'  => '<p class="comment-form-email">' .
									'<input id="email" name="email" type="email" class="form-control" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="'. esc_attr__( 'Email', 'ecademy' ) .'*" size="30" required /></p>',
					),
					'label_submit'        => __( 'Submit', 'ecademy' ),
					'logged_in_as'        => '',
					'comment_field'       => '',
				);

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'ecademy' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
				}

				if ( wc_review_ratings_enabled() ) {
					$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Rate this item', 'ecademy' ) . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'ecademy' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'ecademy' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'ecademy' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'ecademy' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'ecademy' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'ecademy' ) . '</option>
					</select></div>';
				}

				$comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea id="comment" class="form-control" name="comment" placeholder="'. esc_attr__( 'Write your review', 'ecademy' ) .'*"  cols="45" rows="4" required></textarea></p>';

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'ecademy' ); ?></p>
	<?php endif; ?>

	<div class="clear"></div>
</div>
