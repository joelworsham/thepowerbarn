<?php
/**
 * The site search form.
 *
 * @since 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Core Theme Files
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$term            = get_term_by( 'name', 'All Products', 'product_cat' );
$parent_category = $term->term_id;

$categories = get_terms( 'product_cat', array(
	'parent' => $parent_category,
) );

// Get the current category
$term             = isset( $_GET['product_cat'] ) ? $_GET['product_cat'] : 0;
$current_category = $term != 0 ? get_term( $term, 'product_cat' ) : 'All';
$current_category = $current_category != 'All' ? $current_category->name : 'All';
?>

<form action="<?php echo home_url(); ?>" method="get" class="search-form">

	<input type="hidden" name="post_type" value="product" />

	<div class="select-container">
		<select class="search-options" name="product_cat">
			<option value="0" <?php selected( 0, $term ); ?>>All</option>
			<?php
			if ( ! empty( $categories ) ) {
				foreach ( $categories as $category ) {
					echo "<option value='$category->slug'" . selected( $category->term_id, $term, false ) . '>';
					echo $category->name;
					echo '</option>';
				}
			}
			?>
		</select>
		<span class="select-arrow"></span>
		<span class="width-temp"><?php echo $current_category; ?></span>
	</div>
	<input type="text" class="search-box" name="s" placeholder="Search our catalog" aria-label="Search"
	       value="<?php echo isset( $_GET['s'] ) ? $_GET['s'] : ''; ?>"/>
	<button type="submit" class="search-icon"><span class="icon-search"></span></button>
</form>