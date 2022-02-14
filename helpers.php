<?php
require __DIR__ . '/vendor/autoload.php';

use WebSocket\Client;

if ( ! function_exists( 'f' ) ) {
	function f( ...$variables ) {
		$message = json_encode( $variables );

		$client = new Client( 'ws://' . HOST . ':' . PORT );
		$client->binary( $message );
		$client->close();
	}
}