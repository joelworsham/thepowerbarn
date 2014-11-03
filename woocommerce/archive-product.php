<?php
/**
 * Handles filtering of the archive products page.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage WooCommerce Template Overrides
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

get_header( 'shop' );

// Remove the WC breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * woocommerce_before_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );
?>

<section class="columns small-12">
	<div class="section-title row">

<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

	<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

<?php endif; ?>

<?php
//do_action( 'woocommerce_archive_description' );

if ( have_posts() ) : /**
 * woocommerce_before_shop_loop hook
 *
 * @hooked woocommerce_result_count - 20
 * @hooked woocommerce_catalog_ordering - 30
 */ {
	do_action( 'woocommerce_before_shop_loop' );
	?>

	</div>
	</section>

	<?php pb_sidebar( 'product-archive' ); ?>

	<section class="products-grid columns small-12 medium-9">
		<ul class="product-grid row" data-equalizer>

			<?php
			woocommerce_product_subcategories();

			while ( have_posts() ) : the_post();

				$classes = array(
					'small-12',
					'medium-6',
					'large-4',
				);
				pb_loop( 'products' );

			endwhile;
			?>

		</ul>

	<?php
	/**
	 * woocommerce_after_shop_loop hook
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
	?>

	</section>

<?php
} elseif ( ! woocommerce_product_subcategories( array(
	'before' => woocommerce_product_loop_start( false ),
	'after'  => woocommerce_product_loop_end( false )
) )
) : ?>
	</div>
	</section>

	<?php wc_get_template( 'loop/no-products-found.php' ); ?>

<?php endif; ?>

<?php
/**
 * woocommerce_after_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
?>

<?php get_footer( 'shop' ); ?>