<?php
/**
 * The sidebar for display on product archives.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Sidebars
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly
?>

<aside id="product-archive-sidebar" class="columns hide-for-small-only medium-3">
	<div class="container">
		<ul class="widgets">
			<?php dynamic_sidebar( 'product-archive' ); ?>
		</ul>
	</div>
</aside>