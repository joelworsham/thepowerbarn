<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class ThePowerBarn_Scripts
 *
 * Loads all files needed for the theme.
 *
 * @package ThePowerBarn
 * @subpackage Scripts
 *
 * @since ThePowerBarn 0.1.0
 */
class ThePowerBarn_Scripts extends ThePowerBarn {
	/**
	 * The main construct function.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	function __construct() {
		add_action( 'init', array( $this, 'register_files' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_files' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_files' ) );
	}

	/**
	 * Registers all files for the the theme.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	public function register_files() {
		foreach ( $this->files as $section => $types ) {
			foreach( $types as $type => $files ) {
				foreach( $files as $file ) {
					if ( $type == 'css' ) {

						if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
							wp_register_style(
								"pb-$file[name]",
								get_template_directory_uri() . "/assets/css/thepowerbarn.$file[name].css",
								isset( $file['deps'] ) ? $file['deps'] : null,
								time()
							);
						} else {
							wp_register_style(
								"pb-$file[name]",
								get_template_directory_uri() . "/assets/css/thepowerbarn.$file[name].min.css",
								isset( $file['deps'] ) ? $file['deps'] : null,
								$this->version
							);
						}
					} elseif ( $type == 'js' ) {
						wp_register_script(
							"pb-$file[name]",
							get_template_directory_uri() . "/assets/js/source/$file[filename].js",
							isset( $file['deps'] ) ? $file['deps'] : null,
							time()
						);
					}
				}
			}
		}
	}

	/**
	 * Enqueues all of the files for the frontend of the theme.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	public function enqueue_frontend_files() {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			foreach( $this->files['frontend'] as $type => $files) {
				foreach( $files as $file ) {
					if ( $type == 'css' || $type == 'font' ) {
						wp_enqueue_style( "pb-$file[name]" );
					} else {
						wp_enqueue_script( "pb-$file[name]" );
					}
				}
			}
		} else {
			foreach( $this->files['frontend'] as $type => $files) {
				foreach( $files as $file ) {
					if ( $type == 'css' ) {
						wp_enqueue_style( "pb-$file[name]" );
					}
				}
			}
			wp_enqueue_script(
				'thepowerbarn',
				get_template_directory_uri() . '/assets/js/thepowerbarn.min.js',
				array( 'jquery' ),
				$this->version,
				true
			);
		}
	}

	/**
	 * Enqueues all of the files for the backend of the theme.
	 *
	 * @since ThePowerBarn 0.1.0
	 */
	public function enqueue_backend_files() {
		foreach( $this->files['backend'] as $types ) {
			foreach( $types as $type => $files ) {
				foreach( $files as $file ) {
					if ( $type == 'css' ) {
						wp_enqueue_style( "pb-$file[name]" );
					} else {
						wp_enqueue_script( "pb-$file[name]" );
					}
				}
			}
		}
	}
}

new ThePowerBarn_Scripts();