<?php
/**
 * The functions for The Power Barn.
 *
 * @since ThePowerBarn 0.1
 *
 * @package WordPress
 * @subpackage ThePowerBarn
 * @category Basic Theme Files
 */

/**
 * Class ThePowerBarn
 *
 * The main class for all functionality of the theme.
 *
 * @package WordPress
 * @subpackage ThePowerBarn
 *
 * @since ThePowerBarn 0.1
 */
class ThePowerBarn {

	/**
	 * The current theme version.
	 *
	 * @since ThePowerBarn 0.1
	 */
	public $version = '0.1';

	/**
	 * Classes to go into the wrapper div.
	 *
	 * @since ThePowerBarn 0.1
	 */
	public $wrapper_classes = '';

	/**
	 * All necessary files to require.
	 *
	 * @since ThePowerBarn 0.1
	 */
	public $necessities = array(
		'scripts',
		'transients'
	);

	/**
	 * All files to load.
	 *
	 * @since ThePowerBarn 0.1
	 */
	public $files = array(
		'frontend' => array(
			'css'  => array(
				array(
					'handle'   => 'pb-main',
					'filename' => 'pb.main.min'
				)
			),
			'js'   => array(
				array(
					'handle'   => 'pb-navigation',
					'filename' => 'pb.navigation.min',
					'footer'   => true
				)
			),
			'font' => array()
		),
		'backend'  => array(
			'css' => array(),
			'js'  => array()
		),
	);

	/**
	 * The global length of the excerpt.
	 *
	 * @since ThePowerBarn 0.1
	 */
	public $excerpt_length = 100;

	/**
	 * The main construct function.
	 *
	 * @since ThePowerBarn 0.1
	 */
	function __construct() {

		$this->require_necessities();
		$this->add_wrapper_classes();

		// Add thumbnail support and options
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'product', 500, 500, true );

		// Modify the excerpt length to whatever we've set
		add_filter( 'excerpt_length', array( $this, 'custom_excerpt_length' ), 999 );

		// Register some sidebars
		add_action( 'init', array( $this, 'register_sidebars' ) );

		// Add catalog fallback image size
		add_image_size( 'catalog_fallback', 200, 200, true );
	}

	/**
	 * Requires all files for the theme.
	 *
	 * @since ThePowerBarn 0.1
	 */
	private function require_necessities() {

		foreach ( $this->necessities as $file ) {
			require_once( get_template_directory() . '/inc/' . $file . '.php' );
		}
	}

	/**
	 * Adds all classes for the wrapper.
	 *
	 * @since ThePowerBarn 0.1
	 */
	private function add_wrapper_classes() {

		if ( is_user_logged_in() ) {
			$this->wrapper_classes .= 'logged-in ';
		}
	}

	/**
	 * Changes the excerpt to a specified length.
	 *
	 * @since ThePowerBarn 0.1
	 *
	 * @return int The new custom length.
	 */
	public function custom_excerpt_length() {

		return $this->excerpt_length;
	}

	/**
	 * Registers all of our theme sidebars.
	 *
	 * @since ThePowerBarn 0.1
	 */
	public function register_sidebars() {

		// Register all 4 footer boxes
		for ( $i = 1; $i <= 4; $i ++ ) {
			register_sidebar( array(
				'name'         => "Footer $i",
				'id'           => "footer-$i",
				'before_title' => '<h4>',
				'after_title'  => '</h4>',
			) );
		}
	}

	/**
	 * Outputs the post thumbnail with the first image size that exists.
	 *
	 * @since ThePowerBarn 0.1
	 *
	 * @param int /string $ID The attachment image ID.
	 * @param array $sizes Array of sizes to try, in order.
	 *
	 * @return string The post thumbnail HTMl.
	 */
	public static function attachment_image_exact( $ID, $sizes ) {

		global $_wp_additional_image_sizes;

		$image_src = wp_get_attachment_image_src( $ID, $sizes[0] );

		foreach ( $sizes as $size ) {
			if ( $image_src[2] >= $_wp_additional_image_sizes[ $size ]['height'] ) {
				echo wp_get_attachment_image( $ID, $size );

				return;
			}
		}

		echo wp_get_attachment_image( $ID, 'full' );
	}

	/**
	 * Creates and returns a hierarchy of terms.
	 *
	 * Creates the hierarchy based on the term associations set up by
	 * the products' configuration
	 *
	 * @since ThePowerBarn 0.1
	 *
	 * @return array The terms.
	 */
	public static function get_product_terms_hierarchy() {

		$products = get_posts( array(
			'post_type'   => 'product',
			'numberposts' => - 1
		) );

		$product_terms = array();

		foreach ( $products as $product ) {
			$brand = wp_get_post_terms( $product->ID, 'pa_brand' );
			$brand = $brand[0]->term_id;

			$line = wp_get_post_terms( $product->ID, 'pa_line' );
			$line = $line[0]->term_id;

			$series = wp_get_post_terms( $product->ID, 'pa_series' );
			$series = $series[0]->term_id;

			if ( ! empty( $brand ) && ! empty( $line ) && ! empty( $series ) ) {
				if ( empty( $product_terms[ $brand ][ $line ] ) ) {
					$product_terms[ $brand ][ $line ] = array();
				}

				if ( ! in_array( $series, $product_terms[ $brand ][ $line ] ) ) {
					array_push( $product_terms[ $brand ][ $line ], $series );
				}
			}
		}

		return $product_terms;
	}

	/**
	 * Returns the products filtered by optional taxonomies.
	 *
	 * This works with the filtering system set up in the theme. This function
	 * searches the url for the params filter_brand, filter_line, and filter_series.
	 * It then filters the output products by any, all, or none of the filters.
	 *
	 * @since ThePowerBarn 0.1
	 *
	 * @return mixed The filtered products.
	 */
	public static function get_filtered_products( $numposts = 20, $filter_brand = null, $filter_line = null, $filter_series = null ) {

		// Defaults
		if ( ! $filter_brand ) {
			$filter_brand = isset( $_GET['filter_brand'] ) ? $_GET['filter_brand'] : null;
		}

		if ( ! $filter_line ) {
			$filter_line = isset( $_GET['filter_line'] ) ? $_GET['filter_line'] : null;
		}

		if ( ! $filter_series ) {
			$filter_series = isset( $_GET['filter_series'] ) ? $_GET['filter_series'] : null;
		}

		// Query products based on filter
		$args = array(
			'post_type'   => 'product',
			'numberposts' => $numposts,
			'tax_query'   => array()
		);

		$products_transient_ID = 'products_numberposts_20';

		// Filter by the brand
		if ( isset( $filter_brand ) ) {
			array_push( $args['tax_query'], array(
				'taxonomy' => 'pa_brand',
				'field'    => 'slug',
				'terms'    => $filter_brand
			) );

			$products_transient_ID .= '_brand_' . $filter_brand;
		}

		// Filter by the line
		if ( isset( $filter_line ) ) {
			array_push( $args['tax_query'], array(
				'taxonomy' => 'pa_line',
				'field'    => 'slug',
				'terms'    => $filter_line
			) );

			$products_transient_ID .= '_line_' . $filter_line;
		}

		// Filter by the series
		if ( isset( $filter_series ) ) {
			array_push( $args['tax_query'], array(
				'taxonomy' => 'pa_series',
				'field'    => 'slug',
				'terms'    => $filter_series
			) );

			$products_transient_ID .= '_series_' . $filter_series;
		}

		return ThePowerBarn_Transients::get_posts( $args );
	}
}

$ThePowerBarn = new ThePowerBarn();