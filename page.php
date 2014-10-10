<?php
/**
 * The page template for The Power Barn.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Core Theme Files
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();
the_post();
?>

<div class="columns small-12">
	<h2 class="section-title"><?php the_title(); ?></h2>

	<div class="page-content">
		<?php the_content(); ?>
	</div>
</div>

<?php get_footer(); ?>