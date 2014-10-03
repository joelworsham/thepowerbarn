<?php
/**
 * The sidebar for The Power Barn.
 *
 * @since ThePowerBarn 0.1
 *
 * @package WordPress
 * @subpackage ThePowerBarn
 * @category Basic Theme Files
 */
?>
<aside id="site-sidebar">
	Sidebar

	<section id="filter-menu">
		<h3>Filter by Brand</h3>

		<ul class="filter-brand">
			<?php
			// If the brand is being filtered, provide just a link to unfilter it
			if ( isset( $_GET['filter_brand'] ) ) {
				$brand = get_term_by( 'slug', $_GET['filter_brand'], 'pa_brand' );

				$posts = ThePowerBarn::get_filtered_products( - 1 );

				$count = count( $posts );

				echo '<li><a href="' . remove_query_arg( 'filter_brand' ) . '">' . $brand->name . '</a>' . $count . '</li>';
			} else {
				// If the brand is not being filtered, show all brands
				foreach ( get_terms( 'pa_brand' ) as $brand ) {

					$posts = ThePowerBarn::get_filtered_products( - 1, $brand->slug );

					$count = count( $posts );

					if ( $count == 0 ) {
						continue;
					}

					echo '<li><a href="' . add_query_arg( 'filter_brand', $brand->slug ) . '">' . $brand->name . '</a>' . $count . '</li>';
				}
			}
			?>
		</ul>

		<h3>Filter by Line</h3>

		<ul class="filter-line">
			<?php
			// If the line is being filtered, provide just a link to unfilter it
			if ( isset( $_GET['filter_line'] ) ) {
				$line = get_term_by( 'slug', $_GET['filter_line'], 'pa_line' );

				$posts = ThePowerBarn::get_filtered_products( - 1 );

				$count = count( $posts );

				echo '<li><a href="' . remove_query_arg( 'filter_line' ) . '">' . $line->name . '</a>' . $count . '</li>';
			} else {
				// If the line is not being filtered, show all lines
				foreach ( get_terms( 'pa_line' ) as $line ) {

					$posts = ThePowerBarn::get_filtered_products( - 1, null, $line->slug );

					$count = count( $posts );

					if ( $count == 0 ) {
						continue;
					}

					echo '<li><a href="' . add_query_arg( 'filter_line', $line->slug ) . '">' . $line->name . '</a>' . $count . '</li>';
				}
			}
			?>
		</ul>

		<h3>Filter by Series</h3>

		<ul class="filter-series">
			<?php
			// If the series is being filtered, provide just a link to unfilter it
			if ( isset( $_GET['filter_series'] ) ) {
				$series = get_term_by( 'slug', $_GET['filter_series'], 'pa_series' );

				$posts = ThePowerBarn::get_filtered_products( - 1 );

				$count = count( $posts );

				echo '<li><a href="' . remove_query_arg( 'filter_series' ) . '">' . $series->name . '</a>' . $count . '</li>';
			} else {
				// If the series is not being filtered, show all seriess
				foreach ( get_terms( 'pa_series' ) as $series ) {

					$posts = ThePowerBarn::get_filtered_products( - 1, null, null, $series->slug );

					$count = count( $posts );

					if ( $count == 0 ) {
						continue;
					}

					echo '<li><a href="' . add_query_arg( 'filter_series', $series->slug ) . '">' . $series->name . '</a>' . $count . '</li>';
				}
			}
			?>
		</ul>
	</section>
</aside>