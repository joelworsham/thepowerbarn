<?php global $post; ?>

<div class="columns large-4 medium-6 small-12">
	<div class="category">
		<?php
		$thumbnail_id = get_woocommerce_term_meta( $post->term_id, 'thumbnail_id', true );
		if ( isset ( $thumbnail_id ) ) {
			ThePowerBarn::attachment_image_exact(
				$thumbnail_id,
				array( 'shop_catalog', 'catalog_fallback' )
			);
		} else {
			echo '<img src="' . get_template_directory_uri() . '/assets/images/product-placeholder.png" />';
		}
		?>

		<div class="product-info">
			<h4 class="product-title">
				<?php echo $post->name; ?>
			</h4>

			<div class="product-description">
				<?php echo $post->description; ?>
			</div>
		</div>
	</div>
</div>