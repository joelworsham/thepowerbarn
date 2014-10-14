<?php
/**
 * The pagination for the archive footer.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage WooCommerce Template Overrides
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}
?>
<nav class="woocommerce-pagination row">
	<div class="columns small-12">
		<?php
		echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base'      => esc_url( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
			'format'    => '',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query->max_num_pages,
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
			'type'      => 'list',
			'end_size'  => 3,
			'mid_size'  => 3
		) ) );
		?>
	</div>
</nav>
