<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var WC_Aplazame $aplazame */
global $aplazame;
if ( ! $aplazame->enabled ) {
	return;
}

/** @var WC_Product $product */
global $product;

switch ( $product->get_type() ) {
	case 'variable':
		$price_selector = '#main [itemtype="http://schema.org/Product"] .single_variation_wrap .amount';
		$price = '';
		break;
	default:
		$price_selector = '';
		$price = Aplazame_Filters::decimals( $product->get_price() );
}
?>

<div
	data-aplazame-simulator=""
	data-view="product"
	<?php if ( empty( $price_selector ) ) :  ?>
		data-amount='<?php echo $price; ?>'
	<?php else : ?>
		data-price='<?php echo $price_selector; ?>'
	<?php endif; ?>
	data-currency="<?php echo get_woocommerce_currency(); ?>"
	data-stock="<?php echo $product->is_in_stock() ? 'true' : 'false'; ?>">
</div>
