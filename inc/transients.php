<?php

/**
 * Class ThePowerBarn_Transients
 *
 * Provides a clean way of using transients to replace all post gathering
 * queries. This can save some load time.
 *
 * @package WordPress
 * @subpackage ThePowerBarn 0.1
 *
 * @since ThePowerBarn 0.1
 */
class ThePowerBarn_Transients extends ThePowerBarn {
	/**
	 * The main construct function.
	 *
	 * @since ThePowerBarn 0.1
	 */
	function __construct() {
		add_action( 'save_post', array( $this, 'manage_transients' ) );
		add_action( 'delete_post', array( $this, 'manage_transients' ) );
	}
	/**
	 * Gets stored transients, or creates them.
	 *
	 * This function is the main way of getting posts in this theme. It allows
	 * for the saving of queries in order to save some load time and reduce
	 * database calls.
	 *
	 * @since ThePowerBarn 0.1
	 *
	 * @param string $ID The unique ID of the transient.
	 * @param array $args The arguments to send through get_posts().
	 * @param bool /int $bypass Allows you to bypass the transient.
	 *
	 * @return mixed The object retrieved from the database.
	 */
	public static function get_posts( $args = null, $bypass =false ) {
		// See if our post type has been defined in the arguments
		// Otherwise, set it to 'post' as default
		if ( array_key_exists( 'post_type', $args ) ) {
			$post_type = $args['post_type'];
		} else {
			$post_type = 'post';
		}

		// Generate the ID
		$ID = $post_type;
		foreach ( $args as $key => $value ) {
			if ( ! is_array( $value ) && $key != 'post_type') {
				$ID .= "_{$key}_$value";
			} else {
				if ( $key == 'tax_query' ) {
					foreach( $value as $tax_query ) {
						foreach ( $tax_query as $tax_key => $tax_value ) {
							$ID .= "_{$tax_key}_$tax_value";
						}
					}
				}
			}
		}

		// If bypass is set to true, skip getting the transient altogether
		// Otherwise, get the transient and save it in $obj
		if ( ! $bypass ) {
			$obj = get_transient( 'pb_' . $ID );
		} else {
			$obj = null;
		}


		// If our transient returned nothing, then get the posts manually
		// Otherwise, move on
		if ( ! $obj ) {
			$obj = get_posts( $args );
			set_transient( 'pb_' . $ID, $obj, YEAR_IN_SECONDS );
		}

		// Store transients for managing
		$transients        = get_option( 'pb_transients', array() );
		$transients[ $ID ] = array( 'ID' => $ID, 'post_type' => $post_type );
		update_option( 'pb_transients', $transients );

		// Return our finalized object
		return $obj;
	}

	public static function get_terms( $ID, $taxonomies = array( 'category' ), $args = null, $post_type = null, $bypass = false ) {
		// If bypass is set to true, skip getting the transient altogether
		// Otherwise, get the transient and save it in $obj
		if ( ! $bypass ) {
			$obj = get_transient( 'pb_' . $ID );
		} else {
			$obj = null;
		}

		// Require certain arguments
		if ( ! isset( $post_type ) ) {
			echo 'Invalid: Need argument $post_type.';
			return false;
		}

		// If our transient returned nothing, then get the posts manually
		// Otherwise, move on
		if ( ! $obj ) {
			$obj = get_terms( $taxonomies, $args );
			set_transient( 'pb_' . $ID, $obj, YEAR_IN_SECONDS );
		}

		// Store transients for managing
		$transients        = get_option( 'pb_transients', array() );
		$transients[ $ID ] = array( 'ID' => $ID, 'post_type' => $post_type );
		update_option( 'pb_transients', $transients );

		// Return our finalized object
		return $obj;
	}

	/**
	 * Deletes transients when the post type updates in some way.
	 *
	 * @since ThePowerBarn 0.1
	 *
	 * @param int $post_id Supplied ID of current post.
	 */
	public function manage_transients( $post_id ) {
		$post       = get_post( $post_id );
		$transients = get_option( 'pb_transients' );

		if ( ! empty( $transients ) ) {
			foreach ( $transients as $trans ) {
				if ( $post->post_type == $trans['post_type'] ) {
					delete_transient( 'pb_' . $trans['ID'] );
				}
			}
		}
	}
}

new ThePowerBarn_Transients();