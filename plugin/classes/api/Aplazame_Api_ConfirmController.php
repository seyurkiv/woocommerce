<?php

final class Aplazame_Api_ConfirmController {

	private static function ok() {
		return Aplazame_Api_Router::success(
			array(
				'status' => 'ok',
			)
		);
	}

	private static function ko( $reason ) {
		return Aplazame_Api_Router::success(
			array(
				'status' => 'ko',
				'reason' => $reason,
			)
		);
	}

	/**
	 *
	 * @var string
	 */
	private $sandbox;

	public function __construct( $sandbox ) {
		$this->sandbox = $sandbox;
	}

	public function confirm( $payload ) {
		if ( ! $payload ) {
			return Aplazame_Api_Router::client_error( 'Payload is malformed' );
		}

		if ( ! isset( $payload['sandbox'] ) || $payload['sandbox'] !== $this->sandbox ) {
			return Aplazame_Api_Router::client_error( '"sandbox" not provided' );
		}

		if ( ! isset( $payload['mid'] ) ) {
			return Aplazame_Api_Router::client_error( '"mid" not provided' );
		}

		$order = wc_get_order( $payload['mid'] );
		if ( ! $order ) {
			return Aplazame_Api_Router::not_found();
		}

		if ( ! in_array( $order->get_payment_method(), array( WC_Aplazame::METHOD_ID, WC_Aplazame::METHOD_ID . '_' . WC_Aplazame::PAY_LATER ) ) ) {
			return self::ko( 'Aplazame is not the current payment method' );
		}

		switch ( $payload['status'] ) {
			case 'pending':
				switch ( $payload['status_reason'] ) {
					case 'confirmation_required':
						if ( method_exists( $order, 'payment_complete' ) ) {
							if ( ! $order->payment_complete() ) {
								return self::ko( "'payment_complete' function failed" );
							}
						} else {
							$order->update_status( 'processing', sprintf( __( 'Confirmed', 'aplazame' ) ) );
						}
						break;
				}
				break;
			case 'ko':
				$order->update_status(
					'cancelled',
					sprintf(
						__( 'Order has been cancelled: %s', 'aplazame' ),
						$payload['status_reason']
					)
				);
				break;
		}

		return self::ok();
	}
}
