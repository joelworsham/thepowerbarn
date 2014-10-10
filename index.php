<?php
/**
 * The index for The Power Barn.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Core Theme Files
 */

// TODO Account edit page

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();
?>

<?php

// Get some featured categories for our query
$featured_categories = array(
	'Chainsaws',
	'Mulchers',
	'Trimmers',
);

$category_includes = array();
foreach ( $featured_categories as $featured_category ) {
	$term                = get_term_by( 'name', $featured_category, 'product_cat' );
	$category_includes[] = $term->term_id;
}

$categories = ThePowerBarn_Transients::get_terms(
	'home_cats',
	array( 'product_cat' ),
	array(
		'include' => $category_includes,
	),
	'products'
);

$products = ThePowerBarn_Transients::get_posts(
	array(
		'post_type'   => 'product',
		'numberposts' => 12,
		'product_cat' => 'all-products',
		'meta_key'    => '_featured',
		'meta_value'  => 'yes',
	)
);
?>

	<div class="columns small-12">
		<div id="home-action">
			<?php pb_partial( 'home-action' ); ?>
		</div>
	</div>

	<div class="columns small-12">
		<div class="row category-grid" data-equalizer>
			<?php
			if ( ! empty( $categories ) ) {
				foreach ( $categories as $term ) {
					pb_loop( 'categories' );
				}
			}
			?>
		</div>
	</div>

<div class="columns small-12">
	<h2 class="section-title">Featured Products</h2>
</div>

	<div class="columns small-12">
		<div class="row product-grid" data-equalizer>
			<?php
			if ( ! empty( $products ) ) {
				global $post;
				foreach ( $products as $post ) {
					setup_postdata( $post );
					pb_loop( 'products' );
				}
				wp_reset_postdata( $post );
			}
			?>
		</div>
	</div>

<?php get_footer(); ?>