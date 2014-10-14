<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $term;
?>

<div class="columns medium-4 small-12">
	<div class="category">

		<h3 class="category-title">
			<?php echo $term->name; ?>
		</h3>

		<div class="category-image" data-equalizer-watch>
			<?php
			$thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
			if ( isset ( $thumbnail_id ) ) {
				echo wp_get_attachment_image( $thumbnail_id, 'full' );
			} else {
				echo '<img src="' . get_template_directory_uri() . '/assets/images/product-placeholder.png" />';
			}
			?>
		</div>

		<div class="product-info">
			<div class="product-description">
				<?php echo wpautop( $term->description ); ?>
			</div>

			<a href="<?php echo get_term_link( $term ); ?>" class="button">Shop Now!</a>
		</div>
	</div>
</div>