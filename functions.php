<?php

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
					'handle'   => 'frontend-main',
					'filename' => 'frontend-main'
				),
				array(
					'handle'   => 'foundation',
					'filename' => 'foundation.min',
					'version'  => '1.5'
				)
			),
			'js'   => array(),
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
		for ( $i = 1; $i <= 4; $i++ ) {
			register_sidebar( array(
				'name'         => "Footer $i",
				'id'           => "footer-$i",
				'before_title' => '<h4>',
				'after_title'  => '</h4>',
			) );
		}
	}
}

$ThePowerBarn = new ThePowerBarn();