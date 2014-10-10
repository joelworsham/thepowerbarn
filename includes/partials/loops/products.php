<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $classes;

// Is product on sale?
$sale = get_post_meta( $post->ID, '_sale_price', true ) !== '' ? true : false;

// Classes
if ( empty( $classes ) ) {
	$classes = array(
		'small-12',
		'medium-6',
		'large-3',
	);
}
?>

<div class="columns <?php echo implode( ' ', $classes ); ?>">
	<div class="product-box<?php echo $sale ? ' on-sale' : ''; ?>" data-equalizer-watch>
		<div class="product-image">
			<a href="<?php the_permalink(); ?>">
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
			</a>
		</div>

		<div class="product-info">
			<h4 class="product-title">
				<?php the_title(); ?>
			</h4>

			<p class="product-action">
				<?php
				echo WC_Shortcodes::product_add_to_cart( array(
					'id'    => $post->ID,
					'style' => '',
				) );
				?>
			</p>
		</div>
	</div>
</div>