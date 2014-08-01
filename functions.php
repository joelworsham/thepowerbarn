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
			'css' => array(
				array(
					'handle' => 'frontend-main',
					'filename' => 'frontend-main'
				),
				array(
					'handle' => 'foundation',
					'filename' => 'foundation.min',
					'version' => '1.5'
				)
			),
			'js' => array(
			),
			'font' => array(
			)
		),
		'backend' => array(
			'css' => array(
			),
			'js' => array(
			)
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

		add_theme_support( 'post-thumbnails' );
		add_filter( 'excerpt_length', array( $this, 'custom_excerpt_length'), 999 );
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

	public function custom_excerpt_length() {
		return $this->excerpt_length;
	}
}

$ThePowerBarn = new ThePowerBarn();