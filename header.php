<?php
/**
 * The header for The Power Barn.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Core Theme Files
 */

// TODO Gray and red logo, not white and red.

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $ThePowerBarn;
?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" prefix="og: http://ogp.me/ns#">
<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, user-scalable=no"/>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper">

	<nav id="site-top-navigation">
		<div class="row">
			<div class="columns small-12">
				<?php pb_partial( 'top-nav' ); ?>
			</div>
		</div>
	</nav>

	<header id="site-header" class="row">
		<div class="container columns small-12">
			<div class="row">
				<div class="site-logo columns small-12 medium-6">
					<a href="<?php echo home_url(); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png"
						     alt="The Power Barn" width="158" height="111"/>
					</a>
				</div>
				<div class="site-address columns small-12 medium-6 alignright">
					<span class="icon-phone"></span> Mason: (517) 694-9501 &bull; Jackson: (517) 782-3319
				</div>
				<div class="site-search columns small-12">
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>
	</header>


	<nav id="site-navigation" class="row">
		<div class="columns small-12">
			<?php pb_partial( 'navigation' ); ?>
		</div>
	</nav>

	<section id="content" class="row">