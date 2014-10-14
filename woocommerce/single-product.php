<?php
/**
 * Displays a single product via WooCommerce.
 *
 * @since 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage WooCommerce Template Overrides
 */

// TODO Hover implies to view more
// Related not clickable

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Remove some default WooCommerce actions
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

get_header( 'shop' ); ?>

	<div class="container columns small-12">

				<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action( 'woocommerce_before_main_content' );
				?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>

		<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
		?>

		<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
		?>

	</div>

<?php get_footer( 'shop' ); ?>