<?php
/**
 * The archive for products for The Power Barn.
 *
 * This displays all products by default, but allows the user to also
 * filter only specific kinds of products.
 *
 * @since ThePowerBarn 0.1
 *
 * @package WordPress
 * @subpackage ThePowerBarn
 * @category Product Pages
 */

get_header();

// Get our (possibly) filtered products
$products = ThePowerBarn::get_filtered_products();
?>

	<div id="sidebar" class="columns large-3">
		<?php get_sidebar(); ?>
	</div>

	<div class="columns large-9">
		<div class="product-grid row">
			<?php
			if ( ! empty( $products ) ) {
				global $post;
				foreach ( $products as $post ) {
					setup_postdata( $post );
					get_template_part( 'inc/loops/loop', 'products' );
				}
				wp_reset_postdata( $post );
			}
			?>
		</div>
	</div>

<?php get_footer();