<?php
/**
 * Theme helper functions.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Base Functionality
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Includes a theme partial from the correct location.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @param string $partial The partial to include.
 */
function pb_partial( $partial ) {
	include( PB_PATH . "includes/partials/$partial.php" );
}

/**
 * Includes a theme loop from the correct location.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @param string $loop The loop to include.
 */
function pb_loop( $loop ) {
	include( PB_PATH . "includes/partials/loops/$loop.php" );
}

/**
 * Includes a theme sidebar from the correct location.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @param string $sidebar The loop to include.
 */
function pb_sidebar( $sidebar ) {
	include( PB_PATH . "includes/sidebars/$sidebar.php" );
}