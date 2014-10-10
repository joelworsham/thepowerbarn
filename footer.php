<?php
/**
 * The footer for The Power Barn.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage CoreThemeFiles
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php // #content ?>
</section>

<footer id="site-footer" class="row">
	<div class="footer-widgets columns small-12">

		<div class="container row">
			<?php for ( $i = 1; $i <= 4; $i++ ) { ?>
				<ul class="footer-widget-box-<?php echo $i; ?> columns large-3 medium-6 small-12">
					<?php dynamic_sidebar( "footer-$i" ); ?>
				</ul>
			<?php } ?>
		</div>

	</div>
</footer>

</div><!--#wrapper-->

<?php wp_footer(); ?>

</body>
</html>