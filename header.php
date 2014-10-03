<?php
/**
 * The header for The Power Barn.
 *
 * @since ThePowerBarn 0.1
 *
 * @package WordPress
 * @subpackage ThePowerBarn
 * @category Basic Theme Files
 */

global $ThePowerBarn;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" prefix="og: http://ogp.me/ns#">
<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, user-scalable=no"/>

	<?php wp_head(); ?>
</head>

<body>
<div id="wrapper" class="<?php echo $ThePowerBarn->wrapper_classes; ?>">

	<header id="site-header" class="row">
		<div class="columns small-12">
			<div class="row logo-area">
				<div class="columns small-12">
					<div class="site-logo">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" alt="The Power Barn" />
					</div>
				</div>
			</div>

			<div class="row menu-area">
				<div class="columns small-12">
					<?php get_template_part( '/inc/navigation' ); ?>
				</div>
			</div>
		</div>
	</header>

	<section id="content" class="row">