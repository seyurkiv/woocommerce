<?php

/**
 * Order.
 */
class Aplazame_Aplazame_BusinessModel_Order {

	public static function crateFromOrder( WC_Order $order ) {
		$aOrder = new self();
		$aOrder->id = $order->id;
		$aOrder->currency = get_woocommerce_currency();
		$aOrder->total_amount = Aplazame_Sdk_Serializer_Decimal::fromFloat( $order->get_total() );
		$aOrder->articles = array_map( array( 'Aplazame_Aplazame_BusinessModel_Article', 'crateFromOrderItem' ), array_values( $order->get_items() ) );
	    $aOrder->discount = Aplazame_Sdk_Serializer_Decimal::fromFloat( $order->get_total_discount() );

		return $aOrder;
	}
}
