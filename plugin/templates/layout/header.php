<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var WC_Aplazame $aplazame */
global $aplazame;

if ( ! $aplazame->enabled ) {
	return;
}

$aplazameJsUri = defined( 'APLAZAME_JS_URI' ) ? APLAZAME_JS_URI : 'https://aplazame.com/static/aplazame.js';
?>

<!-- TODO: nav hook and exclude redirect page -->
<style type="text/css">
	li.page-item-<?php echo Aplazame_Redirect::get_the_ID() ?> {
		display: none;
	}
</style>

<script
	type="text/javascript"
	src="<?php echo esc_attr( $aplazameJsUri ); ?>"
	data-aplazame="publicKey: <?php echo $aplazame->settings['public_api_key']; ?>"
	data-sandbox="<?php echo $aplazame->sandbox ? 'true' : 'false'; ?>">
</script>