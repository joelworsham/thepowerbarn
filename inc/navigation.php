<?php
/**
 * The navigation menu for The Power Barn.
 *
 * This will output a navigation menu that is built completely dynamically based
 * on the product->brand->line->series relationship that is set up by use of
 * WooCommerce product attributes and terms.
 *
 * @since ThePowerBarn 0.1
 *
 * @package WordPress
 * @subpackage ThePowerBarn
 * @category Navigation
 */
?>

<nav class="site-navigation">
	<div class="nav-container">
		<?php
		// Get our product terms hierarchy
		$product_terms = get_transient( 'pb_product_terms_hierarchy' );
		if ( empty( $product_terms ) ) {
			$product_terms = ThePowerBarn::get_product_terms_hierarchy();
			set_transient( 'pb_product_terms_hierarchy', $product_terms, YEAR_IN_SECONDS );
		}

		// Output our menu
		if ( ! empty( $product_terms ) ) {

			echo '<ul class="menu">';

			// Start with brands
			foreach ( $product_terms as $brand => $lines ) {

				// Calculate the brand widths
				$brand_count = count( $product_terms );
				$grid_width  = 100 / $brand_count;

				// Get our term data and output the item
				$brand = get_term( $brand, 'pa_brand' );
				echo "<li class=\"menu-item-brand\" style=\"width:$grid_width%\" onclick=\"PB_Navigation.show_brand(this)\">";
				echo "<p class=\"brand\">$brand->description</p>"; // (the image)

				if ( ! empty( $lines ) ) {

					// Start our lines sub-menu
					echo '<div class="sub-menu">';

					echo '<div class="lines">';

					// Cycle through all the lines
					$i = - 1;
					foreach ( $lines as $line => $all_series ) {
						$i ++;

						// This determines when to open and close our div. Each "line-section" is
						// two lines tall.
						if ( ! is_float( $i / 2 ) ) {
							if ( $i != 0 ) {
								echo '</div>'; // .line-section
							}
							echo '<div class="line-section">';
						}

						// Get our term data
						$line = get_term( $line, 'pa_line' );

						// Output our line image with the onclick attr to show the corresponding line list
						echo "<div class=\"line" . ( $i == 0 ? ' active' : '' ) . "\" onclick=\"PB_Navigation.show_line(this)\" data-line=\"$line->slug\">";

						// Extract each image into it's own variable
						preg_match_all( '/<img(.*?)>/', $line->description, $images );

						// Cycle throuch each image and only show if the class contains the parent brand
						foreach ( $images[0] as $image ) {
							if ( strpos( $image, $brand->slug ) !== false ) {
								echo $image;
							}
						}

						echo '</div>'; // .line

						// Closes off the last line-section
						if ( $i == count( $lines ) ) {
							echo '</div>'; // .line-section
						}
					}
					echo '</div>'; // .lines

					// Now cycle through lines again in order to output our series accordingly
					$i = 0;
					foreach ( $lines as $line => $all_series ) {
						$i ++;

						// Get our term data
						$line = get_term( $line, 'pa_line' );

						// Start our series list with a class that contains the line slug it belongs to.
						// This way when we click on a line above, it can find the corresponding series
						// list and show it
						echo "<ul class=\"series-section $line->slug" . ( $i == 1 ? ' active' : '' ) . "\">";

						// The line title
						echo '<p class="line-title">';
						echo '<a href="?filter_line=' . $line->term_id . '">';
						echo $line->name;
						echo '</a>';
						echo '</p>';

						if ( ! empty( $all_series ) ) {

							$i2 = 0;
							foreach ( $all_series as $series ) {
								$i2++;
								// Get our term data
								$series = get_term( $series, 'pa_series' );

								// Output the series
								echo '<li class="series">';
								echo '<a href="">';
								echo "$series->name" . ( $i2 != count( $all_series ) ? '<span class="sep">|</span>' : '' );
								echo '</a>';
								echo '</li>';
							}
						}
						echo '</ul>'; // .series.{slug}
					}
					echo '</div>'; // .sub-menu
				}
				echo '</li>'; // .menu-item-brand
			}
			echo '</ul>'; // .menu
		}
		?>
	</div>
</nav>