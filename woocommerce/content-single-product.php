<?php
/**
 * Displays the content for a single product, via WooCommerce.
 *
 * @since 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage WooCommerce Template Overrides
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Filter the post class
add_filter( 'post_class', 'pb_single_post_class' );

function pb_single_post_class( $classes ) {
	$classes[] = 'single-product-view';
	$classes[] = 'row'; // Foundation compatibility
	return $classes;
}

// Remove some filters / actions
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// New hooks (or moved)
add_action( 'pb_single_product_title_area', 'woocommerce_template_single_title' );

// Filter number of related products
//add_filter( 'woocommerce_output_related_products_args', 'pb_related_products_args' );

function pb_related_products_args( $args ) {

	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 2; // arranged in 2 columns
	return $args;
}

/**
 * woocommerce_before_single_product hook
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}
?>

<?php // For messages sitting above ?>
<div class="clear"></div>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>"
     id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="columns small-12">
		<div class="single-product-title">
			<?php
			/**
			 * pb_single_product_title_area hook
			 *
			 * @hooked woocommerce_template_single_title - 10
			 */
			do_action( 'pb_single_product_title_area' );
			?>
		</div>
	</div>

	<div class="columns small-12 medium-5">
		<?php
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
		?>
	</div>

	<div class="columns small-12 medium-7">
		<div class="summary entry-summary">

			<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5 <- REMOVED
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
			?>

		</div>
		<!-- .summary -->
	</div>

	<div class="columns small-12">

		<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>

		<meta itemprop="url" content="<?php the_permalink(); ?>"/>

	</div>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
