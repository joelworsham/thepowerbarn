<?php
/**
 * The navigation menu for The Power Barn.
 *
 * This will output a navigation menu that is built completely dynamically based
 * on the product->brand->line->series relationship that is set up by use of
 * WooCommerce product attributes and terms.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package WordPress
 * @subpackage ThePowerBarn
 * @category Navigation
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $pb_all_products_link;
?>

<div class="nav-container">
	<?php
	// Get our stored menu if possible
	if ( ! isset( $_GET['flush_nav'] ) ) {
		$nav_menu = get_transient( 'pb_nav_menu' );
	} else {
		echo 'Nav Flushed!';
	}
	if ( empty( $nav_menu ) ) {

		$nav_menu = '';

		$product_terms = ThePowerBarn::get_product_terms_hierarchy();

		// Output our menu
		if ( ! empty( $product_terms ) ) {

			$nav_menu .= '<ul class="menu row">';

			// Start with brands
			foreach ( $product_terms as $brand => $lines ) {

				// TODO Get width by determining/using foundation grid classes

				// Calculate the brand widths
				$brand_count = count( $product_terms );
				$grid_width  = 100 / $brand_count;

				// Get our term data and output the item
				$brand = get_term( $brand, 'pa_brand' );

				// Use regex to eliminate all but the image itself
				preg_match( '/<img.*?\/>/', $brand->description, $matches );

				$nav_menu .= "<li class=\"menu-item-brand\" style=\"width:$grid_width%\" onclick=\"PB_Navigation.show_brand(this)\">";
				$nav_menu .= "<p class=\"brand\">$matches[0]</p>"; // (the image)

				if ( ! empty( $lines ) ) {

					// Start our lines sub-menu
					$nav_menu .= '<div class="sub-menu">';

					// View brand
					$nav_menu .= "<a href='/products/?filter_brand=$brand->term_id' class='brand-link'>View brand <span class='icon-arrow-right'></span></a>";

					$nav_menu .= '<div class="lines">';

					// Cycle through all the lines
					$i = - 1;
					foreach ( $lines as $line => $all_series ) {
						$i ++;

						// This determines when to open and close our div. Each "line-section" is
						// two lines tall.
						if ( ! is_float( $i / 2 ) ) {
							if ( $i != 0 ) {
								$nav_menu .= '</div>'; // .line-section
							}
							$nav_menu .= '<div class="line-section">';
						}

						// Get our term data
						$line = get_term( $line, 'pa_line' );

						// Output our line image with the onclick attr to show the corresponding line list
						$nav_menu .= "<div class=\"line" . ( $i == 0 ? ' active' : '' ) . "\" onclick=\"PB_Navigation.show_line(this)\" data-line=\"$line->slug\">";

						// Extract each image into it's own variable
						if ( preg_match_all( '/<img(.*?)>/', $line->description, $images ) > 0 ) {

							// If there's more than one image present, cycle through each and look for the brand's class
							if ( count( $images[0] ) > 1 ) {
								foreach ( $images[0] as $image ) {
									if ( strpos( $image, $brand->slug ) !== false ) {
										$nav_menu .= $image;
									}
								}
							} elseif ( $images[0] ) {
								$nav_menu .= $images[0][0];
							}
						}

						$nav_menu .= '</div>'; // .line

						// Closes off the last line-section
						if ( $i == count( $lines ) ) {
							$nav_menu .= '</div>'; // .line-section
						}
					}
					$nav_menu .= '</div>'; // .lines

					// Now cycle through lines again in order to output our series accordingly
					$i = 0;
					foreach ( $lines as $line => $all_series ) {
						$i ++;

						// Get our term data
						$line = get_term( $line, 'pa_line' );

						// Start our series list with a class that contains the line slug it belongs to.
						// This way when we click on a line above, it can find the corresponding series
						// list and show it
						$nav_menu .= "<ul class=\"series-section $line->slug" . ( $i == 1 ? ' active' : '' ) . "\">";

						// The line title
						$nav_menu .= '<p class="line-title">';
						$nav_menu .= "<a href='$pb_all_products_link?filter_line=$line->term_id'>";
						$nav_menu .= $line->name;
						$nav_menu .= '</a>';
						$nav_menu .= '</p>';

						if ( ! empty( $all_series ) ) {

							$i2 = 0;
							foreach ( $all_series as $series ) {
								$i2 ++;
								// Get our term data
								$series = get_term( $series, 'pa_series' );

								// Output the series
								$nav_menu .= '<li class="series">';
								// TODO Get the correct "archive" link
								$nav_menu .= "<a href='$pb_all_products_link?filter_series=$series->term_id'>";
								$nav_menu .= "$series->name" . ( $i2 != count( $all_series ) ? '<span class="sep">|</span>' : '' );
								$nav_menu .= '</a>';
								$nav_menu .= '</li>';
							}
						}
						$nav_menu .= '</ul>'; // .series.{slug}
					}
					$nav_menu .= '</div>'; // .sub-menu
				}
				$nav_menu .= '</li>'; // .menu-item-brand
			}
			$nav_menu .= '</ul>'; // .menu
		}
		echo $nav_menu;
		set_transient( 'pb_nav_menu', $nav_menu, WEEK_IN_SECONDS );
	} else {
		echo $nav_menu;
	}
	?>
</div>