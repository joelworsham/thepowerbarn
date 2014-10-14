<?php
/**
 * The top navigation menu for The Power Barn.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

// Get page urls
$contact_page = get_page_by_title( 'Contact' );
$account_page = get_page_by_title( 'Account' );

wp_nav_menu( array( 'theme_location' => 'upper', 'container' => false ) );
?>
<ul class="menu extra-nav-items">
	<li class="menu-item separator">|</li>
	<li class="menu-item home">
		<a href="<?php echo home_url(); ?>">
			Home
		</a>
	</li>
	<?php
	if ( ! empty( $account_page ) ) :
		$page_url = get_permalink( $account_page->ID );
		?>
		<?php if ( is_user_logged_in() ) : ?>
		<li class="menu-item account">
			<a href="<?php echo $page_url; ?>">
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

	<?php
	if ( ! empty( $contact_page ) ) :
		$page_url = get_permalink( $contact_page->ID );
		?>
		<li class="menu-item contact">
			<a href="<?php echo $page_url; ?>">
				Contact
			</a>
		</li>
	<?php endif; ?>
</ul>