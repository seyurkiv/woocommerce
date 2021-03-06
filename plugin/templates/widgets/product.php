<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * @var WC_Aplazame $aplazame
 */
global $aplazame;

/**
 *
 * @var WC_Product $product
 */
global $product;

switch ( WC_Aplazame::_m_or_a( $product, 'get_type', 'product_type' ) ) {
	case 'variable':
		$price_selector = $aplazame->settings['price_variable_product_selector'];
		break;
	default:
		$price_selector = $aplazame->settings['price_product_selector'];
}

if ( function_exists( 'wc_get_price_including_tax' ) ) {
	$price = wc_get_price_including_tax( $product );
} else {
	/** @noinspection PhpDeprecationInspection */
	$price = $product->get_price_including_tax();
}
?>

<div
	data-aplazame-widget-instalments=""
	data-view="product"
	<?php if ( empty( $price_selector ) ) : ?>
		data-amount="<?php echo esc_attr( Aplazame_Sdk_Serializer_Decimal::fromFloat( $price )->jsonSerialize() ); ?>"
	<?php else : ?>
		data-price="<?php echo esc_attr( $price_selector ); ?>"
	<?php endif; ?>
	<?php if ( ! empty( $aplazame->settings['quantity_selector'] ) ) : ?>
		data-qty="<?php echo esc_attr( $aplazame->settings['quantity_selector'] ); ?>"
	<?php endif; ?>
	data-currency="<?php echo esc_attr( get_woocommerce_currency() ); ?>"
	data-article-id="<?php echo esc_attr( $product->get_id() ); ?>"
	data-option-legal-advice="<?php echo esc_attr( $aplazame->settings['product_legal_advice'] === 'yes' ? 'true' : 'false' ); ?>">
</div>
