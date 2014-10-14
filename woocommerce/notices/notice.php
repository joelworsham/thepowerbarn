<?php
/**
 * Shows a notice message.
 *
 * @since 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage WooCommerceTemplateOverrides
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>

<?php foreach ( $messages as $message ) : ?>
	<div class="alert-box info" data-alert>
		<?php echo wp_kses_post( $message ); ?>
		<span class="close"></span>
	</div>
<?php endforeach; ?>