<?php

/**
 * Class ThePowerBarn_Scripts
 *
 * Loads all files needed for the theme.
 *
 * @package WordPress
 * @subpackage ThePowerBarn
 *
 * @since ThePowerBarn 0.1
 */
class ThePowerBarn_Scripts extends ThePowerBarn {
	/**
	 * The main construct function.
	 *
	 * @since ThePowerBarn 0.1
	 */
	function __construct() {
		add_action( 'init', array( $this, 'register_files' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_files' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_files' ) );
	}

	/**
	 * Registers all files for the the theme.
	 *
	 * @since ThePowerBarn 0.1
	 */
	public function register_files() {
		foreach ( $this->files as $section => $types ) {
			foreach( $types as $type => $files ) {
				foreach( $files as $file ) {
					if ( $type == 'css' ) {
						wp_register_style(
							$file['handle'],
							get_template_directory_uri() . '/assets/css/' . ( isset( $file['filename'] ) ? $file['filename'] : $file['handle'] ) . '.css',
							isset( $file['deps'] ) ? $file['deps'] : null,
							isset( $file['version'] ) ? $file['version'] : $this->version
						);
					} elseif ( $type == 'font' ) {
						wp_register_style(
							$file['handle'],
							$file['link'],
							isset( $file['deps'] ) ? $file['deps'] : null,
							isset( $file['version'] ) ? $file['version'] : $this->version
						);
					} elseif ( $type == 'js' ) {
						wp_register_script(
							$file['handle'],
							get_template_directory_uri() . '/assets/js/' . ( isset( $file['filename'] ) ? $file['filename'] : $file['handle'] ) . '.js',
							isset( $file['deps'] ) ? $file['deps'] : null,
							isset( $file['version'] ) ? $file['version'] : $this->version,
							isset( $file['footer'] ) ? $file['footer'] : false
						);
					}
				}
			}
		}
	}

	/**
	 * Enqueues all of the files for the frontend of the theme.
	 *
	 * @since ThePowerBarn 0.1
	 */
	public function enqueue_frontend_files() {
		foreach( $this->files['frontend'] as $type => $files) {
			foreach( $files as $file ) {
				if ( $type == 'css' || $type == 'font' ) {
					wp_enqueue_style( $file['handle'] );
				} else {
					wp_enqueue_script( $file['handle'] );
				}
			}
		}
	}

	/**
	 * Enqueues all of the files for the backend of the theme.
	 *
	 * @since ThePowerBarn 0.1
	 */
	public function enqueue_backend_files() {
		foreach( $this->files['backend'] as $types ) {
			foreach( $types as $type => $files ) {
				foreach( $files as $file ) {
					if ( $type == 'css' ) {
						wp_enqueue_style( $file['handle'] );
					} else {
						wp_enqueue_script( $file['handle'] );
					}
				}
			}
		}
	}
}

new ThePowerBarn_Scripts();