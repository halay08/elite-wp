<?php
/**
 * Template for displaying pagination of course within the loop.
 *
 * This template can be overridden by copying it to ecademy/learnpress/loop/course/pagination.php.
 *
 * @author   EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}
?>

<nav class="pagination-area text-center">
	<?php echo paginate_links( apply_filters( 'learn_press_pagination_args', array(
		'base'      => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
		'format'    => '',
		'add_args'  => '',
		'current'   => max( 1, get_query_var( 'paged' ) ),
		'total'     => $wp_query->max_num_pages,
		'prev_text' => '<i class="bx bxs-chevrons-left"></i>',
		'next_text' => '<i class="bx bxs-chevrons-right"></i>',
		'end_size'  => 3,
		'mid_size'  => 3
	) ) );
	?>
</nav>