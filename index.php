<?php get_header(); ?>

<?php
$categories = ThePowerBarn_Transients::get_terms(
	'home_categories',
	array( 'product_cat' ),
	array(
		'include' => array( 100, 14, 102, 78 ),
	),
	'products',
	true
);
?>

<section id="slider" class="row">
	<div class="columns large-12">
		<div id="temp-slider" style="height:400px;background:gray;text-align:center;font-size:40px;padding-top:160px;">
			SLIDER
		</div>
	</div>
</section>

<section id="content" class="row product-grid">
	<?php
	if ( ! empty( $categories ) ) {
		global $post;
		foreach ( $categories as $category ) {
			get_template_part( 'inc/loops/loop', 'categories' );
		}
		wp_reset_postdata( $post );
	}
	?>
</section>

<?php get_footer(); ?>