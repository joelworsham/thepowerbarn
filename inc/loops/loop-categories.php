<?php global $category; ?>

<div class="columns large-4 medium-6 small-12">
	<?php
	$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
	if ( isset ( $thumbnail_id ) ) {
		echo '<img src="'. wp_get_attachment_url( $thumbnail_id ). '" />';
	} else {
		echo '<img src="' . get_template_directory_uri() . '/assets/images/product-placeholder.png" />';
	}
	?>

	<div class="product-gutter">
		<h4 class="product-title">
			<?php echo $category->name; ?>
		</h4>

		<div class="product-gutter">
			<?php echo $category->description; ?>
		</div>
	</div>
</div>