<?php global $post; ?>

<div class="columns large-4 small-6">
	<?php
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'Catalog Image' );
	} else {
		echo '<img src="' . get_template_directory_uri() . '/assets/images/product-placeholder.png" />';
	}
	?>

	<div class="product-gutter">
		<h4 class="product-title">
			<?php the_title(); ?>
		</h4>

		<p class="product-price">
			<?php echo get_post_meta( $post->ID, '_regular_price' , true ); ?>
		</p>
	</div>
</div>