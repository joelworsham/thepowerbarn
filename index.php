<?php
/**
 * The index for The Power Barn.
 *
 * @since ThePowerBarn 0.1
 *
 * @package WordPress
 * @subpackage ThePowerBarn
 * @category Basic Theme Files
 */

get_header();
?>

<?php
$categories = ThePowerBarn_Transients::get_terms(
	'home_cats',
	array( 'product_cat' ),
	array(
		'include' => array( 100, 14, 102 ),
	),
	'products'
);

$products = ThePowerBarn_Transients::get_posts(
	array(
		'post_type' => 'product',
		'numberposts' => 8,
		'product_cat' => 'all-products'
	)
);
?>

<div class="columns small-12">
	<div class="row">
		<div id="sidebar" class="columns small-3">
			<?php get_sidebar(); ?>
		</div>
		<div class="columns small-9">
			<div id="slider" style="height:400px;background:gray;text-align:center;font-size:40px;padding-top:160px;width:100%;">
				SLIDER
			</div>

			<div class="row category-grid">
				<?php
				if ( ! empty( $categories ) ) {
					global $post;
					foreach ( $categories as $post ) {
						setup_postdata( $post );
						get_template_part( 'inc/loops/loop', 'categories' );
					}
					wp_reset_postdata( $post );
				}
				?>
			</div>
		</div>
	</div>
</div>

<div class="columns small-12">
	<div class="row product-grid">
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

<?php get_footer(); ?>