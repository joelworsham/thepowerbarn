<?php global $post; ?>

<div class="columns large-3 medium-6 small-12">
	<div class="product">
		<div class="product-image">
			<?php
			if ( has_post_thumbnail() ) {
				ThePowerBarn::attachment_image_exact(
					get_post_thumbnail_id( $post->ID ),
					array( 'shop_catalog', 'catalog_fallback' )
				);
			} else {
				echo '<img src="' . get_template_directory_uri() . '/assets/images/product-placeholder.png" />';
			}
			?>
		</div>

		<div class="product-info">
			<h4 class="product-title">
				<?php the_title(); ?>
			</h4>

			<p class="product-price">
				<?php
				$price = intval( get_post_meta( $post->ID, '_regular_price' , true ) );
				if ( ! empty( $price ) ) {
					echo '$' . number_format( $price, 2 );
				} else {
					echo 'No price set';
				}
				?>
			</p>
		</div>
	</div>
</div>