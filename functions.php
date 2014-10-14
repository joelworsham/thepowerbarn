<?php
/**
 * The functions for The Power Barn.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Core Theme Files
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class ThePowerBarn
 *
 * The main class for all functionality of the theme.
 *
 * @package ThePowerBarn
 * @subpackage Functions
 *
 * @since ThePowerBarn 0.1.0
 */
class ThePowerBarn {

	/**
	 * The current theme version.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	public $version = '0.1';

	/**
	 * Classes to go into the wrapper div.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	public $wrapper_classes = '';

	/**
	 * All necessary files to require.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	public $necessities = array(
		'scripts',
		'transients',
		'functions',
	);

	/**
	 * All files to load.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	public $files = array(
		'frontend' => array(
			'css'  => array(
				array(
					'name'   => 'main',
//					'deps' => array( 'woocommerce-general' ),
				),
			),
			'js'   => array(
				array(
					'name'   => 'modernizr',
					'filename' => 'deps/modernizr',
					'deps' => array( 'jquery' ),
				),
				array(
					'name'   => 'jquery-cookie',
					'filename' => 'deps/jquery.cookie',
					'deps' => array( 'jquery' ),
				),
				array(
					'name'   => 'placeholder',
					'filename' => 'deps/placeholder',
					'deps' => array( 'jquery' ),
				),
				array(
					'name'   => 'fastclick',
					'filename' => 'deps/fastclick',
					'deps' => array( 'jquery' ),
				),
				array(
					'name'   => 'foundation',
					'filename' => 'deps/foundation/foundation',
					'deps' => array( 'pb-modernizr' ),
				),
				array(
					'name'   => 'foundation-equalizer',
					'filename' => 'deps/foundation/foundation.equalizer',
					'deps' => array( 'pb-foundation' ),
				),
				array(
					'name'   => 'foundation-accordion',
					'filename' => 'deps/foundation/foundation.accordion',
					'deps' => array( 'pb-foundation' ),
				),
				array(
					'name'   => 'foundation-alert',
					'filename' => 'deps/foundation/foundation.alert',
					'deps' => array( 'pb-foundation' ),
				),
				array(
					'name'   => 'main',
					'filename' => 'main',
					'deps' => array( 'pb-foundation' ),
					'footer'   => true,
				),
				array(
					'name'   => 'navigation',
					'filename' => 'navigation',
					'deps' => array( 'pb-main' ),
					'footer'   => true,
				),
				array(
					'name'   => 'search',
					'filename' => 'search',
					'deps' => array( 'pb-main' ),
					'footer'   => true,
				),
			),
		),
		'backend'  => array(
			'css' => array(),
			'js'  => array(),
		),
	);

	/**
	 * The global length of the excerpt.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	public $excerpt_length = 100;

	/**
	 * The main construct function.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	function __construct() {

		$this->require_necessities();
		$this->constants();
		$this->globals();

		// Add thumbnail support and options
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'product', 500, 500, true );

		// Modify the excerpt length to whatever we've set
		add_filter( 'excerpt_length', array( $this, 'custom_excerpt_length' ), 999 );

		// Register some sidebars
		add_action( 'init', array( $this, 'register_sidebars' ) );

		// Register some menus
		$this->register_menus();

		// Add catalog fallback image size
		add_image_size( 'catalog_fallback', 200, 200, true );

		// Output extra html in the head
		add_action( 'wp_head', array( $this, 'head' ) );

		// Delete the product terms transient when updating any products or terms
		add_action( 'save_post', array( $this, 'delete_product_terms_transient' ) );

		// Declare WooCommerce theme support
		add_theme_support( 'woocommerce' );

		// Change button text for "Read More"
		add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'change_read_more_text' ), 100, 2 );

		// Disable WooCommerce styling
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );

		// Change remove product button from the cart page
		add_filter( 'woocommerce_cart_item_remove_link', array( $this, 'remove_product_link' ), 10, 2 );
	}

	/**
	 * Requires all files for the theme.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	private function require_necessities() {

		foreach ( $this->necessities as $file ) {
			include_once( get_template_directory() . '/includes/' . $file . '.php' );
		}
	}

	private function constants() {

		define( 'PB_PATH', plugin_dir_path( __FILE__ ) );
	}

	private function globals() {

		global $pb_all_products_link;

		if ( function_exists( 'wc_get_page_id' ) ) {
			$pb_all_products_link = get_permalink( wc_get_page_id( 'shop' ) );
		} else {
			$pb_all_products_link = false;
		}
	}

	/**
	 * Changes the excerpt to a specified length.
	 *
	 * @since ThePowerBarn 0.1.0
	 *
	 * @return int The new custom length.
	 */
	public function custom_excerpt_length() {

		return $this->excerpt_length;
	}

	/**
	 * Registers all of our theme sidebars.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	public function register_sidebars() {

		// Product archives
		register_sidebar( array(
			'name' => 'Product Archives',
			'id' => 'product-archive',
			'description' => 'Any page that shows a list of products',
			'before_title' => '<h4 class="filter-title">',
			'after_title' => '</h4>',
		));

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

	public function register_menus() {

		register_nav_menus( array(
			'upper' => 'Top Menu',
		));
	}

	/**
	 * Outputs the post thumbnail with the first image size that exists.
	 *
	 * @since ThePowerBarn 0.1.0
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
	 * @since ThePowerBarn 0.1.0
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
			if ( empty( $brand ) || is_wp_error( $brand ) ) {
				continue;
			}
			$brand = $brand[0]->term_id;

			$line = wp_get_post_terms( $product->ID, 'pa_line' );
			if ( empty( $brand ) || is_wp_error( $line ) ) {
				continue;
			}
			$line = $line[0]->term_id;

			$series = wp_get_post_terms( $product->ID, 'pa_series' );
			if ( empty( $brand ) || is_wp_error( $series ) ) {
				continue;
			}
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

	public function remove_product_link( $html, $cart_item_key ) {

		return sprintf( '<a href="%s" class="remove" title="Remove from cart"></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ) );
	}

	public function delete_product_terms_transient( $post_ID ) {

		if ( ! isset( $_POST['post_type'] ) || $_POST['post_type'] != 'product' ) {
			return;
		}

		delete_transient( 'pb_nav_menu' );
	}

	public function change_read_more_text( $text ) {

		if ( $text === 'Read More' ) {
			return 'View Product';
		}

		return $text;
	}

	public function head() {
		?>
		<link href='http://fonts.googleapis.com/css?family=Arvo:400,700' rel='stylesheet' type='text/css'>
<?php
	}
}

$ThePowerBarn = new ThePowerBarn();