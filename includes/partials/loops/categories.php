<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $term;
?>

<div class="columns medium-4 small-12">
	<div class="category">
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
			<h4 class="product-title">
				<?php echo $term->name; ?>
			</h4>

			<?php // TODO Better solution than boring description ?>
			<div class="product-description">
				<?php echo $term->description; ?>
			</div>
		</div>
	</div>
</div>