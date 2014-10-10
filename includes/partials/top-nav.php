<?php
/**
* The top navigation menu for The Power Barn.
*
* @since ThePowerBarn 0.1.0
*
* @package ThePowerBarn
* @subpackage Partials
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_nav_menu( array( 'theme_location' => 'upper', 'container' => false ) );
?>
<ul class="menu extra-nav-items">
	<li class="menu-item separator">|</li>
	<li class="menu-item home">
		<a href="<?php echo home_url(); ?>">
			Home
		</a>
	</li>
	<?php if ( is_user_logged_in() ) : ?>
		<li class="menu-item account">
			<a href="<?php echo wp_login_url() ?>">
				Account
			</a>
		</li>
	<?php else: ?>
		<li class="menu-item account">
			<a href="<?php echo wp_login_url() ?>">
				Login
			</a>
		</li>
	<?php endif; ?>
	<li class="menu-item cart">
		<?php
		global $woocommerce;
		$cart_items = $woocommerce->cart->get_cart_contents_count();
		$cart_link  = $woocommerce->cart->get_cart_url();
		?>
		<a href="<?php echo $cart_link; ?>">
			Cart<?php echo $cart_items > 0 ? " ($cart_items " . _n( 'item', 'items', $cart_items ) . ')' : ''; ?>
		</a>
	</li>
	<li class="menu-item contact">
		<a href="/contact">
			Contact
		</a>
	</li>
</ul>