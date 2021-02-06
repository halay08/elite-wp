<?php
/**
 * The Template for displaying pagination of archive events page.
 *
 * Override this template by copying it to ecademy/wp-events-manager/pagination.php
 *
 * @author        EnvyTheme
 * @package       WP-Events-Manager/Template
 * @version       2.1.7.3
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
} ?>

    <div class="pagination-area text-center">
        <nav aria-label="navigation">
        <?php echo paginate_links( array(
            'format' => '?paged=%#%',
            'prev_text' => '<i class="bx bxs-chevrons-left"></i>',
            'next_text' => '<i class="bx bxs-chevrons-right"></i>',
                )
            ) ?>
        </nav>
    </div>