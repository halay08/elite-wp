<?php
/**
 * A single course loop pagination
 *
 * @since v.1.0.0
 * @author envytheme
 * @url https://envytheme.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php do_action('tutor_course/archive/pagination/before');  ?>

<div class="pagination-area text-center">
	<?php
	global $wp_query;
	$big = 999999999; // need an unlikely integer

	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
        'prev_text' => '<i class="fa fa-angle-double-left"></i>',
        'next_text' => '<i class="fa fa-angle-double-right"></i>',
	) );
	?>
</div>

<?php do_action('tutor_course/archive/pagination/after');  ?>
