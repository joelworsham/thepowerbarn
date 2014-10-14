<?php
/**
 * The search results page.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Core Theme Files
 */

get_header();
global $wp_query, $posts_per_page, $wp_the_query;
?>

	<section class="columns small-12 search-results">

		<?php if ( have_posts() ) : ?>

			<h2 class="section-title">
				<?php echo $wp_query->found_posts; ?> products found
				for: &ldquo;<?php echo get_search_query(); ?>&rdquo;
			</h2>

			<div class="row product-grid" data-equalizer>
				<?php
				while ( have_posts() ) {
					the_post();
					pb_loop( 'products' );
				}
				?>
			</div>

			<?php if ( $wp_the_query->found_posts > $posts_per_page ) : ?>
				<div class="search-footer">
					<div class="nav-previous alignright">
						<?php next_posts_link( 'Next <span class="icon-arrow-right"></span>' ); ?>
					</div>
					<div class="nav-next alignleft">
						<?php previous_posts_link( '<span class="icon-arrow-left"></span> Back' ); ?>
					</div>
					<div class="clear"></div>
				</div>
			<?php endif; ?>

		<?php else: ?>

			<h2 class="section-title">No products found for: &ldquo;<?php echo get_search_query(); ?>&rdquo;</h2>

		<?php endif; ?>

	</section>
<?php

get_footer();