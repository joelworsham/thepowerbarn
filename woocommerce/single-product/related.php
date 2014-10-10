<?php
/**
 * Shows related products.
 *
 * @since 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage WooCommerceTemplateOverrides
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce_loop;

// Number of related products to show
$post_count = 4;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}
$related = $product->get_related( $post_count );

if ( sizeof( $related ) == 0 ) {
	return;
}

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $post_count,
	'post__in'            => $related,
	'post__not_in'        => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>

	<div class="related products">

		<h2 class="section-title">Related Products</h2>

		<div class="row product-grid" data-equalizer>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php pb_loop( 'products' ); ?>

			<?php endwhile; // end of the loop. ?>

		</div>

	</div>

<?php endif;

wp_reset_postdata();
